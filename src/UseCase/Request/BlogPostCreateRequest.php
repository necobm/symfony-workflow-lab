<?php

namespace App\UseCase\Request;

class BlogPostCreateRequest extends AbstractRequest
{
    public function __construct(
        public ?string $title,
        public ?string $excerpt,
        public ?string $content,
        public ?string $author,
        public ?string $status
    ) {
    }

    public static function createFromArray(array $data): AbstractRequest
    {
        return new self(
            title: $data['title'] ?? null,
            excerpt: $data['title'] ?? null,
            content: $data['content'] ?? null,
            author: $data['author'] ?? null,
            status: $data['status'] ?? null
        );
    }
}
