<?php
// src/Ens/JobeetBundle/Admin/CategoryAdmin.php

namespace Aldor\BackendBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;

use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\ValidatorInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Acl\Model\DomainObjectInterface;


use Sonata\AdminBundle\Admin\Pool;
use Sonata\AdminBundle\Validator\Constraints\InlineConstraint;

use Sonata\AdminBundle\Translator\LabelTranslatorStrategyInterface;
use Sonata\AdminBundle\Builder\FormContractorInterface;
use Sonata\AdminBundle\Builder\ListBuilderInterface;
use Sonata\AdminBundle\Builder\DatagridBuilderInterface;
use Sonata\AdminBundle\Builder\ShowBuilderInterface;
use Sonata\AdminBundle\Builder\RouteBuilderInterface;
use Sonata\AdminBundle\Route\RouteGeneratorInterface;

use Sonata\AdminBundle\Security\Handler\SecurityHandlerInterface;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Model\ModelManagerInterface;

use Knp\Menu\FactoryInterface as MenuFactoryInterface;
use Knp\Menu\ItemInterface as MenuItemInterface;


class QuotesListAdmin extends Admin
{
 protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
             ->add('startdate')
            ->add('enddate')
            ->add('quotecount')
            ->add('stats')

                   ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
               ->add('startdate')
            ->add('enddate')
            ->add('quotecount')
            ->add('stats')
        ;
    }


/**
 * @param \Symfony\Component\Security\Core\SecurityContextInterface $securityContext
 */
public function setSecurityContext(SecurityContextInterface $securityContext)
{
    $this->securityContext = $securityContext;
}


protected function configureRoutes(RouteCollection $collection)
{
    $collection->add('calculate');
     $collection->add('generate');

}

# Override to add actions like delete, etc...
public function getBatchActions()
{
    // retrieve the default (currently only the delete action) actions
    $actions = parent::getBatchActions();

    // check user permissions
    if($this->hasRoute('edit') && $this->isGranted('EDIT') && $this->hasRoute('create') && $this->isGranted('CREATE'))
    {
        // define calculate action
        $actions['calculate']= array ('label' => 'Calculate', 'ask_confirmation'  => false );
        $actions['generate']= array ('label' => 'Generuj', 'ask_confirmation'  => false );

    }

    return $actions;
}

protected function configureListFields(ListMapper $listMapper)
{
    $listMapper
        ->addIdentifier('enddate')
              ->add('startdate')
            ->add('quotecount')
            ->add('stats')
        ->add('_action', 'actions', array(
            'actions' => array(
                'view' => array(),
                'calculate' => array('template' => 'AldorBackendBundle:CRUD:list__action_calculate.html.twig'),
                  'generate' => array('template' => 'AldorBackendBundle:CRUD:list__action_generate.html.twig'),
                'edit' => array(),
            )
        ))


    ;
}
}

