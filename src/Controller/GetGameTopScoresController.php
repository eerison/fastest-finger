<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\GameRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GetGameTopScoresController
{
    public function __construct(
        private GameRepository $repository,
        private SerializerInterface $serializer,
    ) {
    }

    #[Route('/api/games/top-scores', name: 'api_get_game_top_scores', methods: ['GET'])]
    public function __invoke(): JsonResponse
    {
        $games = $this->repository->findByTopScores();

        // TODO: it can be moved for a listener.
        $json = $this->serializer
            ->serialize(
                $games,
                'json',
                ['groups' => ['read']]
            );

        return new JsonResponse($json, json: true);
    }
}
