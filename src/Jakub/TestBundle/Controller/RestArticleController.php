<?php

namespace Jakub\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\FOSRestController;

use Jakub\TestBundle\Form\Type\ArticleType;
use Jakub\TestBundle\Entity\Article;

class RestArticleController extends FOSRestController
{
    /**
     * @Route(
	 *		"/article/create/{topicId}",
	 *		name="rest-create-article",
	 *		defaults={"topicId" = 0}
	 * )
     * @Method("POST")
     */
    public function saveAction($topicId, Request $request)
    {
        if ($topicId> 0 && ($jsonData = json_decode($request->getContent()))) {
            $conn = $this->get('database_connection');
            $conn->beginTransaction();
            
            try{
                $sql = "INSERT INTO article"
                    ." (topic_id, title, author, text)"
                    ." VALUES"
                    ." (:topic_id, :title, :author, :text)";

                $stmt = $conn->prepare($sql);
                $stmt->bindValue(":topic_id", $topicId);
                $stmt->bindValue(":title", $jsonData->articleTitle);
                $stmt->bindValue(":author", $jsonData->articleAuthor);
                $stmt->bindValue(":text", $jsonData->articleText);
                $stmt->execute();

                // can be used instead of stmt
                //$conn->insert(
                //  'topic',
                //   array(
                //      'topic_id' => $topicId,
                //      'title' => $jsonData->articleTitle,
                //      'author' => $jsonData->articleAuthor,
                //      'text' => $jsonData->articleText
                //   )
                //);

                $conn->commit();
                
                return new JsonResponse(array('result' => 'OK'));
            } catch(Exception $e) {
                $conn->rollback();
                throw $e;
            }
        }

        return new JsonResponse(array('result' => $articleForm->getErrorsAsString()));
    }
    
    /**
     * @Route("/article/delete", name="rest-delete-article", options={"expose"=true})
     * @Method("DELETE")
     */
    public function deleteAction(Request $request)
    {
        if (($jsonData = json_decode($request->getContent())) && $jsonData->articleId > 0) {
            $conn = $this->get('database_connection');
            $conn->beginTransaction();

            try {
                $sql = "DELETE FROM article WHERE id = :id";

                $stmt = $conn->prepare($sql);
                $stmt->bindValue("id", $jsonData->articleId);
                $stmt->execute();

                $conn->commit();
                return new JsonResponse(array('result' => 'OK'));
            } catch(Exception $e) {
                $conn->rollback();
                throw $e;
            }
        }
        
        return new JsonResponse(array('result' => 'ERROR'));
    }
    
    /**
     * @Route("/article/{articleId}", name="rest-get-article", options={"expose"=true})
     * @Method("GET")
     */
    public function getAction($articleId)
    {
        if ($articleId > 0) {
            try {
                $conn = $this->get('database_connection');
                
                // articles
                $sql = "SELECT"
                    ." a.title AS ArtTitle, a.author AS ArtAuthor, a.text AS ArtText,"
                    ." t.title AS TpcTitle"
                    ." FROM article a"
                    ." LEFT JOIN topic t ON t.id = a.topic_id"
                    ." WHERE a.id = :id";
                $articleData = $conn->fetchAssoc($sql, array(':id' => $articleId));

                return new JsonResponse($articleData);
            } catch (Exception $ex) {
                throw $e;
            }
        }
        
        return new JsonResponse(array('result' => 'ERROR'));
    }
}
