<?php

namespace App\Listeners;

use App\Events\POChangePaymentStatusEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Repositories\Eloquent\PORepository;

class POChangePaymentStatusListener
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
     * @param  POChangePaymentStatusEvent  $event
     * @return void
     */
    public function handle(POChangePaymentStatusEvent $event)
    {
        $this->repositoryPO->POChangePaymentStatus($event->po,$event->type,$event->status);
    }
}
