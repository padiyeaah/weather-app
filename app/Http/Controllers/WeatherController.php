<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    public function getWeather($city)
    {
        $apiKey = env('OPENWEATHER_API_KEY');
        $response = Http::timeout(10)->get("https://api.openweathermap.org/data/2.5/weather", [
            'q' => $city,
            'appid' => $apiKey,
            'units' => 'metric'
        ]);
    
        if ($response->failed()) {
            return response()->json(['error' => 'Kota tidak ditemukan atau terjadi kesalahan pada API.'], 404);
        }
    
        return $response->json();
    }
    

    

}

