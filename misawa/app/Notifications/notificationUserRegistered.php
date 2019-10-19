<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class notificationUserRegistered extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $user;
    protected $agent;
    public function __construct($user,$agent)
    {
        $this->user=$user;
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
        $father=User::where("id",$this->user->parent_id)->first();

        return (new MailMessage)
            ->subject($this->user->name.' Registered in Notification ')
            ->line('User '.$this->user->name." has just Registered!")
            ->line('His parent is:  '.$father !==null?$father->name:"lionhu")
            ->line('Using : '.$this->agent->device()." & ".$this->agent->platform())
            ->action('Notification Action', url('http://shop.misawa-pharmacy.com'))
            ->line('Thank you for using our application!');
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
            //
        ];
    }
}
