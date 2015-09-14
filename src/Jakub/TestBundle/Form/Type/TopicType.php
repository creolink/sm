<?php

namespace Jakub\TestBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('topicTitle', 'text', array('label' => 'Title:'));
        $builder->add('save', 'submit', array('label' => 'Save topic'));
    }

    public function getName()
    {
        return '';
    }
    
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Jakub\TestBundle\Entity\Topic',
            'csrf_protection'   => false,
            'cascade_validation' => true
        ));
    }
}