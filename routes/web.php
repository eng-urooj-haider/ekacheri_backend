<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EkachehriController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserController;
use App\Models\Ekachehri;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('welcome');
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});
Route::resource('cities', CityController::class);
Route::resource('locations', LocationController::class);
Route::resource('dfps', UserController::class);
Route::resource('departments', DepartmentController::class);
Route::get('latest_kacheries', [EkachehriController::class, 'latestId']);
Route::resource('kachehries', EkachehriController::class);
Route::resource('complaints', ComplaintController::class);
Route::get('all_complaints/{id}', [ComplaintController::class, 'allComplaint']);
Route::get('/generate-kacheri-uuids', function () {

    $kacheries = Ekachehri::whereNull('uuid')->get();
    foreach ($kacheries as $kacheri) {
        $kacheri->uuid = Str::uuid();
        $kacheri->save();
    }
    return 'UUIDs generated successfully.';
});
Route::get('complaints/fetchuuid/{uuid}', [ComplaintController::class, 'finduuid']);
// routes/api.php
Route::prefix('dashboard')->group(function () {
    Route::get('/kachehri-stats', [DashboardController::class, 'dashboardStats']);
    Route::get('/kachehri-monthly', [DashboardController::class, 'kachehriMonthly']);
    Route::get('/complaint-monthly', [DashboardController::class, 'complaintMonthly']);
    Route::get('/complaint-status', [DashboardController::class, 'complaintStatus']);
    Route::get('/total-city', [DashboardController::class, 'totalCity']);
    Route::get('/total-dfp', [DashboardController::class, 'totalDfp']);
});
    Route::get('/announcements/active', [DashboardController::class, 'activeAnnouncement']);
    Route::get('/get-user', [DashboardController::class, 'getUser']);
