<?php

namespace RelationDesk\RetrieverServicesSdk\DTO;

class LanguageDetectionDTO extends BaseDTO
{
    protected array $requiredProperties = ['languages', 'text_id'];
    public array $languages;
    public array $text_id;
}