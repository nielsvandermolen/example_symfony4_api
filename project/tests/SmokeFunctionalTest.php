<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SmokeFunctionalTest extends WebTestCase {

    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSecure($url) {
        $client = self::createClient([], [
            'PHP_AUTH_USER' => 'test',
            'PHP_AUTH_PW'   => 'incorrect_pw',
        ]);
        $client->request('GET', $url);
        $this->assertFalse($client->getResponse()->isSuccessful());
    }

    /**
     * @dataProvider urlProvider
     */
    public function testPageIsSuccessful($url) {
        $client = self::createClient([], [
            'PHP_AUTH_USER' => 'test',
            'PHP_AUTH_PW'   => 'test',
        ]);
        $client->request('GET', $url);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlProvider() {
        yield ['/api'];
        yield ['/admin/?entity=Article'];
        yield ['/admin/?entity=Comment'];
        yield ['/admin/?entity=User'];
    }

    /**
     * @dataProvider urlApiProvider
     */
    public function testAPIisSecure($url) {
        $client = self::createClient([]);
        $client->request('GET', $url, [], [], ['HTTP_X_AUTH_TOKEN' => 'incorrect_api_key', 'HTTP_ACCEPT' => 'application/json']);
        $this->assertFalse($client->getResponse()->isSuccessful());
    }

    /**
     * @dataProvider urlApiProvider
     */
    public function testAPIWorks($url) {
        $client = self::createClient([]);
        $client->request('GET', $url, [], [], ['HTTP_X_AUTH_TOKEN' => 'test_api_key', 'HTTP_ACCEPT' => 'application/json']);
        $this->assertTrue($client->getResponse()->isSuccessful());
    }

    public function urlApiProvider() {
        yield ['/api/articles'];
        yield ['/api/comments'];
    }
}
