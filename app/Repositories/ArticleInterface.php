<?php

namespace App\Repositories;

interface ArticleInterface
{
    public function show($article_id);

    public function store($_article);

    public function selectDailyArticle();

    public function selectLatestArticles();

}
