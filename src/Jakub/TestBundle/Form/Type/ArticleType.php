<?php

namespace Jakub\TestBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('articleTitle', 'text', array('label' => 'Title:'));
        $builder->add('articleAuthor', 'text', array('label' => 'Author:'));
        $builder->add('articleText', 'textarea', array('label' => 'Text:'));
        $builder->add('save', 'submit', array('label' => 'Save article'));
    }

    public function getName()
    {
        return 'article';
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jakub\TestBundle\Entity\Article',
            //'csrf_protection'   => false,
        ));
    }
}