<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PlayerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $player = new Player('uniquePlayerName');
        $manager->persist($player);

        $manager->flush();
    }
}
