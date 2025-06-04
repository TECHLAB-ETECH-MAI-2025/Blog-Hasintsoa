<?php

namespace App\Service\Message;

use App\Entity\Message;
use App\Repository\MessageRepository;
use App\Service\AbstractService;
use App\Service\Message\MessageServiceInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

final class MessageService extends AbstractService implements MessageServiceInterface
{
    public function __construct(
        private readonly MailerInterface $mailer,
        MessageRepository $repository
    ) {
        $this->repository = $repository;
    }

    public function sendNotification(Message $message): void
    {
        $email = (new TemplatedEmail())
            ->to($message->getReceiver()->getEmail())
            ->from($message->getSender()->getEmail())
            ->subject('Message Conversation')
            ->htmlTemplate('emails/mail_notification.html.twig')
            ->context([
                'message' => $message
            ]);
        $this->mailer->send($email);
    }
}
