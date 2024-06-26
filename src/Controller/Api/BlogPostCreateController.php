<?php

namespace App\Controller\Api;

use App\UseCase\BlogPostCreateHandler;
use App\UseCase\Dto\BlogPostDto;
use App\UseCase\Request\BlogPostCreateRequest;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
#[Route(path: '/api/blog-post', name: 'api_blog_post_create', methods: ['POST'])]
/**
 * @OA\RequestBody(@Model(type=BlogPostCreateRequest::class))
 *
 * @OA\Response(
 *     response="201",
 *
 *     description="Success response for BlogPost creation",
 *
 *     @Model(type=BlogPostDto::class)
 * )
 *
 * @OA\Tag(name="BlogPost")
 */
class BlogPostCreateController
{
    public function __invoke(Request $request, BlogPostCreateHandler $blogPostCreateHandler): JsonResponse
    {
        $payLoad = $request->getContent();
        $payLoad = json_decode($payLoad, true) ?? [];

        $blogPostRequest = BlogPostCreateRequest::createFromArray($payLoad);

        try {
            $blogPostCreateResponse = $blogPostCreateHandler($blogPostRequest);

            return new JsonResponse(
                data: $blogPostCreateResponse->toArray(),
                status: Response::HTTP_CREATED
            );
        } catch (\LogicException $exception) {
            return new JsonResponse(
                data: [
                    'message' => $exception->getMessage(),
                ],
                status: Response::HTTP_BAD_REQUEST
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
