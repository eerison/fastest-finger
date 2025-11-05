<?php

declare(strict_types=1);

namespace App\Tests\Functional\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostGameControllerTest extends WebTestCase
{
    public function testStartANewGame(): void
    {
        $client = static::createClient();
        $gameRepository = static::getContainer()->get(GameRepository::class);

        $crawler = $client->request('POST', '/api/games', [
            'playerName' => 'erison-silva',
            'score' => 1.5,
        ]);

        $this->assertResponseIsSuccessful();
        [$game] = $gameRepository->findByPlayerName('erison-silva');

        $this->assertInstanceOf(Game::class, $game);
        $this->assertSame($game->getPlayer()->getName(), 'erison-silva');
        $this->assertSame($game->getScore(), 1.5);
    }

    public function testRequiredFields(): void
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/api/games');

        $this->assertResponseStatusCodeSame(400);
        $this->assertJsonStringEqualsJsonString(
            $client->getResponse()->getContent(),
            '
            {
                "data": {
                    "code": 400,
                    "message": "Request payload contains invalid \"form\" data."
                }
            }
            ');
    }

    public function testScoreFloat(): void
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/api/games', [
            'score' => 'abc',
            'playerName' => 'foo',
        ]);

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            $client->getResponse()->getContent(),
            '
            {
                "data": {
                    "code": 422,
                    "message": "score:\n    This value should be of type float.\n"
                }
            }
            ');
    }

    public function testPlayerNameType(): void
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/api/games', [
            'score' => 0.5,
            'playerName' => [],
        ]);

        $this->assertResponseStatusCodeSame(422);
        $this->assertJsonStringEqualsJsonString(
            $client->getResponse()->getContent(),
            '
            {
                "data": {
                    "code": 422,
                    "message": "playerName:\n    This value should be of type string.\n"
                }
            }
            ',
        );
    }

    public function testAcceptOnlyPositiveScores(): void
    {
        $client = static::createClient();

        $crawler = $client->request('POST', '/api/games', [
            'score' => -0.5,
            'playerName' => 'bar',
        ]);

        $this->assertResponseStatusCodeSame(422);
    }
}
