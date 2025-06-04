<?php

namespace App\Controller\Api;

use App\Entity\Category;
use App\Service\Category\CategoryServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route("/api/categories")]
final class CategoryController extends AbstractController
{
    public function __construct(private readonly CategoryServiceInterface $categoryService) {}

    #[Route("/data-table", name: "api_categories_data", methods: ["POST"])]
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
}
