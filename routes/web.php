<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\ImageRecognitionController;


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

Route::get('/', function () {
    return view('auth.register');
});

Route::post('send', [ChatBotController::class, 'sendChat'])
->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/botman', function(){
    app('botman')->listen();
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/recognize-image', [ImageRecognitionController::class, 'recognizeImage']);

Route::get('/recognize-image', function () {
    return view('recognize-image');
})->name('recognize-image-form');

Route::post('/recognize-image', [ImageRecognitionController::class, 'recognizeImage'])
    ->name('recognize-image');


require __DIR__.'/auth.php';
