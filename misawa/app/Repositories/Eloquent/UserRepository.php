<?php
/**
 * Created by PhpStorm.
 * User: liuxiang
 */
namespace App\Repositories\Eloquent;


use App\User;

class UserRepository extends Repository
{

    function model()
    {
        return User::class;
    }
    public function deleteUser($userid){
        $user=User::find($userid);

        return $user->delete();
    }

    public function getUserInfo($userid){
        $user=User::with("client","roles")->find($userid);

        return $user;
    }

    public function updateUserInfo($userid,$email,$phone,$rate,$roleid,$clientid,$introcode){
        $user=User::find($userid );
        $user->email=$email;
        $user->phone=$phone;
        $user->introcode=$introcode;
        $user->rate=$rate;
        $user->client_id=$clientid;


        $user->detachRoles($user->roles);
        $user->attachRole($roleid);
        $user->save();

        return $user;

    }
}