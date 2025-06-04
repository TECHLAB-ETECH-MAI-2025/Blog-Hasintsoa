<?php

namespace App\EventSubscriber;

use App\Event\MessageNotificationEvent;
use App\Service\MessageService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MessageNotificationSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly MessageService $messageService
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
