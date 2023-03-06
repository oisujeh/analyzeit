<?php

namespace App\Helpers;

use App\Models\TreatmentPerformance;
use Illuminate\Support\Facades\DB;

class Mortality
{
    public static function mortality_stats($data, $start_date, $end_date): array
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
            'new_state_data' => self::StateGraph($data, $start_date, $end_date)
        ];
    }

    public static function StateGraph($data, $start_date, $end_date)
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


}
