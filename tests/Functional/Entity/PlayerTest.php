<?php

declare(strict_types=1);

namespace App\Tests\Functional\Entity;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PlayerTest extends WebTestCase
{
    public function testUniquePlayer(): void
    {
        $this->expectException(UniqueConstraintViolationException::class);
        $playerRepository = static::getContainer()->get(PlayerRepository::class);

        $playerRepository->save(new Player('uniquePlayerName'));
    }
}
