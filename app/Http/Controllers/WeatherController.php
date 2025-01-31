<?php

namespace App\Http\Controllers;

use App\Actions\StoreUpdateWeatherAction;
use App\Http\Requests\StoreWeatherRequest;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller
{

    public function __construct(private readonly WeatherService $service)
    {

    }
    public function getWeatherFromApi(string $city): JsonResponse
    {
        return  response()->json( $this->service->loadWeatherFromApi($city));
    }

    public function saveWeather(StoreWeatherRequest $request, StoreUpdateWeatherAction $action): JsonResponse
    {
        return response()->json([
            'message' => $action->handle($request->validated())->wasRecentlyCreated
                ? 'Weather data created'
                : 'Weather data updated'
        ]);
    }


    public function loadWeather(string $city): JsonResponse
    {
        return response()->json($this->service->loadWeatherFromDB($city));
    }
}
