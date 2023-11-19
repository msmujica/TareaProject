<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\Mails;
use Illuminate\Support\Facades\Mail;


class JobEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $to; 
    private $from;
    private $subject;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($from, $to, $subject)
    {
       $this -> to = $to;
       $this -> from = $from;
       $this -> subject = $subject;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new Mails($this -> from, $this -> subject);

        Mail::to($this -> to )->send($email);
    }
}

