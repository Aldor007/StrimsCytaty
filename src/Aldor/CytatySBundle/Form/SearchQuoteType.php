<?php

namespace Aldor\CytatySBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SearchQuoteType extends AbstractType
{
     private $fieldname;
     public function   __construct($name = 'author')
     {
         $this->fieldname = $name;
     }
      public function getDefaultOptions(array $options)
    {
        $options = parent::getDefaultOptions($options);
        $options['csrf_protection'] = false;

        return $options;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('Szukaj','genemu_jqueryautocomplete_entity', array(
                'route_name' => 'ajax_search_'.$this->fieldname,
                'class' => 'Aldor\CytatySBundle\Entity\Quote',
            'csrf_protection'   => false,

        ));        ;
    }
    private function translatefieldname($field)
    {
   if($searching === 'author')
                $header = 'autor';
            else if($searching === 'intext')
                $header = 'fraza';
            else
                $header = 'uzytkownik';


    }

    public function getName()
    {
        return 'searching';//.$this->fieldname;
    }
}
