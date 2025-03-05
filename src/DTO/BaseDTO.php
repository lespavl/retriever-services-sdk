<?php

namespace RelationDesk\RetrieverServicesSdk\DTO;

use RelationDesk\RetrieverServicesSdk\Exceptions\ApiException;

abstract class BaseDTO
{
    protected array $requiredProperties = [];

    public function __construct(?array $data)
    {
        foreach ($this->requiredProperties as $property) {
            if (!isset($data[$property])) {
                throw new \InvalidArgumentException("Missing required property: $property");
            }
        }

        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}