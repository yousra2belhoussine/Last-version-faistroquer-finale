<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdController as AdminAdController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\PropositionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessageController;

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

// Routes publiques
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication routes
require __DIR__.'/auth.php';

// Routes d'administration
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des utilisateurs
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    
    // Gestion des articles
    Route::get('/articles', [AdminArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/{article}', [AdminArticleController::class, 'show'])->name('articles.show');
    Route::patch('/articles/{article}/approve', [AdminArticleController::class, 'approve'])->name('articles.approve');
    Route::patch('/articles/{article}/reject', [AdminArticleController::class, 'reject'])->name('articles.reject');
    
    // Gestion des annonces
    Route::get('/ads', [AdminAdController::class, 'index'])->name('ads.index');
    Route::get('/ads/{ad}', [AdminAdController::class, 'show'])->name('ads.show');
    Route::get('/ads/{ad}/edit', [AdminAdController::class, 'edit'])->name('ads.edit');
    Route::put('/ads/{ad}', [AdminAdController::class, 'update'])->name('ads.update');
    Route::delete('/ads/{ad}', [AdminAdController::class, 'destroy'])->name('ads.destroy');
    Route::delete('/ads/images/{image}', [AdminAdController::class, 'deleteImage'])->name('ads.images.destroy');
});

// Routes pour les articles
Route::middleware(['auth'])->group(function () {
    Route::get('/mes-articles', [ArticleController::class, 'myArticles'])->name('articles.my');
    Route::resource('articles', ArticleController::class);
});

// API routes for user search
Route::middleware('auth')->group(function () {
    Route::get('/api/users/search', [UserController::class, 'search']);
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

// Messages routes
Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{conversation}/fetch', [MessageController::class, 'fetchMessages'])->name('messages.fetch');
});