<?php

namespace App\Repositories;

use App\Http\Model\MailArticleRelation;
use Illuminate\Support\Facades\Log;

class MailArticleRelationRepository implements MailArticleRelationInterface
{
    private $mail_article_relation;

    public function __construct(MailArticleRelation $mail_article_relation)
    {
        $this->mail_article_relation = $mail_article_relation;
    }

    public function store($_mail_article_relation)
    {

        return $this->mail_article_relation
            ->create([
                'mail_id' => $_mail_article_relation['mail_content_id'],
                'article_history_id' => $_mail_article_relation['article_history_id']
            ]);
    }
}
