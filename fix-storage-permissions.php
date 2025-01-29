<?php

$basePath = __DIR__;
$storagePath = $basePath . '/storage';
$publicStoragePath = $basePath . '/public/storage';
$adsPath = $basePath . '/storage/app/public/ads';

// Vérifier et créer les dossiers nécessaires
$paths = [
    $storagePath,
    $storagePath . '/app',
    $storagePath . '/app/public',
    $adsPath,
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

echo "Terminé !\n"; 