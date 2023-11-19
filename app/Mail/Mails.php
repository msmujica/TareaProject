<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mails extends Mailable
{
    use Queueable, SerializesModels;

    private $mailFrom;
    private $mailSubject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($from, $subject)
    {
        $this -> mailFrom = $from;
        $this -> mailSubject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this 
        -> from($this -> mailFrom, $this -> mailSubject) 
        -> view('mail', [
            'subject' => $this -> mailSubject, 
            'from' => $this -> mailFrom
        ]);
    }
}