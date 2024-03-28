<?php

namespace App\UseCase\Request;

abstract class AbstractDto
{
    abstract public static function createFromArray(array $data): self;

    public function toArray(): array
    {
        return json_decode(json_encode($this), true);
    }
}
