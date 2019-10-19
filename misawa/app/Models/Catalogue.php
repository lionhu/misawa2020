<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Catalogue extends Model
{
    //
    protected $fillable=['name'];

    public function subCatalogues(){
        return $this->hasMany(SubCatalogue::class);
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, SubCatalogue::class, 'catalogue_id', 'subcatalogue_id');
    }

}
