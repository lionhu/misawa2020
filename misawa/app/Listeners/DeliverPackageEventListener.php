<?php

namespace App\Listeners;

use App\Events\DeliverPackageEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class DeliverPackageEventListener
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
     * @param  DeliverPackageEvent  $event
     * @return void
     */
    public function handle(DeliverPackageEvent $event)
    {
        $po=$event->po;
        Mail::send('emails.customer_OrderDelivery', ['po' => $po],
            function ($m) use ($po) {
                $m->to($po->customer->email, $po->customer->name)->subject('[Customer]EMS快件已经邮递成功!');
            });

//        Mail::send('emails.customerAdmin_OrderDelivery', ['po' => $po],
//            function ($m) use ($po) {
//                $m->to($po->user->email, $po->user->name)->subject('[CustomerAdmin]Package Delivered Notification!');
//            });

        Mail::send('emails.superAdmin_OrderDelivery', ['po' => $po],
            function ($m) use ($po) {
                $m->to(env('SUPERADMIN_EMAIL'), $po->user->name)->subject('[superAdmin]EMS快件已经邮递成功!');
            });

        // Mail::send('emails.vendor_OrderDelivery', ['po' => $po],
        //     function ($m) use ($po) {
        //         $m->to($po->vendor->email, $po->vendor->name)->subject('[vendor]KPZH Package Delivered Notification!');
        //     });
    }
}
