<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class RequestCategoryDto
{
    #[Assert\NotBlank(message: "Ne doit pas être vide")]
    #[Assert\Length(min: 5)]
    public string $title;

    #[Assert\NotBlank(message: "Ne doit pas être vide")]
    #[Assert\Length(min: 5)]
    public string $description;
}
