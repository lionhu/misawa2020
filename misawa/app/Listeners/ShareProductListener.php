<?php

namespace App\Listeners;

use App\Events\ShareProductEvent;
use App\Models\Product;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class ShareProductListener
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
     * @param  ShareProductEvent  $event
     * @return void
     */
    public function handle(ShareProductEvent $event)
    {

        $product=Product::findOrFail($event->product_id);
        $email=$event->email;

        if ($product->b_price > 0){
            Mail::send('emails.ShareProduct', ["product"=>$product],
                function ($m) use ($product,$email) {
                    $m->to($email,$name = null)->subject('[Canvas]产品信息介绍');
                });
        }

    }
}
