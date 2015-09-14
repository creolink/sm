<?php

namespace Jakub\TestBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\FOSRestController;

use Jakub\TestBundle\Form\Type\TopicType;
use Jakub\TestBundle\Entity\Topic;

class RestTopicController extends FOSRestController
{
    /**
     * @Route("/topic/create", name="rest-create-topic", options={"expose"=true})
     * @Method("POST")
     */
    public function saveAction(Request $request)
    {
        $topicForm = $this->createForm(new TopicType(), new Topic());
        $topicForm->handleRequest($request);
        
        if ($topicForm->isValid()) {
            $jsonData = json_decode($request->getContent());
            
            $conn = $this->get('database_connection');
            $conn->beginTransaction();
            
            try {
                $sql = "INSERT INTO topic"
                    ." (title)"
                    ." VALUES"
                    ." (:title)";

                $stmt = $conn->prepare($sql);
                $stmt->bindValue("title", $jsonData->topicTitle);
                $stmt->execute();

                //$conn->insert('topic', array('title' => $jsonData->topicTitle)); // can be used instead of stmt

                $conn->commit();
                
                return new JsonResponse(array('result' => 'OK'));
            } catch(Exception $e) {
                $conn->rollback();
                throw $e;
            }
        }
        
        return new JsonResponse(array('result' => $topicForm->getErrorsAsString()));
    }
    
    /**
     * @Route("/topic/delete/{topicId}", name="rest-delete-topic", options={"expose"=true})
     * @Method("GET")
     */
    public function deleteAction($topicId)
    {
        $conn = $this->get('database_connection');
        $conn->beginTransaction();
        
        try {
            $sql = "DELETE FROM topic WHERE id = :id";

            $stmt = $conn->prepare($sql);
            $stmt->bindValue("id", $topicId);
            $stmt->execute();

            //$conn->delete('topic', array('id' => $topicId)); // can be used instead of stmt

            $conn->commit();
        } catch(Exception $e) {
            $conn->rollback();
            throw $e;
        }
            
        return $this->redirect($this->generateUrl('topics-list'));
    }
    
    /**
     * @Route("/topic/{topicId}", name="rest-get-topic", options={"expose"=true})
     * @Method("GET")
     */
    public function getAction($topicId)
    {
        if ($topicId > 0) {
            try {
                $conn = $this->get('database_connection');

                // topic data
                $sql = "SELECT * FROM topic WHERE id = :id";
                $topicData = $conn->fetchAssoc($sql, array(':id' => $topicId));

                // articles
                $sql = "SELECT * FROM article WHERE topic_id = :topic_id";
                $stmt = $conn->prepare($sql);
                $stmt->bindValue("topic_id", $topicId);
                $stmt->execute();
                $articlesList = $stmt->fetchAll();
                
                $jsonData = array(
                        'topicData' => $topicData,
                        'articlesList' => $articlesList
                    );

                return new JsonResponse($jsonData);
            } catch (Exception $ex) {
                throw $e;
            }
        }
        
        return new JsonResponse(array('result' => 'ERROR'));
    }
}
