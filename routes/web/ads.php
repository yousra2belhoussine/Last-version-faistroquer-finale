<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// Routes publiques des annonces
Route::get('/ads', [AdController::class, 'index'])->name('ads.index');
Route::get('/ads/search', [AdController::class, 'search'])->name('ads.search');
Route::get('/ads/{ad}', [AdController::class, 'show'])->name('ads.show');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/ads/category/{category:slug}', [AdController::class, 'byCategory'])->name('ads.by.category');

// Routes protégées des annonces
Route::middleware(['auth'])->group(function () {
    // Gestion des annonces
    Route::get('/my-ads', [AdController::class, 'myAds'])->name('ads.my-ads');
    Route::get('/ads/create', [AdController::class, 'create'])->name('ads.create');
    Route::post('/ads', [AdController::class, 'store'])->name('ads.store');
    Route::get('/ads/{ad}/edit', [AdController::class, 'edit'])->name('ads.edit');
    Route::put('/ads/{ad}', [AdController::class, 'update'])->name('ads.update');
    Route::delete('/ads/{ad}', [AdController::class, 'destroy'])->name('ads.destroy');
    Route::patch('/ads/{ad}/toggle-status', [AdController::class, 'toggleStatus'])->name('ads.toggle-status');
    Route::post('/ads/{ad}/rate', [AdController::class, 'rate'])->name('ads.rate');
    
    // Création d'annonce en plusieurs étapes
    Route::get('/ads/create/step1', [AdController::class, 'createStep1'])->name('ads.create.step1');
    Route::post('/ads/create/step1', [AdController::class, 'storeStep1'])->name('ads.create.step1.store');
    Route::get('/ads/create/step2', [AdController::class, 'createStep2'])->name('ads.create.step2');
    Route::post('/ads/create/step2', [AdController::class, 'storeStep2'])->name('ads.create.step2.store');
    Route::get('/ads/create/step3', [AdController::class, 'createStep3'])->name('ads.create.step3');
    Route::post('/ads/create/step3', [AdController::class, 'storeStep3'])->name('ads.create.step3.store');
    Route::get('/ads/create/step4', [AdController::class, 'createStep4'])->name('ads.create.step4');
    Route::post('/ads/create/step4', [AdController::class, 'storeStep4'])->name('ads.create.step4.store');
}); 