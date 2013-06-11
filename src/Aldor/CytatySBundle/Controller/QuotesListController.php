<?php

namespace Aldor\CytatySBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\CssSelector\CssSelector;
use Symfony\Component\HttpFoundation\Response;
use Aldor\CytatySBundle\Entity\Quote;
use Aldor\CytatySBundle\Entity\QuotesList;
use Aldor\CytatySBundle\Utils\DateHelper as DateHelper;
use Aldor\CytatySBundle\Utils\AuthorParser as AuthorParser;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

class QuotesListController extends Controller
{
    public function showAction($id,$page)
    {



        $em = $this->getDoctrine()->getManager();

       $qb = $em->createQueryBuilder('q')->select('q')->from('AldorCytatySBundle:Quote','q')->where('q.quoteslist = :value')->setParameter('value',$id)->add('orderBy', 'q.votes DESC');
        $quotesList =  $em->getRepository('AldorCytatySBundle:QuotesList')->findById($id);

        $paginator = $this->get('knp_paginator');
        $quotes = $paginator->paginate($qb->getQuery(),
                          $this->get('request')->query->get('page', $page), 10);
        if(!$quotesList)
            throw $this->createNotFoundException('Unable to find Quote entity.');
        return $this->render('AldorCytatySBundle:QuotesList:show.html.twig',
            array('quotes'=>$quotes,
            'quoteslist' => $quotesList[0]
            ));

    }
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
         $qb = $em->createQueryBuilder('q')->select('q')->from('AldorCytatySBundle:QuotesList','q')->add('orderBy', 'q.id DESC');

        $paginator = $this->get('knp_paginator');
        $quotesList = $paginator->paginate($qb->getQuery(),
                                $this->get('request')->query->get('page', $page), 10);

        if(!$quotesList)
            throw $this->createNotFoundException('Unable to find Quote entity.');
        return $this->render('AldorCytatySBundle:QuotesList:index.html.twig',
            array( 'quoteslist' => $quotesList
            ));

    }

}
