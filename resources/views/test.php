<?php

$test = new \App\Repositories\ArticleRepository(new \App\Http\Model\Article());
$articles = $test->selectLatestArticles();

foreach ($articles as $article){

    print $article;
}


