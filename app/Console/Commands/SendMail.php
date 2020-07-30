<?php

namespace App\Console\Commands;

use App\Http\Services\MailService;
use Illuminate\Console\Command;

class SendMail extends Command
{
    protected $signature = 'command:send_mail';

    protected $description = 'Command description';

    private $mail_service;


    public function __construct(MailService $mail_service)
    {
        parent::__construct();

        $this->mail_service = $mail_service;
    }


    public function handle()
    {
        $this->mail_service->sendMail();
    }
}
