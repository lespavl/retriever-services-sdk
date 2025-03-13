<?php

namespace RelationDesk\RetrieverServicesSdk\DTO;

class LanguageDetectionDTO extends BaseDTO
{
    protected array $requiredProperties = ['languages', 'text_id'];
    public array $languages;
    public array $text_id;

    public function getDataById()
    {
        $result = [];
        foreach ($this->text_id as $index => $textId) {
            $result[$textId] = $this->languages[$index] ?? [];
        }
        return $result;
    }
}
