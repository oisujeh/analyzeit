<?php

namespace App\Helpers;

use App\Models\VLDashboard;
use Illuminate\Support\Facades\DB;

class test
{

    public static function ipSupVL($data): array
    {
        $list =  VLDashboard::select(DB::raw("
            '#246D38' as `color`,
            true as `drilldown`,
            ip AS `name`,
            CAST(COALESCE(SUM(`no_vl_result`),0) AS SIGNED) AS `y`
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
            'name' => 'VL Coverage',
            'yAxis' => 0
        ];
    }

    public static function ipUnVLC($data): array
    {
        $list =  VLDashboard::select(DB::raw("
            '#6CB0A8' as `color`,
            true as `drilldown`,
            ip AS `name`,
            CAST(COALESCE(SUM(`gap`),0)  AS UNSIGNED) AS `y`
        "))
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('name')
            ->withoutGlobalScopes()
            ->get();

        return [
            'color' => '#6CB0A8',
            'data' => $list,
            'name' => 'VL Coverage Gap',
            'yAxis' => 0
        ];
    }

    public static function ipsupCov($data): array
    {
        $list =  VLDashboard::select(DB::raw("
            '#ffb95e' as `color`,
            false as `drilldown`,
            ip AS `name`,
            cast(ROUND(COALESCE(SUM(`no_vl_result`), 0) / COALESCE(SUM(`eligible`), 0) * 100, 0) as unsigned) AS `y`
        "))
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('name')
            ->withoutGlobalScopes()
            ->get();

        return [
            'color' => '#ffb95e',
            'data' => $list,
            'name' => 'VL Coverage Rate',
            'type'=>'scatter',
            'yAxis' => 1
        ];
    }

    public static function stateSupVL($data)
    {
        $list =  VLDashboard::select(DB::raw("
            '#246D38' as `color`,
            true as `drilldown`,
            stateCode AS `id`,
            ip AS `ip`,
            state as `name`,
            CAST(COALESCE(SUM(`no_vl_result`),0) AS SIGNED) AS `y`
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
                'name' => 'VL Coverage',
                'type'=> null,
                'yAxis' => 0
            ],
            'name'=>'APIN'
        ];
    }

    public static function stateUnVLC($data): array
    {
        $list =  VLDashboard::select(DB::raw("
            '#6CB0A8' as `color`,
            true as `drilldown`,
            stateCode AS id,
            ip AS `ip`,
            state as `name`,
            CAST(COALESCE(SUM(`gap`),0)  AS UNSIGNED) AS `y`
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
                'color' => '#6CB0A8',
                'data' => $list,
                'name' => 'VL Coverage Gap',
                'type'=> null,
                'yAxis' => 0
            ],
            'name'=>'APIN'
        ];

    }

    public static function statesupCov($data): array
    {
        $list =  VLDashboard::select(DB::raw("
            '#ffb95e' as `color`,
            false as `drilldown`,
            stateCode AS `id`,
            ip AS `ip`,
            state as `name`,
            cast(ROUND(COALESCE(SUM(`no_vl_result`), 0) / COALESCE(SUM(`eligible`), 0) * 100, 0) as unsigned) AS `y`
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
                'color' => '#ffb95e',
                'data' => $list,
                'name' => 'VL Coverage Rate',
                'type'=> 'scatter',
                'yAxis' => 1
            ],
            'name'=>'APIN'
        ];
    }

    public static function lGASupVL($data): array
    {
        $stateListBar = [];
        $stateList = VLDashboard::select(DB::raw("state AS `name`"))
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('stateCode')
            ->withoutGlobalScopes()
            ->get();

        foreach ($stateList as $index1 => $states) {
            $stateListBar[$index1]['name'] = $states->name;

            $lgaList = VLDashboard::select(DB::raw(
                "
            stateCode as `StateCode`,
            lga as `name`,
            lgaCode as `id`,
            true as 'drilldown',
            CAST(COALESCE(SUM(`no_vl_result`),0) AS SIGNED) AS `y`"
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
                    'name' => 'VL Coverage',
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

    public static function lGAUnSup($data): array
    {
        $stateListBar = [];
        $stateList = VLDashboard::select(DB::raw("state AS `name`"))
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('stateCode')
            ->withoutGlobalScopes()
            ->get();

        foreach ($stateList  as  $index1  => $states) {
            $stateListBar[$index1]['name'] = $states->name;

            $lgaList =  VLDashboard::select(DB::raw(
                "
            stateCode as `StateCode`,
            lga as `name`,
            lgaCode as `id`,
            true as 'drilldown',
            CAST(COALESCE(SUM(`gap`),0)  AS UNSIGNED) AS `y`"
            ))->lga($data->lgas)->facilities($data->facilities)
                ->where(['state' => $states->name])
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
                    'name' => 'VL Coverage Gap',
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

    public static function lGASupCov($data): array
    {
        $stateListBar = [];
        $stateList = VLDashboard::select(DB::raw("state AS `name`"))
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->groupBy('stateCode')
            ->withoutGlobalScopes()
            ->get();

        foreach ($stateList  as  $index1  => $states) {
            $stateListBar[$index1]['name'] = $states->name;

            $lgaList =  VLDashboard::select(DB::raw(
                "
            stateCode as `StateCode`,
            lga as `name`,
            lgaCode as `id`,
            false as 'drilldown',
            cast(ROUND(COALESCE(SUM(`no_vl_result`), 0) / COALESCE(SUM(`eligible`), 0) * 100, 0) as unsigned) AS `y`"
            ))->lga($data->lgas)->facilities($data->facilities)
                ->where(['state' => $states->name])
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
                    'name' => 'VL Coverage Rate',
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

    public static function facSupVL($data): array
    {
        $graphData = [];
        $lgaList = [];

        $query = VLDashboard::select(DB::raw("
        lgaCode as `LgaCode`,
        lga as `lga`,
        facility_name as `name`,
        datim_code as `id`,
        false as 'drilldown',
        '#246D38' as `color`,
        CAST(COALESCE(SUM(`no_vl_result`),0) AS SIGNED) AS `y`
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
                    'name' => 'VL Coverage',
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

    public static function facUnSup($data): array
    {
        $graphData = [];
        $lgaList = [];

        $query = VLDashboard::select(DB::raw("
        lgaCode as `LgaCode`,
        lga as `lga`,
        facility_name as `name`,
        datim_code as `id`,
        false as 'drilldown',
        '#6CB0A8' as `color`,
        CAST(COALESCE(SUM(`gap`),0)  AS UNSIGNED) AS `y`
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
                    'name' => 'VL Coverage Gap',
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

    public static function facSupCov($data): array
    {
        $graphData = [];
        $lgaList = [];

        $query = VLDashboard::select(DB::raw("
        lgaCode as `LgaCode`,
        lga as `lga`,
        facility_name as `name`,
        datim_code as `id`,
        false as 'drilldown',
        '#ffb95e' as `color`,
        cast(ROUND(COALESCE(SUM(`no_vl_result`), 0) / COALESCE(SUM(`eligible`), 0) * 100, 0) as unsigned) AS `y`
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
                    'name' => 'VL Coverage Rate',
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
