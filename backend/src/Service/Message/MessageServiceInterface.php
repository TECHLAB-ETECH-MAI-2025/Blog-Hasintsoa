<?php

namespace App\Service\Message;

use App\Entity\Message;
use Symfony\Component\HttpFoundation\Request;

interface MessageServiceInterface
{

    public function sendNotification(Message $message): void;

    public function paginateDataTable(Request $request, $cb): array;
}
