<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class VisitLog extends Model
{
    protected $fillable=["country","province","city","other_address","user_id","user_name","device","platform","browser"];
    protected $table="visitLogs";

    public function scopeRecent50($query){

        return $query->orderBy('created_at', 'desc')->limit(20);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
