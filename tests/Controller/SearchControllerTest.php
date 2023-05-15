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

        $entityManager = static::getContainer()
            ->get('doctrine')
            ->getManager();

        $game = new Game();
        $game->setName('Cyberpunk');

        $entityManager->persist($game);
        $entityManager->flush();

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
}
