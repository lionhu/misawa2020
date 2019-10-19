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

class TransferCart
{
    public $items = null;
    public $user_rate=1;

    /**
     * Cart constructor.
     */
    public function __construct($user_rate)
    {
            $this->user_rate = $user_rate;
    }
    public function destory(){
        $this->items = null;
        $this->user_rate = 1;
    }

    public function findItem($id)
    {
        return array_key_exists($id, $this->items);
    }

    public function addItem($id,$val){
        $product = Product::find($id);

        $item=null;

        if ($product) {
            $item = new TransferItem($product->id, $product->name, $product->name_jp, $product->product_code,$product->thumbImage,
                $product->o_price, $product->b_price,$this->user_rate);
        }

        $storedItem = ['qty' => 0, 'total_o' => $item->o_price,'total_b' => $item->b_price,
            'product' => $item];

        if ($this->items) {
            if (array_key_exists($id, $this->items)) {
                $storedItem = $this->items[$id];
            }
        }

        if ($val <= 0) {
            unset($this->items[$id]);
        }
        else{
            $storedItem['qty']+=$val;
            $qty=$storedItem['qty'];
            $storedItem['total_o'] = $item->o_price*$qty;
            $storedItem['total_b'] = $item->b_price*$qty;
            $this->items[] = $storedItem;
        }

    }
}

class TransferCartItem
{
    public $qty = 0;
    public $total_o = 0;
    public $total_b = 0;
    public $product = null;

    public function __construct($qty, $item)
    {
        $this->qty = $qty;
        $this->total_o = $item->o_price* $qty;
        $this->total_b = $item->b_price* $qty;
        $this->product = $item;
    }
}

//each product object
class TransferItem
{
    public $id = 0;
    public $name = '';
    public $name_jp = '';
    public $product_code = '';
    public $thumbimage="";

    public $o_price = 0;
    public $b_price = 0;

    public function __construct($id,$name,$name_jp,$product_code,$thumbimage,
                                $o_price,$b_price,$user_rate)
    {
        $this->id = $id;
        $this->name = $name;
        $this->name_jp = $name_jp;
        $this->product_code = $product_code;
        $this->thumbImage=$thumbimage;


        $this->o_price=$o_price;
        $this->b_price=intval(($o_price-$b_price)*$user_rate)+$b_price;
    }
}
