<?php

namespace Aldor\CytatySBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Aldor\CytatySBundle\Utils\SearchHelper as SearchHelper;


class AjaxController extends Controller
{
        public function textSearchAction(Request $request)
    {
        $value = $request->get('term');
        $em = $this->getDoctrine()->getManager();

        // .... (Search values)
        echo $value;
         $json = array();
        $qoutes = $em->getRepository('AldorCytatySBundle:Quote')->searchAjaxText($value);
            if($qoutes)
            {
                foreach($qoutes as $qoute )
                {
                    //  print_r($qoute);
                    $text = $qoute['text'];



                  $json[] = array(
                'label' => $value,
                'value' => $value
                    );
                }
           }



        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }
  public function searchAction(Request $request)
    {
        $value = $request->get('term');

         $routeName = $request->get('_route');
         $tmp = (explode('_',$routeName));

         $searching = $tmp[2];

            $em = $this->getDoctrine()->getManager();

        // .... (Search values)
         $json = array();
        $qoutes = $em->getRepository('AldorCytatySBundle:Quote')->searchAjax($searching,$value);
            if($qoutes)
            {
                foreach($qoutes as $qoute )
                {
                  //  print_r($qoute);

                  $json[] = array(
                'label' => $qoute[$searching],
                'value' => $qoute[$searching]
                    );
                }
           }



        $response = new Response();
        $response->setContent(json_encode($json));

        return $response;
    }


    }
