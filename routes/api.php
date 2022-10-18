<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchController;

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


Route::get('/chars', [MatchController::class, 'getChars']);

Route::middleware("auth:sanctum")->group(function(){
    Route::post('/stat', [MatchController::class, 'statsForChar'])->name("api-stat-ovt");
    Route::post('/stat-ovt', [MatchController::class, 'StatOverTime'])->name("api-stat-ovt");
    Route::post('/stat-avg', [MatchController::class, 'StatAverage'])->name("api-stat-avg");
    Route::post('/stat-sum', [MatchController::class, 'StatSum'])->name("api-stat-sum");
});

require __DIR__ . '/json-api-auth.php';

/*
|--------------------------------------------------------------------------
| An example of how to use the verified email feature with api endpoints
|--------------------------------------------------------------------------
|
| Here examples of a route using Sanctum middleware and verified middleware.
| And another route using Passport middleware and verified middleware.
| You can install and use one of this official packages.
|
*/

//Route::get('/verified-middleware-example', function () {
//    return response()->json([
//        'message' => 'the email account is already confirmed now you are able to see this message...',
//    ]);
//})->middleware('auth:sanctum', 'verified');

//Route::get('/verified-middleware-example', function () {
//    return response()->json([
//        'message' => 'the email account is already confirmed now you are able to see this message...',
//    ]);
//})->middleware('auth:api', 'verified');
