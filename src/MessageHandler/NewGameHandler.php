<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Message\NewGameMessage;
use App\Repository\GameRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class NewGameHandler
{
    public function __construct(private GameRepository $repository)
    {
    }

    public function __invoke(NewGameMessage $message): void
    {
        $this->repository->save($message->getGame());
    }
}
