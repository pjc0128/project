<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class CrawlingFailException extends Exception
{
    public function report(){
        Log::debug('Crawling fail');
    }
}
