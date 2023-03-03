<?php

namespace App\Helpers;

use App\Models\TreatmentPerformance;
use App\Models\QualPerformance;
use App\Models\VLPerformance;
use Illuminate\Support\Facades\DB;

class Treatment_new
{

    public static function treament_new_Performance($data, $tx, $start_date,$end_date): array
    {
        $statsql = "
            FORMAT(COALESCE(COUNT(DISTINCT CASE WHEN `ARTStartDate` BETWEEN '$start_date' AND '$end_date' AND `TI` =  'No' THEN `state` END),0),0) AS `states`,
            FORMAT(COALESCE(COUNT(DISTINCT CASE WHEN `ARTStartDate` BETWEEN '$start_date' AND '$end_date' AND `TI` =  'No' THEN `lga` END),0),0) AS `lga`,
            FORMAT(COALESCE(COUNT(DISTINCT CASE WHEN `ARTStartDate` BETWEEN '$start_date' AND '$end_date' AND `TI` =  'No' THEN `datim_code` END),0),0) AS `facility`,
            COALESCE(SUM(`TI` =  'No' AND `ARTStartDate` BETWEEN '$start_date' AND '$end_date'),0) AS `new`,
            `ip`
	    ";
        $list =  TreatmentPerformance::select(DB::raw($statsql))
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('ip')
            ->withoutGlobalScopes()
            ->first();

        return [
            'treatment_perfomance' => (!empty($list)) ? (array) $list->getAttributes() : [],
            'new_state_data' => self::newPerformanceStateGraph($data,$tx, $start_date, $end_date),
            'new_lga_drill_data' => self::newPerformanceLgaGraph($data, $tx, $start_date, $end_date),
            'tx_trends_data' => self::tx_new_trend($data),
        ];
    }

    public static function newPerformanceStateGraph($data, $tx, $start_date, $end_date)
    {
        $statsql = "
        state AS `name`,
        Count(pepid) AS `y`,
        state AS `drilldown`";
        $list =  TreatmentPerformance::select(DB::raw($statsql))
            ->where('TI','=','No')
            ->whereBetween('ARTStartDate', [$start_date,$end_date])
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('name')
            ->orderBy('name', 'ASC')
            ->withoutGlobalScopes()
            ->get();

        return (!empty($list)) ?  $list : [];
    }

    public static function newPerformanceLgaGraph($data,$tx, $start_date, $end_date): array
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
                " lga,lgaCode, Count(pepid) as  'patients'"
            ))->lga($data->lgas)->facilities($data->facilities)
                ->where(['state' => $states->name])
                ->where('TI','=','No')
                ->whereBetween('ARTStartDate', [$start_date,$end_date])
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
                $out[] = $lgaListArray;
            }
            $stateListBar[$index1]["data"] = $drillDownLga;
        }

        $facilityList =  TreatmentPerformance::select(DB::raw(
            "lga, lgaCode,facility_name , Count(pepid) as  'patients'"
        ))->lga($data->lgas)->facilities($data->facilities)
            ->where('TI','=','No')
            ->whereBetween('ARTStartDate', [$start_date,$end_date])
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
            $stateListBar[] = $list;
        }
        return (!empty($stateListBar)) ?  $stateListBar   : [];
    }



    public static function tx_new_trend($data): array
    {

        $statsql = "
        COUNT(pepid) as enrollments,
        DATE_FORMAT(ARTStartDate, '%b %y') as month_year
        ";

        $facilityList2 = TreatmentPerformance::select(DB::raw($statsql))
            ->where('ARTStartDate', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 1 YEAR)'))
            ->where('TI', '!=', 'Yes')
            ->state($data->states)->lga($data->lgas)->facilities($data->facilities)
            ->groupBy('month_year')
            ->orderBy('ARTStartDate')
            ->withoutGlobalScopes()
            ->get();

        $month_year = [];
        $enrollments = [];
        foreach ($facilityList2 as $index => $list) {
            $month_year[$index] =  $list->month_year;
            $enrollments[$index] =  $list->enrollments;
        }

        $result=[
            'treatment_perfomance' => (!empty($list)) ? (array) $list->getAttributes() : [],
            'tx_new_trend_months'=>$month_year,
            'tx_new_trend_data' => $enrollments
        ];

        return (!empty($result)) ?  $result : [];
    }


}
