<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\OrderPlacedEvent' => [
            'App\Listeners\OrderPlacedEventListener',
        ],
        'App\Events\OrderPlaced2VendorEvent' => [
            'App\Listeners\OrderPlaced2VendorEventListener',
        ],
        'App\Events\DeliverPackageEvent' => [
            'App\Listeners\DeliverPackageEventListener',
        ],
        'App\Events\OrderCompletedEvent' => [
            'App\Listeners\OrderCompletedEventListener',
        ],
        'App\Events\NewCommentEvent' => [
            'App\Listeners\NewCommentListener',
        ],

//        speradmin action
        'App\Events\SuperAdminMessageEvent' => [
            'App\Listeners\SuperAdminMessageListener',
        ],
        'App\Events\POChangePaymentStatusEvent' => [
            'App\Listeners\POChangePaymentStatusListener',
        ],
        'App\Events\POChangeStatusEvent' => [
            'App\Listeners\POChangeStatusListener',
        ],
        'App\Events\PODeletedEvent' => [
            'App\Listeners\PODeletedListener',
        ],
        'App\Events\POUpdatedEvent' => [
            'App\Listeners\POUpdatedListener',
        ],
        'App\Events\SendPOMailEvent' => [
            'App\Listeners\SendPOMailListener',
        ],

//        user action
        'App\Events\UserLoggedInEvent' => [
            'App\Listeners\UserLoggedInListener',
        ],
        'App\Events\UserRegisteredEvent' => [
            'App\Listeners\UserRegisteredListener',
        ],
        'App\Events\BrowseProductEvent' => [
            'App\Listeners\BrowseProductListener',
        ],
        'App\Events\SendWelcomeRegisterEvent' => [
            'App\Listeners\SendWelcomeRegisterEventListener',
        ],



    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
