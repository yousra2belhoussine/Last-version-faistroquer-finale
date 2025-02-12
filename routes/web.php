<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropositionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// Authentication routes
require __DIR__.'/auth.php';

// API routes for user search
Route::middleware('auth')->group(function () {
    Route::get('/api/users/search', [\App\Http\Controllers\UserController::class, 'search']);
});

// Module routes
require __DIR__.'/web/pages.php';
require __DIR__.'/web/profile.php';
require __DIR__.'/web/ads.php';
require __DIR__.'/web/messaging.php';

// Propositions routes
Route::middleware('auth')->group(function () {
    Route::get('/propositions', [PropositionController::class, 'index'])->name('propositions.index');
    Route::get('/propositions/{proposition}', [PropositionController::class, 'show'])->name('propositions.show');
    Route::post('/propositions/{ad}', [PropositionController::class, 'store'])->name('propositions.store');
    Route::post('/propositions/{proposition}/accept', [PropositionController::class, 'accept'])->name('propositions.accept');
    Route::post('/propositions/{proposition}/reject', [PropositionController::class, 'reject'])->name('propositions.reject');
    Route::post('/propositions/{proposition}/cancel', [PropositionController::class, 'cancel'])->name('propositions.cancel');
    Route::post('/propositions/{proposition}/complete', [PropositionController::class, 'complete'])->name('propositions.complete');
    Route::post('/propositions/{proposition}/feedback', [PropositionController::class, 'feedback'])->name('propositions.feedback');
    Route::post('/propositions/{proposition}/meeting', [PropositionController::class, 'updateMeeting'])->name('propositions.update.meeting');
});