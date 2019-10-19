<?php

namespace App\Listeners;

use App\Events\UserLoggedInEvent;
use App\Models\VisitLog;
use App\Notifications\notificationUserLoggedIn;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Zhuzhichao\IpLocationZh\Ip;
use Jenssegers\Agent\Agent;
use Session;


class UserLoggedInListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserLoggedInEvent  $event
     * @return void
     */
    public function handle(UserLoggedInEvent $event)
    {

        $IP_info=Ip::find($event->request->getClientIp());
        $user=$event->request->user();
        $agent=new Agent();

//        dd(BrowserDetect::detect());
        $log=VisitLog::create([
            "country"=>$IP_info[0],
            "province"=>$IP_info[1],
            "city"=>$IP_info[2],
            "other_address"=>$IP_info[3],
            "postcode"=>$IP_info[4],
            "user_id"=>$user->id,
            "user_name"=>$user->name,
            "device"=>$agent->device(),
            "platform"=>$agent->platform(),
            "browser"=>$agent->browser(),
            "admin_notification"=>0
        ]);

        $user_rate=$user->rate;
        Session::put("user_rate",$user_rate);
    }
}
