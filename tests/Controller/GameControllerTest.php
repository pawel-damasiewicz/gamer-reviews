<?php

namespace App\Tests\Controller;

use App\Entity\Game;
use App\Entity\Review;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameControllerTest extends WebTestCase
{
    public function testDoesShowGameName(): void
    {
        $client = static::createClient();
        $entityManager = static::getContainer()
            ->get('doctrine')
            ->getManager();

        $gameRepository = $entityManager->getRepository(Game::class);

        /** @var Game $game */
        $game = $gameRepository->findOneBy(['name' => 'Cyberpunk']);

        $client->request('GET', '/game/' . $game->getId());


        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Cyberpunk');
    }

    public function testDoesShowGameReviews(): void
    {
        $client = static::createClient();
        $entityManager = static::getContainer()
            ->get('doctrine')
            ->getManager();

        $gameRepository = $entityManager->getRepository(Game::class);

        $game = $gameRepository->findOneBy(['name' => 'Cyberpunk']);

        $review = new Review();
        $review->setContent('Test Review');
        $review->setRating(0.69);


        $game->addReview($review);

        $client->request('GET', '/game/' . $game->getId());

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains(
            'ul#reviews li:first-child',
            'Test Review'
        );
    }
}
