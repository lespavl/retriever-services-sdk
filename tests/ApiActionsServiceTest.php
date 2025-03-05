<?php

namespace Tests;

use Illuminate\Support\Facades\Http;
use RelationDesk\RetrieverServicesSdk\Services\ApiActionsService;
use RelationDesk\RetrieverServicesSdk\Services\ApiRequestServiceWithToken;
use RelationDesk\RetrieverServicesSdk\DTO\LanguageDetectionDTO;
use RelationDesk\RetrieverServicesSdk\DTO\SentimentAnalysisDTO;

class ApiActionsServiceTest extends TestCase
{
    protected $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(ApiActionsService::class);
    }

    public function testAnalyzeSentiment()
    {
        $response = [
            "text_id" => ["234234"],
            "score" => [0.7956580519676208],
            "label" => ["neutral"]
        ];

        Http::fake([
            'https://example.com/api/ret-sentiment-proxy/analyse' => Http::response($response, 200)
        ]);

        $result = $this->service->analyzeSentiment('no', [
            [
                "text_id" => "234234",
                "text" => "123 🦊"
            ]
        ]);

        $this->assertInstanceOf(SentimentAnalysisDTO::class, $result);
        $this->assertEquals($response['text_id'], $result->text_id);
        $this->assertEquals($response['score'], $result->score);
        $this->assertEquals($response['label'], $result->label);
    }

    public function testDetectLanguage()
    {
        $response = [
            "languages" => [["no"]],
            "text_id" => ["23423"]
        ];

        Http::fake([
            'https://example.com/api/language/fasttext' => Http::response($response, 200)
        ]);


        $result = $this->service->detectLanguage([
            "23423" => "123 🦊"
        ]);

        $this->assertInstanceOf(LanguageDetectionDTO::class, $result);
        $this->assertEquals($response['languages'], $result->languages);
        $this->assertEquals($response['text_id'], $result->text_id);
    }
}