<?php

namespace RelationDesk\RetrieverServicesSdk\DTO;

class SentimentAnalysisDTO extends BaseDTO
{
    protected array $requiredProperties = ['text_id', 'score', 'label'];
    public array $text_id;
    public array $score;
    public array $label;

    public function getDataById(): array
    {
        $result = [];
        foreach ($this->text_id as $index => $textId) {
            $result[$textId] = [
                'score' => $this->score[$index] ?? null,
                'label' => $this->label[$index] ?? null,
            ];
        }
        return $result;
    }
}
