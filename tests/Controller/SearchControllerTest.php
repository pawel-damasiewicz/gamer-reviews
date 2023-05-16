<?php

namespace App\Tests\Controller;

use App\Entity\Game;
use App\Repository\GameRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchControllerTest extends WebTestCase
{
    public function testDisplaysSearchResult(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/games/search?query=Cyberpunk');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Search results for "Cyberpunk"');
    }

    public function testDisplaysLinkToHome(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/games/search');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('a[href="/"]');
        $this->assertSelectorTextContains('a.home', 'Home');
    }

    public function testDisplaysASearchResultWhenExists(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/games/search?query=Cyberpunk');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('li', 'Cyberpunk');
    }

    public function testDisplayNoResultsWhenDoesNotExist(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/games/search?query=NonExistent');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'No results found');
    }

    public function testSearchResultDoesLinkToGamePage(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/games/search?query=Cyberpunk');

        $entityManager = static::getContainer()
            ->get('doctrine')
            ->getManager();

        /** @var GameRepository $gameRepository */
        $gameRepository = $entityManager->getRepository(Game::class);
        $game = $gameRepository->findBy(['name' => 'Cyberpunk'])[0];
        $gameId = $game->getId();

        $this->assertResponseIsSuccessful();
        $this->assertEquals('/games/' . $gameId, $crawler->filter('li > a')->attr('href'));
    }

    public function testShowMoreThanOneResultsWhenMatchesFound(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/games/search?query=Witcher');

        $this->assertResponseIsSuccessful();

        $this->assertEquals(3, $crawler->filter('li')->count());
    }
}
