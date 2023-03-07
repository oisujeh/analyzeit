<?php

namespace App\Helpers;

use App\Models\TreatmentPerformance;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;

class Mortality
{
    #[ArrayShape(['mortality_stats' => "array", 'new_state_data' => "mixed", 'regimenLineQs' => "array", 'sex_total' => "array", 'vl' => "array", 'artd' => "array"])] public static function mortality_stats($data, $start_date, $end_date): array
    {
        $statsql = "FORMAT(COALESCE(COUNT(DISTINCT CASE WHEN `Outcomes_Date` BETWEEN '$start_date' AND '$end_date' AND `Outcomes` = 'Dead' THEN `state` END),0),0) AS `states`,
        FORMAT(COALESCE(COUNT(DISTINCT CASE WHEN `Outcomes_Date` BETWEEN '$start_date' AND '$end_date' AND `Outcomes` = 'Dead' THEN `lga` END),0),0) AS `lga`,
        FORMAT(COALESCE(COUNT(DISTINCT CASE WHEN `Outcomes_Date` BETWEEN '$start_date' AND '$end_date' AND `Outcomes` = 'Dead' THEN `datim_code` END),0),0) AS `facility`,
        COALESCE(SUM(`Outcomes` = 'Dead' AND `Outcomes_Date` BETWEEN '$start_date' AND '$end_date'),0) AS `Dead`,
        `ip`";
        $list = TreatmentPerformance::select(DB::raw($statsql))
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('ip')
            ->withoutGlobalScopes()
            ->first();

        return [
            'mortality_stats' => (!empty($list)) ? (array) $list->getAttributes() : [],
            'new_state_data' => self::MortalityGraph($data, $start_date, $end_date),
            'regimenLineQs' => self::regimenLineByMortality($data, $start_date, $end_date),
            'sex_total' => self::sexByMortality($data, $start_date, $end_date),
            'vl'  => self::vlByMortality($data, $start_date, $end_date),
            'artd'  => self::ArtDuration($data, $start_date, $end_date)
        ];
    }

    public static function MortalityGraph($data, $start_date, $end_date)
    {
        $statsql = "
            year(Outcomes_Date) as `year`,
            CAST(SUM(`Outcomes` = 'Dead' and MONTH(Outcomes_Date) >= 1 AND MONTH(Outcomes_Date) <= 3) as unsigned) AS `q1`,
            CAST(SUM(`Outcomes` = 'Dead' and MONTH(Outcomes_Date) >= 4 AND MONTH(Outcomes_Date) <= 6) as unsigned) AS `q2`,
            CAST(SUM(`Outcomes` = 'Dead' and MONTH(Outcomes_Date) >= 7 AND MONTH(Outcomes_Date) <= 9) as unsigned) AS `q3`,
            CAST(SUM(`Outcomes` = 'Dead' and MONTH(Outcomes_Date) >= 10 AND MONTH(Outcomes_Date) <= 12) as unsigned) AS `q4`,
            CAST(SUM(`Outcomes` = 'Dead' and MONTH(Outcomes_Date) = 1) as unsigned) AS `january`,
            CAST(SUM(`Outcomes` = 'Dead' and MONTH(Outcomes_Date) = 2) as unsigned) AS `february`,
            CAST(SUM(`Outcomes` = 'Dead' and MONTH(Outcomes_Date) = 3) as unsigned) AS `march`,
            CAST(SUM(`Outcomes` = 'Dead' and MONTH(Outcomes_Date) = 4) as unsigned) AS `april`,
            CAST(SUM(`Outcomes` = 'Dead' and MONTH(Outcomes_Date) = 5) as unsigned) AS `may`,
            CAST(SUM(`Outcomes` = 'Dead' and MONTH(Outcomes_Date) = 6) as unsigned) AS `june`,
            CAST(SUM(`Outcomes` = 'Dead' and MONTH(Outcomes_Date) = 7) as unsigned) AS `july`,
            CAST(SUM(`Outcomes` = 'Dead' and MONTH(Outcomes_Date) = 8) as unsigned) AS `august`,
            CAST(SUM(`Outcomes` = 'Dead' and MONTH(Outcomes_Date) = 9) as unsigned) AS `september`,
            CAST(SUM(`Outcomes` = 'Dead' and MONTH(Outcomes_Date) = 10) as unsigned) AS `october`,
            CAST(SUM(`Outcomes` = 'Dead' and MONTH(Outcomes_Date) = 11) as unsigned) AS `november`,
            CAST(SUM(`Outcomes` = 'Dead' and MONTH(Outcomes_Date) = 12) as unsigned) AS `december`";

        return TreatmentPerformance::select(DB::raw($statsql))
            ->where('Outcomes','=','Dead')
            ->whereBetween('Outcomes_Date', [$start_date,$end_date])
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('year')
            ->orderBy('year', 'ASC')
            ->withoutGlobalScopes()
            ->get();
    }

    public static function regimenLineByMortality($data, $start_date, $end_date): array
    {

        $statsql = "
        CASE
            WHEN CurrentRegimenLine = 'Adult.1st.Line' THEN 'Adult 1st line ARV regimen'
            when CurrentRegimenLine = 'Adult.2nd.Line' THEN 'Adult 2nd line ARV regimen'
            when CurrentRegimenLine = 'Adult.3rd.Line' THEN 'Adult 3rd line ARV regimen'
            when CurrentRegimenLine = 'Peds.1st.Line' THEN 'Child 1st line ARV regimen'
            when CurrentRegimenLine = 'Peds.2nd.Line' THEN 'Child 2nd line ARV regimen'
            when CurrentRegimenLine = 'Peds.3rd.Line' THEN 'Child 3rd line ARV regimen'
        END as name,

        CAST(COUNT(pepid) AS UNSIGNED) AS y
        ";

        $list = TreatmentPerformance::select(DB::raw($statsql))
            ->state($data->states)->lga($data->lgas)->facilities($data->facilities)
            ->where('Outcomes','=','Dead')
            ->whereBetween('Outcomes_Date', [$start_date,$end_date])
            ->groupBy('name')
            ->orderBy('name','ASC')
            ->withoutGlobalScopes()
            ->get();

        return (!empty($list)) ? $list->toArray() : [];
    }

    public static function sexByMortality($data, $start_date, $end_date): array
    {

        $statsql = "
        CAST(SUM(CASE WHEN sex = 'M' THEN 1 ELSE 0 END) as signed) AS males,
        CAST(SUM(CASE WHEN sex = 'F' THEN 1 ELSE 0 END) as unsigned) AS females
        ";

        $list = TreatmentPerformance::select(DB::raw($statsql))
            ->state($data->states)->lga($data->lgas)->facilities($data->facilities)
            ->where('Outcomes','=','Dead')
            ->whereBetween('Outcomes_Date', [$start_date,$end_date])
           /* ->groupBy('name')
            ->orderBy('name','ASC')*/
            ->withoutGlobalScopes()
            ->get();

        return (!empty($list)) ? $list->toArray() : [];
    }

    public static function vlByMortality($data, $start_date, $end_date): array
    {

        $statsql = "
        CAST(SUM(CASE WHEN CurrentViralLoad < 1000  THEN 1 ELSE 0 END) as unsigned) AS suppressed,
        CAST(SUM(CASE WHEN CurrentViralLoad >= 1000  THEN 1 ELSE 0 END) as unsigned) AS unsuppressed,
        CAST(SUM(CASE WHEN CurrentViralLoad is null THEN 1 ELSE 0 END) as unsigned) AS no_vl
        ";

        $list = TreatmentPerformance::select(DB::raw($statsql))
            ->state($data->states)->lga($data->lgas)->facilities($data->facilities)
            ->where('Outcomes','=','Dead')
            ->whereBetween('Outcomes_Date', [$start_date,$end_date])
            /* ->groupBy('name')
             ->orderBy('name','ASC')*/
            ->withoutGlobalScopes()
            ->get();

        return (!empty($list)) ? $list->toArray() : [];
    }

    public static function ArtDuration($data, $start_date, $end_date): array
    {
        $statsql = "
        state as states,
        CAST(SUM(`Outcomes` = 'Dead' and DATEDIFF(Outcomes_Date, ARTStartDate) < 365) as unsigned) AS `less_1`,
        CAST(SUM(`Outcomes` = 'Dead' and DATEDIFF(Outcomes_Date, ARTStartDate) > 365 and DATEDIFF(Outcomes_Date, ARTStartDate) <= 1095) as unsigned) AS `b1_3`,
        CAST(SUM(`Outcomes` = 'Dead' and DATEDIFF(Outcomes_Date, ARTStartDate) > 1095 and DATEDIFF(Outcomes_Date, ARTStartDate) <= 1825) as unsigned) AS `b3_5`,
        CAST(SUM(`Outcomes` = 'Dead' and DATEDIFF(Outcomes_Date, ARTStartDate) > 1825) as unsigned) AS `gt_5`
        ";

        $list = TreatmentPerformance::select(DB::raw($statsql))
            ->state($data->states)->lga($data->lgas)->facilities($data->facilities)
            ->whereBetween('Outcomes_Date', [$start_date,$end_date])
            ->groupBy('state')
             ->orderBy('state','ASC')
            ->withoutGlobalScopes()
            ->get();
        return (!empty($list)) ? $list->toArray() : [];
    }


}
