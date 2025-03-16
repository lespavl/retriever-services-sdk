<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use RelationDesk\RetrieverServicesSdk\DTO\LanguageDetectionDTO;

class LanguageDetectionDTOTest extends TestCase
{
    public function testGetDataById()
    {
        $data = [
            'languages' => [['en', 'fr'], ['es']],
            'text_id' => ['123', '456']
        ];

        $dto = new LanguageDetectionDTO($data);
        $result = $dto->getDataById();

        $expected = [
            '123' => ['en', 'fr'],
            '456' => ['es']
        ];

        $this->assertEquals($expected, $result);
    }

    public function testGetDataByIdWithMissingLanguages()
    {
        $data = [
            'languages' => [['en', 'fr']],
            'text_id' => ['123', '456']
        ];

        $dto = new LanguageDetectionDTO($data);
        $result = $dto->getDataById();

        $expected = [
            '123' => ['en', 'fr'],
            '456' => []
        ];

        $this->assertEquals($expected, $result);
    }

    public function testGetDataByIdWithEmptyData()
    {
        $data = [
            'languages' => [],
            'text_id' => []
        ];

        $dto = new LanguageDetectionDTO($data);
        $result = $dto->getDataById();

        $expected = [];

        $this->assertEquals($expected, $result);
    }
}