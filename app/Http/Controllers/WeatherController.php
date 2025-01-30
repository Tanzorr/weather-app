<?php

namespace App\Http\Controllers;

use App\Actions\StoreUpdateWeatherAction;
use App\Http\Requests\StoreWeatherRequest;
use App\Models\Weather;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller
{
    public function getWeatherFromApi(string $city): JsonResponse
    {
        try {
            $response = file_get_contents(
                "http://api.openweathermap.org/data/2.5/forecast?q={$city}&units=metric&appid=e4b8b08c185638b825af37facfe1fabb"
            );
            $result = $response !== false ? json_decode($response, true) : null;
            return response()
                ->json($result ?? ['message' => 'City not found'], $result ? 200 : 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while fetching the weather data'], 500);
        }
    }

    public function saveWeather(StoreWeatherRequest $request, StoreUpdateWeatherAction $action): JsonResponse
    {
        return response()->json([
            'message' => $action->handle($request->validated())->wasRecentlyCreated
                ? 'Weather created'
                : 'Weather updated'
        ]);
    }


    public function loadWeather(string $city): JsonResponse
    {
        $cityData = Weather::where('city_name', $city)->first();

        if (!$cityData) {
            return response()->json(['message' => 'City not found'], 404);
        }

        $result = [
            'city' => [
                'name' => $cityData->city_name,
                'updated_at' => $cityData->updated_at
            ],
            'list' => [
                [
                    'dt_txt' => $cityData->created_at,
                    'main' => [
                        'temp_max' => $cityData->max_tmp,
                        'temp_min' => $cityData->min_tmp
                    ],
                    'wind' => ['speed' => $cityData->wind_speed]
                ]
            ]
        ];

        return response()->json($result, 200);
    }
}
