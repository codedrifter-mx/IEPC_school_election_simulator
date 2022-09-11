<?php

use App\Http\Controllers\VoteController;
use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
Route::view('/superior/elector', 'elector.Elector')->name('superior.elector');
Route::get('/votacion/{key?}', [VoteController::class, 'view'])->name('votacion');
Route::get('/superior/votacion/{key}', [VoteController::class, 'view'])->name('superior.votacion');

Route::view('/dashboard', 'dashboard')->middleware(['auth'])->name('dashboard');
Route::view('/events', 'event.Event')->name('events');
Route::view('/candidates', 'candidate.Candidate')->middleware(['auth'])->name('candidates');
Route::view('/iepc', 'dashboard_global')->middleware(['auth'])->name('dashboard_iepc');

// Make QR code
Route::get('/qrcode/{key}', function ($key) {
    $image = QrCode::size(1024)->generate(request()->getHttpHost().'/votacion/' . $key);

    return response($image)->header('Content-type','image/svg+xml');
})->name('qr');

require __DIR__.'/auth.php';
