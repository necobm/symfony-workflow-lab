<?php

namespace App\UseCase;

use App\Entity\BlogPost;
use App\UseCase\Request\AbstractDto;
use App\UseCase\Request\BlogPostCreateRequest;
use App\UseCase\Response\BlogPostCreateResponse;
use Doctrine\ORM\EntityManagerInterface;

class BlogPostCreateHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function __invoke(AbstractDto $blogPostCreateRequest): BlogPostCreateResponse
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

        $blogPostCreateResponse = BlogPostCreateResponse::createFromArray($blogPostCreateRequest->toArray());
        $blogPostCreateResponse->id = $blogPost->getId();
        $blogPostCreateResponse->status = $blogPost->getStatus();

        return $blogPostCreateResponse;
    }
}
