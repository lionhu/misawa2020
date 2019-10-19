<?php
/**
 * Created by PhpStorm.
 * User: liuxiang
 */
namespace App\Repositories\Eloquent;


use App\Models\Client;

class ClientRepository extends Repository
{

    function model()
    {
        return Client::class;
    }

    public function getClientList(){
        $list=Client::where("id","like","%")->get(["id","name"]);
        return $list;
    }

}