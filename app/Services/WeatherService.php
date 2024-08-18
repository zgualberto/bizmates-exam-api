<?php

namespace App\Services;

use App\Services\FourSquareLocationApiService;
use App\Services\OpenWeatherApiService;

class WeatherService
{
    private $fourSquareLocationApiService;
    private $openWeatherApiService;
    public function __construct()
    {
        $this->fourSquareLocationApiService = new FourSquareLocationApiService();
        $this->openWeatherApiService = new OpenWeatherApiService();
    }

    public function getWeather(string $location)
    {
        $geoLocation = $this->fourSquareLocationApiService->searchLocation($location);
        return $this->openWeatherApiService->getWeather($geoLocation);
    }
}
