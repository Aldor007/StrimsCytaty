<?php
// src/Ens/JobeetBundle/Admin/CategoryAdmin.php

namespace Aldor\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class AdsAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('type','choice', array(
    'choices'   => array(
        'image'   => 'image',
        'script' => 'script',
    ),))
            ->add('value')
            ->add('onstatus')
            ->add('weight','integer',array('data'=>1))

                   ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('type')
            ->add('value')
            ->add('onstatus')
            ->add('weight')

        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {

        $listMapper
               ->add('date')
            ->addIdentifier('name')
            ->add('type')
            ->add('value')
            ->add('onstatus')
            ->add('weight')


        ;
    }


}
