<?php

namespace App\Service\Category;

use App\Repository\CategoryRepository;
use App\Service\AbstractService;

final class CategoryService extends AbstractService implements CategoryServiceInterface
{
    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
        $this->dataTableColumns = [
            0 => 'id',
            1 => 'title',
            2 => 'createdAt'
        ];
    }
}
