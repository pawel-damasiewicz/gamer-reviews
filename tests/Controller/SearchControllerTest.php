<?php

namespace App\Tests\Controller;

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
}
