<?php
// src/Ens/JobeetBundle/Controller/CategoryAdminController.php
namespace Aldor\BackendBundle\Controller;
use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\AdminBundle\Form\FormMapper;
use Aldor\CytatySBundle\Entity\QuotesList;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Aldor\CytatySBundle\Utils\QuotesListMake as QuotesListMake;

use Sonata\AdminBundle\Controller\CRUDController as Controller;

class QuotesListAdminController extends Controller
{


    public function batchActionCalculate(ProxyQueryInterface $selectedModelQuery)
    {
    }
    public function calculateAction(Request $request)

    {        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $quoteList =  $em->getRepository('AldorCytatySBundle:QuotesList')->findOneById($id);
        $minVotes =  $this->container->getParameter('votes_limit');
        $makeList = new QuotesListMake($minVotes,$em);
        $makeList->make($quoteList);


        $datagrid = $this->admin->getDatagrid();
        $formView = $datagrid->getForm()->createView();
            $this->setFlash('sonata_flash_success', 'Lista przeliczona');

        // set the theme for the current Admin Form
        $this->get('twig')->getExtension('form')->renderer->setTheme($formView, $this->admin->getFilterTheme());
        $notice_level = 'success';
        return $this->render($this->admin->getTemplate('list'), array(
            'action'   => 'list',
            'form'     => $formView,
            'datagrid' => $datagrid,
            'flash' => 'OK',
            'notice_level'=>$notice_level
        ));      }



      public function generateAction(Request $request)

    {        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $list = $em->getRepository('AldorCytatySBundle:QuotesList')->findOneById($id);
        $entities = $em->getRepository('AldorCytatySBundle:Quote')->findBy(array('quoteslist'=>$id),array('votes'=>'desc'));

       $responsetext = '';
       $i = 1;
        foreach($entities as $quote)
        {
            $responsetext = $responsetext. $i++.'. *'.$quote->getText().'* <br/> ~'.$quote->getAuthor().'<br/> Dodane przez @'
                    .$quote->getUser().' dnia '.$quote->getDate()->format('H:i:s d.m.Y').'  '.$quote->getVotes()
                    .' [Link](http://strims.pl'.$quote->getUrl().') <br/><br/> ';
        }
        $stats = $list->getStatsHTML();
        $responsetext .=$stats['heading'].'<br/>';
        foreach($stats['items'] as $item)
            $responsetext .=$item.'<br/>';
        $responsetext.=$stats['footer'];
        $response = new Response(
    $responsetext,
    200,
    array('content-type' => 'text/html')
);

$response->setCharset('UTF-8');

        return $response;


    }
protected function setFlash($action, $value)
    {
        $this->container->get('session')->getFlashBag()->set($action, $value);
    }

}
