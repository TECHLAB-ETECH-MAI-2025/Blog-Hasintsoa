<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
final class SecurityController extends AbstractController
{
    #[Route('/me', name: 'api_user_me', methods: ['POST'])]
    public function getConnectedUser(): JsonResponse
    {
        return $this->json(
            $this->getUser()
        );
    }
}
