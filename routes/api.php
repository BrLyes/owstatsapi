<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

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

//TODO: rename routes and replace - with .
Route::get('/chars', [GameController::class, 'getChars']);

Route::middleware("auth:sanctum")->group(function () {
    Route::get("/tracker", function () {
        return Storage::disk("s3")->temporaryUrl(
            "tracker.zip",
            now()->addMinutes(5),
        );
    });
    Route::post("/games", [GameController::class, "store"])->name("api.game.store");
    Route::post('/stat-all', [GameController::class, 'statsForChar'])->name("api.stat.all");
    Route::post('/stat-ovt', [GameController::class, 'StatOverTime'])->name("api.stat.ovt");
    Route::post('/stat-avg', [GameController::class, 'StatAverage'])->name("api.stat.avg");
    Route::post('/stat-sum', [GameController::class, 'StatSum'])->name("api.stat.sum");
    Route::get('/games-by-char', [GameController::class, 'GamesByChar'])->name("api.games.by.char");
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
