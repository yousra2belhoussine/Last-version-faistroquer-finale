<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class ImageService
{
    /**
     * Traite et enregistre une image de profil
     *
     * @param UploadedFile $file
     * @return string|null
     */
    public function handleProfilePhoto(UploadedFile $file): ?string
    {
        try {
            // Génère un nom unique pour l'image
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            
            // Crée une instance de l'image
            $image = Image::make($file);
            
            // Redimensionne l'image tout en conservant le ratio
            $image->resize(800, 800, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            
            // Optimise la qualité de l'image
            $image->encode($file->getClientOriginalExtension(), 80);
            
            // Enregistre l'image dans le stockage
            $path = 'profile-photos/' . $fileName;
            Storage::disk('public')->put($path, $image->stream());
            
            // Crée une version miniature
            $thumbnail = Image::make($file);
            $thumbnail->fit(150, 150);
            $thumbnail->encode($file->getClientOriginalExtension(), 60);
            
            $thumbnailPath = 'profile-photos/thumbnails/' . $fileName;
            Storage::disk('public')->put($thumbnailPath, $thumbnail->stream());
            
            return $path;
        } catch (\Exception $e) {
            \Log::error('Erreur lors du traitement de l\'image de profil:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return null;
        }
    }

    /**
     * Supprime les fichiers d'image associés
     *
     * @param string $path
     * @return bool
     */
    public function deleteProfilePhoto(string $path): bool
    {
        try {
            // Supprime l'image principale
            Storage::disk('public')->delete($path);
            
            // Supprime la miniature
            $thumbnailPath = str_replace('profile-photos/', 'profile-photos/thumbnails/', $path);
            Storage::disk('public')->delete($thumbnailPath);
            
            return true;
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la suppression de l\'image de profil:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return false;
        }
    }
} 