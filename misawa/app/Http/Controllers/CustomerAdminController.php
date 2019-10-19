<?php

namespace App\Http\Controllers;

use App\Events\SuperAdminMessageEvent;
use App\Models\AdminPODetails;
use App\Models\AdminPOs;
use App\Models\BrowseProduct;
use App\Models\Catalogue;
use App\Models\Client;
use App\Models\Customer;
use App\Models\customerAdminPODetails;
use App\Models\customerAdminPOs;
use App\Models\PO;
use App\Models\Vendor;
use App\Models\VendorPODetails;
use App\Models\VendorPOs;
use App\Repositories\Eloquent\ClientRepository;
use App\Repositories\Eloquent\PORepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class CustomerAdminController extends Controller
{
    protected $repoProduct;
    protected $repoUser;
    protected $repoClient;
    protected $repoPO;
    public function __construct(ProductRepository $productRepository,
                                UserRepository $userRepository,
                                ClientRepository $clientRepository,
                                PORepository $repoPO)
    {
        $this->repoProduct=$productRepository;
        $this->repoUser=$userRepository;
        $this->repoClient=$clientRepository;
        $this->repoPO=$repoPO;
    }

    public function index(){
        return view("customerAdmin.adminhome");
    }

    public function getManagementInfo(Request $request)
    {
        $user=User::with("roles")->where("id",$request->user()->id)->first();
        $client=Client::find($user->client_id);


        $catalogues=Catalogue::with(["subcatalogues","subcatalogues.products","subcatalogues.products.images"])->get();

        $myUsers=User::where("client_id",$client->id)->get();
        $mycustomer=Customer::where("user_id",$user->id)->get();
        $myPOS=PO::where("user_id",$user->id)->get();
        $teamPOS=$client->pos;

        \Log::info("Customer system information");
        Log::info(json_encode($user));

        return response([
            "result"=>"OK",
            "user"=>$user,
            "catalogues"=>$catalogues,
            "myUsers"=>$myUsers,
            "mycustomer"=>$mycustomer,
            "myPOS"=>$myPOS,
            "teamPOS"=>$teamPOS,
        ],201);
    }

    public function getUserHistory(Request $request,$userid){
        $browseitems=BrowseProduct::userHistory($userid)->with("product")->get();
        $user=User::find($userid);

        return view("customerAdmin.userhistory",[
            "browseitems" =>$browseitems,
            "user"=>$user
        ]);
    }

    public function PrintPO(Request $request,$poid )
    {
        $po=$this->repoPO->getVendor_PrintedPO_ByPOID($poid);

        \Log::info($po);
        return view("customerAdmin.PO_customer",[
            "po"=>$po,
            "user"=>$po->user ,
            "customer"=>$po->customer ,
            "vendor"=>$po->vendor,
            "cart_items"=>$po->cartitems
        ]);
    }
    public function team(Request $request){
//        dd("team");
        $user=$request->user();
        $client=Client::with("users")->findOrFail($user->client_id);

//        dd($client->users);
        return view("customerAdmin.team",[
            "users"=>$client->users
        ]);
    }

    public function getAllUsers(Request $request)
    {
        $children=User::where("client_id",$request->user()->client_id)->with(["roles"])->get();

        \Log::info("children");
        \Log::info($children);
        return response([
            "result"=>"OK",
            "users"=>$children
        ],201);

    }

    public function monthlySummary(Request $request)
    {
        $client_id=$request->user()->client_id;
        $procedure="call proc_monthly_summary_byClientID($client_id)";
        $result=$this->repoPO->CallProcedure("$procedure");

        if ($result){
            return response([
                "result"=>"OK",
                "monthlySummary"=>$result
            ],201);
        }

        return response([
            "result"=>"NG",
            "monthlySummary"=>null
        ],201);
    }

    public function download_POList(Request $request){
        $userid=$request->user()->id;

        $client=Client::find($request->user()->client_id);
        $adminid=$client->admin_id;
        \Log::info("userid id: ".$userid);
        \Log::info("admin id: ".$adminid);

        if ($userid == $adminid){
            $todaystr=Carbon::today()->format("Y_m_d");

            $pos=customerAdminPOs::customerAdminAllPOs($client->id)->get();

            Excel::create('Order_all'.$todaystr,function($excel) use ($pos){

                $excel->sheet('Order_POList', function($sheet) use ($pos){
                    $sheet->fromModel($pos);
                });
            })->download('xlsx');
        }
    }

    public function updateCustomerInfo(Request $request)
    {
        \Log::info($request);

        $customer=Customer::find($request->input("customerid"));

        if ($customer){
            $customer->phone=$request->input("phone");
            $customer->email=$request->input("email");
            $customer->postcode=$request->input("postcode");
            $customer->address1=$request->input("address1");
            $customer->address2=$request->input("address2");
            $customer->save();

            return response([
                "result"=>"OK",
                "customer"=>$customer
            ],201);
        }

        return response([
            "result"=>"NG",
            "customer"=>null
        ],201);

    }
    public function getcustomers(Request $request){
        $user=$request->user();
        $client=Client::find($user->client_id);
        $customers=$client->customers;

        \Log::info(count($customers));
        return response([
            "result"=>"OK",
            "customers"=>$customers
        ],201);

        return view("customerAdmin.customers",[
            "customers"=>$customers
        ]);
    }

    public function getPOs_ofStatus(Request $request)
    {
        $user=$request->user();
        $client=Client::find($user->client_id);
        $status=$request->input("status");

        \Log::info($request );
        switch ($status){
            case "all":
                $pos=$client->pos()
                    ->with(["user"=>function($query){
                        return $query->select(["id","name"]);
                    },"customer","vendor"=>function($query){
                        return $query->select(["id","name"]);
                    },"cartitems.product"=>function($query){
                        return $query->select(["id","name","o_price","b_price","thumbImage"]);
                    },"cartitems"])
                    ->orderBy("id","DESC")
                    ->get();;
                break;
            default:
                $pos=$client->pos()
                ->with(["user"=>function($query){
                    return $query->select(["id","name"]);
                },"customer","vendor"=>function($query){
                    return $query->select(["id","name"]);
                },"cartitems.product"=>function($query){
                    return $query->select(["id","name","o_price","b_price","thumbImage"]);
                },"cartitems"])
                    ->where("pos.status",$status)
                ->orderBy("id","DESC")
                ->get();;

        }

        \Log::info($pos);
        \Log::info("getTeamPOs count: ".count($pos));
        if (count($pos) > 0) {
            return response([
                "result" => "OK",
                "pos" => $pos
            ], 201);
        }

        return response([
            "result" => "NG",
            "pos" => null
        ], 201);
    }
    public function getTeamPOs(Request $request){
        $user=$request->user();
        $client=Client::find($user->client_id);

        if($client->admin_id == $user->id){
            $pos=$client->pos()
                ->with(["user"=>function($query){
                    return $query->select(["id","name"]);
                },"customer","vendor"=>function($query){
                    return $query->select(["id","name"]);
                },"cartitems.product"=>function($query){
                    return $query->select(["id","name","o_price","b_price","thumbImage"]);
                },"cartitems"])
                ->orderBy("id","DESC")
                ->get();;

            \Log::info("getTeamPOs count: ".count($pos));
            if (count($pos)>0){
                return response([
                    "result"=>"OK",
                    "pos"=>$pos
                ],201);
            }
        }

            return response([
                "result"=>"NG",
                "pos"=>null
            ],201);
    }


    public function getMyPOs_customerAdmin(Request $request){
        $user=$request->user();
        $mypos=PO::myPOs($user->id)
            ->with(["user"=>function($query){
                return $query->select(["id","name"]);
            },"customer","vendor"=>function($query){
                return $query->select(["id","name"]);
            },"cartitems.product"=>function($query){
                return $query->select(["id","name","o_price","b_price","thumbImage"]);
            },"cartitems"])
            ->orderBy("id","DESC")
            ->get();


        \Log::info("getMyPOs_customerAdmin count: ".count($mypos));
        if (count($mypos)==0){
            return response([
                "result"=>"NG",
                "pos"=>null
            ],201);
        }

        return response([
            "result"=>"OK",
            "pos"=>$mypos
        ],201);
    }

    public function getDeleteMyPO(Request $request)
    {
        $po=PO::where("id",$request->input("poid"))->first();

        if ($po){
            $ret=$po->delete();

            if ($ret){
                return response([
                    "result"=>"OK"
                ],201);
            }
        }

        return response([
            "result"=>"NG"
        ],201);
    }

}
