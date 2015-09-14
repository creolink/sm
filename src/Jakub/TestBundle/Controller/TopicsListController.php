<?php

namespace Jakub\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $conn = $this->get('database_connection');
        
        $sql = "SELECT * FROM topic";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $topicsList = $stmt->fetchAll();
        
        return array(
            'topicId' => 0,
            'topicsList' => $topicsList,
            'articleId' => 0
        );
    }
}
