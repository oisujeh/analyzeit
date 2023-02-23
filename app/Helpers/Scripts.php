<?php

namespace App\Helpers;

use App\Models\TreatmentPerformance;
use App\Models\VLPerformance;
use App\HTSPerformance;
use Illuminate\Support\Facades\DB;

class Scripts
{

    public static function dashboardSummary()
    {
        $statsql = "
        COALESCE(SUM(`total_patients`),0) `total_patients`,
        COALESCE(SUM(`tx_new`),0) tx_new,
        COALESCE(SUM(`pbs`),0) pbs,
        COALESCE(SUM(`active`),0) active,
        COALESCE(SUM(`transferred_out`),0) transferred_out,
        COALESCE(SUM(`dead`),0) dead,
        COALESCE(SUM(`stopped`),0) stopped,
        COALESCE(SUM(`ltfu`),0) `ltfu`,
        `IP` ";

        $list =  DB::table('treament_report')
            ->select(DB::raw($statsql))
            //->where(['State'=>'Benue'])
            ->groupBy('IP')
            ->first();
        return $list;
    }

    public static function summaryList()
    {
        $statsql = "*";
        $list =  DB::table('treament_report')
            ->select(DB::raw($statsql))
            //->where(['State'=>'Benue'])
            ->get();
        return $list;
    }


    public static function dashboardGraphs()
    {
        $graphSql  = " `state` AS 'name', COUNT(`PepID`) AS  'y', `state` AS 'drilldown' ";
        $graphSql2 = " `lga` as 'lga',count(pepid) as  'patients'";
        $today_appointments_stats = DB::table('today_appointments')->select(DB::raw($graphSql))->groupBy('state')->get();

        return  [
            'today_lga_list' =>  $today_appointments_stats,
            'today_appointments_graph_drilldown' => self::plotGraphByLGA('today_appointments', $today_appointments_stats, $graphSql2),
        ];
    }




    public static function plotGraphByLGA($tableName, $lgaList, $graphSql)
    {
        $graphSqlDrilldown = [];
        foreach ($lgaList  as $key1  => $data) {
            $dataD = [];
            $fac = [];
            $graphSqlDrilldown[$key1]['name'] = $data->name;
            $graphSqlDrilldown[$key1]['id'] = $data->name;
            $drilldownData = [];
            $drilldownDataArray = [];
            $drilldown =  DB::table($tableName)->select(DB::raw($graphSql))
                ->where(['state' => $data->name])
                ->groupBy('state')
                ->groupBy('lga')
                //->groupBy('facility')
                //->groupBy('fac_id')
                ->get();

            foreach ($drilldown as $key => $data) {
                $drilldownData[0] = $data->lga;
                $drilldownData[1] = $data->patients;
                $drilldownDataArray[] = $drilldownData;
            }
            $graphSqlDrilldown[$key1]["data"] = $drilldownDataArray;
        }
        return  $graphSqlDrilldown;
    }

    public static function dashbordScript($table)
    {

        $StatsSql = "SELECT * FROM( SELECT
        COUNT(`PepID`) total_Appointments,
        SUM(IF(`phone_no` IS NOT NULL ,1,0)) total_Appointments_valid_no,
        SUM(IF(`phone_no` IS NOT NULL && STATUS = 1 ,1,0)) total_sent,
        SUM(IF(`phone_no` IS NOT NULL && STATUS = 0 ,1,0)) total_not_sent,
        SUM(IF(`phone_no` IS NULL ,1,0)) total_appointments_invalid_no
        FROM " . $table . " ) as appointments ";
        $stats = DB::select(DB::raw($StatsSql))[0];

        $listSql = "state as lga,
        COUNT(`PepID`) total_Appointments,
        SUM(IF(`phone_no` IS NOT NULL ,1,0)) total_Appointments_valid_no,
        SUM(IF(`phone_no` IS NOT NULL && STATUS = 1 ,1,0)) total_sent,
        SUM(IF(`phone_no` IS NOT NULL && STATUS = 0 ,1,0)) total_not_sent,
        SUM(IF(`phone_no` IS NULL ,1,0)) total_appointments_invalid_no";
        $list =  DB::table($table)
            ->select(DB::raw($listSql))
            ->groupBy('state')
            ->get();

        return array('stats' => $stats, 'list' => $list);
    }

    #TX  Graphs
    public static function treamentPerformance($data, $tx = 'tx_curr')
    {
        $tx = ($tx == 'tx_curr') ? 'active' : 'tx_new';
        $statsql = "
        FORMAT(COALESCE(COUNT(DISTINCT `state`),0),0) `states`,
        FORMAT(COALESCE(COUNT(DISTINCT `lga`),0),0) `lga`,
        FORMAT(COALESCE(COUNT(DISTINCT `datim_code`),0),0) `facilities`,
        FORMAT(COALESCE(SUM(`total_patients`),0),0) `total_patients`,
        FORMAT(COALESCE(SUM(`tx_new`),0),0) tx_new,
        FORMAT(COALESCE(SUM(`pbs`),0),0) pbs,
        FORMAT(COALESCE(SUM(`active`),0),0) active,
        FORMAT(COALESCE(SUM(`transferred_out`),0),0) transferred_out,
        FORMAT(COALESCE(SUM(`dead`),0),0) dead,
        FORMAT(COALESCE(SUM(`stopped`),0),0) stopped,
        FORMAT(COALESCE(SUM(`ltfu`),0),0) `ltfu`,
        `ip`";
        $list =  TreatmentPerformance::select(DB::raw($statsql))
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('ip')
            ->withoutGlobalScopes()
            ->first();
        $response = [
            'treatment_perfomance' => (!empty($list)) ? (array) $list->getAttributes() : [],
            'tx_new_state_data' => self::treamentPerformanceStateGraph($data, $tx),
            'tx_new_lga_drill_data' => self::treamentPerformanceLgaGraph($data, $tx)
        ];
        return $response;
    }

    public static function treamentPerformanceStateGraph($data, $tx)
    {

        $statsql = "
        state AS `name`,
        CAST(COALESCE(SUM($tx),0)  AS UNSIGNED) AS `y`,
        state AS `drilldown`";
        $list =  TreatmentPerformance::select(DB::raw($statsql))
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('name')
            ->orderBy('name', 'ASC')
            ->withoutGlobalScopes()
            ->get();

        return (!empty($list)) ?  $list : [];
    }

    public static function treamentPerformanceAgeGraph($data, $tx)
    {

        $statsql = "
        state AS `name`,
        CAST(COALESCE(SUM($tx),0)  AS UNSIGNED) AS `y`,
        state AS `drilldown`";
        $list =  TreatmentPerformance::select(DB::raw($statsql))
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('name')
            ->orderBy('name', 'ASC')
            ->withoutGlobalScopes()
            ->get();

        return (!empty($list)) ?  $list : [];
    }



    public static function treamentPerformanceLgaGraph($data, $tx)
    {

        $stateListBar = [];
        $stateList =  TreatmentPerformance::select(DB::raw("state AS `name`"))
            ->state($data->states)->lga($data->lgas)->facilities($data->facilities)
            ->groupBy('name')->withoutGlobalScopes()->get();

        $out = [];
        $out2 = [];

        foreach ($stateList  as  $index1  => $states) {
            $stateListBar[$index1]['name'] = $states->name;
            $stateListBar[$index1]['id'] = $states->name;

            $lgaList =  TreatmentPerformance::select(DB::raw(
                " lga,lgaCode, CAST(COALESCE(SUM( $tx ),0)  AS UNSIGNED) as  'patients'"
            ))->lga($data->lgas)->facilities($data->facilities)
                ->where(['state' => $states->name])
                ->groupBy('lga')
                ->groupBy('lgaCode')
                ->get();

            $lgaArray = [];
            $drillDownLga = [];
            $lgaListArray = [];

            foreach ($lgaList as $index2 => $lgas) {
                $lgaArray['name'] = $lgas->lga;
                $lgaArray['y'] = $lgas->patients;
                $lgaArray['drilldown'] = $lgas->lga;
                $drillDownLga[$index2] = $lgaArray;

                $lgaListArray['lgaCode'] = $lgas->lgaCode;
                $lgaListArray['lga'] = $lgas->lga;
                array_push($out, $lgaListArray);
            }
            $stateListBar[$index1]["data"] = $drillDownLga;
        }

        $facilityList =  TreatmentPerformance::select(DB::raw(
            "lga, lgaCode,facility_name , CAST(COALESCE(SUM($tx),0)  AS UNSIGNED) as  'patients'"
        ))->lga($data->lgas)->facilities($data->facilities)
            ->groupBy('lga')
            ->groupBy('lgaCode')
            ->groupBy('facility_name')
            ->withoutGlobalScopes()
            ->get();


        foreach ($out as $index => $lga) {
            $out2[$index]['name'] = $lga['lga'];
            $out2[$index]['id'] = $lga['lga'];
            $fac = [];
            $facElement = [];
            $i = 0;
            foreach ($facilityList as $key => $facility) {

                if ($facility->lgaCode == $lga['lgaCode']) {
                    $facElement[0] = $facility->facility_name;
                    $facElement[1] = $facility->patients;
                    $fac[$i] =  $facElement;
                    $i++;
                }
            }
            $out2[$index]['data'] = $fac;
        }

        foreach ($out2 as $index => $list) {
            array_push($stateListBar, $list);
        }
        return (!empty($stateListBar)) ?  $stateListBar   : [];
    }

    public static function vLGraph($data)
    {
        $facilityList = VLPerformance::select(DB::raw(
            "CAST(COALESCE(SUM(active),0)  AS UNSIGNED) as `active`,
            CAST(COALESCE(SUM(eligible),0)  AS UNSIGNED) as `eligible`,
            CAST(COALESCE(SUM(supressedVl),0)  AS UNSIGNED) as supressedVl ,
            CAST(COALESCE(SUM(eligibleWithVl),0)  AS UNSIGNED) as eligibleWithVl ,
            state"
        ))
            ->state($data->states)->lga($data->lgas)->facilities($data->facilities)
            ->groupBy('state')
            ->orderBy('state', 'ASC')
            //->groupBy('eligibleWithVl')
            // ->groupBy('eligible')
            // ->groupBy('supressedVl')
            // ->groupBy('active')
            // ->groupBy('lgaCode')
            // ->groupBy('facility_name')
            ->withoutGlobalScopes()
            ->get();

        $state = [];
        $lga = [];
        $facility =[];
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
            'lgas'=>$lga,
            'facilities'=>$facility,
            'eligible' => $eligible,
            'eligibleWithVl' => $eligibleWithVl,
            'tx_curr'=>$txCurr,
            'viralLoadSuppressed'=>$viralLoadSuppressed,
            'tx_Vl_Coverage'=>$txVlCoverage,
            'percentage_viral_load_suppressed'=>$percentageViralLoadSuppressed
        ];

        return (!empty($result)) ?  $result : [];
    }

    public static function htsGraph($data)
    {

        $facilityList = HTSPerformance::select(DB::raw(
            "FORMAT(COALESCE(COUNT(DISTINCT `state`),0),0) `states`,
            CAST(COALESCE(SUM(hts_tst),0)  AS UNSIGNED) as `hts_tst`,
            CAST(COALESCE(SUM(hts_tst_pos),0)  AS UNSIGNED) as `hts_tst_pos`,
            state
            "
        ))
            ->state($data->states)
            ->groupBy('state')
            // ->groupBy('eligibleWithVl')
            // ->groupBy('eligible')
            // ->groupBy('supressedVl')
            // ->groupBy('active')
            // ->groupBy('lgaCode')
            // ->groupBy('facility_name')
            ->withoutGlobalScopes()
            ->get();

        $state = [];
        $hts_tst = [];
        $hts_tst_pos = [];
        $percentage_yield = [];
        foreach ($facilityList as $index => $list) {
            $state[$index] =  $list->state;
            $hts_tst[$index] =  $list->hts_tst;
            $hts_tst_pos[$index] =  $list->hts_tst_pos;
            $percentage_yield[$index] =  round((($list->hts_tst_pos/$list->hts_tst)*100),2);
        }

        $result=[
            'hts_performance' => (!empty($list)) ? (array) $list->getAttributes() : [],
            'states'=>$state,
            'hts_tst' => $hts_tst,
            'hts_tst_pos'=>$hts_tst_pos,
            'percentage_yield'=>$percentage_yield
        ];

        return (!empty($result)) ?  $result : [];
    }
}
