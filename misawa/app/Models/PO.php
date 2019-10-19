<?php

namespace App\Models;

use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class PO extends Model
{
    protected $table="pos";


    public function getPoDateAtAttribute()
    {
        return Carbon::parse($this->attributes["created_at"])->format("m/d");
    }

    public function cartitems(){
        return $this->hasMany(CartItem::class,"po_id","id");
    }

    public function user(){
        return $this->belongsTo(User::class,"user_id");
    }

    public function customer(){
        return $this->belongsTo(Customer::class,"customer_id");
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class,"vendor_id");
    }

    public function client(){
        return $this->belongsTo(Client::class,"client_id");
    }

    public function scopeMyPos($query,$id){
        return $query->where("user_id",$id)->orderBy('created_at', 'asc');
    }

    public function scopeOfStatus($query,$status){
        return $query->where("status",$status);
    }
    public function scopeOfUnpaid($query){
        return $query->where("paid_vendor","0");
    }

    public function scopeOfVendor($query,$vendor_id){

        return $query->where("vendor_id",$vendor_id)->where("status","!=","new");
    }
}
