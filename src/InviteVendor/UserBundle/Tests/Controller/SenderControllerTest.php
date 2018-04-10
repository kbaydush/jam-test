<?php

namespace InviteVendor\UserBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SenderControllerTest extends WebTestCase
{
    public function testSendinvite()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/sendInvite');
    }

    public function testCancelinvite()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'cancel');
    }

    public function testList()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/list');
    }

}
