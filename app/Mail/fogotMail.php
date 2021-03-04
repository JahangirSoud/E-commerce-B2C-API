<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class fogotMail extends Mailable
{
    use Queueable, SerializesModels;
    public $token;
    public function __construct($token)
    {
        $this->data=$token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data=$this->data;
        return $this->from("mdjahangiralamsoud@gmail.com")->view('Mail.Forgot',compact('data'))->subject("Password Reset");
    }
}
