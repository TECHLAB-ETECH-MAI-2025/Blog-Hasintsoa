<?php

namespace App\Service\Comment;

use App\Dto\CommentDto;
use App\Entity\Comment;
use App\Service\User\UserServiceInterface;

final class CommentService implements CommentServiceInterface
{
    public function __construct(
        private readonly UserServiceInterface $userService
    ) {}

    public function convertToDto(Comment $comment): CommentDto
    {
        $commentDto = new CommentDto();
        $commentDto->id = $comment->getId();
        $commentDto->content = $comment->getContent();
        $commentDto->createdAt = $comment->getCreatedAt();
        $commentDto->authorDto = $this->userService->convertUserToAuthorDto($comment->getAuthor());
        return $commentDto;
    }
}
