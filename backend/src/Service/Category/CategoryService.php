<?php

namespace App\Service\Category;

use App\Dto\CategoryDto;
use App\Dto\RequestCategoryDto;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Service\AbstractService;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;

final class CategoryService extends AbstractService implements CategoryServiceInterface
{
    public function __construct(
        CategoryRepository $repository,
        private readonly EntityManagerInterface $entityManager
    ) {
        $this->repository = $repository;
        $this->dataTableColumns = [
            0 => 'id',
            1 => 'title',
            2 => 'createdAt'
        ];
    }

    public function getById(int $id): Category
    {
        return $this->repository->findOneBy([
            'id' => $id
        ]);
    }

    public function addCategory(RequestCategoryDto $request): Category
    {
        $category = new Category();
        $category->setTitle($request->title);
        $category->setDescription($request->description);
        $category->setCreatedAt(new \DateTimeImmutable());
        $this->entityManager->persist($category);
        $this->entityManager->flush();
        return $category;
    }

    public function convertToDto(Category $category): CategoryDto
    {
        $categoryDto =  new CategoryDto();
        $categoryDto->id = $category->getId();
        $categoryDto->title = $category->getTitle();
        $categoryDto->description = $category->getDescription();
        $categoryDto->createdAt = $category->getCreatedAt();
        return $categoryDto;
    }

    public function convertAllToDto(array $categories): array
    {
        return array_map(
            fn($category): CategoryDto => $this->convertToDto($category),
            $categories
        );
    }
}
