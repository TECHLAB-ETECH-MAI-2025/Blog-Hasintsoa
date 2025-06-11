<?php

namespace App\Service\Article;

use App\Dto\ArticleDto;
use App\Dto\RequestArticleDto;
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
     * Add Article from Dto
     * @param \App\Dto\RequestArticleDto $request
     * @return Article
     */
    public function addArticle(RequestArticleDto $request): Article;

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
