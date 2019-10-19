<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App;
use App\Models\Product;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    public function setLanguage(Request $request,$language){
        Session::put('lang', $language);
        App::setLocale(Session::get('lang'));

        return redirect()->back();
    }

    public function checkname(Request $request){
        return [
          "result"=>"OK",
            "newname"=>request()->input("name")." from server"
        ];
    }

}
