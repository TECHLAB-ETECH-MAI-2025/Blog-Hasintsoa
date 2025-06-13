<?php

namespace App\Controller\Api;

use App\Dto\PaginationDto;
use App\Entity\User;
use App\Service\User\UserServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted("ROLE_ADMIN")]
final class UserController extends AbstractController
{
    public function __construct(private readonly UserServiceInterface $userService) {}

    #[Route("/app/users/data-table", name: "app_users_data", methods: ['POST'])]

    public function index(Request $request): JsonResponse
    {
        $paginationResult = $this->userService->paginateDataTable(
            $request,
            fn(User $user) => [
                'id' => $user->getId(),
                'fullName' => $user->getLastName() . " " . $user->getFirstName(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
                'isVerified' => $user->isVerified() ? "Oui" : "Non",
                'createdAt' => $user->getCreatedAt()->format('d/m/Y H:i'),
                'actions' => $this->renderView("admin/user/_actions.html.twig", [
                    'user' => $user
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

    #[Route('/api/users/paginated', name: 'api_users_paginated', methods: ['GET'])]
    public function getPaginatedUsers(
        #[MapQueryString]
        PaginationDto $paginationDto
    ): JsonResponse {
        return $this->json(
            [
                'data' => $this->userService->paginateWithPaginationDto($paginationDto),
                'message' => 'get paginated users'
            ],
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/json'
            ],
            [
                'groups' => 'user.message'
            ]
        );
    }
}
