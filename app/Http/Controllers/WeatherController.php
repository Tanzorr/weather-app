<?php

namespace App\Http\Controllers;

use App\Models\Weather;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WeatherController extends Controller
{
    public function getWeatherFromApi(string $city)
    {
        $apiKey = 'e4b8b08c185638b825af37facfe1fabb';

        $url = "http://api.openweathermap.org/data/2.5/weather?q={$city}&units=metric&appid={$apiKey}";

        $response = file_get_contents($url);
         return response()->json(json_decode($response));

    }

    public function saveWeather(Request $request): JsonResponse
    {
        $cityName = $request->city_name;
        $request->validate([
            'city_name' => 'required|string',
            'min_tmp' => 'required|numeric',
            'max_tmp' => 'required|numeric',
            'wind_spd' => 'required|numeric',
        ]);

        if(Weather::where('city_name', $cityName)->exists()){
            Weather::updated([
                'min_tmp' => $request->min_tmp,
                'max_tmp' => $request->max_tmp,
                'wind_spd' => $request->wind_spd,
            ]);
            return response()->json(['message' => 'Weather updated']);
        }else{
            Weather::create($request->all());
            return response()->json(['message' => 'Weather created']);
        }
    }


    public function loadWeather()
    {
        return response()->json(Weather::all());
    }
}
