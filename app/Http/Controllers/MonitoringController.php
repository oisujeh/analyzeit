<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Helpers\Scripts as Helper;

class MonitoringController extends Controller
{
    public function index(): Factory|View|Application
    {
        /*$data = [
            'dashboardGraphs' => Helper::dashboardGraphs()
        ];*/
        return view('/pages');
    }
}
