<?php

namespace App\Console\Commands;

use App\Http\Services\CrawlingService;
use Illuminate\Console\Command;

class CheckArticle extends Command
{

    protected $signature = 'command:check_article';
    protected $description = 'Command description';

    private $crawling_service;

    public function __construct(CrawlingService $crawling_service)
    {
        parent::__construct();
        $this->crawling_service = $crawling_service;
    }

    public function handle()
    {
        $this->crawling_service->checkArticle();
    }
}
