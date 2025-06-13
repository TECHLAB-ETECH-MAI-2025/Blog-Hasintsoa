<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final class RequestRatingDto
{
    #[Assert\Range(min: 1, max: 5, notInRangeMessage: 'Doit être entre 0 à 5')]
    public int $rating = 1;
}
