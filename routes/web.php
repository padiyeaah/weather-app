
<?php

use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/weather/{city}', function ($city) {
    $apiKey = env('OPENWEATHER_API_KEY'); // Pastikan API key ada di .env
    $url = "https://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric&lang=id";

    $response = Http::get($url);

    return $response->json();
});

Route::get('/weather', function (Request $request) {
    $lat = $request->query('lat');
    $lon = $request->query('lon');

    if (!$lat || !$lon) {
        return response()->json(['error' => 'Latitude dan Longitude diperlukan'], 400);
    }

    $apiKey = env('OPENWEATHER_API_KEY'); // Pastikan API key ada di .env
    $url = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&appid={$apiKey}&units=metric&lang=id";

    $response = Http::get($url);

    return $response->json();
});

