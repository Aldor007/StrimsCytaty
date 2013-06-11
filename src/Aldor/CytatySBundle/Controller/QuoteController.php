<?php

namespace Aldor\CytatySBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Aldor\CytatySBundle\Entity\Quote;
use Aldor\CytatySBundle\Entity\QuotesList;
use Aldor\CytatySBundle\Form\QuoteType;

/**
 * Quote controller.
 *
 */
class QuoteController extends Controller
{
    /**
     * Lists all Quote entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $quoteList = new QuotesList();
        $quoteList->setStartdate(new \DateTime('- 7 day'));
        $quoteList->setEnddate(new \DateTime());
               $minVotes = $this->container->getParameter('votes_limit');




        $entities = $em->getRepository('AldorCytatySBundle:Quote')->getQuoteToList($quoteList->getStartdate(),$quoteList->getEnddate(),30);
        $quotesCount = 0;
        foreach($entities as $quote)
        {
            if($quote->getVotes()>$minVotes)
            {
                $quote->setQouteslist($quoteList);
                $em->persist($quote);


            }
            $quotesCount++;
        }
             $quoteList->setQuotecount($quotesCount);

          $em->persist($quoteList);
        $em->flush();

        return $this->render('AldorCytatySBundle:Quote:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * Creates a new Quote entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity  = new Quote();
        $form = $this->createForm(new QuoteType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('quote_show', array('id' => $entity->getId())));
        }

        return $this->render('AldorCytatySBundle:Quote:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to create a new Quote entity.
     *
     */
    public function newAction()
    {
        $entity = new Quote();
        $form   = $this->createForm(new QuoteType(), $entity);

        return $this->render('AldorCytatySBundle:Quote:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Quote entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AldorCytatySBundle:Quote')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Quote entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AldorCytatySBundle:Quote:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Quote entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AldorCytatySBundle:Quote')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Quote entity.');
        }

        $editForm = $this->createForm(new QuoteType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('AldorCytatySBundle:Quote:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Quote entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('AldorCytatySBundle:Quote')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Quote entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new QuoteType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('quote_edit', array('id' => $id)));
        }

        return $this->render('AldorCytatySBundle:Quote:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Quote entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('AldorCytatySBundle:Quote')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Quote entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('quote'));
    }

    /**
     * Creates a form to delete a Quote entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
