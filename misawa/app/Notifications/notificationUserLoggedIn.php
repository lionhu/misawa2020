<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Zhuzhichao\IpLocationZh\Ip;

class notificationUserLoggedIn extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $IPinfo;
    protected $user_name;
    protected $agent;
    public function __construct($IPinfo,$user_name,$agent)
    {
        $this->IPinfo=$IPinfo;
        $this->user_name=$user_name;
        $this->agent=$agent;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {

        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject(' 用户 '.$this->user_name.' 登录通知 ')
                    ->line('用户 '.$this->user_name." 刚刚登录到Misawa药房系统!")
                    ->action(' Misawa药房', url('http://new.misawa-pharmacy.com/admin'))
                    ->line('感谢对我们团队的关注!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
                "country"=>$this->IPinfo[0],
                "province"=>$this->IPinfo[1],
                "city"=>$this->IPinfo[2],
                "other_address"=>$this->IPinfo[3],
                "postcode"=>$this->IPinfo[4],
                "user_name"=>$this->user_name,
                "device"=>$this->agent->device(),
                "platform"=>$this->agent->platform(),
                "browser"=>$this->agent->browser()

        ];
    }
}
