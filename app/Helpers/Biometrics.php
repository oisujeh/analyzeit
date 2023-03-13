<?php

namespace App\Helpers;

use App\Models\TreatmentPerformance;
use Illuminate\Support\Facades\DB;

class Biometrics
{
    public static function biometrics($data): array
    {
        $lgaCurrData = self::lGACurr($data);
        $lgaBioData = self::lGABiometrics($data);
        $lgaCov = self::lGACov($data);

        $facCurrData = self::facCurr($data);
        $facBioData = self::facBio($data);
        $facCov= self::facCov($data);

        $mergedData = [];
        $mergedData2 = [];

        foreach ($lgaCurrData as $index => $lgaData) {
            $mergedData[] = $lgaData;
            $mergedData[] = $lgaBioData[$index];
            $mergedData[] = $lgaCov[$index];
        }

        foreach ($facCurrData as $index => $lgaData2) {
            $mergedData2[] = $lgaData2;
            $mergedData2[] = $facBioData[$index];
            $mergedData2[] = $facCov[$index];
        }




        return [
            'Results' => [
                'coveragedata' => [
                    'iPCovSeries' =>[
                        self::ipCurr($data),
                        self::ipBiometrics($data),
                        self::ipCov($data)

                    ],'stateCovSeries' =>[
                        self::stateCurr($data),
                        self::stateBiometrics($data),
                        self::stateCov($data)

                    ],
                    'lGACovSeries' => $mergedData,
                    'facilityCovSeries' => $mergedData2
                ]
            ]
        ];
    }


    public static function ipCurr($data)
    {
        $list =  TreatmentPerformance::select(DB::raw("
            '#246D38' as `color`,
            true as `drilldown`,
            ip AS `name`,
            CAST(COALESCE(SUM(`CurrentARTStatus` = 'Active'),0)  AS UNSIGNED) AS `y`
        "))
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('name')
            ->withoutGlobalScopes()
            ->get();

        return [
            'color' => '#246D38',
            'data' => $list,
            'name' => 'TX_CURR',
            'yAxis' => 0
        ];
    }

    public static function ipBiometrics($data)
    {
        $list =  TreatmentPerformance::select(DB::raw("
            '#6CB0A8' as `color`,
            true as `drilldown`,
            ip AS `name`,
            CAST(COALESCE(SUM(`PBS` = 'Yes'),0)  AS UNSIGNED) AS `y`
        "))
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->where('CurrentARTStatus','=','Active')
            ->groupBy('name')
            ->withoutGlobalScopes()
            ->get();

        return [
            'color' => '#6CB0A8',
            'data' => $list,
            'name' => 'Patients with Fingerprints',
            'yAxis' => 0
        ];
    }

    public static function ipCov($data)
    {
        $list =  TreatmentPerformance::select(DB::raw("
            '#ffb95e' as `color`,
            false as `drilldown`,
            ip AS `name`,
            cast(ROUND(COALESCE(SUM(`PBS` = 'Yes'), 0) / COALESCE(SUM(`CurrentARTStatus` = 'Active'), 0) * 100, 0) as unsigned) AS `y`
        "))
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->where('CurrentARTStatus','=','Active')
            ->groupBy('name')
            ->withoutGlobalScopes()
            ->get();

        return [
            'color' => '#ffb95e',
            'data' => $list,
            'name' => '% Fingerprints Coverage',
            'type'=>'scatter',
            'yAxis' => 1
        ];
    }


    public static function stateCurr($data)
    {
        $list =  TreatmentPerformance::select(DB::raw("
            '#246D38' as `color`,
            true as `drilldown`,
            stateCode AS `id`,
            ip AS `ip`,
            state as `name`,
            CAST(COALESCE(SUM(`CurrentARTStatus` = 'Active'),0)  AS UNSIGNED) AS `y`
        "))
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('name')
            ->groupBy('ip')
            ->withoutGlobalScopes()
            ->get();

        return [
            'data'=>[
                'color' => '#246D38',
                'data' => $list,
                'name' => 'TX_CURR',
                'type'=> null,
                'yAxis' => 0
            ],
            'name'=>'APIN'

        ];
    }

    public static function stateBiometrics($data): array
    {
        $list =  TreatmentPerformance::select(DB::raw("
            '#6CB0A8' as `color`,
            true as `drilldown`,
            stateCode AS id,
            ip AS `ip`,
            state as `name`,
            CAST(COALESCE(SUM(`PBS` = 'Yes'),0)  AS UNSIGNED) AS `y`
        "))
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->where('CurrentARTStatus','=','Active')
            ->groupBy('name')
            ->groupBy('ip')
            ->withoutGlobalScopes()
            ->get();

        return [
            'data'=>[
                'color' => '#6CB0A8',
                'data' => $list,
                'name' => 'Patients with Fingerprints',
                'type'=> null,
                'yAxis' => 0
            ],
            'name'=>'APIN'

        ];

    }

    public static function stateCov($data): array
    {
        $list =  TreatmentPerformance::select(DB::raw("
            '#ffb95e' as `color`,
            false as `drilldown`,
            stateCode AS `id`,
            ip AS `ip`,
            state as `name`,
            cast(ROUND(COALESCE(SUM(`PBS` = 'Yes'), 0) / COALESCE(SUM(`CurrentARTStatus` = 'Active'), 0) * 100, 0) as unsigned) AS `y`
        "))
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->where('CurrentARTStatus','=','Active')
            ->groupBy('name')
            ->groupBy('ip')
            ->withoutGlobalScopes()
            ->get();

        return [
            'data'=>[
                'color' => '#ffb95e',
                'data' => $list,
                'name' => '% Fingerprints Coverage',
                'type'=> 'scatter',
                'yAxis' => 1
            ],
            'name'=>'APIN'

        ];
    }


    public static function lGACurr($data): array
    {
        $stateListBar = [];
        $stateList = TreatmentPerformance::select(DB::raw("state AS `name`"))
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('stateCode')
            ->withoutGlobalScopes()
            ->get();

        foreach ($stateList as $index1 => $states) {
            $stateListBar[$index1]['name'] = $states->name;

            $lgaList = TreatmentPerformance::select(DB::raw(
                "
            stateCode as `StateCode`,
            lga as `name`,
            lgaCode as `id`,
            true as 'drilldown',
            CAST(COALESCE(SUM(`CurrentARTStatus` = 'Active'),0)  AS UNSIGNED) AS `y`"
            ))
                ->lga($data->lgas)
                ->facilities($data->facilities)
                ->where(['state' => $states->name])
                ->groupBy('lga')
                ->groupBy('lgaCode')
                ->get();

            $drillDownLga = [];
            foreach ($lgaList as $index2 => $lgas) {
                $lgaArray = [];
                $lgaArray['name'] = $lgas->name;
                $lgaArray['StateCode'] = (string) $lgas->StateCode;
                $lgaArray['color'] = "#246D38";
                $lgaArray['id'] = (string) $lgas->id;
                $lgaArray['drilldown'] = $lgas->drilldown;
                $lgaArray['y'] = $lgas->y;
                $drillDownLga[] = $lgaArray;

            }
            $stateListBar[$index1]["data"] = $drillDownLga;

            $graphData[] = [
                'data' => [
                        'name' => 'TX_CURR',
                        'type' => null,
                        'yAxis' => 0,
                        'color' => '#246D38',
                        'data' => $drillDownLga,
                ],
                'name' => $states->name
            ];
        }

        return $graphData;
    }


    public static function lGABiometrics($data): array
    {
        $stateListBar = [];
        $stateList = TreatmentPerformance::select(DB::raw("state AS `name`"))
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('stateCode')
            ->withoutGlobalScopes()
            ->get();

        foreach ($stateList  as  $index1  => $states) {
            $stateListBar[$index1]['name'] = $states->name;

            $lgaList =  TreatmentPerformance::select(DB::raw(
                "
            stateCode as `StateCode`,
            lga as `name`,
            lgaCode as `id`,
            true as 'drilldown',
            CAST(COALESCE(SUM(`PBS` = 'Yes'),0)  AS UNSIGNED) AS `y`"
            ))->lga($data->lgas)->facilities($data->facilities)
                ->where(['state' => $states->name])
                ->where('CurrentARTStatus','=','Active')
                ->groupBy('lga')
                ->groupBy('lgaCode')
                ->get();

            $drillDownLga = [];
            foreach ($lgaList as $index2 => $lgas) {
                $lgaArray['name'] = $lgas->name;
                $lgaArray['StateCode'] = (string)$lgas->StateCode;
                $lgaArray['color'] = "#6CB0A8";
                $lgaArray['id'] = (string)$lgas->id;
                $lgaArray['drilldown'] = $lgas->drilldown;
                $lgaArray['y'] = $lgas->y;
                $drillDownLga[$index2] = $lgaArray;

            }
            $stateListBar[$index1]["data"] = $drillDownLga;

            $graphData[] = [
                'data' => [
                        'name' => 'Patients with Fingerprints',
                        'type' => null,
                        'yAxis' => 0,
                        'color' => '#6CB0A8',
                        'data' => $drillDownLga,
                ],
                'name' => $states->name
            ];
        }

        return $graphData;
    }

    public static function lGACov($data): array
    {
        $stateListBar = [];
        $stateList = TreatmentPerformance::select(DB::raw("state AS `name`"))
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('stateCode')
            ->withoutGlobalScopes()
            ->get();

        foreach ($stateList  as  $index1  => $states) {
            $stateListBar[$index1]['name'] = $states->name;

            $lgaList =  TreatmentPerformance::select(DB::raw(
                "
            stateCode as `StateCode`,
            lga as `name`,
            lgaCode as `id`,
            false as 'drilldown',
            cast(ROUND(COALESCE(SUM(`PBS` = 'Yes'), 0) / COALESCE(SUM(`CurrentARTStatus` = 'Active'), 0) * 100, 0) as unsigned) AS `y`"
            ))->lga($data->lgas)->facilities($data->facilities)
                ->where(['state' => $states->name])
                ->where('CurrentARTStatus','=','Active')
                ->groupBy('lga')
                ->groupBy('lgaCode')
                ->get();

            $drillDownLga = [];
            foreach ($lgaList as $index2 => $lgas) {
                $lgaArray['name'] = $lgas->name;
                $lgaArray['StateCode'] = (string)$lgas->StateCode;
                $lgaArray['color'] = "#ffb95e";
                $lgaArray['id'] = (string)$lgas->id;
                $lgaArray['drilldown'] = $lgas->drilldown;
                $lgaArray['y'] = $lgas->y;
                $drillDownLga[$index2] = $lgaArray;

            }
            $stateListBar[$index1]["data"] = $drillDownLga;

            $graphData[] = [
                'data' => [
                    'name' => '% Fingerprints Coverage',
                    'type' => 'scatter',
                    'yAxis' => 1,
                    'color' => '#ffb95e',
                    'data' => $drillDownLga,
                ],
                'name' => $states->name
            ];
        }

        return $graphData;
    }

    public static function facCurr($data): array
    {
        $graphData = [];
        $lgaList = [];

        $query = TreatmentPerformance::select(DB::raw("
        lgaCode as `LgaCode`,
        lga as `lga`,
        facility_name as `name`,
        datim_code as `id`,
        false as 'drilldown',
        '#246D38' as `color`,
        CAST(COALESCE(SUM(`CurrentARTStatus` = 'Active'),0)  AS UNSIGNED) AS `y`
    "))
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('LgaCode')
            ->groupBy('facility_name')
            ->get();

        foreach ($query as $item) {
            if (!isset($lgaList[$item->LgaCode])) {
                $lgaList[$item->LgaCode] = [
                    'name' => $item->lga,
                    'data' => []
                ];
            }
            $lgaList[$item->LgaCode]['data'][] = [
                'name' => $item->name,
                'LgaCode' => (string) $item->LgaCode,
                'color' => $item->color,
                'id' => $item->id,
                'drilldown' => $item->drilldown,
                'y' => $item->y
            ];
        }

        foreach ($lgaList as $lgaCode => $lgaData) {
            $graphData[] = [
                'data' => [
                    'name' => 'TX_CURR',
                    'type' => null,
                    'yAxis' => 0,
                    'color' => '#246D38',
                    'data' => $lgaData['data'],
                ],
                'name' => $lgaData['name']
            ];
        }

        return $graphData;
    }


    public static function facBio($data): array
    {
        $graphData = [];
        $lgaList = [];

        $query = TreatmentPerformance::select(DB::raw("
        lgaCode as `LgaCode`,
        lga as `lga`,
        facility_name as `name`,
        datim_code as `id`,
        false as 'drilldown',
        '#6CB0A8' as `color`,
        CAST(COALESCE(SUM(`PBS` = 'Yes'),0)  AS UNSIGNED) AS `y`
    "))
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->where('CurrentARTStatus','=','Active')
            ->groupBy('LgaCode')
            ->groupBy('facility_name')
            ->get();

        foreach ($query as $item) {
            if (!isset($lgaList[$item->LgaCode])) {
                $lgaList[$item->LgaCode] = [
                    'name' => $item->lga,
                    'data' => []
                ];
            }
            $lgaList[$item->LgaCode]['data'][] = [
                'name' => $item->name,
                'LgaCode' => (string) $item->LgaCode,
                'color' => $item->color,
                'id' => $item->id,
                'drilldown' => $item->drilldown,
                'y' => $item->y
            ];
        }

        foreach ($lgaList as $lgaCode => $lgaData) {
            $graphData[] = [
                'data' => [
                    'name' => 'Patients with Fingerprints',
                    'type' => null,
                    'yAxis' => 0,
                    'color' => '#6CB0A8',
                    'data' => $lgaData['data'],
                ],
                'name' => $lgaData['name']
            ];
        }

        return $graphData;
    }

    public static function facCov($data): array
    {
        $graphData = [];
        $lgaList = [];

        $query = TreatmentPerformance::select(DB::raw("
        lgaCode as `LgaCode`,
        lga as `lga`,
        facility_name as `name`,
        datim_code as `id`,
        false as 'drilldown',
        '#ffb95e' as `color`,
        cast(ROUND(COALESCE(SUM(`PBS` = 'Yes'), 0) / COALESCE(SUM(`CurrentARTStatus` = 'Active'), 0) * 100, 0) as unsigned) AS `y`
    "))
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->where('CurrentARTStatus','=','Active')
            ->groupBy('LgaCode')
            ->groupBy('facility_name')
            ->get();

        foreach ($query as $item) {
            if (!isset($lgaList[$item->LgaCode])) {
                $lgaList[$item->LgaCode] = [
                    'name' => $item->lga,
                    'data' => []
                ];
            }
            $lgaList[$item->LgaCode]['data'][] = [
                'name' => $item->name,
                'LgaCode' => (string) $item->LgaCode,
                'color' => $item->color,
                'id' => $item->id,
                'drilldown' => $item->drilldown,
                'y' => $item->y
            ];
        }

        foreach ($lgaList as $lgaCode => $lgaData) {
            $graphData[] = [
                'data' => [
                    'name' => '% Fingerprints Coverage',
                    'type' => 'scatter',
                    'yAxis' => 1,
                    'color' => '#ffb95e',
                    'data' => $lgaData['data'],
                ],
                'name' => $lgaData['name']
            ];
        }

        return $graphData;
    }









}
