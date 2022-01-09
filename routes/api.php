<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\AdminPanel\AdminsController;
use App\Http\Controllers\API\AdminPanel\CustomersController;
use App\Http\Controllers\API\AdminPanel\MainController;

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


/////////////////////////////// Start Auth //////////////////////////////////
Route::post('user/register', [ AuthController::class,'register']);
Route::post('user/login', [ AuthController::class,'login']);
Route::post('user/email-verification', [ AuthController::class,'verifyEmail']);
Route::post('user/resend-code', [ AuthController::class,'resendCode']);
//////////////////////////////// End Auth //////////////////////////////////


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('customer')->middleware('auth:api')->group(function () {
    Route::post('logout', [ AuthController::class,'logout']);

});

Route::prefix('admin')->middleware(['auth:api', 'admin', 'permission.handler'])->group(function () {

    Route::apiResource('admins', AdminsController::class );
    Route::apiResource('customers', CustomersController::class );

    Route::get('permissions', [ MainController::class, 'getPermissions']);

});

