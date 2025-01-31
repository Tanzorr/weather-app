<?php

namespace App\Services;

use App\Models\Weather;
use Illuminate\Http\JsonResponse;

class WeatherService
{
    private string $forecastApiBaseUrl = 'http://api.openweathermap.org/data/2.5/forecast';
    private string $idKey = 'e4b8b08c185638b825af37facfe1fabb';
    public function loadWeatherFromApi(string $city): mixed
    {
        $response = file_get_contents(
            "$this->forecastApiBaseUrl?q={$city}&units=metric&appid={$this->idKey}"
        );
        return $response !== false ? json_decode($response, true) : null;
    }

    public function loadWeatherFromDB($city): array
    {
        $cityData = Weather::where('city_name', $city)->first();

        if (!$cityData) {
            return ['list' => []];
        }
        return [
            'city' => [
                'name' => $cityData->city_name,
                'updated_at' => $cityData->updated_at
            ],
            'list' => [
                [
                    'dt_txt' => $cityData->timestamp_dt,
                    'main' => [
                        'temp_max' => $cityData->max_tmp,
                        'temp_min' => $cityData->min_tmp
                    ],
                    'wind' => ['speed' => $cityData->wind_speed]
                ]
            ]
        ];
    }
}
