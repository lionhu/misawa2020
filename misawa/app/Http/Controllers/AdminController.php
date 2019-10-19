<?php

namespace App\Http\Controllers;

use App\Events\SuperAdminMessageEvent;
use App\Models\AdminPODetails;
use App\Models\AdminPOs;
use App\Models\BrowseProduct;
use App\Models\Catalogue;
use App\Models\Client;
use App\Models\Customer;
use App\Models\PO;
use App\Models\Product;
//use App\Models\Vendor;
//use App\Models\VendorPODetails;
//use App\Models\VendorPOs;
use App\Models\Vendor;
use App\Models\VisitLog;
use App\Repositories\Eloquent\ClientRepository;
use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Eloquent\PORepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Role;
use App\User;
use Carbon\Carbon;
use function Couchbase\defaultDecoder;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use DB;
use Event;
use App\Events\SendPOMailEvent;
use App\Events\POChangePaymentStatusEvent;
use App\Events\POChangeStatusEvent;

use App\Utilities\Cart;
use App\Models\CartItem;
use Session;


class AdminController extends Controller
{
    protected $repoProduct;
    protected $repoUser;
    protected $repoCustomer;
    protected $repoClient;
    protected $repoPO;
    public function __construct(ProductRepository $productRepository,
                                UserRepository $userRepository,
                                CustomerRepository $customerRepository,
                                ClientRepository $clientRepository,
                                PORepository $repoPO)
    {
        $this->repoProduct=$productRepository;
        $this->repoUser=$userRepository;
        $this->repoCustomer=$customerRepository;
        $this->repoClient=$clientRepository;
        $this->repoPO=$repoPO;
    }

    public function index(){

        return view("admin.adminhome",[
            "resutl"=>"OK",
        ]);
    }

    public function newhome()
    {
        return view("admin.newhome");
    }



    public function postGetAllUsers(Request $request)
    {
        $users=User::with(["parent","client","roles"])->get();
        return response([
            "result"=>"OK",
            "users"=>$users
        ],201);
    }
    public function getRecentVisit(){
        $visitors=VisitLog::recent50()->with("user")->get();

        return view("admin.recentvisitors",[
            "visitors"=>$visitors
        ]);
    }

    public function postClientSummary(){
        $clientSummaryList=$this->repoPO->getClientSummaryList();
//        dd($clientSummaryList);

        $clientnames=[];
        $client_B_price=[];
        $client_profit=[];

        foreach ($clientSummaryList as $item){
            $clientnames[]=$item->client_name;
            $client_B_price[]=$item->total_B_price;
            $client_profit[]=$item->salesprofit;
        }

        return [
            "resutl"=>"OK",
            "clientnames"=>$clientnames,
            "client_B_price"=>$client_B_price,
            "client_profit"=>$client_profit
        ];
    }

    public function sendmessage(Request $request){
        $message=$request->input("message");

        if ($message !==""){
            event(new SuperAdminMessageEvent($message));
            // broadcast(new SuperAdminMessageEvent($message));
            return [
                "result"=>"OK",
                "message"=>$message
            ];
        }

        return [
            "result"=>"NG",
            "message"=>"No message was received!"
        ];

    }

    public function managerUsers(){
        $users=User::usersExceptSuperadmin()->with("client","roles")->get();
        $clients=Client::all();
        $roles=Role::all();

        return view("admin.adminusers",[
           "users"=>$users,
            "clients"=>$clients,
            "roles"=>$roles
        ]);
    }

    public function deleteUser(Request $request){
        $userid=$request->input("userid");
        \Log::info("delete user: ".$userid);

        if ($userid !==""){
            $this->repoUser->deleteUser($userid);
            return response([
                "result"=>"OK",
                "id"=>$userid
            ],201);

        }
        return response([
            "result"=>"NG",
            "user_id"=>0
        ],201);

    }

    public function getinfo(Request $request){
        $userid=$request->input("userid");

        if ($userid !==""){
            $user=$this->repoUser->getUserInfo($userid);
//            dd($user->roles[0]);
            $roleid=$user->roles[0]->id;
            return [
                "result"=>"OK",
                "user"=>$user,
                "roleid"=>$roleid
            ];
        }
        return [
            "result"=>"NG",
            "user"=>null
        ];
    }

    public function getManagementinfo(Request $request)
    {
        $clients=Client::with(["admin"])->get();
        $roles=Role::all();

        return response([
            "result"=>"OK",
            "clients"=>$clients,
            "roles"=>$roles
        ],201);
    }

    public function updateUserInfo(Request $request){
        \Log::info($request);
        $type=$request->input("type");
        $userid=$request->input("userid");
        $clientid=$request->input("clientid");
        $roleid=$request->input("roleid");
        $email=$request->input("email");
        $introcode=$request->input("introcode");
        $phone=$request->input("phone");
        $rate=$request->input("rate");


        $user=User::find($userid);

        \Log::info($introcode);
        switch ($type){
            case "basic":
                $user->introcode=$introcode;
                $user->rate=$rate;
                $user->email=$email;
                $user->phone=$phone;
                \Log::info("update basic: ");
                break;
            case "client":
                $user->client_id=$clientid;
                \Log::info("update client: ".$clientid);
                break;
            case "role":
                if (isset($roleid)) {
                    $user->roles()->sync($roleid);  // 如果有角色选中与用户关联则更新用户角色
                } else {
                    //多态关联删除
                    $user->roles()->detach(); // 如果没有选择任何与用户关联的角色则将之前关联角色解除
                }
                \Log::info("update role: ".$roleid);
                break;
            default:
                break;
        }
        $user->save();
         \Log::info($user);
        $user=User::where("id",$userid)->with(["parent","client","roles"])->first();

        return response([
            "result"=>"OK",
            "user"=>$user
        ],201);
    }

    public function getClientList(){
        $list=$this->repoClient->getClientList();

        return [
            "result"=>"OK",
            "clientlist"=>$list
        ];
    }

    public function download_POList(){

        $todaystr=Carbon::today()->format("Y_m_d");

        $pos=AdminPOs::all();
        $podetails=AdminPODetails::all();

        Excel::create('Order_all'.$todaystr,function($excel) use ($pos,$podetails){

            $excel->sheet('Order_POList', function($sheet) use ($pos){
                $sheet->fromModel($pos);
            });

            $excel->sheet('Order_DetailList', function($sheet) use ($podetails){
                $sheet->fromModel($podetails);
            });
        })->download('xlsx');
    }

    public function admin_getDownloadProducts(Request $request){
        
        $todaystr=Carbon::today()->format("Y_m_d");

        $products=Product::all();

        Excel::create('Products_all'.$todaystr,function($excel) use ($products){

            $excel->sheet('products', function($sheet) use ($products){
                $sheet->fromModel($products);
            });
        })->download('xlsx');
    }

    public function getMyPOs_admin(Request $request){
        $user=$request->user();
        $mypos=PO::myPOs($user->id)
            ->with("user","customer","vendor")
            ->orderBy("created_at","DESC")
            ->get();
//        dd($mypos);

        if ($mypos->count()==0){
            return redirect()->route("shop_home");
        }

        $total=$this->repoPO->getMyPOsTotal($user->id);


        $thismonthSummary=$this->repoPO->getThisMonthPOSummary_ByUserID($user->id);
        $allSummary=$this->repoPO->getAllPOSummary_byUser($user->id);

//        dd($thismonthSummary);
        if ($allSummary[0]->B_price != null){
            $allSummary_payrate_customer=round($allSummary[0]->Paid_Customer/$allSummary[0]->B_price*100,2);
        }else{
            $allSummary_payrate_customer=0;
        }

        if ($allSummary[0]->R_price != null){
            $allSummary_payrate_vendor=round($allSummary[0]->Paid_Vendor/$allSummary[0]->R_price*100,2);
        }else{
            $allSummary_payrate_vendor=0;
        }

        return view("admin.POs",[
            "summary_thismonth"=>$thismonthSummary[0],
            "summary_all"=>$allSummary[0],
            "mypos"=>$mypos,
            "all_payrate_customer"=>$allSummary_payrate_customer,
            "all_payrate_vendor"=>$allSummary_payrate_vendor,
            "po_count"=>$total[0]->po_count,
            "Qty"=>$total[0]->Qty,
            "O_price"=>$total[0]->O_price
        ]);
    }

    public function getAllPOs_admin(Request $request){
        $mypos=PO::with(["user"=>function($query){
            return $query->select(["id","name"]);
        },"customer"=>function($query){
            return $query->select(["id","name"]);
        },"vendor"=>function($query){
            return $query->select(["id","name"]);
        },"cartitems.product"=>function($query){
            return $query->select(["id","name","o_price","r_price","b_price","thumbimage"]);
        },"cartitems"])
            ->orderBy("id","DESC")
            ->get();

        \Log::info("getAllPOs_admin");

        if (count($mypos)!=0){
            return response([
                "result"=>"OK",
                "pos"=>$mypos,
                "rate"=>env("JPYRate")
            ],201);
        }
        return response([
            "result"=>"NG",
            "pos"=>null
        ],201);
    }

    public function getPOsOfStatus_admin(Request $request){
        $status=$request->input("status");
        if($status !="all"){
            $mypos=PO::ofStatus($status)->with(["user"=>function($query){
                return $query->select(["id","name"]);
            },"customer"=>function($query){
                return $query->select(["id","name"]);
            },"vendor"=>function($query){
                return $query->select(["id","name"]);
            },"cartitems.product"=>function($query){
                return $query->select(["id","name","o_price","r_price","b_price","thumbimage"]);
            },"cartitems"])
                ->orderBy("id","DESC")
                ->get();
        }else{
            $mypos=PO::with(["user"=>function($query){
                return $query->select(["id","name"]);
            },"customer"=>function($query){
                return $query->select(["id","name"]);
            },"vendor"=>function($query){
                return $query->select(["id","name"]);
            },"cartitems.product"=>function($query){
                return $query->select(["id","name","o_price","r_price","b_price","thumbimage"]);
            },"cartitems"])
                ->orderBy("id","DESC")
                ->get();
        }


        \Log::info("getAllPOs_admin");

        if (count($mypos)!=0){
            return response([
                "result"=>"OK",
                "pos"=>$mypos,
                "rate"=>env("JPYRate")
            ],201);
        }
        return response([
            "result"=>"NG",
            "pos"=>null
        ],201);
    }
    
    public function monthlySummary(Request $request){

        $query="CALL proc_monthly_summary()";
        $result=$this->repoPO->CallProcedure($query);

        if($result){
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

    public function resentMail(Request $request){
        $poid=$request->input("poid");
        $receiver=$request->input("receiver");
        $messageType=$request->input("messageType");

        \Log::info($request);

        $po=PO::find($poid);

        if ($po !=null){
            Event::fire(new SendPOMailEvent($po,$messageType,$receiver));
            return response([
                "result"=>"OK",
                "poid"=>$poid
            ],201);
        }
        return response([
            "result"=>"NG",
            "poid"=>null
        ],201);

    }

    public  function updatePaymentStatus(Request $request){
        $poid=$request->input("poid");
        $customerpay=$request->input("customerpay");
        $vendorpay=$request->input("vendorpay");
        $marginpay=$request->input("marginpay");

        $po=PO::find($poid);

        if ($po !=null){
            Event::fire(new POChangePaymentStatusEvent($po,"customer",$customerpay));
            Event::fire(new POChangePaymentStatusEvent($po,"vendor",$vendorpay));
            Event::fire(new POChangePaymentStatusEvent($po,"margin",$marginpay));
        }

        return [
            "result"=>"OK",
            "poid"=>$poid
        ];
    }

    public function updatePOStatus(Request $request){
        $poid=$request->input("poid");
        $status=$request->input("status");

        $po=PO::find($poid);

        if ($po !=null){
            Event::fire(new POChangeStatusEvent($po,$status));
        }

        return [
            "result"=>"OK",
            "poid"=>$poid
        ];
    }
    
    public function getUserHistory(Request $request,$userid){
        $browseitems=BrowseProduct::userHistory($userid)->with("product")->get();
        $user=User::findOrFail($userid);

       return view("admin.userhistory",[
          "browseitems" =>$browseitems,
           "user"=>$user
       ]);
    }
    
    public function printPO(Request $request,$poid){

        $po=$this->repoPO->getVendor_PrintedPO_ByPOID($poid);

        return view("PrintPOS.PO_OpenValue",[
            "po"=>$po,
            "user"=>$po->user ,
            "customer"=>$po->customer ,
            "vendor"=>$po->vendor,
            "cart_items"=>$po->cartitems
        ]);
    }

    public function getEditPO(Request $request,$poid){
        $poitems=CartItem::where("po_id",$poid)->get();


        if ($poitems != null){

            $mycart=new Cart(null);

            foreach ($poitems as $poitem){
                $mycart->addItem($poitem->product_id,$poitem->qty);
            }

            Session::put(env("CART_NAME"),$mycart);
            Session::put("cart_mode","edit");
            Session::put("edit_poid",$poid);

            return view("shop.cart",[
                "cart"=>$mycart,
                "cart_total"=>$mycart->Total_Qty,
                "cart_mode"=>"edit"

            ]);
        }
    }

    public function getupdatePO(Request $request)
    {
        $mycart=Session::has(env("CART_NAME"))?Session::get(env("CART_NAME")):null;
        $poid=Session::has("edit_poid")?Session::get("edit_poid"):null;

        $po=PO::find($poid);
        $user=User::find($po->user_id);
        $user_rate=$user->rate;
        $po=$this->repoPO->po_update($po,$user_rate,$mycart);

        Session::forget("cart_mode");
        Session::forget("edit_poid");
        Session::forget(env("CART_NAME"));

        return redirect()->route("admin_getAllMyPOs");
    }

    public function managerCustomers(){
        $customers=Customer::with(["user","pos"])->get();

        return response([
            "result"=>"OK",
            "customers"=>$customers
        ],201);
    }

    public function getCustomerinfo(Request $request){
        $customerid=$request->input("customerid");

        if ($customerid !==""){
            $customer=$this->repoCustomer->getInfo($customerid);
            return [
                "result"=>"OK",
                "customer"=>$customer
            ];
        }
    }

    public function updateCustomerInfo(Request $request){
        $customer=null;
        $customer["postcode"]=$request->input("postcode");
        $customer["address1"]=$request->input("address1");
        $customer["address2"]=$request->input("address2");
        $customer["email"]=$request->input("email");
        $customer["phone"]=$request->input("phone");
        $customer["id"]=$request->input("customerid");
        $customer["name"]=$request->input("name");
        $customer["sex"]=$request->input("sex");

        \Log::info($customer);
        $this->repoCustomer->update_info_byID($customer,$customer["id"]);

        $new_customer=Customer::with(["user","pos"])->where("id",$customer["id"])->first();

        if($new_customer){
            return response([
                "result"=>"OK",
                "customer"=>$new_customer
            ],201);
        }else{
            return response([
                "result"=>"NG",
                "customer"=>null
            ],201);
        }

    }

    public function deleteCustomer(Request $request){

        $customer_id=$request->input("id");

        if ($customer_id !==""){
            $opt=$this->repoCustomer->delete($customer_id);
            return [
                "result"=>"OK",
                "opt"=>$opt,
                "customer_id"=>$customer_id
            ];
        }
    }

    public function getSystemManagementInfo(Request $request)
    {
        $vendors=Vendor::all();
        $catalogues=Catalogue::with("subcatalogues")->get();
        $count_user=count(User::all(["id"]));
        $po_count=count(PO::all(["id"]));
        $customer_count=count(Customer::all(["id"]));

        \Log::info($catalogues);
        return response([
            "result"=>"OK",
            "rate"=>env("JPYRate"),
            "vendors"=>$vendors,
            "catalogues"=>$catalogues,
            "count_user"=>$count_user,
            "po_count"=>$po_count,
            "customer_count"=>$customer_count,
        ],201);
    }

    public function updatePOInfo(Request $request)
    {
        $poid=$request->input("poid");
        $po=PO::find($poid);
        $type=$request->input("type");

        \Log::info($type);

        if ($po){

            switch ($type){
                case "user":
                    $po->user_id=$request->input("user_id");
                    break;
                case "locked":
                    $po->locked=$request->input("locked");
                    break;
                case "vendor":
                    $po->vendor_id=$request->input("vendorid");
                    break;
                case "delivery_no":
                    $po->delivery_no=$request->input("delivery_no");
                    break;
                case "payment":
                    $po->paid_customer=$request->input("paid_customer");
                    $po->paid_vendor=$request->input("paid_vendor");
                    $po->paid_margin=$request->input("paid_margin");
                    break;
                case "status":
                    $status=$request->input("status");
                    if ($status=="Delivering"){
                        $po->delivery_no=$request->input("delivery_no");
                    }
                    Event::fire(new POChangeStatusEvent($po,$status));
                    break;
                case "P_Adjust":
                    $po->cart_Dis_Price=$request->input("cart_Dis_Price");
                    $po->P_Adjust=1;
                    $po->memo=$request->input("memo");
                    break;
                default:

            }

            $po->save();

            $po=PO::with(["user"=>function($query){
                return $query->select(["id","name"]);
            },"customer"=>function($query){
                return $query->select(["id","name"]);
            },"vendor"=>function($query){
                return $query->select(["id","name"]);
            },"cartitems.product"=>function($query){
                return $query->select(["id","name","o_price","r_price","b_price","thumbimage"]);
            },"cartitems"])
                ->where("id",$poid)
                ->orderBy("id","DESC")
                ->first();


            return response([
                "result"=>"OK",
                "po"=>$po
            ],201);

        }

        if($type=="batchPayvendor"){
            \Log::info("processing batchPayvendor");
            $batchPayVendorPOS=$request->input("batchPayVendorPOS");

            foreach ($batchPayVendorPOS as $PO) {
                \Log::info("process poid:");
                        \Log::info($PO);
                $_po=PO::find($PO["id"]);
                if($_po){
                    $_po->paid_vendor=1;
                    $_po->save();
                }
            }

            $mypos=PO::with(["user"=>function($query){
                return $query->select(["id","name"]);
            },"customer"=>function($query){
                return $query->select(["id","name"]);
            },"vendor"=>function($query){
                return $query->select(["id","name"]);
            },"cartitems.product"=>function($query){
                return $query->select(["id","name","o_price","r_price","b_price","thumbimage"]);
            },"cartitems"])
                ->orderBy("id","DESC")
                ->get();


            \Log::info(count($mypos));

            return response([
                "result"=>"OK",
                "pos"=>$mypos
            ],201);
        }

        return response([
            "result"=>"NG",
            "po"=>null
        ],201);



    }

    public function postDeletePO(Request $request)
    {
        $poid=$request->input("poid");
        \Log::info("postDeletePO : ".$poid);

        if ($poid !==""){
            $po=PO::find($poid);
            if($po){
                $po->delete();

                return response([
                    "result"=>"OK",
                    "id"=>$poid
                ],201);
            }


        }
        return response([
            "result"=>"NG",
            "id"=>0
        ],201);

    }
}
