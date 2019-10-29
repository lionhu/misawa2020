<?php
/**
 * Created by PhpStorm.
 * User: huhaiguang
 * Date: 16/9/19
 * Time: 下午4:08
 */

namespace App\Utilities;

use App\Models\Catalogue;
use App\Models\Product;
use App\Models\SubCatalogue;

class Cart
{
    public $items = null;
    public $user_rate=1;
    public $Total_O_Price = 0;
    public $Total_Dis_Price = 0;
    public $Total_Dis_J_Price = 0;
    public $Total_B_Price = 0;
    public $Total_R_Price = 0;
    public $Total_Qty = 0;

    /**
     * Cart constructor.
     */
    public function __construct($user_rate,$oldCart)
    {
        $this->user_rate = $user_rate;
//        if ($oldCart) {
//            $this->items = $oldCart->items;
//            $this->user_rate = $oldCart->user_rate;
//            $this->Total_O_Price = $oldCart->Total_O_Price;
//            $this->Total_Dis_Price = $oldCart->Total_Dis_Price;
//            $this->Total_B_Price = $oldCart->Total_B_Price;
//            $this->Total_R_Price = $oldCart->Total_R_Price;
//            $this->Total_Qty = $oldCart->Total_Qty;
//        }else{
//            $this->user_rate = $user_rate;
//        }
    }
    public function destory(){
        $this->items = null;
        $this->user_rate = 1;
        $this->Total_O_Price = 0;
        $this->Total_Dis_Price = 0;
        $this->Total_Dis_J_Price = 0;
        $this->Total_B_Price = 0;
        $this->Total_R_Price = 0;
        $this->Total_Qty = 0;
    }

    public function findItem($id)
    {
        return array_key_exists($id, $this->items);
    }

    public function getItemCount($id)
    {
        if ($this->items && array_key_exists($id, $this->items)) {
            return $this->items[$id]['qty'];
        } else {
            return 0;
        }
    }

    public function addItem($id,$val){
        $product = Product::find($id);

        $item=null;

        if ($product) {
            $item = new Item($product->id, $product->name,$product->thumbImage,
                $product->o_price, $product->b_price, $product->r_price, $product->j_price,$this->user_rate);
        }

        $storedItem = ['qty' => 0, 'total_o_price' => $item->o_price,'total_dis_j_price' => $item->dis_j_price,'total_dis_price' => $item->dis_price,
            'total_b_price' => $item->b_price,'total_r_price' => $item->r_price,'product' => $item];

        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }

        $this->Total_Qty +=$val;
        $this->Total_O_Price += $item->o_price*$val;
        $this->Total_Dis_Price += $item->dis_price*$val;
        $this->Total_Dis_J_Price += $item->dis_j_price*$val;
        $this->Total_B_Price += $item->b_price*$val;
        $this->Total_R_Price += $item->r_price*$val;

        if ($val <= 0) {
            unset($this->items[$id]);
        }
        else{
            $storedItem['qty']+=$val;
            $qty=$storedItem['qty'];
            $storedItem['total_o_price'] = $item->o_price*$qty;
            $storedItem['total_dis_price'] = $item->dis_price*$qty;
            $storedItem['total_dis_j_price'] = $item->dis_j_price*$qty;
            $storedItem['total_b_price'] = $item->b_price*$qty;
            $storedItem['total_r_price'] = $item->r_price*$qty;
            $this->items[$id] = $storedItem;
        }

        if ($this->Total_Qty <= 0) {
            $this->items = null;
            $this->Total_Qty = 0;
//            $this->user_rate = 1;
            $this->Total_O_Price = 0;
            $this->Total_Dis_Price = 0;
            $this->Total_Dis_J_Price = 0;
            $this->Total_B_Price = 0;
            $this->Total_R_Price = 0;
        }

    }

    public function updateItem($id,$val){
        $this->removeItem($id);
        $this->addItem($id,$val);
    }

    public function removeItem($id){
        $this->Total_Qty -= $this->items[$id]['qty'];
        $this->Total_O_Price -= $this->items[$id]['total_o_price'];
        $this->Total_Dis_Price -= $this->items[$id]['total_dis_price'];
        $this->Total_Dis_J_Price -= $this->items[$id]['total_dis_j_price'];
        $this->Total_B_Price -= $this->items[$id]['total_b_price'];
        $this->Total_R_Price -= $this->items[$id]['total_r_price'];
        unset($this->items[$id]);

        if ($this->Total_Qty <= 0) {
            $this->items = null;
            $this->Total_Qty = 0;
            $this->Total_O_Price = 0;
            $this->Total_Dis_Price = 0;
            $this->Total_Dis_J_Price = 0;
            $this->Total_B_Price = 0;
            $this->Total_R_Price = 0;
        }
    }

    public function validateRule(){
        if ($this->Total_Qty>env('Cart_Total_limit')){
            return false;
        }

        foreach ($this->items as $item){
            if ($item['qty']>env('Cart_Product_limit')){
                return false;
            }
        }

        return true;
    }
}

class CartItem
{
    public $qty = 0;
    public $total_o_price = 0;
    public $total_dis_price = 0;
    public $total_dis_j_price = 0;
    public $total_b_price = 0;
    public $total_r_price = 0;
    public $product = null;

    public function __construct($qty, $item)
    {
        $this->qty = $qty;
        $this->total_o_price = $item->o_price* $qty;
        $this->total_dis_price = $item->dis_price* $qty;
        $this->total_dis_j_price = $item->dis_j_price* $qty;
        $this->total_b_price = $item->b_price* $qty;
        $this->total_r_price = $item->r_price* $qty;
        $this->product = $item;
    }
}

//each product object
class Item
{
    public $id = 0;
    public $name = '';
    public $thumbimage="";
    public $o_price = 0;
    public $dis_price = 0;
    public $dis_j_price = 0;
    public $b_price = 0;
    public $r_price = 0;

    public function __construct($id,$name,$thumbimage,$o_price,$b_price,$r_price,$dis_j_price,$user_rate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->thumbImage=$thumbimage;
        $this->o_price=$o_price;
        $this->dis_price=intval(($o_price-$b_price)*$user_rate)+$b_price;
        $this->dis_j_price=$dis_j_price;
        $this->b_price=$b_price;
        $this->r_price=$r_price;
    }
}
