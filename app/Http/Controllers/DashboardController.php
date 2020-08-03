<?php


namespace App\Http\Controllers;

use App\Http\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController
{
    private $dashboard_service;

    public function __construct(DashboardService $dashboard_service){
        $this->dashboard_service = $dashboard_service;
    }

    public function index(){

        return view('dashboard/main', ['result'=>$this->dashboard_service->index()]);
    }

    public function detail(Request $request){
        $mail_id = $request->input('mid');
        $mail_title = $request->input('mail_title');

        $result = $this->dashboard_service->detail($mail_id);
        $result['mail_title'] = $mail_title;

        return view('dashboard/detail', ['result'=>$result]);
    }

    public function chart(){

        return view('dashboard/chart', ['result'=>$this->dashboard_service->chart()]);
    }
}
