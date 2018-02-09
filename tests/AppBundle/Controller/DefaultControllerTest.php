<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals("Products list", trim($crawler->filter('h1')->text()));

        $trHeadNode = $crawler->filter('table.products > thead > tr');
        $this->assertEquals('Id', trim($trHeadNode->filter('td:nth-child(1)')->text()));
        $this->assertEquals('Name', trim($trHeadNode->filter('td:nth-child(2)')->text()));
        $this->assertEquals('Price', trim($trHeadNode->filter('td:nth-child(3)')->text()));
        $this->assertEquals('Description', trim($trHeadNode->filter('td:nth-child(4)')->text()));
    }

    public function testLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/login');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        // check if username field is null and if _username field exists
        $this->assertEquals('', $crawler->filter('input[name="_username"]')->attr('value'));
        // check if _password field exists
        $crawler->filter('input[name="_password"]');
    }
}
