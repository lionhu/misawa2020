<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable=['path'];
    protected $table="images";
    public function imageable()
    {
        return $this->morphTo();
    }

}
