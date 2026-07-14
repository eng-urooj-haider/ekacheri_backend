<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EkachehriController;
use App\Http\Controllers\KacheriController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::middleware('auth')->get('/user', function (Request $request) {
    return response()->json($request->user());
});
Route::resource('cities',CityController::class);
Route::resource('locations',LocationController::class);
Route::resource('dfps',UserController::class);
Route::resource('departments',DepartmentController::class);
Route::get('latest_kacheries',[EkachehriController::class , 'getLatestId']);


