<?php

namespace Jakub\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Jakub\TestBundle\Form\Type\ArticleType;
use Jakub\TestBundle\Entity\Article;

class ArticleDeleteController extends Controller
{
    /**
     * @Route("/delete-article/{topicId}/{articleId}", name="delete-article")
     */
    public function indexAction($topicId, $articleId)
    {
        $jsonData = json_encode(
                array('topicId' => $topicId, 'articleId' => $articleId)
            );
        
        $url = $this->generateUrl('rest-delete-article', array(), true);
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        //curl_setopt($ch, CURLOPT_PORT, 8000);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData))
        );

        if ($cResult = curl_exec($ch)) {
            $cResult = json_decode($cResult);
            
            if ($cResult->result == 'OK') {
                return $this->redirect(
                        $this->generateUrl(
                                'articles-list', 
                                array('topicId' => $topicId)
                            )
                    );
            }
        }
        
        return $this->redirect(
                $this->generateUrl(
                        'article-data', 
                        array('topicId' => $topicId, 'articleId' => $articleId)
                    )
            );
    }
}
