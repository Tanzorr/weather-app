<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $table = 'weathers';
    protected $fillable = ['city_name', 'min_tmp', 'max_tmp', 'wind_speed', 'created_at'];
}
