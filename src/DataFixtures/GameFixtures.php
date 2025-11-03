<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Game;
use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GameFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->generateTopScores($manager);
        $manager->flush();

        // $manager->flush();
    }

    private function generateTopScores(ObjectManager $manager): void
    {
        $player = new Player('foo.1');
        $manager->persist($player);
        $manager->flush();

        for ($i = 10; $i < 60; ++$i) {
            $score = rand(0, 10) / 10;
            $score += rand(0, 10);
            $createdAt = new \DateTimeImmutable(sprintf('2001-01-01 01:%d:11', $i));

            $game = new Game();
            $game->setPlayer($player);
            $game->setScore($score);
            $game->setCreatedAt($createdAt);

            $manager->persist($game);
        }
    }
}
