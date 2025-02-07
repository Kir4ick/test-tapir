<?php

namespace App\Clients;

use App\Parsers\CarParser;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

readonly class CarClient
{

    public function __construct(
        private string    $newCarsLink,
        private string    $oldCarsLink,
        private CarParser $carParser,
    )
    {}

    public function getNewCars(): array|null
    {
        $response = Http::get($this->newCarsLink);

        if (!$response->successful()) {
            Log::error('Failed to get new cars from carsLink: ' . $response->body());
            return null;
        }

        return $this->carParser->parse($response->body());
    }

    public function getOldCars(): array|null
    {
        $response = Http::get($this->oldCarsLink);

        if (!$response->successful()) {
            Log::error('Failed to get old cars from carsLink: ' . $response->body());
            return null;
        }

        return $this->carParser->parse($response->body());
    }
}
