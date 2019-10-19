<?php

namespace App\Listeners;

use App\Events\BrowseProductEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;
use App\Models\BrowseProduct;

class BrowseProductListener
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
     * @param  BrowseProductEvent  $event
     * @return void
     */
    public function handle(BrowseProductEvent $event)
    {

        $browseproduct=new BrowseProduct();
        $browseproduct->user_id=$event->user_id;
        $browseproduct->product_id=$event->product_id;

        $browseproduct->save();
        Log::info($browseproduct);

    }
}
