<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $table="vendors";
    protected $fillable=["name","phone","email"];

    public function pos(){
        return $this->hasMany(PO::class,"vendor_id");
    }

    public function pos_deleted(){
        return $this->hasMany(PODeleted::class,"vendor_id");
    }

    public function products(){
        return $this->hasMany(Product::class,"vendor_id");
    }

}
