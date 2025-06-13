<?php

namespace App\Controller\Api;

use App\Dto\RequestMessageDto;
use App\Entity\Message;
use App\Entity\User;
use App\Event\MessageNotificationEvent;
use App\Form\MessageForm;
use App\Repository\MessageRepository;
use App\Service\Message\MessageServiceInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class ChatController extends AbstractController
{
    public function __construct(
        private readonly MessageServiceInterface $messageService,
        private readonly MessageRepository $messageRepository
    ) {}

    #[Route("/app/chat/send/{id}", name: 'api_chat_send')]
    #[IsGranted('ROLE_USER')]
    public function sendMessage(
        User $user,
        Request $request,
        EntityManagerInterface $entityManager,
        HubInterface $hub,
        EventDispatcherInterface $eventDispatcher
    ): JsonResponse {
        $currentUser = $this->getUser();
        $message = new Message();
        $form = $this->createForm(MessageForm::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($currentUser instanceof User) {
                $userAuth = $entityManager->getRepository(User::class)->findOneBy([
                    'id' => $currentUser->getId()
                ]);
            }
            $message->setSender($userAuth);
            $message->setReceiver($user);
            $message->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($message);
            $entityManager->flush();
            try {
                $eventDispatcher->dispatch(new MessageNotificationEvent($message));
                $topic = sprintf(
                    '/chat/messages/%d/%d',
                    min($message->getSender()->getId(), $user->getId()),
                    max($message->getSender()->getId(), $user->getId())
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

    #[Route('/api/messages/{id}', name: 'api_chat_conversations', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function getConversationBetween(
        User $user,
        Request $request
    ): JsonResponse {
        $currentUser = $this->getUser();
        if ($currentUser instanceof User) {
            $conversations = $this->messageRepository->findConversation(
                $currentUser->getId(),
                $user->getId(),
                $request->query->getInt('page', 1),
                $request->query->getInt('size', 10),
            );
        }
        return $this->json(
            [
                'data' => $conversations
            ],
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/json'
            ],
            [
                'groups' => 'message.chat'
            ]
        );
    }

    #[Route('/api/chat/send/{id}', name: 'api_chat_send', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function sendMessageToUser(
        User $user,
        EntityManagerInterface $entityManager,
        HubInterface $hub,
        EventDispatcherInterface $eventDispatcher,
        #[MapRequestPayload]
        RequestMessageDto $request
    ): JsonResponse {
        $currentUser = $this->getUser();
        $message = new Message();
        $message->setContent($request->content);
        if ($currentUser instanceof User) {
            $userAuth = $entityManager->getRepository(User::class)->findOneBy([
                'id' => $currentUser->getId()
            ]);
        }
        $message->setSender($userAuth);
        $message->setReceiver($user);
        $message->setCreatedAt(new \DateTimeImmutable());
        //$entityManager->persist($message);
        //$entityManager->flush();
        try {
            //$eventDispatcher->dispatch(new MessageNotificationEvent($message));
            $topic = sprintf(
                'https://127.0.0.1:8000/front/chat/messages/%d/%d',
                min($message->getSender()->getId(), $user->getId()),
                max($message->getSender()->getId(), $user->getId())
            );
            $update = new Update($topic, json_encode([
                'message' => [
                    'id' => $message->getId(),
                    'content' => $message->getContent(),
                    'createdAt' => $message->getCreatedAt(),
                    'sender' => [
                        'id' => $message->getSender()->getId(),
                        'email' => $message->getSender()->getEmail(),
                        'firstName' => $message->getSender()->getFirstName(),
                        'lastName' => $message->getSender()->getLastName(),
                    ],
                    'receiver' => [
                        'id' => $message->getReceiver()->getId(),
                        'email' => $message->getReceiver()->getEmail(),
                        'firstName' => $message->getReceiver()->getFirstName(),
                        'lastName' => $message->getReceiver()->getLastName(),
                    ],
                ]
            ]));
            $hub->publish($update);
        } catch (\Exception $e) {
        }
        return $this->json([
            'success' => true,
            'content' => $request->content,
            'message' => [
                'id' => $message->getId(),
                'content' => $message->getContent(),
                'createdAt' => $message->getCreatedAt(),
                'sender' => [
                    'id' => $message->getSender()->getId(),
                    'email' => $message->getSender()->getEmail(),
                    'firstName' => $message->getSender()->getFirstName(),
                    'lastName' => $message->getSender()->getLastName(),
                ],
                'receiver' => [
                    'id' => $message->getReceiver()->getId(),
                    'email' => $message->getReceiver()->getEmail(),
                    'firstName' => $message->getReceiver()->getFirstName(),
                    'lastName' => $message->getReceiver()->getLastName(),
                ],
            ]
        ]);
    }
}
