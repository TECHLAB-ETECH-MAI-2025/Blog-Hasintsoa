<?php

namespace App\Dto;

final class ArticleDto
{
    public ?int $id = null;

    public string $title;

    public string $content;

    public AuthorDto $author;

    /**
     * @var CategoryDto[]
     */
    public array $categories;

    public \DateTimeImmutable $createdAt;
}
