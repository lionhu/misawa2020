<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use App\Notifications\notificationUserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;
use Zhuzhichao\IpLocationZh\Ip;
use Jenssegers\Agent\Agent;
use Mail;

class UserRegisteredListener
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
     * @param  UserRegisteredEvent  $event
     * @return void
     */
    public function handle(UserRegisteredEvent $event)
    {
        $agent=new Agent();

        //        send notification mail to superadmin
        \Log::info("listener: admin id:".env("SUPERADMIN_ID"));
        \Log::info($event->user);
        User::find(env("SUPERADMIN_ID"))->notify(new notificationUserRegistered($event->user,$agent));
        
        //welcomeRegister.blade.php
        Mail::send('emails.welcomeRegister', [],function ($m) use ($event) {
                $m->to($event->user->email, $event->user->name)->subject('[MISAWA Pharmacy]Welcom Register!');
            });

    }
}
