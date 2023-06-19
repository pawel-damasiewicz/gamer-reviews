<?php

namespace App\Tests\Controller;

use App\Entity\Game;
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
}
