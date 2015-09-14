<?php

namespace Jakub\TestBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Topic
{
    private $topicId;
    
    /*
     * @Assert\NotBlank()
     * @Assert\Length(min = 1, max = 255)
     */
    private $topicTitle;
    
    private $topicArticles;
    
    public function getTopicId()
    {
        return ($this->topicId);
    }
    
    public function setTopicId($topicId)
    {
        $this->topicId = $topicId;
    }
    
    public function getTopicTitle()
    {
        return ($this->topicTitle);
    }
    
    public function setTopicTitle($topicTitle)
    {
        $this->topicTitle = $topicTitle;
    }
    
    public function getTopicArticles()
    {
        return ($this->topicArticles);
    }
    
    public function setTopicArticles($topicArticles)
    {
        $this->topicArticles = $topicArticles;
    }
}
