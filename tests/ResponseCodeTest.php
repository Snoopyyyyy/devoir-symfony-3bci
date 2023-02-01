<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResponseCodeTest extends WebTestCase
{
    private static int $id;
    public function testGetAllOk(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/getall');
        $this->assertResponseIsSuccessful();
    }

    public function testGetAllHasAll(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/api/getall');
        $list = $client->getResponse();

        $json =json_decode($list->getContent(), true);

        $this::$id = $json[0]['id'];
        $this->assertTrue(count($json) == 10);
    }

    public function testGetByIdOk() {
        echo $this::$id;

        $client = static::createClient();
        $crawler = $client->request('GET', '/api/get/'.$this::$id);
        $list = $client->getResponse();
        $this->assertResponseIsSuccessful();
    }

    public function testGetById404() {
        echo $this::$id;

        $client = static::createClient();
        $crawler = $client->request('GET', '/api/get/4040404400');
        $response = $client->getResponse();
        $this->assertTrue($response->getStatusCode() == 404);
    }
}
