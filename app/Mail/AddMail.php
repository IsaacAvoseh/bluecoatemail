<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AddMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email)
    {
        $this->email = $email;
    }
   
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'isaactraintest@gmail.com';
        $subject = 'New Email Notification';
        $name = 'BlueCoat';

        return $this->view('mails.addnew')
        ->from($address, $name)
            ->replyTo($address, $name)
            ->subject($subject)
            ->with(['data' => $this->email]);
    }
}
