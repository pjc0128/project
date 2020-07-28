<?php

namespace App\Http\Controllers;

use App\AccessHistory;
use Illuminate\Http\Request;

class AccessHistoryController extends Controller
{
    public function store($mail_history_id){
        AccessHistory::create([
            'mail_history_id' => $mail_history_id
        ]);
    }
}
