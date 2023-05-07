<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SearchControllerTest extends WebTestCase
{
    public function testSearchDisplaysSearchResult(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/games/search?query=Cyberpunk');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Search results for "Cyberpunk"');
    }
}
