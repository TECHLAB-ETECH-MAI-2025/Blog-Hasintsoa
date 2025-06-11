<?php

namespace App\Dto;

final class AuthorDto
{
    public ?int $id = null;

    public string $email;

    public ?string $firstName = null;

    public ?string $lastName = null;

    public \DateTimeImmutable $createdAt;

    public function getFullName(): string
    {
        if ($this->firstName && $this->lastName) {
            return $this->firstName . ' ' . $this->lastName;
        }
        return $this->email;
    }
}
