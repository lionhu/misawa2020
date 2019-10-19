<?php

namespace App\Listeners;

use App\Events\OrderCompletedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class OrderCompletedEventListener
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
     * @param  OrderCompletedEvent  $event
     * @return void
     */
    public function handle(OrderCompletedEvent $event)
    {
        $po=$event->po;
        Mail::send('emails.customer_OrderComplete', ['po' => $po],
            function ($m) use ($po) {
                $m->to($po->customer->email, $po->customer->name)->subject('[Customer]订单完成通知!');
            });

//        Mail::send('emails.customerAdmin_OrderComplete', ['po' => $po],
//            function ($m) use ($po) {
//                $m->to($po->user->email, $po->user->name)->subject('[CustomerAdmin]Order Completed Notification!');
//            });

        Mail::send('emails.superAdmin_OrderComplete', ['po' => $po],
            function ($m) use ($po) {
                $m->to(env('SUPERADMIN_EMAIL'), $po->user->name)->subject('[superAdmin]订单完成通知!');
            });

        // Mail::send('emails.vendor_OrderComplete', ['po' => $po],
        //     function ($m) use ($po) {
        //         $m->to($po->vendor->email, $po->vendor->name)->subject('[vendor]KPZH Order Completed Notification!');
        //     });
    }
}
