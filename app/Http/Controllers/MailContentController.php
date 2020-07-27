<?php

namespace App\Http\Controllers;

use App\MailContent;
use App\MailHistory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class MailContentController extends Controller
{

    public function store()
    {
        $mail_content = MailContent::create([
            'created_at' => now()
        ]);

        return $mail_content->id;
    }

    public function selectLatest(){
        $mail_contents = MailContent::latest('created_at')->first();

        return $mail_contents;
    }
}
