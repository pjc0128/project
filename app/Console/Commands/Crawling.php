<?php
//
//namespace App\Console\Commands;
//
//use App\Http\Controllers\ArticleController;
//use App\Http\Controllers\ArticleHistoryController;
//use App\Http\Controllers\Clawler;
//use App\Http\Controllers\MailArticleRelationController;
//use App\Http\Controllers\MailContentController;
//use App\Http\Model\Article;
//use App\Http\Model\MailContent;
//use Illuminate\Console\Command;
//use Illuminate\Support\Facades\Log;
//
//class Crawling extends Command
//{
//
//    protected $signature = 'command:crawling';
//
//    protected $description = 'Command description';
//
//
//    public function __construct()
//    {
//        parent::__construct();
//        $ac = new ArticleController(new Article());
//        $c = new Clawler();
//        $ahc = new ArticleHistoryController();
//        $mcc = new MailContentController(new MailContent());
//        $marc = new MailArticleRelationController();
//
//    }
//
//    public function handle()
//    {
//        function (){
//
//
//            $mail = $mcc->selectLatest();
//            $old_articles = $ac->selectArticles($mail->id);
//
//            Log::info('oldArticles : '.$old_articles );
//
//            $check = false;
//            $mail_content_id = 0;
//
//            foreach ($old_articles as $article) {
//
//                $deleted = $c->checkDelete($article->url);
//                Log::info('check1');
//
//                if ($deleted) {
//                    $check = true;
//                    Log::info('check2');
//
//                    $article_history = ([
//                        'article_id' => $article->id,
//                        'type' => 'D'
//                    ]);
//
//                    $ahc->store($article_history);
//                }
//            }
//
//            if($check){
//                if($mail_content_id == 0){
//                    $mail_content_id = $mcc->store();
//                }
//
//                $latest_histories = $ahc->selectLatestHistory();
//
//                foreach ($latest_histories as $lh){
//                    $marc->store($mail_content_id, $lh->id);
//                }
//            }
//
//        }
//
//        return 0;
//    }
//}
