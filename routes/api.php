<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Helpers\APIResponse;
use App\Http\Controllers\VersionObjectController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'object'], function () {
    Route::post('/', [VersionObjectController::class, 'store']);
    Route::get('/get_all_records', [VersionObjectController::class, 'index']);
    Route::get('/{key}', [VersionObjectController::class, 'show']);
    
});

Route::any('{catchall}', function (Request $request) {
    return APIResponse::abort404();
})->where('catchall', '.*');