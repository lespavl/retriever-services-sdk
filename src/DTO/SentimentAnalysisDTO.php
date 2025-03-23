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

    public static function convertSentimentToNumber(string $sentiment): int
    {
        switch ($sentiment) {
            case 'positive':
                return 4;
            case 'neutral':
                return 5;
            case 'negative':
                return 6;
            default:
                return 2;
        }
    }
}
