<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;


class notificationPayBill extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $po;
    protected $user;
    public function __construct($po,$user)
    {
        $this->po=$po;
        $this->user=$user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {

        return ['mail'];
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
                    ->subject('[ミサワ薬局] 支付通知')
                    ->line('亲爱的用户，'.$this->user->name)
                    ->line("您的订单（#".$this->po->id."）尚未支付，现在处在保留状态。")
                    ->line("为了能让您可以及时收到产品，希望能尽快完成支付。")
                    ->action('ミサワ薬局', url('http://new.misawa-pharmacy.com'))
                    ->line('非常感谢您使用我们的服务!');
    }
}
