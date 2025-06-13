<?php

namespace App\Service\Comment;

use App\Dto\CommentDto;
use App\Entity\Article;
use App\Entity\Comment;
use App\Repository\CommentRepository;
use App\Service\User\UserServiceInterface;

final class CommentService implements CommentServiceInterface
{
    public function __construct(
        private readonly UserServiceInterface $userService,
        private readonly CommentRepository $commentRepository
    ) {}

    public function getAllCommentsByArticle(Article $article, ?int $page, ?int $size): array
    {
        $pageSize = $size ?: 10;
        return $this->commentRepository->findBy(
            [
                'article' => $article
            ],
            [
                'createdAt' => 'DESC'
            ],
            $pageSize,
            $pageSize * (($page ?: 1) - 1)
        );
    }

    public function countCommentsByArticle(Article $article): int
    {
        return $this->commentRepository->count([
            'article' => $article
        ]);
    }

    public function convertToDto(Comment $comment): CommentDto
    {
        $commentDto = new CommentDto();
        $commentDto->id = $comment->getId();
        $commentDto->content = $comment->getContent();
        $commentDto->createdAt = $comment->getCreatedAt();
        $commentDto->authorDto = $this->userService->convertUserToAuthorDto($comment->getAuthor());
        return $commentDto;
    }

    public function convertAllToDto(array $comments): array
    {
        return array_map(
            fn($comment): CommentDto => $this->convertToDto($comment),
            $comments
        );
    }
}
