<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\JobEmails;

class MailController extends Controller
{

    public function Send(Request $request){
        
        $emailJob = new JobEmails(
            $request -> post("from"),
            $request -> post("to"),
            $request -> post("subject")
        );
        
        $this->dispatch($emailJob);
        return [ 'status' => 'success'];
    }
    
}
