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

class DefaultController extends Controller
{
    public function indexAction($page)
    {
        $em = $this->getDoctrine()->getManager();
        $quotes = $em->getRepository('AldorCytatySBundle:Quote')->findAll();
         $qb = $em->createQueryBuilder('q')->select('q')->from('AldorCytatySBundle:Quote','q')->add('orderBy', 'q.date DESC');

        $paginator = $this->get('knp_paginator');
        $quotes = $paginator->paginate($qb->getQuery(),
                                $this->get('request')->query->get('page', $page), 10);


        $quotesList = $em->getRepository('AldorCytatySBundle:QuotesList')->getLastQouteList(3);

        return $this->render('AldorCytatySBundle:Default:index.html.twig',
            array('quotes'=>$quotes,
            'quotesList'=>$quotesList));

    }
}
