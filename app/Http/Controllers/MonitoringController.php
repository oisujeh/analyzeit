<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use App\Helpers\Scripts as Helper;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

class MonitoringController extends Controller
{
    public function treatmentDashboard(): Factory|View|Application
    {
        /*$data = [
            'dashboardGraphs' => Helper::dashboardGraphs()
        ];*/
        return view('monitoring.treatment_dashboard');
    }

    public function appointmentDashboard(): Factory|View|Application
    {
        $todaysAppt = $this->dashboardScript("today_appointments");

        $data = [
            'dashboardGraphs' => Helper::dashboardGraphs(),
            'today_appointments' => Helper::dashbordScript("today_appointments")
        ];
        return view('monitoring.appointment_dashboard',compact('data','todaysAppt'));
    }

    #[ArrayShape(['stats' => "mixed", 'list' => "mixed"])] public function dashboardScript($table): array
    {

        $StatsSql = "SELECT * FROM( SELECT
        COUNT(`PepID`) total_Appointments,
        SUM(IF(`phone_no` IS NOT NULL ,1,0)) total_Appointments_valid_no,
        SUM(IF(`phone_no` IS NOT NULL && STATUS = 1 ,1,0)) total_sent,
        SUM(IF(`phone_no` IS NOT NULL && STATUS = 0 ,1,0)) total_not_sent,
        SUM(IF(`phone_no` IS NULL ,1,0)) total_appointments_invalid_no
        FROM ".$table." ) as treatment_report ";
        $stats = DB::select(DB::raw($StatsSql))[0];

        $listSql = "lga,
        facility_name,
        COUNT(`PepID`) total_Appointments,
        SUM(IF(`phone_no` IS NOT NULL ,1,0)) total_Appointments_valid_no,
        SUM(IF(`phone_no` IS NOT NULL && STATUS = 1 ,1,0)) total_sent,
        SUM(IF(`phone_no` IS NOT NULL && STATUS = 0 ,1,0)) total_not_sent,
        SUM(IF(`phone_no` IS NULL ,1,0)) total_appointments_invalid_no";
        $list =  DB::table($table)
            ->select(DB::raw($listSql))
            ->groupBy('lga','facility_name')
            ->get();

        return array('stats'=> $stats ,'list'=> $list);

    }

    public function pbs(): Factory|View|Application
    {
        $active = DB::table('pbs_report')
            ->select(DB::raw("
            CAST(COALESCE(SUM(`active`),0) AS UNSIGNED) active
            "
            ))->get();

        $captured = DB::table('pbs_report')
            ->select(DB::raw("
            CAST(COALESCE(SUM(`pbs_captured`),0) AS UNSIGNED) captured
            "
            ))->get();

        $notcaptured = DB::table('pbs_report')
            ->select(DB::raw("
            CAST(COALESCE(SUM(`not_captured`),0) AS UNSIGNED) notcaptured
            "
            ))->get();

        $valid = DB::table('pbs_report')
            ->select(DB::raw("
            CAST(COALESCE(SUM(`validfingers`),0) AS UNSIGNED) valid
            "
            ))->get();
        $invalid = DB::table('pbs_report')
            ->select(DB::raw("
            CAST(COALESCE(SUM(`invalidfingers`),0) AS UNSIGNED) invalid
            "
            ))->get();

        return view('monitoring.pbs', compact('active','captured','notcaptured','invalid','valid'));
        //dd($pbsList);
        //dd(json_encode($pbsList));
    }


    public function regimenDashboard(): Factory|View|Application
    {
        /*$data = [
            'dashboardGraphs' => Helper::dashboardGraphs()
        ];*/
        return view('monitoring.quality_of_care');
    }

}
