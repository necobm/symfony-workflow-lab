<?php

namespace App\UseCase\Request;

class BlogPostChangeStateRequest extends AbstractDto
{
    public function __construct(
        public int $id,
        public ?string $newState
    ) {
    }

    public static function createFromArray(array $data): AbstractDto
    {
        return new self(
            id: $data['id'],
            newState: $data['newState'] ?? null
        );
    }
}
