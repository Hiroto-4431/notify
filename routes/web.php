<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleCalendarController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', [GoogleCalendarController::class, 'admin'])->name('admin');
// Route::post('/register', [GoogleCalendarController::class, 'register'])->name('register');
Route::get('/getTodayEvent', [GoogleCalendarController::class, 'getTodayEvent'])->name('today');
Route::get('/getTomorrowEvent', [GoogleCalendarController::class, 'getTomorrowEvent'])->name('tomorrow');
Route::get('/getSpecificEvent', [GoogleCalendarController::class, 'getSpecificEvent'])->name('specific');


Route::get('/index', [GoogleCalendarController::class, 'index'])->name('index');
Route::get('/register', [GoogleCalendarController::class, 'register'])->name('register');
Route::post('/store', [GoogleCalendarController::class, 'store'])->name('store');