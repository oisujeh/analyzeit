<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Helpers\Scripts as Helper;
use Illuminate\Support\Facades\View;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/treatment-filter', function(Request $request){
    error_log(print_r($request->all(), true));
    if($request->selectIndicator == 'pvls'){
        return Helper::vLGraph($request,$request->selectIndicator);
    }else if($request->selectIndicator == 'tx_curr') {
        return Helper::treamentPerformance($request,$request->selectIndicator);
    }else if($request->selectIndicator == 'tx_new') {
        return Helper::treamentPerformance($request,$request->selectIndicator);
    }
})->name('treatment.filter');


Route::get('/get-wiget/{id}', function($page){
    return View::make('monitoring.reports.'.$page);
});
