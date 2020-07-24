<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function mail_histories(){

        return $this->hasMany(MailHistory::class);
    }
}
