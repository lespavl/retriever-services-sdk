<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use RelationDesk\RetrieverServicesSdk\DTO\SentimentAnalysisDTO;

class SentimentAnalysisDTOTest extends TestCase
{
    public function testGetDataById()
    {
        $data = [
            'text_id' => ['id1', 'id2'],
            'score' => [0.9, 0.1],
            'label' => ['positive', 'negative']
        ];

        $dto = new SentimentAnalysisDTO($data);
        $result = $dto->getDataById();

        $expected = [
            'id1' => ['score' => 0.9, 'label' => 'positive'],
            'id2' => ['score' => 0.1, 'label' => 'negative']
        ];

        $this->assertEquals($expected, $result);
    }

    public function testGetDataByIdWithMissingScores()
    {
        $data = [
            'text_id' => ['id1', 'id2'],
            'score' => [0.9],
            'label' => ['positive', 'negative']
        ];

        $dto = new SentimentAnalysisDTO($data);
        $result = $dto->getDataById();

        $expected = [
            'id1' => ['score' => 0.9, 'label' => 'positive'],
            'id2' => ['score' => null, 'label' => 'negative']
        ];

        $this->assertEquals($expected, $result);
    }

    public function testGetDataByIdWithMissingLabels()
    {
        $data = [
            'text_id' => ['id1', 'id2'],
            'score' => [0.9, 0.1],
            'label' => ['positive']
        ];

        $dto = new SentimentAnalysisDTO($data);
        $result = $dto->getDataById();

        $expected = [
            'id1' => ['score' => 0.9, 'label' => 'positive'],
            'id2' => ['score' => 0.1, 'label' => null]
        ];

        $this->assertEquals($expected, $result);
    }
}