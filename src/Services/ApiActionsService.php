<?php

namespace RelationDesk\RetrieverServicesSdk\Services;

use RelationDesk\RetrieverServicesSdk\DTO\LanguageDetectionDTO;
use RelationDesk\RetrieverServicesSdk\DTO\SentimentAnalysisDTO;

class ApiActionsService
{

    public function __construct(protected ApiRequestServiceWithToken $requestService)
    {}

    public function detectLanguage(array $texts): LanguageDetectionDTO
    {
        $response = $this->requestService->request('/language/fasttext', ['text_id' => array_keys($texts), 'text' => array_values($texts)]);
        return new LanguageDetectionDTO($response);
    }

    public function analyzeSentiment(string $lang, array $documents): SentimentAnalysisDTO
    {
        $response = $this->requestService->request('/ret-sentiment-proxy/analyse', ['lang' => $lang, 'documents' => $documents]);
        return new SentimentAnalysisDTO($response);
    }
}