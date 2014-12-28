<?php

namespace Aldor\CytatySBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\CssSelector\CssSelector;
use Symfony\Component\HttpFoundation\Response;
use Aldor\CytatySBundle\Entity\Quote;
use Aldor\CytatySBundle\Entity\QuotesList;
use Symfony\Component\DependencyInjection\ContainerInterface as ContainerInterface;

class AdsController
{


protected $container, $ads;



    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
            }


    public function getAds()
    {
        $em = $this->container->get('doctrine')->getManager();
        $ads = $em->getRepository('AldorCytatySBundle:Ads')->getOneAds();
        if($ads ==null)
            return null;

        return $ads[0];
    }
}
