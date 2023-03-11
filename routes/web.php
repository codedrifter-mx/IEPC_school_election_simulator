<?php

use App\Http\Controllers\ElectorController;
use App\Http\Controllers\VoteController;
use Faker\Provider\Image;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

// public
Route::view('/', 'welcome')->name('welcome');
Route::view('/rejected', 'welcome')->name('rejected');
Route::view('/votacion/registro/{event_key}', 'electors.elector.Elector')->name('elector');
Route::get('/votacion/{event_key}', [VoteController::class, 'view'])->name('votacion');



// auth
Route::view('/panel', 'auth.panel')->name('panel');
Route::view('/events', 'auth.event.Event')->middleware(['auth'])->name('events');
Route::view('/candidates', 'auth.candidate.Candidate')->middleware(['auth'])->name('candidates');
Route::get('/elector/register', [ElectorController::class, 'view'])->middleware(['auth'])->name('register_electors');


// iepc
Route::view('/admin/register', 'auth_iepc.register')->name('admin_register');
Route::view('/admin/panel', 'auth_iepc.panel')->name('admin_panel');

Route::view('/admin/active_events', 'auth_iepc.active_events')->name('admin_active_events');
Route::view('/admin/validate_events', 'auth_iepc.validate_events')->name('admin_validate_events');
Route::view('/admin/satisfaction', 'auth_iepc.satisfaction')->name('admin_satisfaction');
Route::view('/admin/reports', 'auth_iepc.reports')->name('admin_reports');

// QR event code
Route::get('/qr_register/{key}', function ($event_key) {
    $image = QrCode::size(1024)->generate(request()->getHttpHost().'/votacion/registro/' . $event_key);

    return response($image)->header('Content-type','image/svg+xml');
})->name('qr_register');

Route::get('/qr_vote/{key}', function ($event_key) {
    $image = QrCode::size(1024)->generate(request()->getHttpHost().'/votacion/' . $event_key);

    return response($image)->header('Content-type','image/svg+xml');
})->name('qr_vote');

Route::get('/candidate/image/{candidate_key}', function ($candidate_key) {
    if ($candidate_key == 'nulo') {
        $file = Storage::disk('s3')->get('nulo.png');
    } elseif (!Storage::disk('s3')->exists('candidates/' . $candidate_key . '.jpg')) {
        $file = Storage::disk('s3')->get('default.png');
    } else{
        $file = Storage::disk('s3')->get('candidates/' . $candidate_key . '.jpg');
    }


    return response($file, 200)->header('Content-Type','image/jpeg');
})->name('candidate.image');

// Candidate stored video
Route::get('/candidate/video/{candidate_key}', function ($candidate_key) {
    $url = Storage::disk('s3')->get('candidates/' . $candidate_key . '.mp4');

    return response($url, 200)->header('Content-Type','video/mp4');
})->name('candidate.video');


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
