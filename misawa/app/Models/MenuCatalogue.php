<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SubCatalogue;
use App\Models\Product;

class MenuCatalogue extends Model
{
    //
    protected $fillable=['name'];
    protected $table="view_menu_catalogues";

    public function subcatalogues(){
        return $this->hasMany(MenuSubCatalogue::class,"catalogue_id");
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, SubCatalogue::class, 'catalogue_id', 'subcatalogue_id');
    }

}
