<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogue;
use App\Models\Product;

class MenuSubCatalogue extends Model
{
    //
    protected $fillable=['name','short_desc','catalogue_id'];
    protected $table = 'view_menu_subcatalogues';

    public function catalogue(){
        return $this->belongsTo(MenuSubCatalogue::class,"catalogue_id");
    }

    public function products(){
        return  $this->hasMany(Product::class,'subcatalogue_id');
    }
}
