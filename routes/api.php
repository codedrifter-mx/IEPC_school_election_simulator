<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CandidateController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\ElectorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


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
Route::get('event_showToValidate', [EventController::class, 'showToValidate'])->name('event_showToValidate');
Route::post('event_update', [EventController::class, 'update'])->name('event_update');
Route::post('event_destroy', [EventController::class, 'destroy'])->name('event_destroy');
Route::post('event_stop', [EventController::class, 'stop'])->name('event_stop');

// Make elector API routes for store
Route::post('elector_store', [ElectorController::class, 'store'])->name('elector_store');

// Make vote API routes to store
Route::post('vote_store', [VoteController::class, 'store'])->name('vote_store');

// get getFichaTecnica
Route::get('getFichaTecnica', [EventController::class, 'getFichaTecnica'])->name('getFichaTecnica');

// AdminController
// Admin send email
Route::post('get_events', [AdminController::class, 'index_events'])->name('index_events');
Route::post('send_email', [AdminController::class, 'sendEmail'])->name('send_email');

