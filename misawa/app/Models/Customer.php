<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table="customers";
    protected $fillable=["name","user_id","sex","phone","email","address1","address2","postcode"];

    public function user(){
        return $this->belongsto(User::class,"user_id");
    }

    public function pos(){
        return $this->hasMany(PO::class,"customer_id");
    }
    public function pos_deleted(){
        return $this->hasMany(PODeleted::class,"vendor_id");
    }

}
