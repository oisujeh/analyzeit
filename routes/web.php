<?php

use App\Http\Livewire\Pages;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::get('/performance', [App\Http\Controllers\HomeController::class, 'performance'])->name('performance');

Route::get('monitoring/treatment_dashboard', [App\Http\Controllers\MonitoringController::class,'treatmentDashboard'])->name('treatment');

Route::get('monitoring/appointment_dashboard', [App\Http\Controllers\MonitoringController::class,'appointmentDashboard'])->name('appointment');

Route::get('/reports/vl/vl_cascade', [App\Http\Controllers\ReportController::class,'vlcascade'])->name('vlcascade');

Route::get('monitoring/pbs', [App\Http\Controllers\MonitoringController::class,'pbs'])->name('pbs');

Route::get('monitoring/quality_of_care', [App\Http\Controllers\MonitoringController::class,'regimenDashboard'])->name('regimen');


