<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    //
    public function index(){
        $mailData = [
            'title'=> 'Mail from Laravel',
            'body'=>'This is for testing email using smtp',
        ];
        Mail::to('essadanyya@cy-tech.fr')->send(new SendMail($mailData));
        dd('Email send successfully');
    }
}
