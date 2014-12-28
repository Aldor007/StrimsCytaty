<?php

namespace Aldor\CytatySBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Aldor\CytatySBundle\Entity\Quote;
use Aldor\CytatySBundle\Entity\QuotesList;
use Aldor\CytatySBundle\Form\SearchQuoteType as SearchQuoteType;
use Aldor\CytatySBundle\Utils\SearchHelper as SearchHelper;
/**
 * Quote controller.
 *
 */
class SearchController extends Controller
{
    /**
     * Lists all Quote entities.
     *
     */
    public function indexAction()
    {
        $request = $this->container->get('request');
        $routeName = $request->get('_route');
        $tmp = (explode('_',$routeName));
         $searching = $tmp[2];
            if($searching === 'author')
                $header = 'po autorze';
            else if($searching === 'text')
                $header = 'fraze';
            else
                $header = 'użytkownika';

          $form   = $this->createForm(new SearchQuoteType($searching));


         return $this->render('AldorCytatySBundle:Search:index.html.twig',
             array('form'=> $form->createView(),'header'=>$header,'searching'=> $searching)

            );
    }
 public function searchAction(Request $request)
        {
         $routeName = $request->get('_route');
         $tmp = (explode('_',$routeName));
        $fieldname = 'Szukaj';
         $searching = $tmp[2];
            if($searching === 'author')
                $header = 'po autorze';
            else if($searching === 'text')
                $header = 'fraze';
            else
                $header = 'użytkownika';
            $form   = $this->createForm(new SearchQuoteType($searching));
            $form->bind($request);//->get($fieldname)));
            $quotes = array();

  if ($form->isValid())
 {

            $em = $this->getDoctrine()->getManager();
            $value = $form->getData('searching');
            $page = $request->get('page');
            $value = $value[$fieldname];
            $quotes = $em->getRepository('AldorCytatySBundle:Quote')->searchPagination($searching,$value);
  $paginator = $this->get('knp_paginator');
        $quotes = $paginator->paginate($quotes,
            $this->get('request')->query->get('page', $page), 10);
        $quotes->setUsedRoute($routeName);


            if($quotes)
            {
                foreach($quotes as $quote )

                if($searching === 'author')
               $quote->setAuthor(SearchHelper::findAndMark($quote->getAuthor(),$value,'<strong>','</strong>'));
                else if($searching === 'text')
                    $quote->setText(SearchHelper::findAndMark($quote->getText(),$value,'<strong>','</strong>'));



                                }

            //return $this->render('AldorCytatySBundle:Search:author.html.twig',array('quotes'=>$quotes,'form'=> $form->createView()));

        }
       return $this->render('AldorCytatySBundle:Search:results.html.twig',array('quotes'=>$quotes,'form'=> $form->createView(),
            'header'=>$header,'searching'=> $searching));

        }

    /**
     * Creates a new Quote entity.
     *
     */
        public function authorAction(Request $request)
        {
         $routeName = $request->get('_route');
         $tmp = (explode('search',$routeName));
           print_r($tmp);

        $searching = $tmp[1];
        $form   = $this->createForm(new SearchQuoteType($searching));
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $author = $form->getData('author');
            $author = $author['author'];
            $qoutes = $em->getRepository('AldorCytatySBundle:Quote')->searchAuthor($author);
            if($qoutes)
            {
                foreach($qoutes as $qoute )
                    $qoute->setAuthor(SearchHelper::findAndMark($qoute->getAuthor(),$author,'<strong>','</strong>'));
            }

            // return $this->redirect($this->generateUrl('quote_show', array('id' => $quote->getId())));
            return $this->render('AldorCytatySBundle:Search:author.html.twig',array('quotes'=>$qoutes,'form'=> $form->createView()));

        }

        }



        public function userAction(Request $request)
        {
        $form = $this->createForm(new SearchQuoteType());
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $author = $form->getData('author');
            $author = $author['author'];
            $qoutes = $em->getRepository('AldorCytatySBundle:Quote')->searchAuthor($author);
            if($qoutes)
            {
                foreach($qoutes as $qoute )
                    $qoute->setAuthor(SearchHelper::findAndMark($qoute->getAuthor(),$author,'<strong>','</strong>'));
            }

            // return $this->redirect($this->generateUrl('quote_show', array('id' => $quote->getId())));
            return $this->render('AldorCytatySBundle:Search:author.html.twig',array('quotes'=>$qoutes,'form'=> $form->createView()));

        }

        }

}
