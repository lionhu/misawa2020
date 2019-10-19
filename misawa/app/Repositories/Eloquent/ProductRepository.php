<?php
/**
 * Created by PhpStorm.
 * User: liuxiang
 */
namespace App\Repositories\Eloquent;

use App\Models\CartItem;
use App\Models\Product;
use DB;

class ProductRepository extends Repository
{

    function model()
    {
        return Product::class;
    }

    public function getSalesTop5(){

        $query="CALL Top5_Sales_Products()";

        $top5=DB::select($query);

        return $top5;
    }


    public function getSafeProductInfo($productid){
        $product=Product::where("id",$productid)->get([
            "id","name","name_jp","subcatalogue_id","catalogue_id",
            "vendor_id","o_price","ingredient","product_code","postimage",
            "thumbImage","manufactory","rate",
            "flag_suggest"
        ]);

        if ($product->count()){
            return $product[0];
        }else{
            return null;
        }
    }

    public function addNewProductInfo($request){
        $product_id=Product::create([
            "active"=>$request->input("active"),
            "vendor_id"=>$request->input("vendor_id"),
            "manufactory"=>$request->input("manufactory"),
            "product_code"=>$request->input("product_code"),
            "name"=>$request->input("name"),
            "name_jp"=>$request->input("name_jp"),
//            "unit"=>$request->input("unit"),
//            "tablets"=>$request->input("tablets"),
            "o_price"=>$request->input("o_price"),
            "b_price"=>$request->input("b_price"),
            "r_price"=>$request->input("r_price"),
            "efficacy"=>$request->input("efficacy"),
            "website"=>$request->input("website"),
            "description"=>$request->input("description"),
            "subcatalogue_id"=>$request->input("subcatalogue_id"),
            "catalogue_id"=>$request->input("catalogue_id")
        ])->id;

        return $product_id;



    }

    public function updateProductInfo($request,$id){
        $product=Product::find($id);


            $product->active=$request->input("active");
            $product->vendor_id=$request->input("vendor");
            $product->manufactory=$request->input("manufactory");
            $product->product_code=$request->input("product_code");
            $product->name=$request->input("name");
            $product->name_jp=$request->input("name_jp");
            $product->unit=$request->input("unit");
            $product->tablets=$request->input("tablets");
            $product->o_price=$request->input("o_price");
            $product->b_price=$request->input("b_price");
            $product->r_price=$request->input("r_price");
            $product->efficacy=$request->input("efficacy");
            $product->website=$request->input("website");
            $product->description=$request->input("description");
            $product->subcatalogue_id=$request->input("subcatalogue");
            $product->catalogue_id=$request->input("catalogue");

            $product->save();


        return $product;



    }

    public function searchForProduct($text){
        $products=Product::searchProduct($text)->active()->get();
        return $products;

    }

    public function getAllProducts_ByVendorID($vendorid){
        $products=Product::allVendorProducts($vendorid)->get();
        return $products;
    }

    public function getVendorProductByID($productid){
        $product=Product::with("catalogue","subcatalogue")->where("id",$productid)->get([
            "id","name","name_jp","subcatalogue_id","catalogue_id",
            "vendor_id","r_price","ingredient","product_code","postimage",
            "thumbImage","efficacy","manufactory","description","rate",
            "flag_suggest"
        ]);

        if ($product->count()){
            return $product[0];
        }else{
            return null;
        }
    }
}