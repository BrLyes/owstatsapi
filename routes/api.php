<?php

use App\Actions\JsonApiAuth\AuthKit;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
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
