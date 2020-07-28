<?php

namespace App;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;

class AccessHistory extends Model
{
    protected $fillable = ['mail_history_id'];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
