<?php

namespace Jakub\TestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TopicsListControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        //$this->assertTrue($crawler->filter('html:contains("List of topics")')->count() > 0);
        
        $h1 = $crawler->filter('h1')->eq(0)->text();
        $this->assertEquals('List of topics', $h1);
        
        $link = $crawler->filter('a:contains("Create a topic")')->first()->link();
        $createTopicPage = $client->click($link);
        
        $this->assertEquals('Create new topic', $createTopicPage->filter('h1')->first()->text());
    }
}
