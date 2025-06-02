<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Form\MessageForm;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/chat')]
final class ChatController extends AbstractController
{
    #[Route('', name: 'app_chat')]
    public function index(
        UserRepository $userRepository
    )
    {
        $currentUser = $this->getUser();
        return $this->render('chat/index.html.twig', [
            'users' => $userRepository->getAllUsersWithoutConnected($currentUser->getUserIdentifier())
        ]);
    }

    #[Route('/{receiverId}', name: 'app_chat_show')]
    public function show(
        int $receiverId,
        UserRepository $userRepository,
        MessageRepository $messageRepository,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $currentUser = $this->getUser();
        $currentUserId = $currentUser->getId();

        if ($receiverId == $currentUserId) {
            return $this->redirectToRoute('app_chat');
        }

        if (!$currentUser instanceof UserInterface) {
            throw $this->createAccessDeniedException('Vous devez être connecté.');
        }

        $receiver = $entityManager->getRepository(User::class)->find($receiverId);

        if (!$receiver) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        $messages = $messageRepository->findConversation($currentUserId, $receiverId);

        $message = new Message();
        $form = $this->createForm(MessageForm::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($currentUser);
            $message->setReceiver($receiver);
            $message->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('app_chat_show', ['receiverId' => $receiverId]);
        }

        return $this->render('chat/show.html.twig', [
            'messages' => $messages,
            'receiver' => $receiver,
            'users' => $userRepository->getAllUsersWithoutConnected($currentUser->getUserIdentifier()),
            'form' => $form
        ]);
    }
}
