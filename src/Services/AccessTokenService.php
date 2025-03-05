<?php

namespace RelationDesk\RetrieverServicesSdk\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use RelationDesk\RetrieverServicesSdk\DTO\AccessTokenDTO;
use RelationDesk\RetrieverServicesSdk\Exceptions\ApiException;

class AccessTokenService
{
    public function fetchAccessToken(): string
    {
        $response = Http::post(Config::get('retriever-services.access-token.url'), [
            'key' => Config::get('retriever-services.access-token.key'),
            'secret' => Config::get('retriever-services.access-token.secret')
        ]);

        if ($response->failed()) {
            throw new ApiException("Failed to get access token", $response->status());
        }

        $data = $response->json();
        return (new AccessTokenDTO($data))->access_token;
    }
}