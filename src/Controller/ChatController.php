<?php

namespace App\Controller;

use App\Entity\Message;
use App\Entity\User;
use App\Form\MessageForm;
use App\Repository\MessageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/chat')]
final class ChatController extends AbstractController
{
    #[Route('/{receiverId}', name: 'app_chat')]
    public function index(
        int $receiverId,
        MessageRepository $messageRepository,
        EntityManagerInterface $entityManager,
        Request $request
    ): Response {
        $currentUser = $this->getUser();
        if (!$currentUser instanceof UserInterface) {
            throw $this->createAccessDeniedException('Vous devez être connecté.');
        }

        $receiver = $entityManager->getRepository(User::class)->find($receiverId);

        if (!$receiver) {
            throw $this->createNotFoundException('Utilisateur non trouvé.');
        }

        $messages = $messageRepository->findConversation($currentUser->getId(), $receiverId);

        $message = new Message();
        $form = $this->createForm(MessageForm::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $message->setSender($currentUser);
            $message->setReceiver($receiver);
            $message->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('app_chat', ['receiverId' => $receiverId]);
        }

        return $this->render('chat/index.html.twig', [
            'messages' => $messages,
            'receiver' => $receiver,
            'form' => $form
        ]);
    }
}
