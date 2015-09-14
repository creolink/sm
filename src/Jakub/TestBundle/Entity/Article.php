<?php

namespace Jakub\TestBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;

class Article
{
    /*
     * @Assert\NotBlank
     */
    private $topicId;
    
    private $articleId;
    
    /*
     * @Assert\NotBlank
     * @Assert\Length(max = 255)
     */
    private $articleTitle;
    
    /*
     * @Assert\NotBlank
     * @Assert\Length(max = 255)
     */
    private $articleAuthor;
    
    /*
     * @Assert\NotBlank
     */
    private $articleText;
    
    public function getTopicId()
    {
        return ($this->topicId);
    }
    
    public function setTopicId($topicId)
    {
        $this->topicId = $topicId;
    }
    
    public function getArticleId()
    {
        return ($this->articleId);
    }
    
    public function setArticleId($articleId)
    {
        $this->articleId = $articleId;
    }
    
    public function getArticleTitle()
    {
        return ($this->articleTitle);
    }
    
    public function setArticleTitle($articleTitle)
    {
        $this->articleTitle = $articleTitle;
    }
    
    public function getArticleAuthor()
    {
        return ($this->articleAuthor);
    }
    
    public function setArticleAuthor($articleAuthor)
    {
        $this->articleAuthor = $articleAuthor;
    }
    
    public function getArticleText()
    {
        return ($this->articleText);
    }
    
    public function setArticleText($articleText)
    {
        $this->articleText = $articleText;
    }
}
