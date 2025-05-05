<?php

namespace App\DataFixtures;

use App\Entity\Game;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class GameFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $game = new Game();
        $game->setName('Cyberpunk');
        $manager->persist($game);

        $game = new Game();
        $game->setName('The Witcher');
        $manager->persist($game);

        $game = new Game();
        $game->setName('The Witcher 2: Assasins of Kings');
        $manager->persist($game);

        $game = new Game();
        $game->setName('The Witcher 3: Wild Hunt');
        $manager->persist($game);

        $manager->flush();
    }
}
