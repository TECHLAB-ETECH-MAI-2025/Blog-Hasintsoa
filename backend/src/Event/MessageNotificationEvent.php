<?php

namespace App\Event;

use App\Entity\Message;

final class MessageNotificationEvent
{
    public function __construct(public Message $message) {}
}
