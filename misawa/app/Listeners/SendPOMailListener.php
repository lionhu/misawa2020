<?php

namespace App\Listeners;

use App\Events\SendPOMailEvent;
use App\Notifications\notificationPayBill;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;
class SendPOMailListener
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
     * @param  SendPOMailEvent  $event
     * @return void
     */
    public function handle(SendPOMailEvent $event)
    {


        $po=$event->po;

        $user=User::findOrFail($po->user_id);
        $clientAdmin=User::findOrFail($user->client->admin_id);

        if ($event->receiver =="superadmin"){
            if ($event->mailtype == "new"){
                Mail::send('emails.superAdmin_newOrderPlaced', ['po' => $po,'clientAdmin'=>$clientAdmin],
                    function ($m) use ($po) {
                        $m->to(env('SUPERADMIN_EMAIL'), $po->customer->name)->subject('[superadmin]新订单通知!');
                    });
            }
            if ($event->mailtype == "Order2Vendor"){
                Mail::send('emails.superAdmin_Order2Vendor', ['po' => $po],
                    function ($m) use ($po) {
                        $m->to(env('SUPERADMIN_EMAIL'), $po->customer->name)->subject('[superadmin]订单发送至药房通知!');
                    });
            }
            if ($event->mailtype == "OrderDeliverPackage"){

                Mail::send('emails.superAdmin_OrderDelivery', ['po' => $po],
                    function ($m) use ($po) {
                        $m->to(env('SUPERADMIN_EMAIL'), $po->customer->name)->subject('[superadmin]订单完成通知!');
                    });
            }
            if ($event->mailtype == "OrderCompleted"){
                Mail::send('emails.superAdmin_OrderComplete', ['po' => $po],
                    function ($m) use ($po) {
                        $m->to(env('SUPERADMIN_EMAIL'), $po->customer->name)->subject('[superadmin]订单完成通知!');
                    });
            }
        }
        if ($event->receiver =="customer"){
            if ($event->mailtype == "new"){
                Mail::send('emails.customer_newOrderPlaced', ['po' => $po],
                    function ($m) use ($po) {
                        $m->to($po->customer->email, $po->customer->name)->subject('[Customer]新订单通知!');
                    });
            }
            if ($event->mailtype == "Order2Vendor"){
                Mail::send('emails.customer_Order2Vendor', ['po' => $po],
                    function ($m) use ($po) {
                        $m->to($po->customer->email, $po->customer->name)->subject('[Customer]订单发送至药房通知!');
                    });
            }
            if ($event->mailtype == "OrderDeliverPackage"){

                Mail::send('emails.customer_OrderDelivery', ['po' => $po],
                    function ($m) use ($po) {
                        $m->to($po->customer->email, $po->customer->name)->subject('[Customer]EMS快件已经邮递成功!');
                    });
            }
            if ($event->mailtype == "OrderCompleted"){
                Mail::send('emails.customer_OrderComplete', ['po' => $po],
                    function ($m) use ($po) {
                        $m->to($po->customer->email, $po->customer->name)->subject('[Customer]订单完成通知!');
                    });
            }
        }
        if ($event->receiver =="vendor"){
            // if ($event->mailtype == "new"){
            // }
            if ($event->mailtype == "Order2Vendor"){
                Mail::send('emails.vendor_Order2Vendor', ['po' => $po],
                    function ($m) use ($po) {
                        $m->to($po->vendor->email, $po->vendor->name)->subject('[vendor]KPZH 新しい注文!');
                    });
            }
            // if ($event->mailtype == "OrderDeliverPackage"){
            //     Mail::send('emails.vendor_OrderDelivery', ['po' => $po],
            //         function ($m) use ($po) {
            //             $m->to($po->vendor->email, $po->vendor->name)->subject('[vendor]KPZH Package Delivered Notification!');
            //         });
            // }
            // if ($event->mailtype == "OrderCompleted"){
            //     Mail::send('emails.vendor_OrderComplete', ['po' => $po],
            //         function ($m) use ($po) {
            //             $m->to($po->vendor->email, $po->vendor->name)->subject('[vendor]KPZH Order Completed Notification!');
            //         });
            // }
        }

        if ($event->receiver =="distributor"){
            if ($event->mailtype == "notificationPayBill"){
                $user->notify(new notificationPayBill($po,$user));
            }
        }



    }
}
