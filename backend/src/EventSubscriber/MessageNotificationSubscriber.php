<?php

namespace App\EventSubscriber;

use App\Event\MessageNotificationEvent;
use App\Service\Message\MessageServiceInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MessageNotificationSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly MessageServiceInterface $messageService
    ) {}

    public function onMessageNotificationEvent(MessageNotificationEvent $event): void
    {
        $this->messageService->sendNotification($event->message);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MessageNotificationEvent::class => 'onMessageNotificationEvent',
        ];
    }
}
