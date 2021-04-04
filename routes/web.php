<?php

use App\Http\Controllers\ApplicationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::domain(Config::get('app.url'))->get('/', function () {
    return view('pages.home', [
        'user' => Auth::user()
    ]);
})->name('home');

Route::domain(Config::get('app.url'))->get('/auth/login', function () {
    return view('pages.login');
})->name('auth.login');

Route::domain(Config::get('app.dashboard_url'))
    ->get('/{any}', [ApplicationController::class, 'index'])
    ->where('any', '.*')
    ->name('dashboard');

//require __DIR__.'/auth.php';
