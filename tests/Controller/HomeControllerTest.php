<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testDisplaysWelcomeMessage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Welcome to Gamer Reviews!');
    }

    public function testDisplaysSearchBar(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorExists('input.search-input');
        $this->assertSelectorExists('button.search-button');
        $this->assertSelectorTextContains('button.search-button', 'Search');
    }
}
