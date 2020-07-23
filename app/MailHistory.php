<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailHistory extends Model
{
    function user(){

        return $this->belongsTo(User::class);
    }

    function mail_content(){

        return $this->belongsTo(MailContent::class);
    }

    function access_histories(){

        return $this->hasMany(AccessHistory::class);
    }
}
