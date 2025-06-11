<?php

namespace App\Service\Category;

use App\Dto\CategoryDto;
use App\Dto\RequestCategoryDto;
use App\Entity\Category;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\Request;

interface CategoryServiceInterface
{
    /**
     * Paginate Category for
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param mixed $cb
     * @return array
     */
    public function paginateDataTable(Request $request, $cb): array;

    /**
     * Get Category By Id
     * @param int $id
     * @return Category
     */
    public function getById(int $id): Category;

    /**
     * Add Category From RequestCategoryDto
     * @param \App\Dto\RequestCategoryDto $categoryDto
     * @return Category
     */
    public function addCategory(RequestCategoryDto $request): Category;

    /**
     * Convert Category to CategoryDto
     * @param \App\Entity\Category $category
     * @return \App\Dto\CategoryDto
     */
    public function convertToDto(Category $category): CategoryDto;

    /**
     * Convert All Categories to Dto
     * @param Category[] $categories
     * @return CategoryDto[]
     */
    public function convertAllToDto(array $categories): array;
}
