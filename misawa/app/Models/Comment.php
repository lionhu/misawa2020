<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table="comments";
    protected $fillable=["product_id","user_id","comment"];

    public function user(){
        return $this->belongsto(User::class,"user_id");
    }

    public function product(){
        return $this->belongsto(Product::class,"product_id");
    }


}
