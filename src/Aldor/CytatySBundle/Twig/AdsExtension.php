<?php


namespace Aldor\CytatySBundle\Twig;
use Symfony\Component\DependencyInjection\ContainerInterface as ContainerInterface;

class AdsExtension extends \Twig_Extension
{
    protected $container, $ads;



    public function __construct(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->ads = $container->get('aldor.strims.ads');
    }
    public function getName()
    {
        return 'aldor_ads_extension';
    }
  public function renderOne( $container = false)
    {
            $adsEntities = $this->ads->getAds();

        if (count($adsEntities) > 0) {
            return $this->container->get('templating')
                ->render(
                    "AldorCytatySBundle:Ads:single.html.twig",
                    compact("adsEntities", "container")
                );
        }

        return null;
    }
     public function getFunctions()
    {
        return array(
            'aldor_ads' => new \Twig_Function_Method($this, 'renderOne', array('is_safe' => array('html'))),
        );
    }
}

