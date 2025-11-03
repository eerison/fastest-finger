<?php

declare(strict_types=1);

namespace App\Message;

use App\Entity\Game;

class NewGameMessage
{
    public function __construct(private Game $game)
    {
    }

    public function getGame(): Game
    {
        return $this->game;
    }
}
