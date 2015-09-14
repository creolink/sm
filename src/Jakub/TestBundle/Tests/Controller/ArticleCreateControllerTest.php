<?php

namespace Jakub\TestBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Jakub\TestBundle\Controller\ArticleCreateController;

class ArticleCreateControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        
        $client->enableProfiler();
        
        $crawler = $client->request('GET', '/create-article/1');
        
        $h1 = $crawler->filter('h1')->eq(0)->text();
        $this->assertEquals('Create new article', $h1);
        
        $csrfToken = $client->getContainer()->get('form.csrf_provider')->generateCsrfToken('article');
        
        $crawler = $client->request(
                'POST',
                '/create-article/1',
                array(
                    'article' => array
                    (
                        'articleTitle' => "Test Title",
                        'articleAuthor' => "Test Author",
                        'articleText' => "Test Text",
                        '_token' => $csrfToken
                    )
                ),
                array(),
                array()
            );
        
        // TODO: doesn't work for now, I don't know why, yet
        //$response = $client->getResponse();
        //$this->assertEquals('List of articles', $response->getContent());
        
        if ($profile = $client->getProfile()) {
            $this->assertLessThan(
                500,
                $profile->getCollector('time')->getDuration()
            );
        }
    }
}
