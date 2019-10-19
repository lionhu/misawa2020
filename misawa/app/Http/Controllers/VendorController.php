<?php

namespace App\Http\Controllers;

use App\Models\MisawaCustomers;
use Event;
use App\Events\SuperAdminMessageEvent;
use App\Events\POChangeStatusEvent;

use App\Models\Client;
use App\Models\PO;
use App\Repositories\Eloquent\PORepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Role;
use App\User;
use Carbon\Carbon;
use App\Models\VendorPODetails;
use App\Models\VendorPOs;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    protected $repoProduct;
    protected $repoUser;
    protected $repoPO;
    public function __construct(ProductRepository $productRepository,
                                UserRepository $userRepository,
                                PORepository $PORepository)
    {
        $this->repoProduct=$productRepository;
        $this->repoUser=$userRepository;
        $this->repoPO=$PORepository;
    }

    public function index(){
        return view("vendor.home");
    }

    public function getStatusPOs(Request $request){

        $user=$request->user();
        $status=$request->input("status");

        if($status =="all"){
            $pos=PO::ofVendor($user->id)->with(["user"=>function($query){
                    return $query->select(["id","name"]);
                },"customer"=>function($query){
                    return $query->select(["id","name"]);
                },"vendor"=>function($query){
                    return $query->select(["id","name"]);
                },"cartitems.product"=>function($query){
                    return $query->select(["id","name","name_jp","o_price","r_price","b_price","product_code","thumbimage"]);
                },"cartitems"])
                    ->orderBy("id","DESC")
                    ->get();
        }elseif ($status=="unpaid"){
            $pos=PO::ofUnpaid()->ofVendor($user->id)->with(["user"=>function($query){
                return $query->select(["id","name"]);
            },"customer"=>function($query){
                return $query->select(["id","name"]);
            },"vendor"=>function($query){
                return $query->select(["id","name"]);
            },"cartitems.product"=>function($query){
                return $query->select(["id","name","name_jp","o_price","r_price","b_price","product_code","thumbimage"]);
            },"cartitems"])
                ->orderBy("id","DESC")
                ->get();
        }else{
            $pos=PO::ofStatus($status)->ofVendor($user->id)->with(["user"=>function($query){
                return $query->select(["id","name"]);
            },"customer"=>function($query){
                return $query->select(["id","name"]);
            },"vendor"=>function($query){
                return $query->select(["id","name"]);
            },"cartitems.product"=>function($query){
                return $query->select(["id","name","name_jp","o_price","r_price","b_price","product_code","thumbimage"]);
            },"cartitems"])
                ->orderBy("id","DESC")
                ->get();
        }


        if (count($pos)){
            return response([
                "result"=>"OK",
                "pos"=>$pos
            ],201);
        }

        return response([
            "result"=>"NG",
            "pos"=>null
        ],201);
    }

    public function setEMScode(Request $request){
        $emscode=$request->input("delivery_no");
        $poid=$request->input("poid");

        if ($emscode !=="" && $poid !==""){
            \Log::info("add ems code: ".$emscode." to PO: ".$poid );
            $po=$this->repoPO->setEMSCode($emscode,$poid);
            
            Event::fire(new POChangeStatusEvent($po,"Delivering"));
            
            return response([
              "result"=>"OK",
                "po"=>$po
            ],201);
        }else{
            \Log::info("nothing");

            return response([
                "result"=>"NG",
                "po"=>null
            ],201);
        }

    }

    public function printPO(Request $request,$poid){

        $po=$this->repoPO->getVendor_PrintedPO_ByPOID($poid);

        return view("vendor.PO_vendor",[
            "po"=>$po,
           "user"=>$po->user ,
           "customer"=>$po->customer ,
           "vendor"=>$po->vendor,
            "cart_items"=>$po->cartitems
        ]);
    }

    public function getLoadPOByID(Request $request){
        $poid=$request->input("poid");

        $po=PO::with("user","customer","vendor","cartitems","cartitems.product")
            ->where("id",$poid)->first();

        $mycart=json_decode($po->cart);
        if ($po){
            return [
                "result"=>"OK",
                "cart"=>$mycart,
                "po"=> $po,
                "user"=>$po->user,
                "customer"=>$po->customer,
                "vendor"=>$po->vendor
            ];
        }

    }

    public  function getAllVendorProducts(Request $request){
        $vendorid=$request->user()->id;
        $products=$this->repoProduct->getAllProducts_ByVendorID($vendorid);
        return view("vendor.products",[
            "products"=>$products
        ]);
    }

    public function getVendorProducts(Request $request)
    {

        $vendorid=$request->user()->id;
        $products=$this->repoProduct->getAllProducts_ByVendorID($vendorid);


        if($products){
            return response([
                "result"=>"OK",
                "products"=>$products
            ],201);
        }
    }

    public  function getProductByID(Request $request){
        $productid=$request->input("productid");
        $product=$this->repoProduct->getVendorProductByID($productid);

        return [
            "result"=>"OK",
            "product"=>$product
        ];
    }

    public function postMonthlySummary(Request $request)
    {
        $vendor_id=$request->user()->id;
        $query="CALL proc_monthly_summary_byVendorID($vendor_id)";
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

    public function download_POList(Request $request){
        $vendor_id=$request->user()->id;
        $todaystr=Carbon::today()->format("Y_m_d");

        $pos=VendorPOs::vendorAllPOs($vendor_id)->get();
        $podetails=VendorPODetails::vendorAllPOs($vendor_id)->get();

        Excel::create('Order_all'.$todaystr,function($excel) use ($pos,$podetails){

            $excel->sheet('Order_POList', function($sheet) use ($pos){
                $sheet->fromModel($pos);
            });

            $excel->sheet('Order_DetailList', function($sheet) use ($podetails){
                $sheet->fromModel($podetails);
            });


        })->download('xlsx');


    }

    public function download_MisawaCustomer(Request $request)
    {
        $customers=MisawaCustomers::all();

        if ($customers){
            Excel::create('MisawaCustomers',function($excel) use ($customers){

                $excel->sheet('customerList', function($sheet) use ($customers){
                    $sheet->fromModel($customers);
                });
            })->download('xlsx');
        }
    }
    
        public function download_POCustomer(Request $request,$poid)
    {
        $po=PO::with(["customer"=>function($query){
            $query->select();
        }])
        ->where("id",$poid)
        ->select("id","created_at")->first();
        
        dd($po);
            
        // if ($po){
        //     Excel::create('POCustomer',function($excel) use ($po){

        //         $excel->sheet('customer', function($sheet) use ($po){
        //             $sheet->fromArray($po);
        //         });
        //     })->download('xlsx');
        // }
    }


}
