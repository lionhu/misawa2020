<?php

namespace App\Http\Controllers;

use App\Models\Catalogue;
use App\Models\PO;
use App\Notifications\ContactMessageFromUser;
use App\Repositories\Eloquent\PORepository;
use App\Repositories\Eloquent\ProductRepository;
use App\User;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SubCatalogue;
use Session;
use App\Utilities\Cart;

use App\Events\BrowseProductEvent;

use Event;


class ShopController extends Controller
{

    protected $cart;
    protected $productRepository;
    protected $poRepo;

    public function __construct(ProductRepository $productRepository,
                                PORepository $poRepo)

    {
        $this->productRepository=$productRepository;
        $this->poRepo=$poRepo;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){

        $product=Product::active()->first();
        $id=$product->subcatalogue_id;

        $products=Product::with("images")->active()->subcatalogue($id)->get([
            "id","name","name_jp","o_price","rate","b_price","r_price","j_price"
        ]);

        $top5=$this->productRepository->getSalesTop5();

        if ($request->user()->hasRole("vendor")){
            return redirect()->to("/vendor#/pos");
        }
        
        
        $user_rate=$request->user()->rate;
        Session::put("user_rate",$user_rate);
        
        return view('shop.home',[
            'sub_now_id'=>$id,
            "products"=>$products,
            "top5"=>$top5
        ]);
    }

    public function contactUS(Request $request)
    {
        \Log::info($request);

        $user_name=$request->user()->name;
        $admin=User::find(env("SUPERADMIN_ID"));

        $admin->notify(new ContactMessageFromUser($request->input("message"),$user_name));

        return response([
            "result"=>"OK"
        ],201);






    }


    public function getProduct(Request $request){
        $id=$request->input("productid");
        $product=Product::with("vendor","images","catalogue","subcatalogue")
            ->where("id",$id)->first();

        if ($product){
        	
         Event::fire(new BrowseProductEvent($request->user()->id,$product->id));

         \Log::info($product);
            return response([
                "product"=>$product,
                "result"=>"OK"
            ],201);
        }else{
            return response([
                "product"=>null,
                "result"=>"NG"
            ],201);
        }
    }

    public function getSubcatalogueProducts(Request $request,$id){

        $products=Product::with("images")->active()->subcatalogue($id)->get([
            "id","name","name_jp","o_price","rate","b_price","j_price","r_price"
        ]);

        $top5=$this->productRepository->getSalesTop5();


        return view('shop.home',[
            'sub_now_id'=>$id,
            "products"=>$products,
            "top5"=>$top5
        ]);
    }

    public function getCatalogues(){
        $cats=Catalogue::all();

        return [
            "result"=>"OK",
            "catalogues"=>$cats
        ];
    }

    public function getSubcatalogues(Request $request){
        $catid=$request->input("catalogueid");
        $cat=Catalogue::with("subcatalogues")->find($catid);

        return [
            "result"=>"OK",
            "subcatalogues"=>$cat->subcatalogues
        ];
    }

    public function getAllProducts()
    {
        $products=Product::with("images")->active()
                ->get(["id","name","name_jp","thumbimage","postimage","subcatalogue_id","rate"]);

        return [
            "result"=>"OK",
            "products"=>$products
        ];
    }

    public function getAllActiveProducts(Request $request)
    {
        $oldcart=Session::has(env("CART_NAME"))?Session::get(env("CART_NAME")):null;

        $mycart=new Cart($oldcart);

        $products=Product::with("images")->active()
            ->get(["id","name","name_jp","thumbimage","postimage","subcatalogue_id","o_price","b_price","j_price","rate"]);

        return view("shop.home",[
            "result"=>"OK",
            "products"=>$products,
            "cart_total"=>$mycart->Total_Qty
        ]);
    }
    
       public function faq(){
        return view("shop.faq");
    }

    public function getSystemManagementInfo(Request $request)
    {
        $catalogues=Catalogue::with(["subcatalogues","subcatalogues.products","subcatalogues.products.images"])->get();
        $user=User::with("roles")->where("id",$request->user()->id)->first();

        $top5=$this->poRepo->CallProcedure("CALL Top5_Sales_Products()");

        return response([
            "result"=>"OK",
            "catalogues"=>$catalogues,
            "user"=>$user,
            "top5"=>$top5
        ],201);
    }

}