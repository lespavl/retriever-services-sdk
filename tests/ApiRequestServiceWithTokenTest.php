<?php

namespace Tests;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use RelationDesk\RetrieverServicesSdk\Services\ApiRequestServiceWithToken;
use RelationDesk\RetrieverServicesSdk\Services\AccessTokenService;
use RelationDesk\RetrieverServicesSdk\Exceptions\ApiException;

class ApiRequestServiceWithTokenTest extends TestCase
{
    protected $accessTokenService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->accessTokenService = $this->createMock(AccessTokenService::class);
        $this->accessTokenService->method('fetchAccessToken')->willReturn('test_token');

        Config::set('retriever-services.enabled', true);
    }

    public function testRequestSuccess()
    {
        Http::fake([
            'https://example.com/api/test-endpoint' => Http::response(['data' => 'test_data'], 200)
        ]);

        $service = new ApiRequestServiceWithToken($this->accessTokenService);
        $response = $service->request('/test-endpoint', ['key' => 'value']);

        $this->assertEquals(['data' => 'test_data'], $response);
    }

    public function testRequestDisabled()
    {
        Config::set('retriever-services.enabled', false);

        $service = new ApiRequestServiceWithToken($this->accessTokenService);
        $response = $service->request('/test-endpoint', ['key' => 'value']);

        $this->assertEquals([], $response);
    }

    public function testRequestFailed()
    {
        Http::fake([
            'https://example.com/api/test-endpoint' => Http::response([], 500)
        ]);

        $this->expectException(ApiException::class);

        $service = new ApiRequestServiceWithToken($this->accessTokenService);
        $service->request('/test-endpoint', ['key' => 'value']);
    }

    public function testRequestLocked()
    {
        Http::fake([
            'https://example.com/api/test-endpoint' => Http::response([], 423)
        ]);

        Cache::shouldReceive('forget')->once()->with('api_access_token');

        $service = new ApiRequestServiceWithToken($this->accessTokenService);
        $this->expectException(ApiException::class);

        $service->request('/test-endpoint', ['key' => 'value']);
    }
}