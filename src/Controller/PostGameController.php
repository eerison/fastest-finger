<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\GameInput;
use App\Message\NewGameMessage;
use App\Transformer\GameInputTransformer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class PostGameController
{
    public function __construct(
        private MessageBusInterface $bus,
        private GameInputTransformer $transformer)
    {
    }

    #[Route('/api/games', name: 'api_post_game', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] GameInput $gameInput,
    ): JsonResponse {
        $game = $this->transformer->transformer($gameInput);

        $this->bus->dispatch(new NewGameMessage($game));

        return new JsonResponse(status: JsonResponse::HTTP_NO_CONTENT);
    }
}
