<?php

use App\Http\Controllers\TimeTrackers\TimeTrackerPutController;
use App\Http\Controllers\TimeTrackers\TimeTrackersGetController;
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

Route::get('/', TimeTrackersGetController::class);

Route::name('time_tracker')->prefix('time-tracker')->group(function () {
    Route::name('.new_time_tracker')->prefix('{timeTrackerId}')->group(function () {
        Route::put('/', TimeTrackerPutController::class);
    });
});
