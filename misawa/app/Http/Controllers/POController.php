<?php

namespace App\Http\Controllers;

use App\Http\Requests\requestCommentProduct;
use App\Models\Vendor;
use App\Utilities\Cart;
use App\Utilities\CartItem;
use Illuminate\Http\Request;
use App\Models\PO;
use App\Repositories\Eloquent\PORepository;
use Event;

use App\Events\OrderCompletedEvent;
use App\Events\OrderPlaced2VendorEvent;
use App\Events\DeliverPackageEvent;

class POController extends Controller
{
    //
    protected $repositoryPO;
    public function __construct(PORepository $PORepository)

    {
        $this->repositoryPO=$PORepository;
    }

    public function getAllMyPOS(Request $request)
    {
        $user=$request->user();
        \Log::info($user->id);

        $mypos=PO::with(["customer","vendor"=>function($query){
            return $query->select(["id","name"]);
        }])->where("user_id",$user->id)
            ->orderBy("id","DESC")
            ->get();

        \Log::info("getAllMyPOS_member");

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

    public function printMyPO(Request $request,$poid){

        $po=$this->repositoryPO
            ->get_PrintedPO_ByPOID($request->user()->id,$poid);

        if($po){
            return view("PrintPOS.PO_Distributor",[
                "po"=>$po,
                "user"=>$po->user ,
                "customer"=>$po->customer ,
                "vendor"=>$po->vendor,
                "cart_items"=>$po->cartitems
            ]);
        }
    }
    public function printOpenPO(Request $request,$poid){

        $po=$this->repositoryPO
            ->get_PrintedPO_ByPOID($request->user()->id,$poid);

        if($po){
            return view("PrintPOS.PO_OpenValue",[
                "po"=>$po,
                "user"=>$po->user ,
                "customer"=>$po->customer ,
                "vendor"=>$po->vendor,
                "cart_items"=>$po->cartitems
            ]);
        }
    }

    public function PrintPO(Request $request,$type,$poid)
    {
        \Log::info("print ID: ".$poid);
        $po=PO::with("user","customer","vendor","cartitems","cartitems.product")
            ->where("id",$poid)
            ->first();

            switch ($type){
                case "open":
                    $viewname="PrintPOS.PO_OpenValue";
                    break;
                case "dis":
                    $viewname="PrintPOS.PO_Distributor";
                    break;
                case "phar":
                    break;
                default:
                    break;
            }

            if($po){
                return view($viewname,[
                    "po"=>$po,
                    "user"=>$po->user ,
                    "customer"=>$po->customer ,
                    "vendor"=>$po->vendor,
                    "cart_items"=>$po->cartitems
                ]);
            }else{
                return "error";
            }


    }
//
//
//
//
//
//    public function testpo(){
//        dd($this->repositoryPO->test());
//    }

    public function getMyPOs_customer(Request $request){
        $user=$request->user();
        $mypos=PO::myPOs($user->id)
                ->with("user","customer","vendor")
                ->orderBy("created_at","DESC")
                ->get();
//        dd($mypos);

        if ($mypos->count()==0){
            return redirect()->route("shop_home");
        }

        $total=$this->repositoryPO->getMyPOsTotal($user->id);


        $thismonthSummary=$this->repositoryPO->getThisMonthPOSummary_ByUserID($user->id);
        $allSummary=$this->repositoryPO->getAllPOSummary_byUser($user->id);

        if ($allSummary[0]->B_price != null){
            $allSummary_payrate_customer=round($allSummary[0]->Paid_Customer/$allSummary[0]->B_price*100,2);
        }else {
            $allSummary_payrate_customer = 0;
        }


        return view("customer.myPOs",[
            "summary_thismonth"=>$thismonthSummary[0],
            "summary_all"=>$allSummary[0],
            "mypos"=>$mypos,
            "all_payrate_customer"=>$allSummary_payrate_customer,
            "po_count"=>$total[0]->po_count,
            "Qty"=>$total[0]->Qty,
            "O_price"=>$total[0]->O_price
        ]);
    }

    public function postMyPOs(Request $request){
        $user=$request->user();
        $mypos=PO::myPOs($user->id)->with("user","customer","vendor")->get();

        $total=$this->repositoryPO->getMyPOsTotal($user->id);

        return [
            "mypos"=>$mypos,
            "po_count"=>$total[0]->po_count,
            "Qty"=>$total[0]->Qty,
            "O_price"=>$total[0]->O_price
        ];
    }

    public function getPOCart(Request $request){
        $poid=$request->input("poid");
        $po=PO::findOrFail($poid);
        $mycart=json_decode($po->cart);

        if ($po){
            return [
                "result"=>"OK",
                "cart"=>$mycart,
                "Total_Qty"=> $mycart->Total_Qty,
                "Total_O_Price"=>$mycart->Total_O_Price
            ];
        }
    }

    public function getPOByID(Request $request){
        $poid=$request->input("poid");
        $po=PO::with("user","customer","vendor")
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

    public function postDeletePO(Request $request){
        $poid=$request->input("poid");

        $po=PO::where("id",$poid)->first();

        if($po->user_id == $request->user()->id){
            $ret=$this->repositoryPO->deletePO_ByID($po);
        }

        return response([
            "result"=>"OK",
            "poid"=>$poid
        ],201);

    }


    public function updatePOVendor(Request $request){
        $poid=$request->input("poid");
        $vendor_id=$request->input("vendor_id");

        if ($poid){
            PO::where("id",$poid)->update(["vendor_id"=>$vendor_id]);


            $vendor=Vendor::find($vendor_id);
            return [
                "vendorname"=>$vendor->name
            ];
        }
    }


    public function updatePO(Request $request){
        $poid=$request->input("poid");

        if ($request->input("paid_vendor")=="true"){
            $paid_vendor=1;
        }else{
            $paid_vendor=0;
        }
        if ($request->input("paid_customer")=="true"){
            $paid_customer=1;
        }else{
            $paid_customer=0;
        }

        if ($request->input("paid_margin")=="true"){
            $paid_marginr=1;
        }else{
            $paid_margin=0;
        }

        $status=$request->input("status");

//        dd($request->all());
        $po=PO::find($poid);

        $ret="";
        if ($po){
            $ret=$this->repositoryPO->updatePO_ByID($po,$paid_vendor,$paid_customer,$paid_margin,$status);
        }
//    Event::fire(new OrderPlacedEvent($po));
        if ($status=="processing"){

            Event::fire(new OrderPlaced2VendorEvent($po));
        }elseif ($status=="Delivering"){

            Event::fire(new DeliverPackageEvent($po));
        }elseif ($status=="completed"){

            Event::fire(new OrderCompletedEvent($po));
        }

        return [
            "result"=>"OK",
            "ret"=>$ret
        ];

    }

    public function postUserPOSummary(Request $request){
        $user=$request->user();

        $thismonthSummary=$this->repositoryPO->getThisMonthPOSummary_ByUserID($user->id);
        $allSummary=$this->repositoryPO->getAllPOSummary_byUser($user->id);
        return [
            "summary_thismonth"=>$thismonthSummary[0],
            "summary_all"=>$allSummary[0]
        ];
    }

    //将老的数据库中的订单数据里的cart字段，调整成新数据库格式
    public function migratePOS(){

        $pos=PO::all();

        foreach ($pos as $po){
            $newcart=new Cart(null);
            $cartitems=$po->cartitems;

            if ($cartitems !=null){
                foreach ($cartitems as $item){
                    $newcart->addItem($item["product_id"],$item["qty"]);
                }
                $po->cart=json_encode($newcart);
                $po->save();
            }
        }
        return redirect()->back();

    }

    public function test(){

        $po=PO::find(203);

        $ret="";
        if ($po){
            $ret=$this->repositoryPO->deletePO_ByID($po);
        }

        echo "hello";
    }
}
