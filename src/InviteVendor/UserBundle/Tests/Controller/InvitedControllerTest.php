<?php

namespace InviteVendor\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class InvitedControllerTest extends WebTestCase
{
    public function testAccept()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/accept');
    }

    public function testDecline()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/decline');
    }

    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/list');
    }

}
