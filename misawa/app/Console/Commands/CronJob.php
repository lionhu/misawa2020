<?php

namespace App\Console\Commands;

use App\Models\VisitLog;
use App\Notifications\newLoginNotification;
use Illuminate\Console\Command;
use App\Notifications\Welcome;
use App\User;
use Mail;

class CronJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CronJob:mailWelcome';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $admin=User::findOrFail(env("SUPERADMIN_ID"));
        if ($admin){
            $visitlogs=VisitLog::where("admin_notification",0)->get();
            if (count($visitlogs) > 0){
                $admin->notify(new newLoginNotification($visitlogs));
                VisitLog::where("admin_notification",0)
                    ->update(["admin_notification"=>1]);
                $this->info("Sent mail to admin");
            }else{
                $this->info("No visitors");
            }
        }else{
            $this->info("no Admin exist.");
        }
    }
}
