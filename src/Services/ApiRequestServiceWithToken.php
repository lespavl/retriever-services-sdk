<?php

namespace RelationDesk\RetrieverServicesSdk\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use RelationDesk\RetrieverServicesSdk\Exceptions\ApiException;

class ApiRequestServiceWithToken
{

    public function __construct(protected AccessTokenService $tokenService)
    {}

    public function request(string $endpoint, array $payload, int $attempt = 0): array
    {
        if(Config::get('retriever-services.enabled') === false) {
            return [];
        }

        $response = Http::withHeaders([
            'Authorization' => $this->getAccessToken(),
            'Content-Type' => 'application/json',
        ])->post(Config::get('retriever-services.ai.url') . $endpoint, $payload);

        if ($response->status() === 423) {
            Cache::forget('api_access_token');
        }

        if ($response->failed()) {
            throw new ApiException("API request failed", $response->status());
        }

        return $response->json();
    }

    private function getAccessToken()
    {
        return Cache::remember(
            Config::get('retriever-services.access-token.cache.key'),
            Config::get('retriever-services.access-token.cache.ttl'),
            function () {
                return $this->tokenService->fetchAccessToken();
            }
        );
    }
}