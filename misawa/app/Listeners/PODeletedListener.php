<?php

namespace App\Listeners;

use App\Events\PODeletedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Repositories\Eloquent\PORepository;

class PODeletedListener
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
     * @param  PODeletedEvent  $event
     * @return void
     */
    public function handle(PODeletedEvent $event)
    {
        $this->repositoryPO->deletePO_ByID($event->po);
    }
}
