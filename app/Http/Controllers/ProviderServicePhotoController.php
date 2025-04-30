<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServicePhoto;
use Illuminate\Support\Facades\Storage;

class ProviderServicePhotoController extends Controller
{
    public function destroy(ServicePhoto $photo)
    {
        // Supprimer le fichier du stockage
        if ($photo->filename && Storage::disk('public')->exists('service-photos/' . $photo->filename)) {
            Storage::disk('public')->delete('service-photos/' . $photo->filename);
        }
        $photo->delete();
        return response()->json(['success' => true]);
    }
} 