<?php

namespace Jakub\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Jakub\TestBundle\Form\Type\ArticleType;
use Jakub\TestBundle\Entity\Article;

class ArticleCreateController extends Controller
{
    /**
     * @Route("/create-article/{topicId}", name="create-article")
     * 
     * @Template("JakubTestBundle:Articles:create.html.twig")
     */
    public function indexAction($topicId, Request $request)
    {
        $articleForm = $this->createForm(
                new ArticleType(),
                new Article(),
                array(
                    'action' => $this->generateUrl('create-article', array('topicId' => $topicId))
                    )
            );
        $articleForm->handleRequest($request);
        
        if ($articleForm->isValid()) {
            $encoders = array(new JsonEncoder());
            $normalizers = array(new ObjectNormalizer());
            $serializer = new Serializer($normalizers, $encoders);
            $jsonData = $serializer->serialize($articleForm->getData(), 'json');
            
            $url = $this->generateUrl('rest-create-article', array('topicId' => $topicId), true);
            
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData))
            );
            
            //print_r(array($url, $jsonData)); die();
            
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
        }
        
        return array(
            'topicId' => $topicId,
            'articleId' => 0,
            'articleForm' => $articleForm->createView()
        );
    }
}
