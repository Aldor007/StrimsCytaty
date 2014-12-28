<?php
// src/Ens/JobeetBundle/Admin/CategoryAdmin.php

namespace Aldor\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

class QuoteAdmin extends Admin
{

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
             ->add('date')
            ->add('user')
            ->add('url')
            ->add('text')
            ->add('author')
            ->add('upvotes')
            ->add('downvotes')
            ->add('quoteslist')
            ->add('authorcorect')


                   ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('date')
            ->add('user')
            ->add('url')
            ->add('text')
            ->add('author')
            ->add('upvotes')
            ->add('downvotes')
            ->add('quoteslist')
            ->add('authorcorect')

        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {

        $listMapper
            ->addIdentifier('id')
            ->add('user')
            ->add('url')
            ->add('text')
            ->add('author')
               ->add('upvotes')
               ->add('downvotes')
               ->add('quoteslist')
            ->add('authorcorect')


        ;
    }


}
