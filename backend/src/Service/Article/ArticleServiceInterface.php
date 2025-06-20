<?php

namespace App\Service\Article;

use App\Dto\ArticleDto;
use App\Dto\PaginationDto;
use App\Dto\RequestArticleDto;
use App\Dto\RequestCommentDto;
use App\Dto\RequestRatingDto;
use App\Entity\Article;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Request;

interface ArticleServiceInterface
{
    /**
     * Paginate Article for DataTable
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param mixed $cb
     * @return array
     */
    public function paginateDataTable(Request $request, $cb): array;

    /**
     * Paginate articles for Api with PaginationDto
     * @param \App\Dto\PaginationDto $paginationDto
     * @return array
     */
    public function paginateWithPaginationDto(PaginationDto $paginationDto): array;

    /**
     * Add Article from Dto
     * @param \App\Dto\RequestArticleDto $request
     * @return Article
     */
    public function addArticle(RequestArticleDto $request): Article;

    /**
     * Get LikesCount by article
     * @param Article $article
     * @return array
     */
    public function getLikesCountByArticle(Article $article): array;

    /**
     * Get rates by connected user and article
     * @param Article $article
     * @return array
     */
    public function getRatesCountByArticle(Article $article): array;

    /**
     * Like article by article and connected user
     * @param \App\Entity\Article $article
     * @return array
     */
    public function likeArticle(Article $article, Request $request): array;

    /**
     * Comment article by article and connected user
     * @param \App\Entity\Article $article
     * @param \App\Dto\RequestCommentDto $request
     * @return array
     */
    public function commentArticleFromRequestCommentDto(Article $article, RequestCommentDto $request): array;

    /**
     * Rate article by article and connected user
     * @param \App\Entity\Article $article
     * @param \App\Dto\RequestRatingDto $request
     * @return array
     */
    public function rateArticle(Article $article, RequestRatingDto $request): array;

    /**
     * Convert Article To Dto
     * @param \App\Entity\Article $article
     * @return \App\Dto\ArticleDto
     */
    public function convertToDto(Article $article): ArticleDto;

    /**
     * Convert All Articles to Dto
     * @param Collection<int, Article> $articles
     * @return \App\Dto\ArticleDto[]
     */
    public function convertAllToDto(array $articles): array;
}
