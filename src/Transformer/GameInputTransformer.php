<?php

declare(strict_types=1);

namespace App\Transformer;

use App\Dto\GameInput;
use App\Entity\Game;
use App\Entity\Player;
use App\Repository\PlayerRepository;

class GameInputTransformer
{
    public function __construct(private PlayerRepository $repository)
    {
    }

    public function transformer(GameInput $gameInput): Game
    {
        $player = $this->repository->findOneBy(['name' => $gameInput->playerName]);

        $player = $player ?? new Player($gameInput->playerName);

        return (new Game())
            ->setPlayer($player)
            ->setScore($gameInput->score)
            ->setCreatedAt(new \DateTimeImmutable())
        ;
    }
}
