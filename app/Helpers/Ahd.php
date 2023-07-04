<?php

namespace App\Helpers;

use App\Models\TreatmentPerformance;
use Illuminate\Support\Facades\DB;

class Ahd
{
    public static function ahd_Performance($data,$start_date,$end_date): array
    {
        $statsql = "
            FORMAT(COALESCE(COUNT(DISTINCT CASE WHEN `HIVConfirmedDate` BETWEEN '$start_date' AND '$end_date' THEN `state` END),0),0) AS `states`,
            FORMAT(COALESCE(COUNT(DISTINCT CASE WHEN `HIVConfirmedDate` BETWEEN '$start_date' AND '$end_date' THEN `lga` END),0),0) AS `lga`,
            FORMAT(COALESCE(COUNT(DISTINCT CASE WHEN `HIVConfirmedDate` BETWEEN '$start_date' AND '$end_date' THEN `datim_code` END),0),0) AS `facility`,
            COALESCE(SUM(`HIVConfirmedDate` BETWEEN '$start_date' AND '$end_date'),0) AS `newdiagnose`,
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
            'card' => (!empty($list)) ? (array) $list->getAttributes() : [],
            'ahd' => self::ahd($data,$start_date, $end_date),
            /*
            'new_lga_drill_data' => self::newPerformanceLgaGraph($data, $tx, $start_date, $end_date),
            'tx_trends_data' => self::tx_new_trend($data),
            'tx_new_age_sex' => self::tx_age_sex($data, $tx, $start_date, $end_date),
            'tx_curr_graph' => self::tx_CurrSex($data, $tx, $start_date, $end_date),
            'tx_age_group_graph' => self::txNewageGroup($data, $tx, $start_date, $end_date)*/
        ];
    }

    public static function ahd($data, $start_date, $end_date)
    {
        $statsql = "
        COUNT(pepid) AS hivPosClient,
        CAST(COALESCE(SUM(Whostage != ''),0) AS UNSIGNED) AS whoClinicalStagingCount,
        CAST(COALESCE(SUM(Whostage IN (3, 4)),0) AS UNSIGNED) AS whoClinicalStaging3n4Count,
        CAST(COALESCE(SUM(CD4_LFA_Result != '' OR FirstCD4 != ''),0) AS UNSIGNED) AS cd4Result,
        CAST(COALESCE(SUM(CD4_LFA_Result = 'LessThan200' OR FirstCD4 <= 200),0) AS UNSIGNED) AS cD4LessCount,
        CAST(COALESCE(SUM(Whostage != '') / COUNT(pepid) * 100, 0) AS UNSIGNED) AS percentageWhoClinicalStaging,
        CAST(COALESCE(ROUND(SUM(Whostage IN (3, 4)) / SUM(Whostage != '') * 100, 1),0) AS UNSIGNED) AS percentageWhoClinicalStaging3n4,
        CAST(COALESCE(ROUND(SUM(CD4_LFA_Result != '' OR FirstCD4 != '') /  COUNT(pepid) * 100, 1),0) AS UNSIGNED) AS percentageCD4Results,
        CAST(COALESCE(ROUND(SUM(CD4_LFA_Result = 'LessThan200' OR FirstCD4 <= 200) / SUM(CD4_LFA_Result != '' OR FirstCD4 != '') * 100, 1),0) AS UNSIGNED) AS percentageCD4Less
        ";
        $list = TreatmentPerformance::select(DB::raw($statsql))
            ->state($data->states)->lga($data->lgas)->facilities($data->facilities)
            ->whereBetween('HIVConfirmedDate', [$start_date,$end_date])
            ->withoutGlobalScopes()
            ->first();
        return (!empty($list)) ? $list->toArray() : [];
    }

    public static function cm()
    {}

    public static function tb()
    {}


}
