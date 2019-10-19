<?php

namespace App\Http\Controllers;

use App\Events\OrderPlacedEvent;
use App\Events\SendPOMailEvent;
use App\Http\Requests\CheckoutRequest;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\PO;
use App\Repositories\Eloquent\CustomerRepository;
use App\Repositories\Eloquent\PORepository;
use App\User;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\SubCatalogue;
use Session;
use App\Utilities\Cart;
use Event;
use Mail;



class CartController extends Controller
{

    protected $cart;
    protected $repositoryPO;
    protected $repositoryCustomer;

    public function __construct(PORepository $PORepository,
                                CustomerRepository $customerRepository)

    {
//        $this->middleware('auth');
        $this->repositoryPO=$PORepository;
        $this->repositoryCustomer=$customerRepository;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        $cart_mode=Session::has("cart_mode")?Session::get("cart_mode"):null;

        $oldcart=Session::has(env("CART_NAME"))?Session::get(env("CART_NAME")):null;

        $mycart=new Cart($oldcart);

        if ($mycart->Total_Qty >0){
            return view("shop.cart",[
                "cart"=>$mycart,
                "cart_total"=>$mycart->Total_Qty,
                "cart_mode"=>$cart_mode
            ]);
        }else{
            return redirect()->route("shop_home");
        }
    }


    public function clearCart(Request $request){
        $request->session()->put(env("CART_NAME"),null);

        return redirect()->route("shop_home");
    }

    public function updateItem(Request $request){
        $id =$request->input("id");
        $qty =$request->input("qty");
        $oper =$request->input("operation");

        $oldcart=null;
        $oldcart=Session::has(env("CART_NAME"))?Session::get(env("CART_NAME")):null;
//
        $mycart=new Cart($oldcart);

        $operation="";
        $itemcount=$mycart->getItemCount($id);
        if ($oper=="addone"){
            if($itemcount>0){
                $mycart->updateItem($id,$itemcount+1);
                $operation="addone update";
            }else{
                $mycart->addItem($id,$qty);
                $operation="addone add";
            }
        }else{
            if ($qty===0){
                $mycart->removeItem($id);
                $operation="remove";
            }else{
                if($mycart->getItemCount($id)>0){
                    $mycart->updateItem($id,$qty);
                    $operation="update";
                }else{
                    $mycart->addItem($id,$qty);
                    $operation="add";
                }
            }
        }


        $request->session()->put(env("CART_NAME"),$mycart);
        return [
            "result"=>"OK",
            "cart_Total_Qty"=>$mycart->Total_Qty,
            "cart_Total_Price"=>$mycart->Total_O_Price,
            "Total_O_Price"=>$mycart->Total_O_Price,
            "Total_B_Price"=>$mycart->Total_B_Price,
            "operation"=>$operation
        ];

    }

    public function getCart(Request $request){
        $oldcart=Session::has(env("CART_NAME"))?Session::get(env("CART_NAME")):null;
//
        $mycart=new Cart($oldcart);

        return [
            "result"=>"OK",
            "cart"=>$mycart,
            "Total_Qty"=> $mycart->Total_Qty,
            "Total_O_Price"=>$mycart->Total_O_Price
        ];

    }

    public function getCheckOut(Request $request){


        $oldcart=Session::has(env("CART_NAME"))?Session::get(env("CART_NAME")):null;

        $mycart=new Cart($oldcart);

        if ($mycart->Total_Qty >0){
            return view("shop.checkout",[
                "cart"=>$mycart,
                "cart_total"=>$mycart->Total_Qty,
                "cart_qty"=>$mycart->Total_Qty
            ]);
        }else{
            return redirect()->route("shop_home");
        }
    }

    public function postcheckout(CheckoutRequest $request){
//        \Log::info("passed");


        $adminCart=self::generateAdminCart($request->user()->rate,$request->input("cartitems"));

        $cartitems=$request->input("cartitems");
        $vendor_id=$request->input("vendor_id");
        $customer=$request->input("customer");
        $user=$request->user();
        $coupon=$request->input("coupon");
        $memo=$request->input("memo");
        $userid=$request->user()->id;

        if(count($cartitems)){
            if ($customer["id"]){
                $cus=$this->repositoryCustomer->update_info($customer,$customer["phone"],$userid);
                $message="update customer";
            }else{
                $cus=$this->repositoryCustomer->add($customer,$userid);
                $message="add customer";
            }

            \Log::info(json_encode($adminCart));
            \Log::info($message);


            $cus=Customer::where("phone",$customer["phone"])->first();
            \Log::info(json_encode($cus));

            $poinfo=[
                "memo"=>$memo,
                "vendor_id"=>$vendor_id
            ];

            \Log::info(json_encode($cartitems));
            $po=$this->repositoryPO->poAddNew($cartitems,$poinfo,$user,$cus,$adminCart);
            \Log::info("succefully placed new order");
            \Log::info(json_encode($po));


            Event::fire(new SendPOMailEvent($po,"new","superadmin"));
            Event::fire(new SendPOMailEvent($po,"new","customer"));


            return response([
                "result"=>"OK",
                "po_id"=>$po->id
            ],201);

        }

        return response([
            "result"=>"NG",
            "po_id"=>0
        ],201);


    }

    public function updateAllItems(Request $request,$updateitems){
        $oldcart=Session::has(env("CART_NAME"))?Session::get(env("CART_NAME")):null;

        $mycart=new Cart($oldcart);

        foreach ($updateitems as $updateitem){
            if($updateitem["qty"]==0){
                $mycart->removeItem($updateitem["id"]);
            }else{
                $mycart->updateItem($updateitem["id"],$updateitem["qty"]);
            }
        }

        $request->session()->put(env("CART_NAME"),$mycart);

        return $mycart;

    }

    public function generateAdminCart($user_rate,$cartitems){
        $mycart=new Cart($user_rate,null);

        foreach ($cartitems as $cartitem){
            $mycart->addItem($cartitem["product"]["id"],$cartitem["qty"]);
        }
        return $mycart;
    }

    public function SuperAdmin_evaluateCart(Request $request)
    {

        $user_rate=$request->input("user_rate");
        $cartitems=$request->input("items");

        $adminCart=self::generateAdminCart($user_rate,$cartitems);
        \Log::info(env("JPYRate"));

        \Log::info(json_encode($adminCart));
            return response([
                "result"=>"OK",
                "cart"=>$adminCart,
                "user_rate"=>$user_rate,
                "jpy_rate"=>env("JPYRate")
            ],201);
    }

}
