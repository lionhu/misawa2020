<?php

namespace App\Listeners;

use App\Events\POChangeStatusEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\Eloquent\PORepository;
use Event;
use App\Events\OrderPlaced2VendorEvent;
use App\Events\DeliverPackageEvent;
use App\Events\OrderCompletedEvent;

class POChangeStatusListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    protected $repositoryPO;
    public function __construct(PORepository $PORepository)

    {
//        $this->middleware('auth');
        $this->repositoryPO=$PORepository;
    }

    /**
     * Handle the event.
     *
     * @param  POChangeStatusEvent  $event
     * @return void
     */
    public function handle(POChangeStatusEvent $event)
    {
        $status=$event->status;
        $po=$event->po;

        $this->repositoryPO->POChangeStatus($po,$status);

        \Log::info("poid:".$po->id." ".$status);

        if ($status=="processing"){

            Event::fire(new OrderPlaced2VendorEvent($po));
        }elseif ($status=="Delivering"){

            Event::fire(new DeliverPackageEvent($po));
        }elseif ($status=="completed"){

            Event::fire(new OrderCompletedEvent($po));
        }


    }
}
