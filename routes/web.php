<?php

use App\Http\Controllers\AdController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropositionController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CredibilityController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Authentication routes
require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Badges routes
    Route::get('/profile/badges', [BadgeController::class, 'index'])->name('profile.badges');
    
    // Credibility routes
    Route::get('/profile/credibility', [CredibilityController::class, 'show'])->name('profile.credibility');
    Route::get('/profile/credibility/improve', [CredibilityController::class, 'improve'])->name('profile.credibility.improve');
    
    // Transactions & Reviews routes
    Route::get('/profile/transactions', [TransactionController::class, 'index'])->name('profile.transactions');
    Route::get('/profile/reviews', [ReviewController::class, 'index'])->name('profile.reviews');
    
    // Reports routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    
    // Notifications routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::patch('/notifications/settings', [NotificationController::class, 'updateSettings'])->name('notifications.settings');
    Route::post('/notifications/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-as-read');
    
    // Messages routes
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/conversation/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::get('/messages/direct/{user}', [MessageController::class, 'showDirect'])->name('messages.show.direct');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::post('/messages/direct', [MessageController::class, 'storeDirect'])->name('messages.store.direct');
    
    // Propositions routes
    Route::get('/propositions', [PropositionController::class, 'index'])->name('propositions.index');
    Route::post('/propositions/{ad}', [PropositionController::class, 'store'])->name('propositions.store');
    Route::get('/propositions/{proposition}', [PropositionController::class, 'show'])->name('propositions.show');
    Route::patch('/propositions/{proposition}/accept', [PropositionController::class, 'accept'])->name('propositions.accept');
    Route::patch('/propositions/{proposition}/reject', [PropositionController::class, 'reject'])->name('propositions.reject');
    Route::patch('/propositions/{proposition}/cancel', [PropositionController::class, 'cancel'])->name('propositions.cancel');
    Route::patch('/propositions/{proposition}/complete', [PropositionController::class, 'complete'])->name('propositions.complete');
    Route::patch('/propositions/{proposition}/fail', [PropositionController::class, 'fail'])->name('propositions.fail');
    Route::patch('/propositions/{proposition}/update-meeting', [PropositionController::class, 'updateMeeting'])->name('propositions.update-meeting');
});

// Ad routes
Route::get('/ads', [AdController::class, 'index'])->name('ads.index');
Route::get('/ads/search', [AdController::class, 'search'])->name('ads.search');
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/ads/category/{category:slug}', [AdController::class, 'byCategory'])->name('ads.by.category');
Route::get('/ads/create', [AdController::class, 'create'])->name('ads.create')->middleware('auth');
Route::post('/ads', [AdController::class, 'store'])->name('ads.store')->middleware('auth');
Route::get('/ads/{ad}', [AdController::class, 'show'])->name('ads.show');
Route::get('/my-ads', [AdController::class, 'myAds'])->name('ads.my-ads')->middleware('auth');
Route::patch('/ads/{ad}/toggle-status', [AdController::class, 'toggleStatus'])->name('ads.toggle-status')->middleware('auth');
Route::get('/ads/{ad}/edit', [AdController::class, 'edit'])->name('ads.edit')->middleware('auth');
Route::put('/ads/{ad}', [AdController::class, 'update'])->name('ads.update')->middleware('auth');
Route::delete('/ads/{ad}', [AdController::class, 'destroy'])->name('ads.destroy')->middleware('auth');
Route::post('/ads/{ad}/rate', [AdController::class, 'rate']);

// Pages statiques
Route::get('/how-it-works', [HomeController::class, 'howItWorks'])->name('how-it-works');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/help', [HomeController::class, 'help'])->name('help');

Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

Route::middleware('auth')->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{article}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{article}', [ArticleController::class, 'update'])->name('articles.update');
    Route::delete('/articles/{article}', [ArticleController::class, 'destroy'])->name('articles.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/badges', [ProfileController::class, 'badges'])->name('profile.badges');
});

// Routes d'administration
Route::prefix('admin')->name('admin.')->group(function () {
    // Routes publiques d'administration
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [App\Http\Controllers\Admin\AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [App\Http\Controllers\Admin\AuthController::class, 'login']);
    });

    // Routes protégées d'administration
    Route::middleware('auth:admin')->group(function () {
        Route::post('logout', [App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('logout');
        Route::get('dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // Gestion des utilisateurs
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        
        // Gestion des annonces
        Route::resource('ads', App\Http\Controllers\Admin\AdController::class);
        
        // Gestion des échanges
        Route::resource('exchanges', App\Http\Controllers\Admin\ExchangeController::class);
        
        // Gestion des litiges
        Route::get('situations', [App\Http\Controllers\Admin\SituationController::class, 'index'])->name('situations.index');
        
        // Gestion des sponsors
        Route::resource('sponsors', App\Http\Controllers\Admin\SponsorController::class);
        
        // Gestion des concours
        Route::resource('contests', App\Http\Controllers\Admin\ContestController::class);
    });
}); 



// :::::::::::::::::::::::::::::::
// use App\Http\Controllers\Auth\PasswordResetLinkController;

// Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
// Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');


// ::::::::::::::::::::::::::::::::

Route::post('ad/validate/{ad}', 'Admin\AdController@validateAd')->name('ad.validate');