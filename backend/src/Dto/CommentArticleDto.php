<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class CommentArticleDto
{
    #[Assert\NotBlank()]
    #[Assert\Length(min: 5, minMessage: 'doit contenir au moins {{ limit }} caractères')]
    public string $content;
}
