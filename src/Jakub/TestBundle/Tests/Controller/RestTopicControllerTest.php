<?php

namespace Jakub\TestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RestTopicControllerTest extends WebTestCase
{
    public function testSave()
    {
        $client = static::createClient();
        
        $client->enableProfiler();
        
        $crawler = $client->request(
                'POST',
                '/topic/create',
                array(),
                array(),
                array('CONTENT_TYPE' => 'application/json'),
                '{"topicTitle":"Test"}'
            );
        
        $response = $client->getResponse();
        
        $data = json_decode($response->getContent(), true);
        $this->assertSame(array('result' => 'OK'), $data);
        
        if ($profile = $client->getProfile()) {
            $this->assertLessThan(
                5,
                $profile->getCollector('db')->getQueryCount(),
                sprintf(
                    'query count (token %s)', $profile->getToken()
                )
            );

            $this->assertLessThan(
                500,
                $profile->getCollector('time')->getDuration()
            );
        }
    }
    
    public function testDelete()
    {
        $client = static::createClient();
        
        $client->request(
            'DELETE',
            '/topic/delete/10'
        );
    }
}
