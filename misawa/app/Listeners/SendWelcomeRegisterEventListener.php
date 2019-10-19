<?php

namespace App\Listeners;

use App\Events\OrderPlacedEvent;
use App\Events\SendWelcomeRegisterEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
use App\User;

class SendWelcomeRegisterEventListener
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
     * @param  OrderPlacedEvent  $event
     * @return void
     */
    public function handle(SendWelcomeRegisterEvent $event)
    {

        Mail::send('emails.welcomeRegister', [],function ($m) use($event) {
                $m->to($event->user->email, $event->user->name)
                    ->subject('[MISAWA Pharmacy]感谢注册!');
            });
    }
}
