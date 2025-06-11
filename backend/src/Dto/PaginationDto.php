<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class PaginationDto
{
    #[Assert\Positive()]
    public int $page = 1;

    #[Assert\Positive()]
    public int $size = 10;

    public ?string $orderColumn;

    #[Assert\Choice(choices: ['asc', 'desc', 'ASC', 'DESC'])]
    public ?string $orderDir;
}
