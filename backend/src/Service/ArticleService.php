<?php

namespace App\Service;

use App\Entity\Article;
use App\Repository\ArticleRepository;

final class ArticleService extends AbstractService
{

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
        $this->dataTableColumns = [
            0 => 'id',
            1 => 'title',
            2 => 'categories',
            3 => 'commentsCount',
            4 => 'likesCount',
            5 => 'ratingsSum',
            6 => 'a.createdAt',
        ];
    }

    public function createArticle(Article $article): array
    {
        return [];
    }
}
