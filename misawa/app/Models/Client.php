<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Client extends Model
{
    protected $fillable=["name","email"];
    protected $table="clients";

    public function users(){
        return $this->hasMany(User::class);
    }
    public function admin(){
        return $this->belongsTo(User::class);
    }

    public function pos(){
        return $this->hasManyThrough(PO::class,User::class,"client_id","user_id");
    }

    public function pos_deleted(){
        return $this->hasManyThrough(PODeleted::class,User::class,"client_id","user_id");
    }

    public function customers(){
        return $this->hasManythrough(Customer::class,User::class,"client_id","user_id");
    }
}
