<?php

namespace App\Http\Controllers;

use App\Mail\FirstMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{



    public function index()
    {
        // $mailData = [
        //     'title' => 'Mail from MyoMinNaing.com.mm',
        //     'body' => 'This is for testing email using smtp.'
        // ];

        Mail::to("myominnaing.eng@gmail.com")->send(new FirstMail("I'm title ", "I'm body"));
        return "aung p";
    }
}
