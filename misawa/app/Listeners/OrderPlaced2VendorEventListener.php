<?php

namespace App\Listeners;

use App\Events\OrderPlaced2VendorEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class OrderPlaced2VendorEventListener
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
     * @param  OrderPlaced2VendorEvent  $event
     * @return void
     */
    public function handle(OrderPlaced2VendorEvent $event)
    {
        $po=$event->po;

        Mail::send('emails.customer_Order2Vendor', ['po' => $po],
            function ($m) use ($po) {
                $m->to($po->customer->email, $po->customer->name)->subject('[Customer]订单发送至药房通知!');
            });

        Mail::send('emails.superAdmin_Order2Vendor', ['po' => $po],
            function ($m) use ($po) {
                $m->to(env('SUPERADMIN_EMAIL'), $po->user->name)->subject('[superAdmin]订单发送至药房通知!');
            });

        Mail::send('emails.vendor_Order2Vendor', ['po' => $po],
            function ($m) use ($po) {
                $m->to($po->vendor->email, $po->vendor->name)->subject('[vendor]KPZH 新しい注文!');
            });

    }
}
