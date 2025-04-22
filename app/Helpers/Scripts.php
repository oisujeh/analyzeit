<?php

namespace App\Helpers;

use App\Models\TreatmentPerformance;
use App\Models\QualPerformance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class Scripts
{
    private const CACHE_TTL = 3600; // Cache for 1 hour (in seconds)

    public static function dashboardSummary()
    {
        $cacheKey = 'dashboard_summary';

        return Cache::remember($cacheKey, self::CACHE_TTL, function() {
            $statsql = "
            COALESCE(SUM(`total_patients`),0) `total_patients`,
            COALESCE(SUM(`tx_new`),0) tx_new,
            COALESCE(SUM(`pbs`),0) pbs,
            COALESCE(SUM(`active`),0) active,
            COALESCE(SUM(`transferred_out`),0) transferred_out,
            COALESCE(SUM(`Dead`),0) dead,
            COALESCE(SUM(`stopped`),0) stopped,
            COALESCE(SUM(`ltfu`),0) `ltfu`,
            `IP` ";

            return DB::table('treament_report')
                ->select(DB::raw($statsql))
                ->groupBy('IP')
                ->first();
        });
    }

    public static function summaryList()
    {
        $cacheKey = 'summary_list';

        return Cache::remember($cacheKey, self::CACHE_TTL, function() {
            return DB::table('treament_report')->get();
        });
    }

    public static function dashboardGraphs()
    {
        $cacheKey = 'dashboard_graphs';

        return Cache::remember($cacheKey, self::CACHE_TTL, function() {
            $graphSql = "`state` AS 'name', COUNT(`PepID`) AS 'y', `state` AS 'drilldown'";

            // Execute queries in parallel using query builder
            $today_appointments_stats = DB::table('today_appointments')
                ->select(DB::raw($graphSql))
                ->groupBy('state')
                ->get();

            $tomorrow_appointments_stats = DB::table('tomorrow_appointments')
                ->select(DB::raw($graphSql))
                ->groupBy('state')
                ->get();

            return [
                'today_lga_list' => $today_appointments_stats,
                'tomorrow_lga_list' => $tomorrow_appointments_stats,
                'today_appointments_graph_drilldown' => self::appPerformanceLgaGraph('today_appointments'),
                'tomorrow_appointments_graph_drilldown' => self::appPerformanceLgaGraph('tomorrow_appointments'),
            ];
        });
    }

    public static function plotGraphByLGA($tableName, $lgaList, $graphSql): array
    {
        $cacheKey = "plot_graph_by_lga_{$tableName}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function() use ($tableName, $lgaList, $graphSql) {
            $graphSqlDrilldown = [];

            foreach ($lgaList as $key1 => $data) {
                $graphSqlDrilldown[$key1]['name'] = $data->name;
                $graphSqlDrilldown[$key1]['id'] = $data->name;

                $drilldown = DB::table($tableName)
                    ->select(DB::raw($graphSql))
                    ->where(['state' => $data->name])
                    ->groupBy('state', 'lga')
                    ->get();

                $drilldownDataArray = [];

                foreach ($drilldown as $data) {
                    $drilldownDataArray[] = [$data->lga, $data->patients];
                }

                $graphSqlDrilldown[$key1]["data"] = $drilldownDataArray;
            }

            return $graphSqlDrilldown;
        });
    }

    public static function dashbordScript($table): array
    {
        $cacheKey = "dashboard_script_{$table}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function() use ($table) {
            // Using a single query with conditional aggregates instead of multiple queries
            $statsSql = "
                SELECT
                    COUNT(`PepID`) as total_Appointments,
                    SUM(IF(`phone_no` IS NOT NULL, 1, 0)) as total_Appointments_valid_no,
                    SUM(IF(`phone_no` IS NOT NULL AND STATUS = 1, 1, 0)) as total_sent,
                    SUM(IF(`phone_no` IS NOT NULL AND STATUS = 0, 1, 0)) as total_not_sent,
                    SUM(IF(`phone_no` IS NULL, 1, 0)) as total_appointments_invalid_no
                FROM {$table}
            ";

            $stats = DB::select($statsSql)[0];

            $listSql = "
                state as lga,
                COUNT(`PepID`) as total_Appointments,
                SUM(IF(`phone_no` IS NOT NULL, 1, 0)) as total_Appointments_valid_no,
                SUM(IF(`phone_no` IS NOT NULL AND STATUS = 1, 1, 0)) as total_sent,
                SUM(IF(`phone_no` IS NOT NULL AND STATUS = 0, 1, 0)) as total_not_sent,
                SUM(IF(`phone_no` IS NULL, 1, 0)) as total_appointments_invalid_no
            ";

            $list = DB::table($table)
                ->select(DB::raw($listSql))
                ->groupBy('state')
                ->get();

            return ['stats' => $stats, 'list' => $list];
        });
    }

    public static function treamentPerformance($data, $tx): array
    {
        $cacheKey = 'treatment_performance_' . md5(json_encode($data) . $tx);

        return Cache::remember($cacheKey, self::CACHE_TTL, function() use ($data, $tx) {
            $statsql = "
                FORMAT(COALESCE(COUNT(DISTINCT `state`), 0), 0) AS `states`,
                FORMAT(COALESCE(COUNT(DISTINCT `lga`), 0), 0) AS `lga`,
                FORMAT(COALESCE(COUNT(DISTINCT `datim_code`), 0), 0) AS `facilities`,
                COUNT(`pepid`) AS `total_patients`,
                COALESCE(SUM(`CurrentARTStatus_Pharmacy` = 'Active'), 0) AS `active`,
                `ip`
            ";

            $list = TreatmentPerformance::select(DB::raw($statsql))
                ->state($data->states)
                ->lga($data->lgas)
                ->facilities($data->facilities)
                ->groupBy('ip')
                ->withoutGlobalScopes()
                ->first();

            // Execute queries in parallel
            $tx_curr_graph = self::tx_Curr($data, $tx);
            $tx_age_group_graph = self::ageGroup($data, $tx);
            $tx_new_state_data = self::treamentPerformanceStateGraph($data, $tx);
            $tx_new_lga_drill_data = self::treamentPerformanceLgaGraph($data, $tx);
            $tx_new_age_sex = self::tx_age_sex($data);

            return [
                'treatment_perfomance' => (!empty($list)) ? (array) $list->getAttributes() : [],
                'tx_curr_graph' => $tx_curr_graph,
                'tx_age_group_graph' => $tx_age_group_graph,
                'tx_new_state_data' => $tx_new_state_data,
                'tx_new_lga_drill_data' => $tx_new_lga_drill_data,
                'tx_new_age_sex' => $tx_new_age_sex
            ];
        });
    }

    public static function tx_Curr($data, $tx)
    {
        $cacheKey = 'tx_curr_' . md5(json_encode($data) . $tx);

        return Cache::remember($cacheKey, self::CACHE_TTL, function() use ($data) {
            $statsql = "sex AS `name`, COUNT(pepid) as `y`";

            return TreatmentPerformance::select(DB::raw($statsql))
                ->where('CurrentARTStatus_Pharmacy', '=', 'Active')
                ->state($data->states)
                ->lga($data->lgas)
                ->facilities($data->facilities)
                ->groupBy('sex')
                ->withoutGlobalScopes()
                ->get();
        });
    }

    public static function ageGroup($data, $tx)
    {
        $cacheKey = 'age_group_' . md5(json_encode($data) . $tx);

        return Cache::remember($cacheKey, self::CACHE_TTL, function() use ($data) {
            $statsql = "
                CASE
                    WHEN age <= 9 THEN '≤9'
                    WHEN age BETWEEN 10 AND 19 THEN '10-19'
                    WHEN age BETWEEN 20 AND 24 THEN '20-24'
                    WHEN age >= 25 THEN '25+'
                END as name,
                COUNT(pepid) as `y`
            ";

            return TreatmentPerformance::select(DB::raw($statsql))
                ->where('CurrentARTStatus_Pharmacy', '=', 'Active')
                ->state($data->states)
                ->lga($data->lgas)
                ->facilities($data->facilities)
                ->groupBy('name')
                ->orderBy('name', 'DESC')
                ->withoutGlobalScopes()
                ->get();
        });
    }

    public static function treamentPerformanceStateGraph($data, $tx)
    {
        $cacheKey = 'treatment_performance_state_graph_' . md5(json_encode($data) . $tx);

        return Cache::remember($cacheKey, self::CACHE_TTL, function() use ($data) {
            $statsql = "
                state AS `name`,
                CAST(COALESCE(SUM(`CurrentARTStatus_Pharmacy` = 'Active'), 0) AS UNSIGNED) AS `y`,
                state AS `drilldown`
            ";

            return TreatmentPerformance::select(DB::raw($statsql))
                ->state($data->states)
                ->lga($data->lgas)
                ->facilities($data->facilities)
                ->groupBy('name')
                ->orderBy('name', 'ASC')
                ->withoutGlobalScopes()
                ->get();
        });
    }

    public static function treamentPerformanceLgaGraph($data, $tx): array
    {
        $cacheKey = 'treatment_performance_lga_graph_' . md5(json_encode($data) . $tx);

        return Cache::remember($cacheKey, self::CACHE_TTL, function() use ($data) {
            // Improve performance by reducing multiple queries into fewer queries
            $stateListBar = [];

            // Get state list
            $stateList = TreatmentPerformance::select('state AS name')
                ->state($data->states)
                ->lga($data->lgas)
                ->facilities($data->facilities)
                ->groupBy('name')
                ->withoutGlobalScopes()
                ->get();

            // Build placeholder array structure
            foreach ($stateList as $index1 => $state) {
                $stateListBar[$index1] = [
                    'name' => $state->name,
                    'id' => $state->name,
                    'data' => []
                ];
            }

            // Get LGA data for all states in a single query
            $lgaList = TreatmentPerformance::select(DB::raw(
                "state, lga, lgaCode, CAST(COALESCE(SUM(`CurrentARTStatus_Pharmacy` = 'Active'), 0) AS UNSIGNED) as patients"
            ))
                ->state($data->states)
                ->lga($data->lgas)
                ->facilities($data->facilities)
                ->groupBy('state', 'lga', 'lgaCode')
                ->withoutGlobalScopes()
                ->get()
                ->groupBy('state');

            // Get facility data for all LGAs in a single query
            $facilityList = TreatmentPerformance::select(DB::raw(
                "state, lga, lgaCode, facility_name, CAST(COALESCE(SUM(`CurrentARTStatus_Pharmacy` = 'Active'), 0) AS UNSIGNED) as patients"
            ))
                ->state($data->states)
                ->lga($data->lgas)
                ->facilities($data->facilities)
                ->groupBy('state', 'lga', 'lgaCode', 'facility_name')
                ->withoutGlobalScopes()
                ->get()
                ->groupBy('lgaCode');

            // Build state level drilldown
            foreach ($stateList as $index1 => $state) {
                $stateName = $state->name;

                if (isset($lgaList[$stateName])) {
                    foreach ($lgaList[$stateName] as $lga) {
                        $stateListBar[$index1]['data'][] = [
                            'name' => $lga->lga,
                            'y' => $lga->patients,
                            'drilldown' => $lga->lga
                        ];
                    }
                }
            }

            // Build LGA level drilldown
            $lgaListBar = [];
            foreach ($lgaList as $stateLgas) {
                foreach ($stateLgas as $lga) {
                    $lgaData = [
                        'name' => $lga->lga,
                        'id' => $lga->lga,
                        'data' => []
                    ];

                    if (isset($facilityList[$lga->lgaCode])) {
                        foreach ($facilityList[$lga->lgaCode] as $facility) {
                            $lgaData['data'][] = [
                                $facility->facility_name,
                                $facility->patients
                            ];
                        }
                    }

                    $lgaListBar[] = $lgaData;
                }
            }

            return array_merge($stateListBar, $lgaListBar);
        });
    }

    public static function regimenGraph($data): array
    {
        $cacheKey = 'regimen_graph_' . md5(json_encode($data));

        return Cache::remember($cacheKey, self::CACHE_TTL, function() use ($data) {
            $regimenData = QualPerformance::select("regimen", DB::raw("COUNT(regimen) as count"))
                ->where('artstatus', '=', 'Active')
                ->state($data->states)
                ->lga($data->lgas)
                ->facilities($data->facilities)
                ->groupBy('regimen')
                ->orderBy('count', 'desc')
                ->withoutGlobalScopes()
                ->get();

            $regimen = [];
            $count = [];

            foreach ($regimenData as $index => $item) {
                $regimen[$index] = $item->regimen;
                $count[$index] = $item->count;
            }

            return [
                'quality_care' => [],
                'regimen' => $regimen,
                'count' => $count
            ];
        });
    }

    public static function pedregimenGraph($data): array
    {
        $cacheKey = 'ped_regimen_graph_' . md5(json_encode($data));

        return Cache::remember($cacheKey, self::CACHE_TTL, function() use ($data) {
            $regimenData = QualPerformance::select("regimen", DB::raw("COUNT(regimen) as count"))
                ->where('artstatus', '=', 'Active')
                ->whereBetween('age', [0, 14])
                ->state($data->states)
                ->lga($data->lgas)
                ->facilities($data->facilities)
                ->groupBy('regimen')
                ->orderBy('count', 'desc')
                ->withoutGlobalScopes()
                ->get();

            $regimen = [];
            $count = [];

            foreach ($regimenData as $index => $item) {
                $regimen[$index] = $item->regimen;
                $count[$index] = $item->count;
            }

            return [
                'quality_care' => [],
                'regimen' => $regimen,
                'count' => $count
            ];
        });
    }

    public static function tx_age_sex($data): array
    {
        $cacheKey = 'tx_age_sex_' . md5(json_encode($data));

        return Cache::remember($cacheKey, self::CACHE_TTL, function() use ($data) {
            $statsql = "
                CASE
                    WHEN age < 1 THEN '<1'
                    WHEN age BETWEEN 1 AND 4 THEN '1-4'
                    WHEN age BETWEEN 5 AND 9 THEN '5-9'
                    WHEN age BETWEEN 10 AND 14 THEN '10-14'
                    WHEN age BETWEEN 15 AND 19 THEN '15-19'
                    WHEN age BETWEEN 20 AND 24 THEN '20-24'
                    WHEN age BETWEEN 25 AND 29 THEN '25-29'
                    WHEN age BETWEEN 30 AND 34 THEN '30-34'
                    WHEN age BETWEEN 35 AND 39 THEN '35-39'
                    WHEN age BETWEEN 40 AND 44 THEN '40-44'
                    WHEN age BETWEEN 45 AND 49 THEN '45-49'
                    WHEN age >= 50 THEN '50+'
                END AS age_range,
                CAST(SUM(CASE WHEN sex = 'M' THEN -1 ELSE 0 END) as signed) AS male_count,
                CAST(SUM(CASE WHEN sex = 'F' THEN 1 ELSE 0 END) as unsigned) AS female_count
            ";

            $txAgeSex = TreatmentPerformance::select(DB::raw($statsql))
                ->state($data->states)
                ->lga($data->lgas)
                ->facilities($data->facilities)
                ->where('CurrentARTStatus_Pharmacy', '=', 'Active')
                ->groupBy('age_range')
                ->orderByRaw("FIELD(age_range, '<1','1-4','5-9','10-14','15-19','20-24','25-29','30-34','35-39','40-44','45-49','50+')")
                ->withoutGlobalScopes()
                ->get();

            $male_count = [];
            $female_count = [];

            foreach ($txAgeSex as $index => $item) {
                $male_count[$index] = $item->male_count;
                $female_count[$index] = $item->female_count;
            }

            return [
                'treatment_perfomance' => [],
                'male_data' => $male_count,
                'female_data' => $female_count
            ];
        });
    }

    public static function appPerformanceLgaGraph($tableName): array
    {
        $cacheKey = 'app_performance_lga_graph_' . $tableName;

        return Cache::remember($cacheKey, self::CACHE_TTL, function() use ($tableName) {
            // Get all the data we need in fewer queries
            $states = DB::table($tableName)
                ->select('state')
                ->distinct()
                ->get();

            $lgas = DB::table($tableName)
                ->select('state', 'lga', 'lgaCode', DB::raw('COUNT(pepid) as patients'))
                ->groupBy('state', 'lga', 'lgaCode')
                ->get()
                ->groupBy('state');

            $facilities = DB::table($tableName)
                ->select('state', 'lga', 'lgaCode', 'facility_name', DB::raw('COUNT(pepid) as patients'))
                ->groupBy('state', 'lga', 'lgaCode', 'facility_name')
                ->get()
                ->groupBy('lgaCode');

            // Format for state drilldown
            $stateListBar = [];
            $lgaMapping = [];

            foreach ($states as $index => $state) {
                $stateName = $state->state;
                $stateListBar[$index] = [
                    'name' => $stateName,
                    'id' => $stateName,
                    'data' => []
                ];

                if (isset($lgas[$stateName])) {
                    foreach ($lgas[$stateName] as $lga) {
                        $stateListBar[$index]['data'][] = [
                            'name' => $lga->lga,
                            'y' => $lga->patients,
                            'drilldown' => $lga->lga
                        ];

                        $lgaMapping[$lga->lga] = $lga->lgaCode;
                    }
                }
            }

            // Format for LGA drilldown
            $lgaListBar = [];

            foreach ($lgaMapping as $lgaName => $lgaCode) {
                $lgaData = [
                    'name' => $lgaName,
                    'id' => $lgaName,
                    'data' => []
                ];

                if (isset($facilities[$lgaCode])) {
                    foreach ($facilities[$lgaCode] as $facility) {
                        $lgaData['data'][] = [
                            $facility->facility_name,
                            $facility->patients
                        ];
                    }
                }

                $lgaListBar[] = $lgaData;
            }

            return array_merge($stateListBar, $lgaListBar);
        });
    }
}
