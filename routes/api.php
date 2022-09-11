<?php

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ElectorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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


// Make candidate API routes for index, store, show, edit, update, destroy
Route::get('candidate_index', [CandidateController::class, 'index'])->name('candidate_index');
Route::post('candidate_store', [CandidateController::class, 'store'])->name('candidate_store');
Route::get('candidate_show', [CandidateController::class, 'show'])->name('candidate_show');
Route::post('candidate_update', [CandidateController::class, 'update'])->name('candidate_update');
Route::post('candidate_destroy', [CandidateController::class, 'destroy'])->name('candidate_destroy');

// Make event API routes for index, store, show, edit, update, destroy
Route::get('event_index', [EventController::class, 'index'])->name('event_index');
Route::post('event_store', [EventController::class, 'store'])->name('event_store');
Route::get('event_show', [EventController::class, 'show'])->name('event_show');
Route::post('event_update', [EventController::class, 'update'])->name('event_update');
Route::post('event_destroy', [EventController::class, 'destroy'])->name('event_destroy');

// Make elector API routes for index, store, show, edit, update, destroy
Route::get('elector_index', [ElectorController::class, 'index'])->name('elector_index');
Route::post('elector_store', [ElectorController::class, 'store'])->name('elector_store');
Route::get('elector_show', [ElectorController::class, 'show'])->name('elector_show');
Route::post('elector_edit', [ElectorController::class, 'edit'])->name('elector_edit');
Route::post('elector_destroy', [ElectorController::class, 'destroy'])->name('elector_destroy');

// Make vote API routes for index, store, show, edit, update, destroy
Route::get('vote_index', [VoteController::class, 'index'])->name('vote_index');
Route::post('vote_store', [VoteController::class, 'store'])->name('vote_store');
Route::get('vote_show', [VoteController::class, 'show'])->name('vote_show');
Route::post('vote_edit', [VoteController::class, 'edit'])->name('vote_edit');
Route::post('vote_destroy', [VoteController::class, 'destroy'])->name('vote_destroy');




