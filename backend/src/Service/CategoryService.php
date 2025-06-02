<?php

namespace App\Service;

use App\Repository\CategoryRepository;

final class CategoryService extends AbstractService
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
