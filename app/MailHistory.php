<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class MailHistory extends Model

{
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

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
