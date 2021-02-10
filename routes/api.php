<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\genealogyController;
use App\Http\Controllers\trialController;
use App\Http\Controllers\MpesaController;

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

Route::post('/testing_api', [genealogyController::class, 'index']);
Route::get('/test', [trialController::class, 'index']);
Route::post('/access_token', [MpesaController::class, 'generateAccessToken']);
Route::post('/stk_push', [MpesaController::class,'customerMpesaSTKPush']);
Route::post('/validation', [MpesaController::class,'mpesaValidation']);
Route::post('/transaction_confirmation', [MpesaController::class,'mpesaConfirmation']);
Route::post('/register_urls', [MpesaController::class,'mpesaRegisterUrls']);
