<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessHistory extends Model
{
    protected $fillable = ['mail_id', 'user_id'];
}
