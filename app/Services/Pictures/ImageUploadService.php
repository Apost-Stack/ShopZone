<?php

namespace App\Services\Pictures;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    /**
     * Sauvegarde une image dans un dossier défini par l'utilisateur + date/heure
     *
     * @param UploadedFile $image
     * @param string $baseFolder  // nom du dossier fourni par l'utilisateur
     * @return string chemin du fichier sauvegardé
     */
    public function saveImage(UploadedFile $image, string $baseFolder = 'exemple')
    {
        $folder = $baseFolder . '/' . now()->format('Y-m-d/H-i-s');

        $fileName = uniqid() . '.' . $image->getClientOriginalExtension();

        $path = $image->storeAs("public/$folder", $fileName);

        return Storage::url($path);
    }
}
