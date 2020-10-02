<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\NexmoMessage;

// This class sends a "payment recieved" notification
class PaymentRecieved extends Notification
{
    use Queueable;
    protected $amount;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    // mail => email notification
    // database => store notifications and display when the user visits website
    // nexmo => SMS notification
    // * each channel has an associated toChannel method
    public function via($notifiable)
    {
        return ['mail', 'database', 'nexmo'];
        // usually would include an sms notification if the user checked something (determine whether or not to use the nexmo channel) i.e. 
        // return ['mail', 'database', $notifiable->wants_SMS];
    }

    /**
     * Get the mail representation of the notification (translate the notification into an email).
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    // default email subject is based on the name of the class i.e. this email will have a subject of "Payment Recieved". change the subject
                    ->subject('We got it!')
                    // default greeting is "Hello", change the greeting
                    ->greeting("What's up?")
                    // line => paragraph
                    ->line('The introduction to the notification.')
                    // action => call-to-action button with (button text, url)
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }


    /**
     * Get the Nexmo / SMS representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return NexmoMessage
     */
    public function toNexmo($notifiable)
    {
        return (new NexmoMessage)
                    ->content('Your payment was recieved!' );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        // if you had a model instead, you could cast the model to an array
        // $model->toArray();
        return [
            'amount' => $this->amount
        ];
    }
}
