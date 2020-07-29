<?php

namespace App\Repositories;

use App\Http\Model\MailArticleRelation;

class MailArticleRelationRepository implements MailArticleRelationInterface
{
    private $mail_article_relation;

    public function __construct(MailArticleRelation $mail_article_relation){

        $this->mail_article_relation = $mail_article_relation;

    }

    public function store($mail_id, $article_history_id){
        $this->mail_article_relation
            ->create([
                'mail_id' => $mail_id,
                'article_history_id' =>$article_history_id
            ]);
    }
}
