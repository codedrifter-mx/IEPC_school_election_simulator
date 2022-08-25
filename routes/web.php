<?php

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

Route::view('/', 'welcome')->name('welcome');
Route::view('/elector', 'elector.Elector')->name('elector');
Route::view('/votacion', 'vote.Vote')->name('votacion');

Route::view('/dashboard', 'dashboard')->middleware(['auth'])->name('dashboard');
Route::view('/events', 'event.Event')->name('events');
Route::view('/candidates', 'candidate.Candidate')->middleware(['auth'])->name('candidates');
Route::view('/iepc', 'dashboard_global')->middleware(['auth'])->name('dashboard_iepc');

require __DIR__.'/auth.php';
