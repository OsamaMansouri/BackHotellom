<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserPassHasBeenUpdatedMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * User email.
     *
     * @var String
     */
    public $email;

    /**
     * User password.
     *
     * @var String
     */
    public $password;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.UserPassHasBeenUpdatedMail');
    }
}
