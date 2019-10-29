<?php
/**
 * Created by PhpStorm.
 * User: liuxiang
 */
namespace App\Repositories\Eloquent;

use App\Models\PO;
use App\Models\CartItem;
use App\Models\PODeleted;
use App\Models\Product;
use Carbon\Carbon;
use DB;
use Session;

class PORepository extends Repository
{

    protected $vendor_summary="view_summary_vendor_po";
    protected $vendor_thismonth_summary="view_thismonth_summary_vendor_po";

    protected $view_po_list_vendor="view_po_list_vendor";
    protected $client_po_summary_view="client_po_summary_view";

//    superadmin section
    protected $proc_monthly_accumulateSum_all="proc_monthly_accumulateSum_all";

    function model()
    {
        return PO::class;
    }

//    Superadmin section

    public function CallProcedure($procedurename){

        $result=DB::select($procedurename);
        return $result;
    }

    public function getClientSummaryList(){
        $query="select * from ".$this->client_po_summary_view;
        $polist=DB::select($query);

        return $polist;
    }

    public function getMonthlySummary(){
        $query="CALL proc_monthly_accumulateSum_all()";

        $polist=DB::select($query);
        return $polist;
    }

    public function getPOList_ByUserID($userid){
        $query="select * from ".$this->view_po_list." WHERE user_id=".$userid;
        $polist=DB::select($query);

        return $polist;
    }

    public function getPOList_ByVendorID($vendor_id){
        $query="select * from ".$this->view_po_list_vendor." WHERE vendor_id=".$vendor_id;
        $polist=DB::select($query);

        return $polist;
    }

    public function po_update($po,$user_rate,$cart){
        foreach ($po->cartitems as $cartitem){
            $cartitem->delete();
        }

        $Total_B_Price=0;
        $Total_R_Price=0;
        $Total_Dis_Price=0;
        $Total_Dis_J_Price=0;

        $po->cart_Qty=$cart->Total_Qty;
        $po->cart_O_Price=$cart->Total_O_Price;
        $po->cart=json_encode($cart);
        $po->save();

        foreach ($cart->items as $item){
            $newitem=new CartItem();
            $newitem->po_id=$po->id;
            $newitem->qty=$item["qty"];
            $newitem->total_o_price=$item["total_o_price"];
            $newitem->save();

            $product_id=$item["item"]->id;
            $product=Product::findOrFail($product_id);

            $newitem->product_id=$product_id;
            $newitem->o_price=$product->o_price;

            $newitem->b_price=$product->b_price;
            $newitem->total_b_price=$item["qty"]*$product->b_price;
            $Total_B_Price +=$newitem->total_b_price;

            $newitem->r_price=$product->r_price;
            $newitem->total_r_price=$item["qty"]*$product->r_price;
            $Total_R_Price +=$newitem->total_r_price;


            $newitem->dis_price=$product->b_price+($product->o_price-$product->b_price)*$user_rate;
            $newitem->total_dis_price=$item["qty"]*$newitem->dis_price;
            $Total_Dis_Price +=$newitem->total_dis_price;

            $newitem->dis_j_price=$product->j_price;
            $newitem->total_dis_j_price=$item["qty"]*$newitem->dis_j_price;
            $Total_Dis_J_Price +=$newitem->total_dis_j_price;


            $newitem->save();

            $po->cartitems()->save($newitem);
        }

        $po->cart_R_Price=$Total_R_Price;
        $po->cart_B_Price=$Total_B_Price;
        $po->cart_Dis_Price=$Total_Dis_Price;
        $po->cart_Dis_J_Price=$Total_Dis_J_Price;

        $po->save();

        return $po;
    }


    public function poAddNew($cartitems,$poinfo,$user,$customer,$adminCart){
        $po=new PO();
        $Total_B_Price=0;
        $Total_R_Price=0;
        $Total_Dis_Price=0;
        $Total_Dis_J_Price=0;

        $po->user_id=$user->id;
        $po->customer_id=$customer->id;
        $po->paid_customer=0;
        $po->paid_vendor=0;
        $po->delivery_no="";
        $po->status="new";
        $po->memo=$poinfo["memo"];
        $po->vendor_id=$poinfo["vendor_id"];


        $po->cart_Qty=$adminCart->Total_Qty;
        $po->cart_O_Price=$adminCart->Total_O_Price;
        $po->cart_R_Price=$adminCart->Total_R_Price;
        $po->cart_B_Price=$adminCart->Total_B_Price;
        $po->cart_Dis_Price=$adminCart->Total_Dis_Price;
        $po->cart_Dis_J_Price=$adminCart->Total_Dis_J_Price;


        $po->cart=json_encode($cartitems);
        $po->cart_admin=json_encode($adminCart);
        $po->save();

        \Log::info("cartitems number: ".count($cartitems));
        foreach ($cartitems as $item){
            $product=Product::find($item["product"]["id"]);

            $newitem=new CartItem();
            $newitem->po_id=$po->id;

            \Log::info($item);
            $newitem->qty=$item["qty"];
            $newitem->product_id=$product->id;
            $newitem->o_price=$product->o_price;
            $newitem->b_price=$product->b_price;
            $newitem->dis_price=$item["product"]["b_price"];
            $newitem->dis_j_price=$item["product"]["j_price"];
            $newitem->r_price=$product->r_price;



            $newitem->total_o_price=$item["total_o"];
            $newitem->total_dis_price=$item["total_b"];
            $newitem->total_dis_j_price=$item["total_j"];
            $newitem->total_b_price=$product->b_price*$item["qty"];
            $newitem->total_r_price=$product->r_price*$item["qty"];

            $newitem->save();

            $po->cartitems()->save($newitem);
        }

        $po->save();

        return $po;
    }

    public function getMyPOsTotal($userid){

        $query="CALL proc_PO_summary_ByUserID(".$userid.")";

        $polist=DB::select($query);

        return $polist;
    }

    public function deletePO_ByID($po){
        $po_deleted=new PODeleted();

          $po_deleted->user_id=$po->user_id;
          $po_deleted->customer_id=$po->customer_id;
          $po_deleted->vendor_id=$po->vendor_id;
          $po_deleted->cart=$po->cart;
          $po_deleted->cart_Qty=$po->cart_Qty;
          $po_deleted->cart_R_Price=$po->cart_R_Price;
          $po_deleted->cart_B_Price=$po->cart_B_Price;
          $po_deleted->cart_J_Price=$po->cart_J_Price;
          $po_deleted->cart_O_Price=$po->cart_O_Price;
          $po_deleted->memo=$po->memo;
          $po_deleted->transfer_date=$po->transfer_date;
          $po_deleted->transfer_amount_cn=$po->transfer_amount_cn;
          $po_deleted->transfer_amount_jp=$po->transfer_amount_jp;
          $po_deleted->status=$po->status;
          $po_deleted->delivery_date=$po->delivery_date;
          $po_deleted->delivery_company=$po->delivery_company;
          $po_deleted->delivery_no=$po->delivery_no;
          $po_deleted->created_at=$po->created_at;
          $po_deleted->updated_at=$po->updated_at;
          $po_deleted->warehouse_id=$po->warehouse_id;
          $po_deleted->paid_customer=$po->paid_customer;
          $po_deleted->paid_vendor=$po->paid_vendor;

        $po_deleted->save();

        return $po->delete();
    }

    public function updatePO_ByID($po,$paid_vendor,$paid_customer,$paid_margin,$status){

        $po->status=$status;
        $po->paid_vendor=$paid_vendor;
        $po->paid_customer=$paid_customer;
        $po->paid_margin=$paid_margin;
        $po->save();

        return $po;
    }

    public function POChangePaymentStatus($po,$type,$status){

        if($type == "customer"){
            $po->paid_customer=$status;
        }
        if($type == "vendor"){
            $po->paid_vendor=$status;
        }
        if($type == "margin"){
            $po->paid_margin=$status;
        }
        $po->save();

        return $po;
    }

    public function POChangeStatus($po,$status){

        $po->status=$status;
        $po->save();

        return $po;
    }

    public function getThisMonthPOSummary_ByUserID($userid){

        $query="CALL koun_PO_thismonth_paid_ByUserID(".$userid.")";

        $polist=DB::select($query);

        return $polist;
    }

    public function getAllPOSummary_byUser($userid){
        $query="CALL koun_PO_all_paid_ByUserID(".$userid.")";

        $polist=DB::select($query);
        return $polist;
    }

//    vendor section

    public function getVendor_POsTotal($vendorid){
        $query="select * from ".$this->vendor_summary." WHERE vendor_id=".$vendorid;
        $polist=DB::select($query);

        return $polist;
    }

    public function getVendor_POsTotal_thismonth($vendorid){
        $query="select * from ".$this->vendor_thismonth_summary." WHERE vendor_id=".$vendorid;
        $polist=DB::select($query);

        return $polist;
    }

    public function setEMSCode($emscode,$poid){
        $po=PO::find($poid);

        $po->delivery_no=$emscode;
        $po->delivery_date=Carbon::now();
        $po->save();
        return $po;
    }

    public function getVendor_PrintedPO_ByPOID($poid){
        $po=PO::with("user","customer","vendor","cartitems","cartitems.product")
            ->where("id",$poid)
            ->first();
        return $po;
    }


    public function get_PrintedPO_ByPOID($userid,$poid){
        $po=PO::with("user","customer","vendor","cartitems","cartitems.product")
            ->where("id",$poid)
            ->first();
        if($po->user_id ==$userid){
            return $po;
        }else{
            return null;
        }
    }


}