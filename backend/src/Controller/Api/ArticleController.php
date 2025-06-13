<?php

namespace App\Controller\Api;

use App\Dto\CommentArticleDto;
use App\Dto\PaginationDto;
use App\Dto\RequestArticleDto;
use App\Dto\RequestCommentDto;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Service\Article\ArticleServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/api/articles')]
final class ArticleController extends AbstractController
{
    public function __construct(private readonly ArticleServiceInterface $articleService) {}

    #[Route('', name: 'api_article_list', methods: ['GET'])]
    public function getAllArticles(ArticleRepository $articleRepository): JsonResponse
    {
        return $this->json([
            'data' => $articleRepository->findBy([], [
                'createdAt' => 'DESC'
            ])
        ], Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ], [
            'groups' => 'articles.index'
        ]);
    }

    #[Route('/paginated', name: 'api_article_paginated', methods: ['GET'])]
    public function getPaginatedArticles(
        #[MapQueryString]
        PaginationDto $paginationDto
    ): JsonResponse {
        return $this->json(
            [
                'success' => true,
                'data' => $this->articleService->paginateWithPaginationDto($paginationDto),
            ],
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/json'
            ],
            [
                'groups' => 'articles.index'
            ]
        );
    }

    #[Route('/{id}', name: 'api_article_show', methods: ['GET'])]
    public function getArticleById(string $id, ArticleRepository $articleRepository): JsonResponse
    {
        return $this->json([
            'success' => true,
            'data' => $articleRepository->findOneBy([
                'id' => $id
            ]),
            'message' => 'article by Id'
        ], Response::HTTP_OK, [
            'Content-Type' => 'application/json'
        ], [
            'groups' => 'articles.index'
        ]);
    }

    #[Route('', name: 'api_article_add', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function createArticle(
        #[MapRequestPayload]
        RequestArticleDto $articleDto
    ): JsonResponse {
        $article = $this->articleService->addArticle($articleDto);
        return $this->json([
            'success' => true,
            'data' => $this->articleService->convertToDto($article),
            'message' => 'Article added successfully'
        ], Response::HTTP_CREATED);
    }

    #[Route('/{id}/like', name: 'api_article_like', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function likeArticle(
        Article $article,
        Request $request
    ): JsonResponse {
        return $this->json(
            $this->articleService->likeArticle($article, $request)
        );
    }

    #[Route('/{id}/comment', name: 'api_article_comment', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function commentArticle(
        Article $article,
        #[MapRequestPayload]
        RequestCommentDto $request
    ): JsonResponse {
        return $this->json(
            $this->articleService->commentArticleFromRequestCommentDto($article, $request)
        );
    }
}
