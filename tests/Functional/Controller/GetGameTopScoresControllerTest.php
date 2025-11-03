<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetGameTopScoresControllerTest extends WebTestCase
{
    public function testGetTop10Scores(): void
    {
        $client = static::createClient(server: [
            'Content-Type' => 'application/json',
        ]);

        $playerRepository = static::getContainer()->get(PlayerRepository::class);
        $player = $playerRepository->findOneBy(['name' => 'foo.1']);

        $this->assertInstanceOf(Player::class, $player);
        $this->assertGreaterThan(10, $player->getGames()->count());

        $crawler = $client->request('GET', '/api/games/top-scores');
        $this->assertResponseIsSuccessful();

        $scores = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('score', $scores[0]);
        $this->assertArrayHasKey('playerName', $scores[0]);
    }
}
