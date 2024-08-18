<?php

namespace App\Services;

use App\Utils\HttpUtil;

class OpenWeatherApiService
{
    private $http;
    public function __construct()
    {
        $this->http = new HttpUtil([
            'base_uri' => env('OPENWEATHER_API', 'http://api.openweathermap.org/data/2.5/'),
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'timeout' => 10
        ]);
    }

    public function getWeather(mixed $geoLocation): mixed
    {
        $request = $this->http->get('forecast', [
            'lat' => $geoLocation->latitude,
            'lon' => $geoLocation->longitude,
            'appid' => env('OPENWEATHER_API_KEY'),
            'units' => 'metric',
        ]);

        $body = $request->getBody();
        $response = json_decode($body->getContents());

        return [
            'city' => $response->city,
            'weather_list' => $response->list,
        ];
    }
}
