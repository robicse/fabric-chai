<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MyEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('00e208a5dc-e45b22@inbox.mailtrap.io')->view('email.mail-template')->subject('Welcome To Fabric Lagbe LTD');
//        return $this->from('sayka@staritltd.com')->view('email.mail-template')->subject('Welcome To Fabric Lagbe LTD');
    }
}
