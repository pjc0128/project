<?php

namespace App\Console\Commands;


use App\Http\Controllers\Clawler;
use App\Http\Model\Article;
use App\Http\Model\MailContent;
use App\Http\Services\CrawlingService;
use App\Repositories\ArticleHistoryInterface;
use App\Repositories\ArticleInterface;
use App\Repositories\ArticleRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CrawlingArticle extends Command
{

    protected $signature = 'command:crawling_article';

    protected $description = 'Command description';

    private $crawling_service;

    public function __construct(CrawlingService $crawling_service)
    {
        parent::__construct();

        $this->crawling_service = $crawling_service;

    }

    public function handle()
    {
        $this->crawling_service->crawlingArticle();

    }
}
