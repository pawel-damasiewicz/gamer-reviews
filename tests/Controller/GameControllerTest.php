<?php

namespace App\Tests\Controller;

use App\Entity\Game;
use App\Entity\Review;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GameControllerTest extends WebTestCase
{
    public static function getRepository(): GameRepository
    {
        $entityManager = static::getContainer()
            ->get('doctrine')
            ->getManager();

        return $entityManager->getRepository(Game::class);
    }

    public function testDoesShowGameName(): void
    {
        $client = static::createClient();
        $game = static::getRepository()->findOneBy(['name' => 'Cyberpunk']);

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

        $review = new Review();
        $review->setContent('Test Review');
        $review->setRating(0.69);

        $game = static::getRepository()->findOneBy(['name' => 'Cyberpunk']);

        $review->setGame($game);

        $entityManager->persist($review);
        $entityManager->persist($game);
        $entityManager->flush();

        $client->request('GET', '/game/' . $game->getId());

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains(
            'ul#reviews li:first-child',
            'Test Review'
        );
    }
}
