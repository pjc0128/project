<?php

namespace App\Repositories;

interface MailContentInterface
{
    public function store($total);

    public function selectLatest();

    public function selectArticles($mail_id);

    public function selectMailContents();

}
