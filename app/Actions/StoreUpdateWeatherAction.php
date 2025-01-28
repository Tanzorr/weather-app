<?php

namespace App\Actions;

use App\Models\Weather;

class StoreUpdateWeatherAction
{
    public function handle(array $data): Weather
    {
        return Weather::updateOrCreate(
            ['city_name' => $data['city_name']],
            $data
        );
    }
}
