<?php

namespace App;

use App\Models\Comment;
use App\Models\PODeleted;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Klaravel\Ntrust\Traits\NtrustUserTrait;
use App\Models\PO;
use App\Models\Customer;
use App\Models\Client;
use App\Models\VisitLog;



class User extends Authenticatable
{
    use Notifiable,NtrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected static $roleProfile = 'user';
    protected $fillable = [
        'name','parent_id', 'email','image', 'password','activation_token','token_time','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function pos(){
        return $this->hasMany(PO::class);
    }

    public function pos_deleted(){
        return $this->hasMany(PODeleted::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'user_id');
    }


    public function comments(){
        return $this->hasMany(Comment::class);
    }


    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function children(){
        return $this->hasMany(User::class,"parent_id","id");

    }
    public function parent(){
        return $this->belongsTo(User::class,"parent_id");
    }

    public function scopeUsersExceptSuperadmin($query){
        $retQuery=$query->where("id","<>",env("SUPERADMIN_ID"));
        return $retQuery;
    }

    public function visitlogs(){
        return $this->hasMany(VisitLog::class);
    }

}
