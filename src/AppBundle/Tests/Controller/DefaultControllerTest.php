<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // there is a form to create post
        $this->assertEquals(1, $crawler->filter('form[name="postForm"]')->count());
        $this->assertEquals(1, $crawler->filter('input[name="title"]')->count());
        $this->assertEquals(1, $crawler->filter('textarea[name="description"]')->count());
        $this->assertEquals(1, $crawler->filter('[type="submit"]')->count());
    }
}
