<?php

use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/weather/{city}', [WeatherController::class, 'getWeatherFromApi']);
Route::post('/weather', [WeatherController::class, 'saveWeather']);
Route::get('/weather-load/{city}', [WeatherController::class, 'loadWeather']);

