<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StatController;

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

Route::get('/chars', [StatController::class, 'getChars']);
Route::middleware("QueryParamToRequestInput")->get('/stats/{name?}', [StatController::class, 'statsForChar'])->name("api-stat-name");
Route::post('/stat-ovt', [StatController::class, 'StatOverTime'])->name("api-stat-ovt");
Route::post('/stat-avg', [StatController::class, 'StatAverage'])->name("api-stat-avg");
Route::post('/stat-sum', [StatController::class, 'StatSum'])->name("api-stat-sum");
