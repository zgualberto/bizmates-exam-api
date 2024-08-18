<?php

namespace App\Services;

use App\Utils\HttpUtil;

class FourSquareLocationApiService
{
    private $http;
    public function __construct()
    {
        $this->http = new HttpUtil([
            'base_uri' => env('FOURSQUARE_API', 'https://api.foursquare.com/v3/'),
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => env('FOURSQUARE_API_KEY'),
            ],
            'timeout' => 10
        ]);
    }

    public function searchLocation(string $location): mixed
    {
        $request = $this->http->get('places/search', [
            'near' => $location
        ]);

        $body = $request->getBody();
        $response = json_decode($body->getContents());

        return $response->context->geo_bounds->circle->center;
    }
}
