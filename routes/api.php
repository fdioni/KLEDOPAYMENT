<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentsController;
use App\Events\StatusDeleted;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get',[PaymentsController::class, 'index']);
Route::post('/post',[PaymentsController::class, 'store']);
Route::post('/delete',[PaymentsController::class, 'delete']);
/* Route::get('/test', function () {
    event(new StatusDeleted('1'));
    return "Event has been sent!";
}); */