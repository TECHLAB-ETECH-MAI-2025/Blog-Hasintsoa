<?php

namespace App\Service;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Request;

final class ArticleService extends AbstractService
{

    public function __construct(ArticleRepository $repository)
    {
        $this->repository = $repository;
        $this->dataTableColumns = [
            0 => 'a.id',
            1 => 'a.title',
            2 => 'categories',
            3 => 'likesCount',
            4 => 'a.createdAt',
        ];
    }

    public function paginateDataTable(Request $request, $cb): array
    {
        return [];
    }
}
