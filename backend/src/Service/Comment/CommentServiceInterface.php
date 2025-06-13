<?php

namespace App\Service\Comment;

use App\Dto\CommentDto;
use App\Entity\Comment;

interface CommentServiceInterface
{
    public function convertToDto(Comment $comment): CommentDto;
}
