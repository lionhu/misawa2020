<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class VendorPODetails extends Model
{
    protected $table="vendor_view_po_details";

    public function scopeVendorAllPOs($query,$vendor_id){

        return $query->where("vendor_id",$vendor_id)->orderBy('created_at', 'asc');
    }
}
