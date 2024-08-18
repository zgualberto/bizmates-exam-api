<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchLocationRequest;
use App\Services\WeatherService;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller
{
    protected $weatherService;
    public function __construct()
    {
        $this->weatherService = new WeatherService();
    }

    /**
     * Show the profile for a given user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SearchLocationRequest $request): JsonResponse
    {
        return response()->json(
            $this->weatherService->getWeather(
                $request->input('location')
            ),
        );
    }
}
