<?php

namespace App\Http\Controllers\Auth;

use App\Notifications\notificationUserRegistered;
use App\Notifications\notifyParentRegisteration;
use App\Repositories\Eloquent\UserRepository;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

use Jenssegers\Agent\Agent;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        \Log::info($data);
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

            
        if($data["introcode"]!==null){
            $father=User::where("introcode",$data["introcode"])->first();
            if ($father!==null){
                $user=self::newuser_with_father($data,$father);
            }else{
                $user=self::newuser_without_father($data);
            }
        }else{
            $user=self::newuser_without_father($data);
        }

        \Log::info($user);
        $admin=User::find(env("SUPERADMIN_ID"));

        if($admin!=null){

            $agent=new Agent();

            $admin->notify(new notificationUserRegistered($user,$agent));
        }

        return $user;
    }

    protected function newuser_with_father(array $data,$father){
        $user=User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'parent_id' =>$father->id,
            'client_id' =>$father->client_id,
            'password' => bcrypt($data['password']),
        ]);

        $father->notify(new notifyParentRegisteration($user));

        $user->attachRole(7);

        $user->save();

        return $user;

    }

    protected function newuser_without_father(array $data){
        $user=User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'parent_id' =>env("SUPERADMIN_ID"),
            'client_id' =>env("SUPERADMIN_ID"),
            'password' => bcrypt($data['password']),
        ]);

        $user->attachRole(7);

        $user->save();

        return $user;
    }
}
