<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/api')]
final class SecurityController extends AbstractController
{
    #[Route('/me', name: 'api_user_me', methods: ['POST'])]
    public function getConnectedUser(): JsonResponse
    {
        $user = $this->getUser();
        if ($user) {
            return $this->json([
                'success' => true,
                'status' => Response::HTTP_OK,
                'message' => 'connected user informations',
                'data' => $this->getUser()
            ]);
        } else {
            return $this->json([
                'success' => false,
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => 'HTTP_UNAUTHORIZED',
                'data' => null
            ]);
        }
    }

    #[Route('/logout', name: 'api_logout', methods: ['DELETE'])]
    public function logout(): JsonResponse
    {
        $response = new JsonResponse();
        $cookie = new Cookie('symfony_cookie', '', time() - 3600);
        $response->headers->setCookie($cookie);
        $response->setData([
            'success' => true,
            'status' => Response::HTTP_OK,
            'message' => 'Cookie removed'
        ]);
        return $response;
    }
}
