<?php

namespace App\Repositories;

interface MailContentInterface
{
    public function store();

    public function selectLatest();

    public function selectMailContents();

}
