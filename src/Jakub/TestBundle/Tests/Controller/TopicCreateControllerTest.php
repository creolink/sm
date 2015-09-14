<?php

namespace Jakub\TestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TopicCreateControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/create-topic');
        
        $form = $crawler->selectButton('Save topic')->form();
        
        $form['topicTitle'] = 'New Test Topic';

        $crawler = $client->submit($form);
    }
}
