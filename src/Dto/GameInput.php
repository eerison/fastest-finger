<?php

declare(strict_types=1);

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class GameInput
{
    public function __construct(
        #[Assert\NotBlank]
        public readonly string $playerName,

        #[Assert\NotBlank]
        public readonly float $score,
    ) {
    }
}
