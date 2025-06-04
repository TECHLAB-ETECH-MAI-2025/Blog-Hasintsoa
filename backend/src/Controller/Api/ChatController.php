<?php

namespace App\Controller\Api;

use App\Entity\Message;
use App\Entity\User;
use App\Form\MessageForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Attribute\Route;

final class ChatController extends AbstractController
{
    #[Route("/api/chat/send/{id}", name: 'api_chat_send')]
    public function sendMessage(
        User $user,
        Request $request,
        EntityManagerInterface $entityManager,
        HubInterface $hub
    ): JsonResponse {
        $currentUser = $this->getUser();
        $message = new Message();
        $form = $this->createForm(MessageForm::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($currentUser);
            $message->setReceiver($user);
            $message->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($message);
            $entityManager->flush();
            try {
                $topic = sprintf(
                    '/chat/messages/%d/%d',
                    min($currentUser->getId(), $user->getId()),
                    max($currentUser->getId(), $user->getId())
                );
                $update = new Update($topic, json_encode([
                    'message' => $message->getContent(),
                    'receiverId' => $message->getReceiver()->getId()
                ]));
                $hub->publish($update);

            } catch (\Exception $e) {
                return $this->json([
                    "message" => $e->getMessage(),
                    "code" => $e->getCode(),
                    "trace" => $e->getTraceAsString()
                ]);
            }
            return $this->json([
                'success' => true,
                'messageHtml' => $this->renderView('chat/_message_card.html.twig', [
                    'message' => $message,
                    'receiver' => $user
                ])
            ]);
        }
        $errors = [];
        foreach ($form->getErrors(true) as $error) {
            $errors[$error->getOrigin()->getName()] = $error->getMessage();
        }

        return $this->json([
            'success' => false,
            'error' => count($errors) > 0 ? $errors : 'Formulaire invalide'
        ], Response::HTTP_BAD_REQUEST);
    }
}
