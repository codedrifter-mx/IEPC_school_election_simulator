<?php

use App\Http\Controllers\ElectorController;
use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

// public
Route::view('/', 'welcome')->name('welcome');
Route::view('/elector', 'electors.elector.Elector')->name('elector');
Route::get('/votacion/{key?}', [VoteController::class, 'view'])->name('votacion');
Route::get('/superior/votacion/{key}', [VoteController::class, 'view'])->name('superior.votacion');

// auth
Route::view('/panel', 'auth.panel')->name('panel');
Route::view('/events', 'auth.event.Event')->middleware(['auth'])->name('events');
Route::view('/candidates', 'auth.candidate.Candidate')->middleware(['auth'])->name('candidates');
Route::get('/elector/register', [ElectorController::class, 'view'])->middleware(['auth'])->name('register_electors');


// iepc
Route::view('/admin/register', 'auth_iepc.register')->name('admin_register');
Route::view('/admin/login', 'auth_iepc.login')->name('admin_login');
Route::view('/admin/panel', 'auth_iepc.panel')->name('admin_panel');


// QR event code
Route::get('/qrcode/{key}', function ($key) {
    $image = QrCode::size(1024)->generate(request()->getHttpHost().'/votacion/' . $key);

    return response($image)->header('Content-type','image/svg+xml');
})->name('qr');

// Candidate stored image
Route::get('/candidate/image/{candidate_key}', function ($candidate_key) {
    if (!Storage::disk('public')->exists('candidates/' . $candidate_key . '.jpg')) {
        return response()->file(public_path('img/default.png'));
    }

    $file = File::get(storage_path('app/public/candidates/' . $candidate_key . '.jpg'));
    $response = Response::make($file, 200);
    $response->header("Content-Type", 'image/jpeg');

    return $response;
})->name('candidate.image');

// Get event stored file
Route::get('/pdf/ficha/{candidate_key}', function ($event_key) {
    if (!Storage::disk('public')->exists('pdf/ficha/' . $event_key . '.pdf')) {
        return response()->json(['message' => 'No existe el archivo'], 404);
    }

    $file = File::get(storage_path('app/public/pdf/ficha/' . $event_key . '.pdf'));
    $response = Response::make($file, 200);
    $response->header("Content-Type", 'application/pdf');

    return $response;
})->name('event.ficha');

// Get event stored file in s3
Route::get('/s3/pdf/ficha/{candidate_key}', function ($event_key) {
    $file = Storage::disk('s3')->get('pdf/ficha/' . $event_key . '.pdf');

    return response($file, 200)->header('Content-Type', 'application/pdf');
})->name('s3.event.ficha');

require __DIR__.'/auth.php';
