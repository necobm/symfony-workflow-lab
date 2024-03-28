<?php

namespace App\Controller\Api;

use App\Exception\BlogPostNotFoundException;
use App\Exception\BlogPostStateIsNotAllowedException;
use App\UseCase\BlogPostChangeStateHandler;
use App\UseCase\Request\BlogPostChangeStateRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route(path: '/api/blog-post/{blogPostId}/change-state', name: 'api_blog_post_change_state', methods: ['PATCH'])]
class BlogPostChangeStateController
{
    public function __invoke(
        Request $request,
        int $blogPostId,
        BlogPostChangeStateHandler $blogPostChangeStateHandler
    ): JsonResponse {
        $payload = $request->getContent();
        $payload = json_decode($payload, true) ?? [];

        $blogPostChangeStateRequest = BlogPostChangeStateRequest::createFromArray(
            array_merge($payload, ['id' => $blogPostId])
        );

        try {
            $blogPostChangeStateResponse = $blogPostChangeStateHandler($blogPostChangeStateRequest);

            return new JsonResponse(
                data: $blogPostChangeStateResponse->toArray(),
                status: Response::HTTP_OK
            );
        } catch (BlogPostNotFoundException $exception) {
            return new JsonResponse(
                data: [
                    'message' => $exception->getMessage(),
                ],
                status: Response::HTTP_NOT_FOUND
            );
        } catch (BlogPostStateIsNotAllowedException $exception) {
            return new JsonResponse(
                data: [
                    'message' => $exception->getMessage(),
                ],
                status: Response::HTTP_FORBIDDEN
            );
        } catch (\Exception $exception) {
            return new JsonResponse(
                data: [
                    'message' => $exception->getMessage(),
                ],
                status: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
