<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class RequestArticleDto
{
    #[Assert\NotBlank(message: "Ne doit pas être vide")]
    #[Assert\Length(min: 5, minMessage: 'doit contenir au moins {{ limit }} caractères')]
    public string $title;


    #[Assert\NotBlank(message: "Ne doit pas être vide")]
    #[Assert\Length(min: 5, minMessage: 'doit contenir au moins {{ limit }} caractères')]
    public string $content;

    /**
     * @var int[]
     */
    #[Assert\Count(min: 2, minMessage: "doit contenir au moins {{ limit }} catégories")]
    public array $categories;
}
