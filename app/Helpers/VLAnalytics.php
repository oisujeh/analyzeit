<?php

namespace App\Helpers;

use App\Models\VLDashboard;
use Illuminate\Support\Facades\DB;

class VLAnalytics
{
    public static function vl_analytics($data)
    {
        $statsql = "
            CAST(COALESCE(SUM(`active`),0)  AS UNSIGNED) AS `patientsOnART`,
            CAST(COALESCE(SUM(`eligible`),0)  AS UNSIGNED) AS `eligibleNo`,
            CAST(COALESCE(SUM(`no_vl_result`),0)  AS UNSIGNED) AS `vL_Coverage`,
            CAST(COALESCE(SUM(`suppressed`),0)  AS UNSIGNED) AS `suppressed`,
            CAST(COALESCE(SUM(`llv`),0)  AS UNSIGNED) AS `llv`,
            CAST(COALESCE(SUM(`undetectable`),0)  AS UNSIGNED) AS `undetectable`
	    ";
        $list = VLDashboard::select(DB::raw($statsql))
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->withoutGlobalScopes()
            ->first();

        return [
            'result' => [
                'keyMetrics_VL_Cacade' => (!empty($list)) ? (array) $list->getAttributes() : [],
                'viralLoadCoverage' => self::vlCov($data),
                'viralLoadSuppression' => self::vLsuppress($data),
            ]
        ];

    }

    public static function vLsuppress($data): array
    {
        $statsql = "
        CAST(COALESCE(SUM(`no_vl_result`),0) AS SIGNED) AS `vL_Coverage`,
        CAST(COALESCE(SUM(`suppressed`),0)  AS SIGNED) AS `suppressed`";

        $list = VLDashboard::select(DB::raw($statsql))
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->withoutGlobalScopes()
            ->first();

        if (!empty($list)) {
            $listArray = $list->toArray();
            $listArray['unSuppressed'] =  $listArray['vL_Coverage'] - $listArray['suppressed'];
            return $listArray;
        } else {
            return [];
        }
    }

    public static function vlCov($data): array
    {
        $statsql = "CAST(COALESCE(SUM(`no_vl_result`),0) AS SIGNED) AS `vL_Coverage`,
        CAST(COALESCE(SUM(`samp_collected`),0) AS SIGNED) AS `samp_collected`";

        $list = VLDashboard::select(DB::raw($statsql))
            ->state($data->states)
            ->lga($data->lgas)
            ->facilities($data->facilities)
            ->withoutGlobalScopes()
            ->first();

        if (!empty($list)) {
            $listArray = $list->toArray();
            $listArray['vL_CoverageGap'] =  $listArray['samp_collected'] - $listArray['vL_Coverage'];
            return $listArray;
        } else {
            return [];
        }
    }





}
