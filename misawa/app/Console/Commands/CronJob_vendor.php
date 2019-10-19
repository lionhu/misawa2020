<?php

namespace App\Console\Commands;

use App\Models\PO;
use App\Models\VisitLog;
use App\Notifications\newLoginNotification;
use App\Notifications\notifyVendorNewOrder;
use Illuminate\Console\Command;
use App\Notifications\Welcome;
use App\User;
use Mail;

class CronJob_vendor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CronJob:vendorProcessing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify vendor about orders to process';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $vendor=User::findOrFail(env("VENDOR_ID"));
        if ($vendor){
            $orders=PO::where('status','processing')
                ->where('vendor_id',env("VENDOR_ID"))
                ->get();
            if (count($orders) > 0){
                $vendor->notify(new notifyVendorNewOrder($orders));
                VisitLog::where("admin_notification",0)
                    ->update(["admin_notification"=>1]);
                $this->info("Sent mail to vendor");
            }
        }else{
            $this->info("no Vendor exist.");
        }
    }
}
