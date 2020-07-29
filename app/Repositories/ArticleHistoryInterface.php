<?php

namespace App\Repositories;

interface ArticleHistoryInterface
{
    public function store($_article_history);

    public function selectLatestHistory();

}
