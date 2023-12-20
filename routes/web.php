<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::view('/', 'call');


Route::post('/call', [ App\Http\Controllers\IvrController::class, 'initiateCall' ])->name('initiate_call');
// Route::post('/call_Fun', [ App\Http\Controllers\ProcessIVRDigitsController::class, 'callFun' ])->name('call_Fun');
Route::post('/resopnce_gather/{id}', [ App\Http\Controllers\GatherController::class, 'callFun' ])->name('resopnce_gather');

Route::post('/call_drop/{id}', [ App\Http\Controllers\GatherController::class, 'callDropGet' ])->name('call_drops');
