<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\JobEmails;
use Illuminate\Support\Facades\Cache;

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
    
    public function SendHelp(Request $request){
        $UserData = Cache::get(explode(" ", $request -> header("Authorization"))[1]);

        $emailJob = new JobEmails(
            $UserData['email'],
            'Help@tareasya.com',
            $request -> post('subject')
        );

        $this->dispatch($emailJob);
        return [ 'status' => 'success' ];
    }
}
