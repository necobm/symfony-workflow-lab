<?php

namespace App\UseCase\Response;

use App\UseCase\Request\AbstractDto;

class BlogPostCreateResponse extends AbstractDto
{
    public function __construct(
        public ?int $id,
        public ?string $title,
        public ?string $excerpt,
        public ?string $content,
        public ?string $author,
        public ?string $status
    ) {
    }

    public static function createFromArray(array $data): self
    {
        return new self(
            id: $data['id'] ?? null,
            title: $data['title'] ?? null,
            excerpt: $data['excerpt'] ?? null,
            content: $data['content'] ?? null,
            author: $data['author'] ?? null,
            status: $data['status'] ?? null
        );
    }
}
