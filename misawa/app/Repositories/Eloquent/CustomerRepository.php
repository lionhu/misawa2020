<?php
/**
 * Created by PhpStorm.
 * User: liuxiang
 */
namespace App\Repositories\Eloquent;


use App\Models\Customer;

class CustomerRepository extends Repository
{

    function model()
    {
        return Customer::class;
    }

    public function add($info,$userid){
        $customer=Customer::create([
            'user_id'=>$userid,
            'name' => $info['name'],
            'email' => $info['email'],
            'phone' => $info['phone'],
            'address1' => $info['address1'],
            'address2' => $info['address2'],
            'sex' => $info['sex'],
            'postcode' => $info['postcode']
        ]);
        return $customer;
    }

    public function update_info($info,$condition,$userid){
            $customer=Customer::where('phone',$condition)
                ->update([
                    'user_id'=>$userid,
                    "name"=>$info['name'],
                    "email"=>$info['email'],
                    "address1"=>$info['address1'],
                    "address2"=> $info['address2'],
                    "sex"=>$info['sex'],
                    "postcode"=>$info['postcode']
                ]);


        return $customer;
    }


    public function update_info_byID($info,$userid){
        $customer=Customer::where('id',$userid)
            ->update([
                "name"=>$info['name'],
                "sex"=>$info['sex'],
                "postcode"=>$info['postcode'],
                "address1"=>$info['address1'],
                "address2"=> $info['address2'],
                "email"=>$info['email'],
                "phone"=>$info['phone']
            ]);
        return $customer;
    }

    public function delete($userid){
        $customer=Customer::find($userid);
        return $customer->delete();
    }


    public function getInfo($userid){
        $customer=Customer::find($userid);

        return $customer;
    }


}