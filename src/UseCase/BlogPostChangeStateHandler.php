<?php

namespace App\UseCase;

use App\Entity\BlogPost;
use App\Exception\BlogPostNotFoundException;
use App\Exception\BlogPostStateIsNotAllowedException;
use App\UseCase\Request\AbstractDto;
use App\UseCase\Request\BlogPostChangeStateRequest;
use App\UseCase\Response\BlogPostChangeStateResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\Target;
use Symfony\Component\Workflow\WorkflowInterface;

class BlogPostChangeStateHandler
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        #[Target('blog_publishing')]
        private WorkflowInterface $blogPublishingWorkflow
    ) {
    }

    /**
     * @throws BlogPostNotFoundException
     * @throws BlogPostStateIsNotAllowedException
     */
    public function __invoke(AbstractDto $blogPostChangeStateRequest): Dto\BlogPostDto
    {
        if (!$blogPostChangeStateRequest instanceof BlogPostChangeStateRequest) {
            throw new \LogicException('Invalid object type of '.$blogPostChangeStateRequest::class);
        }

        $blogPost = $this->entityManager->find(BlogPost::class, $blogPostChangeStateRequest->id);

        if (empty($blogPost)) {
            throw new BlogPostNotFoundException($blogPostChangeStateRequest->id);
        }

        $blogPost = $this->updateBlogPostState($blogPost, $blogPostChangeStateRequest->newState);

        $this->entityManager->persist($blogPost);
        $this->entityManager->flush();


        return new BlogPostChangeStateResponse(
            id: $blogPost->getId(),
            title: $blogPost->getTitle(),
            excerpt: $blogPost->getExcerpt(),
            content: $blogPost->getContent(),
            author: $blogPost->getAuthor(),
            status: $blogPost->getStatus()
        );
    }

    /**
     * @throws BlogPostStateIsNotAllowedException
     */
    private function updateBlogPostState(BlogPost $blogPost, string $newBlogPostState): BlogPost
    {
        if (!$this->blogPublishingWorkflow->can($blogPost, $newBlogPostState)) {
            throw new BlogPostStateIsNotAllowedException($newBlogPostState);
        }

        $this->blogPublishingWorkflow->apply($blogPost, $newBlogPostState);

        return $blogPost;
    }
}
