<?php

namespace App\Repositories;

interface MailArticleRelationInterface
{
    public function store($mail_id, $article_history_id);

}
