<?php

use App\Http\Controllers\ApplianceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\SanctumController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\BuildingFloorController;
use App\Http\Controllers\BuildingFloorRoomController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
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

Route::domain(Config::get('app.api_url'))->middleware('auth:sanctum')->group(function () {
    Route::resource('users', UserController::class)->except('put', 'create', 'edit');
    Route::resource('buildings', BuildingController::class)->except('put', 'create', 'edit');
    Route::resource('buildings.floors', BuildingFloorController::class)->except('put', 'create', 'edit');
    Route::resource('buildings.floors.rooms', BuildingFloorRoomController::class)->except('put', 'create', 'edit');
    Route::resource('appliances', ApplianceController::class)->except('put', 'create', 'edit');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

Route::domain(Config::get('app.api_url'))->post('/sanctum/token', [SanctumController::class, 'token']);

// TODO: Clean this up
if (app()->environment('local')) {
    Route::domain(Config::get('app.api_url'))->get('/test', function (Request $request) {

        //    $service = new \App\Services\ApplianceFilterService();
        //
        //    $appliances = $service->filterAppliances(new User(), [
        //        'building_id' => 2
        //    ]);
        //
        //
        //    dd($appliances->toArray());
    });
}
