<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MessageController;

Route::middleware(['auth'])->group(function () {
    // Liste des utilisateurs actifs
    Route::get('/messages/users', [MessageController::class, 'activeUsers'])->name('messages.active_users');
    
    // Liste des conversations et création
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages/start', [MessageController::class, 'startConversation'])->name('messages.start');
    
    // Accès direct à une conversation avec un utilisateur
    Route::get('/messages/user/{user}', [MessageController::class, 'showDirectConversation'])->name('messages.show.direct');
    
    // Contact vendeur depuis une annonce
    Route::post('/messages/contact-seller/{seller}', [MessageController::class, 'contactSeller'])->name('messages.contact.seller');
    
    // Gestion des conversations existantes
    Route::get('/messages/{conversation}', [MessageController::class, 'show'])->name('messages.show');
    Route::post('/messages/{conversation}', [MessageController::class, 'store'])->name('messages.store');
}); 