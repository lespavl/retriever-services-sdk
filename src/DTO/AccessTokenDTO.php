<?php

namespace RelationDesk\RetrieverServicesSdk\DTO;

class AccessTokenDTO extends BaseDTO
{
    protected array $requiredProperties = ['access_token'];
    public string $access_token;
}