<?php

namespace App\UseCase;

use App\Entity\BlogPost;
use App\UseCase\Request\AbstractRequest;
use App\UseCase\Request\BlogPostCreateRequest;
use Doctrine\ORM\EntityManagerInterface;

class BlogPostCreateHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(AbstractRequest $blogPostCreateRequest): void
    {
        if (!$blogPostCreateRequest instanceof BlogPostCreateRequest) {
            throw new \LogicException('Invalid object type of '.$blogPostCreateRequest::class);
        }

        $blogPost = new BlogPost();

        $blogPost->setTitle($blogPostCreateRequest->title);
        $blogPost->setAuthor($blogPostCreateRequest->author);
        $blogPost->setContent($blogPostCreateRequest->content);
        $blogPost->setExcerpt($blogPostCreateRequest->excerpt);

        $this->entityManager->persist($blogPost);
        $this->entityManager->flush();
    }
}
