<?php

namespace RelationDesk\RetrieverServicesSdk\DTO;

class SentimentAnalysisDTO extends BaseDTO
{
    protected array $requiredProperties = ['text_id', 'score', 'label'];
    public array $text_id;
    public array $score;
    public array $label;
}