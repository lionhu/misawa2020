<?php

namespace App\Http\Controllers;

use App\Events\SuperAdminMessageEvent;
use App\Models\AdminPODetails;
use App\Models\AdminPOs;
use App\Models\Client;
use App\Models\customerAdminPODetails;
use App\Models\customerAdminPOs;
use App\Models\PO;
use App\Models\Vendor;
use App\Models\VendorPODetails;
use App\Models\VendorPOs;
use App\Repositories\Eloquent\ClientRepository;
use App\Repositories\Eloquent\PORepository;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Role;
use App\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    protected $repoProduct;
    protected $repoUser;
    protected $repoClient;
    protected $repoPO;
    public function __construct(ProductRepository $productRepository,
                                UserRepository $userRepository,
                                ClientRepository $clientRepository,
                                PORepository $repoPO)
    {
        $this->repoProduct=$productRepository;
        $this->repoUser=$userRepository;
        $this->repoClient=$clientRepository;
        $this->repoPO=$repoPO;
    }

    public function index(){
        return view("distributor.adminhome");
    }

    public function getMyPOs(Request $request){
        $user=$request->user();
        $mypos=PO::myPOs($user->id)
            ->with("user","customer","vendor")
            ->orderBy("created_at","DESC")
            ->get();

        if ($mypos->count()==0){
            return redirect()->route("shop_home");
        }

        return view("distributor.myPOs",[
            "mypos"=>$mypos
        ]);
    }

}
