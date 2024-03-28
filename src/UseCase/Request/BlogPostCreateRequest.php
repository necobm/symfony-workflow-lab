<?php

namespace App\UseCase\Request;

class BlogPostCreateRequest extends AbstractDto
{
    public function __construct(
        public ?string $title,
        public ?string $excerpt,
        public ?string $content,
        public ?string $author
    ) {
    }

    public static function createFromArray(array $data): AbstractDto
    {
        return new self(
            title: $data['title'] ?? null,
            excerpt: $data['excerpt'] ?? null,
            content: $data['content'] ?? null,
            author: $data['author'] ?? null
        );
    }
}
