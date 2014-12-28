<?php
// src/Ens/JobeetBundle/Controller/CategoryAdminController.php
namespace Aldor\BackendBundle\Controller;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class QuoteAdminController extends Controller
{
     // setup the default sort column and order

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
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

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
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

    protected function configureListFields(ListMapper $listMapper)
    {

        $listMapper
            ->addIdentifier('date')
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
}
