<?php

namespace App\Repositories;

interface MailHistoryInterface
{
    public function store($mail_history);

    public function show($mid, $uid);

    public function selectMailHistories($mail_id);

    public function selectDailyMailHistory();

    public function selectHourlyMailHistory();
}
