<?php

namespace App\Tests\Controller;

use App\Entity\Game;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testDoesDisplaysWelcomeMessage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Welcome to Gamer Reviews!');
    }

    public function testDoesDisplaysSearchBar(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('input.search-input');
        $this->assertSelectorExists('button.search-button');
        $this->assertSelectorTextContains('button.search-button', 'Search');
    }

    public function testDoesDisplayListOfTrendingGames(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        /** @var EntityManagerInterface $entityManager */
        $entityManager = static::getContainer()
            ->get('doctrine')
            ->getManager();

        /** @var ServiceEntityRepository $gameRepository */
        $gameRepository = $entityManager->getRepository(Game::class);

        $game = $gameRepository->findOneBy(['name' => 'Cyberpunk']);
        $game->setTrendingIndex(1.0);
        $gameRepository->save($game);

        $game = $gameRepository->findOneBy(
            ['name' => 'The Witcher 3: Wild Hunt']
        );
        $game->setTrendingIndex(0.99);
        $gameRepository->save($game);

        $entityManager->flush();

        $this->assertResponseIsSuccessful();

        $trendingGames = $crawler->filter('.trending-game');

        $this->assertStringContainsString(
            'Cyberpunk',
            $trendingGames->first()->text()
        );
        $this->assertStringContainsString(
            'The Witcher 3',
            $trendingGames->eq(1)->text()
        );
    }
}
