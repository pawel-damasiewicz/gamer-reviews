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
        $game->setTrendingIndex(1);
        $manager->persist($game);

        $game = new Game();
        $game->setName('The Witcher');
        $game->setTrendingIndex(0);
        $manager->persist($game);

        $game = new Game();
        $game->setName('The Witcher 2: Assasins of Kings');
        $game->setTrendingIndex(0);
        $manager->persist($game);

        $game = new Game();
        $game->setName('The Witcher 3: Wild Hunt');
        $game->setTrendingIndex(0.99);
        $manager->persist($game);

        $manager->flush();
    }
}
