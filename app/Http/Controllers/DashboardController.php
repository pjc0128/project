<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController
{
    private $dashboard_service;

    public function __construct(DashboardService $dashboard_service){
        $this->dashboard_service = $dashboard_service;
    }

    public function index(){
        $result = $this->dashboard_service->index();

        return view('dashboard/main', ['result'=>$result]);
    }

    public function detail(Request $request){
        $mail_id = $request->input('mid');

        $result = $this->dashboard_service->detail($mail_id);

        Log::info('controller articles : '. $result['articles']);
        Log::info('controller histories : '. $result['mail_histories']);

        return view('dashboard/detail', ['result'=>$result]);
    }



}
