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
            'cm' => self::cm($data,$start_date, $end_date),
            'tb' => self::tb($data,$start_date, $end_date),
        ];
    }

    public static function ahd($data, $start_date, $end_date)
    {
        $statsql = "
        COUNT(pepid) AS hivPosClient,
        CAST(COALESCE(SUM(Whostage != ''),0) AS UNSIGNED) AS whoClinicalStagingCount,
        CAST(COALESCE(SUM(Whostage IN (3, 4)),0) AS UNSIGNED) AS whoClinicalStaging3n4Count,
        CAST(COALESCE(SUM(CD4_LFA_Result != '' OR FirstCD4 != ''),0) AS UNSIGNED) AS cd4Result,
        CAST(COALESCE(SUM(CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200),0) AS UNSIGNED) AS cD4LessCount,
        CAST(COALESCE(SUM(Whostage != '') / COUNT(pepid) * 100, 0) AS UNSIGNED) AS percentageWhoClinicalStaging,
        CAST(COALESCE(ROUND(SUM(Whostage IN (3, 4)) / SUM(Whostage != '') * 100, 1),0) AS UNSIGNED) AS percentageWhoClinicalStaging3n4,
        CAST(COALESCE(ROUND(SUM(CD4_LFA_Result != '' OR FirstCD4 != '') /  COUNT(pepid) * 100, 1),0) AS UNSIGNED) AS percentageCD4Results,
        CAST(COALESCE(ROUND(SUM(CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200) / SUM(CD4_LFA_Result != '' OR FirstCD4 != '') * 100, 1),0) AS UNSIGNED) AS percentageCD4Less
        ";
        $list = TreatmentPerformance::select(DB::raw($statsql))
            ->state($data->states)->lga($data->lgas)->facilities($data->facilities)
            ->whereBetween('HIVConfirmedDate', [$start_date,$end_date])
            ->withoutGlobalScopes()
            ->first();
        return (!empty($list)) ? $list->toArray() : [];
    }

    public static function cm($data, $start_date, $end_date)
    {
        $statsql = "
        CAST(COALESCE(SUM(CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)),0) AS UNSIGNED) AS presumptiveAHDClients,
        cast(coalesce(sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and Serology_CrAg in ('Positive', 'Negative')),0) AS UNSIGNED) AS serumCragCount,
        cast(coalesce(sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and Serology_CrAg = 'Positive'),0) AS UNSIGNED) AS serumCragPosCount,
        cast(coalesce(sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and Serology_CrAg = 'Positive' and CSF_CrAg in ('Positive', 'Negative')),0) AS UNSIGNED) AS csfCragCount,
        cast(coalesce(sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and Serology_CrAg = 'Positive' and CSF_CrAg = 'Positive'),0) AS UNSIGNED) AS csfCragPosCount,
        CAST(COALESCE(sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and Serology_CrAg in ('Positive', 'Negative')) / SUM(CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) * 100, 0) AS UNSIGNED) AS percentageSerumCrag,
        CAST(COALESCE(sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and Serology_CrAg = 'Positive') / sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and Serology_CrAg in ('Positive', 'Negative')) * 100, 0) AS UNSIGNED) AS percentageSerumCragPos,
        CAST(COALESCE(sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and Serology_CrAg = 'Positive' and CSF_CrAg in ('Positive', 'Negative')) / sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and Serology_CrAg = 'Positive') * 100, 0) AS UNSIGNED) AS percentageCsfCrag,
        CAST(COALESCE(sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and Serology_CrAg = 'Positive' and CSF_CrAg in ('Positive')) / sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and Serology_CrAg = 'Positive' and CSF_CrAg in ('Positive', 'Negative')) * 100, 0) AS UNSIGNED) AS percentageCsfCragPos
        ";
        $list = TreatmentPerformance::select(DB::raw($statsql))
            ->state($data->states)->lga($data->lgas)->facilities($data->facilities)
            ->whereBetween('HIVConfirmedDate', [$start_date,$end_date])
            ->withoutGlobalScopes()
            ->first();
        return (!empty($list)) ? $list->toArray() : [];
    }

    public static function tb($data, $start_date, $end_date)
    {
        $statsql = "
        CAST(COALESCE(SUM(CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)),0) AS UNSIGNED) AS presumptiveAHDClients,
        cast(coalesce(sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and TB_LAM in ('Positive', 'Negative')),0) AS UNSIGNED) AS tB_LAMCount,
        cast(coalesce(sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and TB_LAM = 'Positive'),0) AS UNSIGNED) AS tB_LAMPosCount,
        cast(coalesce(sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and TB_LAM = 'Positive' and TBStatus='On treatment for disease'),0) AS UNSIGNED) AS tB_LAMTreatmentCount,
        CAST(COALESCE(sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and TB_LAM in ('Positive', 'Negative')) / SUM(CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) * 100, 0) AS UNSIGNED) AS percentageTB_LamTest,
        CAST(COALESCE(sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and TB_LAM = 'Positive') / sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and TB_LAM in ('Positive', 'Negative')) * 100, 0) AS UNSIGNED) AS percentageAHD_TBCoInfection,
        CAST(COALESCE(sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and TB_LAM = 'Positive' and TBStatus='On treatment for disease') / sum((CD4_LFA_Result = 'LessThan200' OR FirstCD4 <200 or age<5 or Whostage IN (3, 4)) and TB_LAM = 'Positive')  * 100, 0) AS UNSIGNED) AS percentageAHDClientTB
        ";
        $list = TreatmentPerformance::select(DB::raw($statsql))
            ->state($data->states)->lga($data->lgas)->facilities($data->facilities)
            ->whereBetween('HIVConfirmedDate', [$start_date,$end_date])
            ->withoutGlobalScopes()
            ->first();
        return (!empty($list)) ? $list->toArray() : [];
    }


}
