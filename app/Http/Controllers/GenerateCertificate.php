<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\CourseCertificate;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // or Imagick if you prefer

class GenerateCertificate extends Controller
{
    public static function generate($userName, $subscriptionId, $courseId)
    {
        \Log::info("Starting certificate generation for {$userName}, subscription {$subscriptionId}, course {$courseId}");

        // 1. Fetch the template from the external URL
        $templateUrl = 'https://node14827-technospeakdata.jnb1.cloudlet.cloud/storage/certificates/tscertificate-68a3cf8a1d06b.png';
        $templateContent = file_get_contents($templateUrl);

        if (!$templateContent) {
            \Log::error("Failed to fetch certificate template from {$templateUrl}");
            return null;
        }

        // 2. Create manager (using GD driver here)
        $manager = new ImageManager(new Driver());

        // 3. Load image
        $img = $manager->read($templateContent);

        // 4. Add the user's name
        $img->text($userName, 600, 400, function ($font) {
            $font->filename(public_path('fonts/arial.ttf')); // make sure the font exists
            $font->size(48);
            $font->color('#000000');
            $font->align('center');
            $font->valign('middle');
        });

        // 5. Save it locally with the user's name in filename
        $fileName = 'certificate_' . preg_replace('/\s+/', '_', $userName) . '_' . $subscriptionId . '.png';
        $path = 'certificates/generated/' . $fileName;

        Storage::disk('public')->put($path, (string) $img->encode());

        $url = Storage::url($path);

        \Log::info("Certificate successfully generated: {$url}");

        return $url;
    }
}
