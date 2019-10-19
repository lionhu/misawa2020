<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\User;
use Event;

use App\Events\SendWelcomeRegisterEvent;


class UserController extends Controller
{

    public function postCheckCustomerInformation(Request $request){
        $phone=$request->input("phone");
        $user=null;
        $result="NG";
        $user=Customer::where("phone",$phone)->first();

        if($user){
            $result="OK";
            return [
                "result"=>$result,
                "user"=>$user
            ];
        }else{
            $result="NG";
            return [
                "result"=>$result,
                "user"=>null
            ];
        }
    }

    public function postCheckUserInformation(Request $request){
        $phone=$request->input("phone");
        $user=null;
        $result="NG";
        $user=User::where("phone",$phone)->first();

        if($user){
            $result="OK";
        }else{
            $result="NG";
        }
        return [
            "result"=>$result,
            "user"=>$user[0]
        ];

    }

    public function UserLoggedIn(Request $request){

    }
    
    public function SendWelcomeRegister(Request $request,$id){
        $user=User::find($id);
        Event::fire(new SendWelcomeRegisterEvent($user));

        return redirect()->back();
    }
    
    
}
