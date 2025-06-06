<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
final class SecurityController extends AbstractController
{
    #[Route('/login', name: 'api_login', methods: ['POST'])]
    public function apiLogin(): JsonResponse
    {
        return $this->json([
            'alors' => 'quoi'
        ]);
    }
}
