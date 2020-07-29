<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {


        $this->app->bind("App\Repositories\AccessHistoryInterface", "App\Repositories\AccessHistoryRepository");
        $this->app->bind("App\Repositories\ArticleInterface", "App\Repositories\ArticleRepository");
        $this->app->bind("App\Repositories\ArticleHistoryInterface", "App\Repositories\ArticleHistoryRepository");
        $this->app->bind("App\Repositories\MailArticleRelationInterface", "App\Repositories\MailArticleRelationRepository");
        $this->app->bind("App\Repositories\MailContentInterface", "App\Repositories\MailContentRepository");
        $this->app->bind("App\Repositories\MailHistoryInterface", "App\Repositories\MailHistoryRepository");
        $this->app->bind("App\Repositories\UserInterface", "App\Repositories\UserContentRepository");

//        $models = array(
//            'AccessHistory',
//            'Article',
//            'ArticleHistory',
//            'MailArticleRelation',
//            'MailContent',
//            'MailHistory',
//            'User'
//        );
//        foreach ($models as $model){
//            $this->app->bind("App\Repositories\\".$model."Interface, App\Repositories\\".$model."Repository");
//
//
//            Log::info("App\Repositories\\".$model."Interface, App\Repositories\\".$model."Repository");
//        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
