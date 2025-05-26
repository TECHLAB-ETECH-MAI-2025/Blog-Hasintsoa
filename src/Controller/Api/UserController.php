<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route("/api/users")]
#[IsGranted("ROLE_ADMIN")]
final class UserController extends AbstractController
{
    public function __construct(private readonly UserService $userService) {}

    #[Route("", name: "api_users", methods: ['POST'])]

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
}
