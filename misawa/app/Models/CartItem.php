<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class CartItem extends Model
{
    //
    protected $table="cartitems";

    protected $fillable=["po_id","product_id","qty",
                        "r_price","dis_price","b_price","o_price",
                        "total_r_price","total_dis_price",
                        "total_b_price","total_o_price"];

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function po(){
        return $this->belongsTo(PO::class,"po_id","id");
    }

    public function po_deleted(){
        return $this->belongsTo(PODeleted::class);
    }
}
