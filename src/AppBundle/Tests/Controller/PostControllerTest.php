<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    /**
     * Create post test
     *
     * @return stdClass $post
     */
    public function testCreate()
    {
        $client = static::createClient();
        
        // check validation
        $crawler = $client->request('POST', '/posts', array('post' => array(
            'title' => 'title', 'description' => '')
        ));
        $this->assertJsonResponse(400, $client->getResponse());

        // create post
        $crawler = $client->request('POST', '/posts', array('post' => array(
            'title' => 'title', 'description' => 'desc')
        ));
        $this->assertJsonResponse(200, $client->getResponse());

        $post = json_decode($client->getResponse()->getContent());
        $this->assertObjectHasAttribute('id', $post);
        $this->assertEquals('title', $post->title);
        $this->assertEquals('desc', $post->description);

        return $post;
    }

    /**
     * Get post test
     *
     * @depends testCreate
     */
    public function testGet($post)
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/posts/'.$post->id);
        $this->assertJsonResponse(200, $client->getResponse());
    }

    public function testGetCollection()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/posts');
        $this->assertJsonResponse(200, $client->getResponse());
    }

    /**
     * Edit post test
     *
     * @depends testCreate
     * @return stdClass $post
     */
    public function testEdit($post)
    {
        $client = static::createClient();
        $crawler = $client->request('POST', '/posts/'.$post->id, array('post' => array(
            'title' => 'new-title', 'description' => 'new-desc')
        ));
        $this->assertJsonResponse(200, $client->getResponse());

        $post = json_decode($client->getResponse()->getContent());
        $this->assertEquals('new-title', $post->title);
        $this->assertEquals('new-desc', $post->description);

        return $post;
    }

    /**
     * Delete post test
     *
     * @depends testCreate
     */
    public function testDelete($post)
    {
        $client = static::createClient();
        $crawler = $client->request('DELETE', '/posts/'.$post->id);
        $this->assertEquals(204, $client->getResponse()->getStatusCode());
    }
}
