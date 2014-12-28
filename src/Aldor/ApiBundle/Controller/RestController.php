<?php
namespace Aldor\ApiBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Aldor\CytatySBundle\Entity\Quote;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;

/**
 * Order controller.
 *
 */
class RestController extends  Controller
{

    /**
     * @Rest\View
     *
     * This the documentation description of your method, it will appear
     * on a specific pane. It will read all the text until the first
     * annotation.
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Zwraca losowy cytaty",
     *  filters={
     *      {"name"="date", "dataType"="datetime"},
     *      {"name"="user", "dataType"="string"},
     *      {"name"="text", "dataType"="string"},
     *      {"name"="author", "dataType"="string"},
     *      {"name"="upvotes", "dataType"="int"},
     *      {"name"="downvotes", "dataType"="int"},
     *      {"name"="votes", "dataType"="int"},
     *  }
     * )
     * @Rest\View
     * */
    public function randomAction()
    {
        $em = $this->getDoctrine()->getManager();

        $quote = $em->getRepository('AldorCytatySBundle:Quote')->getRandom();
         if (!$quote)
           throw new NotFoundHttpException('Quote not found');

        $serializedEntity = $this->container->get('serializer')->serialize($quote, 'json');

        return new Response($serializedEntity);
    }
}
