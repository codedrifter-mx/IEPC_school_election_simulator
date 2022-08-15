<?php

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

// Make each controller API routes for index, create, store, show, edit, update, destroy
Route::resource('voters', 'VoterController');
Route::resource('candidates', 'CandidateController');
Route::resource('events', 'EventController');
Route::resource('votes', 'VoteController');

