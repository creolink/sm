<?php

namespace Jakub\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TopicDataController extends Controller
{
    /**
     * @Route(
     *      "/articles-list/{topicId}",
     *      name="articles-list",
     *      defaults={"topicId" = 0}
     * )
     * 
     * @Template("JakubTestBundle:Topics:data.html.twig")
     */
    public function indexAction($topicId)
    {
        if ($topicId > 0) {
            $url = $this->generateUrl('rest-get-topic', array('topicId' => $topicId), true);
            
            // we can do it with curl or fsock
            if ($fileData = file_get_contents($url)) {
                $jsonData = json_decode($fileData);
                
                return array(
                    'topicId' => $topicId,
                    'articleId' => 0,
                    'topicData' => $jsonData->topicData,
                    'articlesList' => $jsonData->articlesList
                );
            }
        }
        
        return $this->redirect($this->generateUrl('topics-list'));
    }
}
