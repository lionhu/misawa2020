<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class PODeleted extends Model
{
    protected $table="pos_deleted";

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

    public function scopeVendorAllPOs($query,$vendor_id){

        return $query->where("vendor_id",$vendor_id)->orderBy('created_at', 'asc');
    }
}
