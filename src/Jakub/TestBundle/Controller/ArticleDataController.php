<?php

namespace Jakub\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ArticleDataController extends Controller
{
    /**
     * @Route(
     *      "/article-data/{topicId}/{articleId}",
     *       name="article-data",
     *       options={"expose"=true},
     *       defaults={"topicId" = 0, "articleId" = 0}
     * )
     * 
     * @Template("JakubTestBundle:Articles:data.html.twig")
     */
    public function indexAction($topicId, $articleId)
    {
        if ($topicId > 0)
        {
            if ($articleId > 0) {
                $url = $this->generateUrl('rest-get-article', array('articleId' => $articleId), true);
                
                // we can do it with curl or fsock
                if ($fileData = file_get_contents($url)) {
                    $jsonData = json_decode($fileData, true);

                    return array(
                        'topicId' => $topicId,
                        'articleId' => $articleId,
                        'data' => $jsonData
                    );
                }
            }

            return $this->redirect(
                    $this->generateUrl(
                            'articles-list', 
                            array('topicId' => $topicId)
                        )
                );
        }
        
        return $this->redirect($this->generateUrl('topics-list'));
    }
}
