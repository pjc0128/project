<?php


namespace App\Http;


abstract class Enum{
    const INSERT = "I";
    const DELETE = "D";

    //crawling
    const PRE = "http://edu.donga.com/";
    const KEYWORD = "?p=article&search=top&stx=%EC%B7%A8%EC%97%85";
    const ARTICLE_LIMIT = 10;

    //mail
    const GATEWAY = 'http://127.0.0.1:8000/gateway';
    const MAIL_REQUEST_URL = 'http://crm3.saramin.co.kr/mail_api/automails';
    const AUTOTYPE = 'A0188';
    const CMPNCODE = 12031;
    const SENDER_MAIL = 'pcc2242@saramin.co.kr';
    const USE_EVENT_SOLUTION = 'y';

    //telegram
    const BOT_TOKEN = '1355338404:AAGMfbvp_gQaBBEU56C4cyjnSQalDQ4hBlA';
    const API_URL = 'https://api.telegram.org/bot'.self::BOT_TOKEN.'/';
    const TELEGRAM_CHAT_ID = ['1336061434'];




}

