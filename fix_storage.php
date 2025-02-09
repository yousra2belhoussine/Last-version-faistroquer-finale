<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Storage;

// Configuration des chemins
$basePath = __DIR__;
$storagePath = $basePath . '/storage';
$publicStoragePath = $basePath . '/public/storage';
$adsPath = $basePath . '/storage/app/public/ads';
$profilePhotosPath = $basePath . '/storage/app/public/profile-photos';

// Vérifier et créer les dossiers nécessaires
$paths = [
    $storagePath,
    $storagePath . '/app',
    $storagePath . '/app/public',
    $adsPath,
    $profilePhotosPath,
];

foreach ($paths as $path) {
    if (!file_exists($path)) {
        echo "Création du dossier : $path\n";
        mkdir($path, 0755, true);
    }
}

// Vérifier le lien symbolique
if (!file_exists($publicStoragePath)) {
    echo "Création du lien symbolique pour le stockage public\n";
    symlink($storagePath . '/app/public', $publicStoragePath);
}

// Définir les permissions
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($storagePath, RecursiveDirectoryIterator::SKIP_DOTS),
    RecursiveIteratorIterator::SELF_FIRST
);

foreach ($iterator as $item) {
    // Définir 755 pour les dossiers et 644 pour les fichiers
    chmod($item, $item->isDir() ? 0755 : 0644);
    echo "Permissions mises à jour pour : " . $item->getPathname() . "\n";
}

// Correction des photos de profil
$users = User::whereNotNull('profile_photo_path')->get();

foreach ($users as $user) {
    $oldPath = $user->profile_photo_path;
    if (!Storage::disk('public')->exists($oldPath)) {
        continue;
    }

    $newPath = 'profile-photos/' . time() . '_' . basename($oldPath);
    
    // Copier l'ancien fichier avec le nouveau nom
    Storage::disk('public')->copy($oldPath, $newPath);
    
    // Mettre à jour le chemin dans la base de données
    $user->update(['profile_photo_path' => $newPath]);
    
    // Supprimer l'ancien fichier si différent
    if ($oldPath !== $newPath) {
        Storage::disk('public')->delete($oldPath);
    }
    
    echo "Photo de profil mise à jour pour l'utilisateur {$user->id}\n";
}

echo "Terminé !\n"; 