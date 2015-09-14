<?php

namespace Jakub\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Jakub\TestBundle\Form\Type\TopicType;
use Jakub\TestBundle\Entity\Topic;

class TopicCreateController extends Controller
{
    /**
     * @Route("/create-topic", name="create-topic")
     * 
     * @Template("JakubTestBundle:Topics:create.html.twig")
     */
    public function indexAction(Request $request)
    {
        $topicForm = $this->createForm(
                new TopicType(),
                new Topic(),
                array(
                    'action' => $this->generateUrl('rest-create-topic')
                    )
            );
        
        return array(
            'topicId' => 0,
            'articleId' => 0,
            'topicForm' => $topicForm->createView()
        );
    }
}
