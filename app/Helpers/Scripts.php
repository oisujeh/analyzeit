<?php

namespace App\Helpers;

use App\Models\VLPerformance;
use Illuminate\Support\Facades\DB;

class Scripts
{
    public static function dashboardGraphs()
    {
        $graphSql  = " `state` AS 'name', COUNT(`PepID`) AS  'y', `state` AS 'drilldown' ";
        $graphSql2 = " `lga` as 'lga',count(pepid) as  'patients'";
        $graphSql3 = " DAYNAME(next_appointment) as days, count(`pepid`) as patients";

        $today_appointments_stats = DB::table('today_appointments')->select(DB::raw($graphSql))->groupBy('state')->get();
        $missed_appointment_stats =  DB::table('missed_appointment')->select(DB::raw($graphSql))->groupBy('state')->get();
        $missed_appointment_days =  DB::table('missed_appointment')->select(DB::raw($graphSql3))->groupBy('days')->get();

        return  [
            'today_lga_list' =>  $today_appointments_stats,
            'missed_appointment_lga_list' =>  $missed_appointment_stats,
            'today_appointments_graph_drilldown' => self::plotGraphByLGA('today_appointments', $today_appointments_stats, $graphSql2),
            'missed_appointment_graph_drilldown' => self::plotGraphByLGA('missed_appointment', $missed_appointment_stats, $graphSql2),
        ];
    }

    public static function vLGraph($data): array
    {

        $facilityList = VLPerformance::select(DB::raw(
            "CAST(COALESCE(SUM(active),0)  AS UNSIGNED) as `active`,
            CAST(COALESCE(SUM(eligible),0)  AS UNSIGNED) as `eligible`,
            CAST(COALESCE(SUM(supressedVl),0)  AS UNSIGNED) as supressedVl,
            CAST(COALESCE(SUM(eligibleWithVl),0)  AS UNSIGNED) as eligibleWithVl,
            state"
        ))
            ->state($data->states)
            ->groupBy('state')
            ->withoutGlobalScopes()
            ->get();

        $state = [];
        $txCurr = [];
        $eligible = [];
        $eligibleWithVl = [];
        $viralLoadSuppressed = [];
        $txVlCoverage = [];
        $percentageViralLoadSuppressed = [];
        foreach ($facilityList as $index => $list) {
            $state[$index] =  $list->state;
            $txCurr[$index] =  $list->active;
            $eligible[$index] =  $list->eligible;
            $eligibleWithVl[$index] = $list->eligibleWithVl;
            $viralLoadSuppressed[$index] =  $list->supressedVl;
            $txVlCoverage[$index] = round((($list->eligible/$list->eligibleWithVl)*100),2);
            $percentageViralLoadSuppressed[$index] =  round((($list->supressedVl/$list->eligibleWithVl)*100),2);
        }

        $result=[
            'treatment_perfomance' => (!empty($list)) ? (array) $list->getAttributes() : [],
            'states'=>$state,
            'eligible' => $eligible,
            'eligibleWithVl' => $eligibleWithVl,
            'tx_curr'=>$txCurr,
            'viralLoadSuppressed'=>$viralLoadSuppressed,
            'tx_Vl_Coverage'=>$txVlCoverage,
            'percentage_viral_load_suppressed'=>$percentageViralLoadSuppressed
        ];

        return (!empty($result)) ?  $result : [];
    }
}
