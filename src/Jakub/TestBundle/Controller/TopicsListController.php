<?php

namespace Jakub\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Jakub\TestBundle\Entity\Topic;

class TopicsListController extends Controller
{
    /**
     * @Route("/", name="topics-list", options={"expose"=true})
     * 
     * @Template("JakubTestBundle:Topics:list.html.twig")
     */
    public function indexAction()
    {
		$url = $this->generateUrl('rest-get-topics', array(), true);
		
		// we can do it with curl or fsock
		if ($fileData = file_get_contents($url)) {
			$jsonData = json_decode($fileData);

			if (!isset($jsonData->result)) {
				return array(
					'topicId' => 0,
					'topicsList' => $jsonData,
					'articleId' => 0
				);
			}
		}
        
        return array(
            'topicId' => 0,
            'topicsList' => array(),
            'articleId' => 0
        );
    }
}
