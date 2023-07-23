<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class ImageRecognitionController extends Controller
{
    public function recognizeImage(Request $request)
    {
        $imageUrl = $request->input('image_url');

        // Check if the image URL is empty or not provided
        if (empty($imageUrl)) {
            return response()->json(['error' => 'Please provide a valid image URL.'], 400);
        }

        $apiKey = env('IMAGGA_API_KEY');
        $apiSecret = env('IMAGGA_API_SECRET');
        $authorization = base64_encode("$apiKey:$apiSecret");
        
        $response = Http::withHeaders([
            'Authorization' => "Basic $authorization",
        ])->get("https://api.imagga.com/v2/tags?image_url=" . urlencode($imageUrl));
        
        // Check the response status code before decoding the response body
        if ($response->status() === 200) {
            $data = $response->json();
            return response()->json($data);
        } else {
            return response()->json(['error' => 'Failed to process the image.'], 500);
        }
    }
}
