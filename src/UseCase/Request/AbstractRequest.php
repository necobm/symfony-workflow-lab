<?php

namespace App\UseCase\Request;

abstract class AbstractRequest
{
    abstract public static function createFromArray(array $data): self;

    public function toArray()
    {
        return json_decode(json_encode($this), true);
    }
}
