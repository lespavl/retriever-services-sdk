<?php

namespace Tests;

use Illuminate\Support\Facades\Http;
use RelationDesk\RetrieverServicesSdk\Services\AccessTokenService;
use RelationDesk\RetrieverServicesSdk\Exceptions\ApiException;

class AccessTokenServiceTest extends TestCase
{

    public function testFetchAccessTokenSuccess()
    {
        // Mock the HTTP response
        Http::fake([
            'https://example.com/token' => Http::response(['access_token' => 'test_token'])
        ]);

        $service = new AccessTokenService();
        $token = $service->fetchAccessToken();

        $this->assertEquals('test_token', $token);
    }

    public function testFetchAccessTokenFailure()
    {
        // Mock the HTTP response
        Http::fake([
            'https://example.com/token' => Http::response([], 500)
        ]);

        $this->expectException(ApiException::class);

        $service = new AccessTokenService();
        $token = $service->fetchAccessToken();
    }

    public function testFetchAccessTokenWrongStructure()
    {
        // Mock the HTTP response
        Http::fake([
            'https://example.com/token' => Http::response(['1111' => '222'])
        ]);

        $this->expectException(\InvalidArgumentException::class);

        $service = new AccessTokenService();
        $token = $service->fetchAccessToken();
    }
}