<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class AdminControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    public function setUp()
    {
        $this->client = static::createClient();
    }

    public function testAddProductWithoutCredentials()
    {
        $this->client->request('GET', '/admin/new-product');
        $this->assertEquals(302, $this->client->getResponse()->getStatusCode());
    }

    public function testAddProductWithCredentials()
    {
        $this->login();

        $crawler = $this->client->request('GET', '/admin/new-product');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $crawler->filter('input[type="text"]')->each(function($inputText) {
            $this->assertRegExp('/(name|description|price)/', $inputText->attr('name'));
        });
    }

    private function login()
    {
        $session = $this->client->getContainer()->get('session');

        $firewallContext = "main";

        $token = new UsernamePasswordToken('admin', null, $firewallContext, ['ROLE_ADMIN']);
        $session->set('_security_'.$firewallContext, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $this->client->getCookieJar()->set($cookie);
    }
}