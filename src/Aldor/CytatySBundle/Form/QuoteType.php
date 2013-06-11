<?php

namespace Aldor\CytatySBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class QuoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('data')
            ->add('user')
            ->add('url')
            ->add('text')
            ->add('author')
            ->add('like')
            ->add('dislike')
            ->add('qouteslist')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Aldor\CytatySBundle\Entity\Quote'
        ));
    }

    public function getName()
    {
        return 'aldor_cytatysbundle_quotetype';
    }
}
