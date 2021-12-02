<?php

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Public Routes
//Register
Route::post('register', [AuthController::class, 'register']);
//Login
Route::post('login', [AuthController::class, 'login']);

//Protected Routes
Route::group(['middleware' => ['auth:sanctum']], function () {

    //User profile
    Route::get('user-profile', [AuthController::class, 'userProfile']);
    //Logout
    Route::post('logout', [AuthController::class, 'logout']);
});
