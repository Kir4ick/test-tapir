<?php

namespace App\Clients;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

readonly class CRMClient
{

    public function __construct(
        private string $crmLink
    )
    {}

    public function sendQuestionnaire(string $phone, string $vinNumber): bool
    {
        $requestData = [
            'phone' => $phone,
            'VIN' => $vinNumber,
        ];

        $response = Http::post($this->crmLink, $requestData);
        if ($response->successful()) {
            return true;
        }

        Log::error('Error when send car questionnaire: ' . $response->body());
        return false;
    }
}
