<?php

namespace App\Listeners;

use App\Events\NewCommentEvent;
use App\Notifications\notificationNewComment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\User;

class NewCommentListener
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
     * @param  NewCommentEvent  $event
     * @return void
     */
    public function handle(NewCommentEvent $event)
    {
        //        send notification mail to superadmin
        User::find(env("SUPERADMIN_ID"))->notify(new notificationNewComment($event->comment));

    }
}
