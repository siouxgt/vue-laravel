<?php

use App\Http\Controllers\RolController;
use App\Http\Controllers\UrgController;
use App\Http\Controllers\UserController;
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


Route::get('roles',[RolController::class,'roles'])->name('roles.roles');
Route::get('urg',[UrgController::class,'apiUrg'])->name('urg.apiUrg');

Route::post('user/store',[UserController::class,'apiStore'])->name('user.store');
Route::put('user/update/{rfc}',[UserController::class,'apiUpdate'])->name('user.update');