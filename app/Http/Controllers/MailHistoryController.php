<?php

namespace App\Http\Controllers;

use App\MailHistory;
use Illuminate\Http\Request;

class MailHistoryController extends Controller
{
    protected $fillable = ['mail_id', 'user_id', 'success'];

    public function store($mail_history){
        MailHistory::create([
            'mail_id' => $mail_history['mail_id'],
            'user_id' => $mail_history['user_id'],
            'success' => $mail_history['success']
        ]);
    }


}
