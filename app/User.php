<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public function mail_histories(){

        return $this->hasMany(MailHistory::class);
    }
}
