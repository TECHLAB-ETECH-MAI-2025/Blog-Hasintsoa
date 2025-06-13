<?php

namespace App\Controller\Api;

use App\Dto\RequestCategoryDto;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Service\Category\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class CategoryController extends AbstractController
{
    public function __construct(private readonly CategoryServiceInterface $categoryService) {}

    #[Route("/app/categories/data-table", name: "api_categories_data", methods: ["POST"])]
    #[IsGranted("ROLE_ADMIN")]
    public function index(Request $request): JsonResponse
    {
        $paginationResult = $this->categoryService->paginateDataTable(
            $request,
            fn(Category $category) => [
                'id' => $category->getId(),
                'title' => $category->getTitle(),
                'createdAt' => $category->getCreatedAt()->format('d/m/Y H:i'),
                'actions' => $this->renderView("category/_actions.html.twig", [
                    'category' => $category
                ])
            ]
        );

        return $this->json(
            [
                'draw' => $request->request->getInt('draw'),
                ...$paginationResult
            ],
            Response::HTTP_OK
        );
    }

    #[Route('/api/categories', name: 'api_categories', methods: ['GET'])]
    public function getAllCategories(CategoryRepository $categoryRepository): JsonResponse
    {
        return $this->json([
            'success' => true,
            'data' => $categoryRepository->findAll()
        ]);
    }

    #[Route('/api/categories', name: 'api_categories_add', methods: ['POST'])]
    public function createCategory(#[MapRequestPayload] RequestCategoryDto $categoryDto): JsonResponse
    {
        $category = $this->categoryService->addCategory($categoryDto);
        return $this->json([
            'success' => true,
            'data' => $this->categoryService->convertToDto($category),
            'message' => 'Category added successfully'
        ], Response::HTTP_CREATED);
    }
}
