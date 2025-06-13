<?php

namespace App\Dto;

final class CommentDto
{
    public ?int $id = null;

    public string $content;

    public \DateTimeImmutable $createdAt;

    public AuthorDto $authorDto;
}
