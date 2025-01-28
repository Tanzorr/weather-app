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
        return response()
            ->json(json_decode(file_get_contents(
                "http://api.openweathermap.org/data/2.5/weather?q={$city}&units=metric&appid=e4b8b08c185638b825af37facfe1fabb"
                )
        ));
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
        return response()->json($cityData ?? ['message' => 'City not found'], $cityData ? 200 : 404);
    }
}
