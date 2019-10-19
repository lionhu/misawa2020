<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class customerAdminPODetails extends Model
{
    protected $table="customeradmin_view_po_details";

    public function scopeCustomerAdminAllPOs($query,$user_id){

        return $query->where("client_id",$user_id)->orderBy('created_at', 'asc');
    }
}
