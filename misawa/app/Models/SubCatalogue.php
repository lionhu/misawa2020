<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Catalogue;
use App\Models\Product;

class SubCatalogue extends Model
{
    //
    protected $fillable=['name','short_desc','catalogue_id'];
    protected $table = 'subcatalogues';

    public function catalogue(){
        return $this->belongsTo(Catalogue::class);
    }

    public function products(){
        return  $this->hasMany(Product::class,'subcatalogue_id');
    }

    public function scopeFirstWithActiveProducts(){
        return 3;
    }
}
