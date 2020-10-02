<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMe extends Mailable
{
    use Queueable, SerializesModels;

    // this Mailer class is going to expect some $topic data to be passed in
    // any public property on this Mailer will instantly be available in the view 
    public $topic;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($topic)
    {
        $this->topic = $topic;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // customize the subject of the email, delay, que, etc
        // return $this->view('emails.ContactMe')->subject('More information about '.$this->topic);

        // instead of view() want to use markdown()
        return $this->markdown('emails.ContactMe')->subject('More information about '.$this->topic);
    }
}
