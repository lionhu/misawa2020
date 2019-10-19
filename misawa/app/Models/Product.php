<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'name_jp','active', 'ingredient','tablets','unit','product_code','manufactory','price','efficacy',
        'description','website','postimage','thumbImage','active','r_price','b_price','o_price',
        'catalogue_id','subcatalogue_id','postimage'];

    protected $table="products";

    public function subcatalogue(){
        return $this->belongsTo(SubCatalogue::class,'subcatalogue_id');
    }

    public function catalogue(){
        return $this->belongsTo(Catalogue::class,'catalogue_id');
    }

    public function vendor(){
        return $this->belongsTo(Vendor::class,'vendor_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }


    public function cartitem(){
        return $this->hasMany(CartItem::class);
    }
    public function images()
    {
        return $this->morphMany(Image::class,"imageable");
    }


    public function scopeActive($query){
        return $query->where("active",1);
    }

    public function scopeSubcatalogue($query,$id){
        return $query->where("subcatalogue_id",$id);
    }

    public function scopeSearchProduct($query,$text){

        return $query->where("name","like","%".$text."%")
                        ->orwhere("name_jp","like","%".$text."%")
                        ->orwhere("product_code","like","%".$text."%");
    }

    public function scopeAllVendorProducts($query,$vendorid){

        return $query->where("vendor_id",$vendorid);
    }





//
//    public function scopeSuperAdminProductList($query){
//        return $query->with(['subcatalogue.catalogue','subcatalogue']);
//    }
}
