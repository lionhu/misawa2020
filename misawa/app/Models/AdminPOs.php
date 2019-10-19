<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AdminPOs extends Model
{
    protected $table="admin_view_po_list";

//    public function scopeVendorAllPOs($query,$vendor_id){
//
//        return $query->where("vendor_id",$vendor_id)->orderBy('created_at', 'asc');
//    }
}
