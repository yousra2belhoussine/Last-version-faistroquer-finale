<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\CredibilityController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Profile related features
    Route::get('/profile/badges', [BadgeController::class, 'index'])->name('profile.badges');
    Route::get('/profile/credibility', [CredibilityController::class, 'show'])->name('profile.credibility');
    Route::get('/profile/credibility/improve', [CredibilityController::class, 'improve'])->name('profile.credibility.improve');
    Route::get('/profile/transactions', [TransactionController::class, 'index'])->name('profile.transactions');
    Route::get('/profile/reviews', [ReviewController::class, 'index'])->name('profile.reviews');
}); 