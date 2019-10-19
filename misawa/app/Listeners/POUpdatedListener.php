<?php

namespace App\Listeners;

use App\Events\POUpdatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class POUpdatedListener
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
     * @param  POUpdatedEvent  $event
     * @return void
     */
    public function handle(POUpdatedEvent $event)
    {
        //
    }
}
