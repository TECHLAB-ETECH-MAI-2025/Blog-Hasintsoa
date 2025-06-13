<?php

namespace App\Service\Comment;

use App\Dto\CommentDto;
use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Common\Collections\Collection;

interface CommentServiceInterface
{
    /**
     * Get All Comment by Article
     * @param Article $article
     * @param int | null $page
     * @param int | null $size
     * @return Comment[]
     */
    public function getAllCommentsByArticle(Article $article, ?int $page, ?int $size): array;

    /**
     * Count All Comments by Article
     * @param Article $article
     * @return int
     */
    public function countCommentsByArticle(Article $article): int;

    public function convertToDto(Comment $comment): CommentDto;

    /**
     * Convert All Comments To Dto
     * @param Comment[] $comments
     * @return CommentDto[]
     */
    public function convertAllToDto(array $comments): array;
}
