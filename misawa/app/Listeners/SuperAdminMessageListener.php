<?php

namespace App\Listeners;

use App\Events\SuperAdminMessageEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class SuperAdminMessageListener
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
     * @param  SuperAdminMessageEvent  $event
     * @return void
     */
    public function handle(SuperAdminMessageEvent $event)
    {
        Log::info($event->message);
    }
}
