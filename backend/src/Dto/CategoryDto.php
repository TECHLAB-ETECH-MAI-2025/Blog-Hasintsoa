<?php

namespace App\Dto;

final class CategoryDto
{
    public ?int $id = null;

    public string $title;

    public string $description;

    public \DateTimeImmutable $createdAt;
}
