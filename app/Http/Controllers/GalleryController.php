<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GalleryController extends Controller
{
    public function gallery()
    {
        $apiKey = env('AIRTABLE_KEY_DEV');
        $baseId = env('AIRTABLE_BASE_ID');
        $tableIDgalleries = env('AIRTABLE_TABLE_ID_GALLERIES');

        // Fetch Gallery Start
        $responseGalleries = Http::withHeaders(['Authorization' => 'Bearer '.$apiKey])
            ->get('https://api.airtable.com/v0/'.$baseId.'/'.$tableIDgalleries);
        $galleries = json_decode($responseGalleries, true)['records'];

        // return response($galleries);
        // Fetch Gallery End

        // Restructure gallery start
        foreach ($galleries as $gallery) {
            // Transform images start
            $transImages = [];
            foreach ($gallery['fields']['images'] as $img) {
                $transImages[] = [
                    'id' => $img['id'],
                    'url' => $img['url'],
                ];
            }
            $simpleImages = $transImages;
            // Transform images end
            $transGallery = [
                'id' => $gallery['id'],
                'name' => Str::ucfirst($gallery['fields']['name']),
                'thumbnail' => $gallery['fields']['thumbnail'][0]['url'],
                'images' => $simpleImages,
            ];
            $simpleGallery[] = $transGallery;
        }
        $galleries = $simpleGallery;

        // return response($galleries);

        return view('gallery', compact('galleries'));
    }
}
