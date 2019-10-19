<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrowseProduct extends Model
{
    protected $table="browseproducts";
    protected $fillable=["user_id","product_id"];

    public function scopeBrowseProductsRanking($query){

        return $query->orderBy('created_at', 'desc')->limit(50);
    }

    public function scopeUserHistory($query,$userid){

        return $query->where("user_id",$userid)
                    ->orderBy('created_at', 'desc')->limit(30);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }


}
