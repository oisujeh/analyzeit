<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function vlcascade(): Factory|View|Application
    {
        $vlCascade = DB::table('gen_vl_cascade')
            ->select('state as state','active as active','eligible as eligible','samp_collected as samp_collected',
                'no_vl_result as vl_result','percent_vl_result as percent_result','suppressed as suppressed','percent_suppressed
                 as percent_suppressed','gap as gap','result_lt_50 as result_lt_50','result_50_999 as result_50_999',
                'result_gt_999 as result_gt_999')
            ->orderBy('state','asc')
            ->get();
        return view('reports/vl.vl_cascade',compact('vlCascade'));
    }
}
