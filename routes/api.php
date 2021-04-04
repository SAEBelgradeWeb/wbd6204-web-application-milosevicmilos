<?php

use App\Http\Controllers\ApplianceController;
use App\Http\Controllers\BuildingController;
use App\Http\Controllers\BuildingFloorController;
use App\Http\Controllers\BuildingFloorRoomController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;

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
});

// TODO: Move to a separate controller
Route::domain(Config::get('app.api_url'))->post('/sanctum/token', function (Request $request) {
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
        'device_name' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $user = User::where('email', $request->email)->first();

    if (! $user || ! Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => ['The provided credentials are incorrect.'],
        ], 400);
    }

    return response()->json([
        'token' => $user->createToken($request->device_name)->plainTextToken
    ]);
});

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
