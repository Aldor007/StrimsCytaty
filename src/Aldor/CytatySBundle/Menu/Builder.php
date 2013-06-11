<?php

/**
 * This file is part of BraincraftedBootstrapDemoBundle.
 * (c) 2012 Florian Eckerstorfer
 */

namespace Aldor\CytatySBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Aldor\CytatySBundle\Entity\Quote;
use Aldor\CytatySBundle\Entity\QuotesList;

/**
 * Builder
 *
 * @category   MenuBuilder
 * @package    BraincraftedBootstrapBundle
 * @subpackage Menu
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2012 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @link       http://bootstrap.braincrafted.com Bootstrap for Symfony2
 */
class Builder extends ContainerAware
{
    /**
     * Builds the navbar menu.
     *
     * @param \Knp\Menu\FactoryInterface $factory The menu factory
     * @param array                      $options The options array
     *
     * @return \Knp\Menu\ItemInterface The root item
     */
    public function navbar(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => 'aldor_homepage'));
        $item = $menu->addChild('Cytaty', array('route' => 'aldor_quote'));
        $item->setAttribute('dropdown', true);

        $item->addChild('Listy',array('route'=>'aldor_qouteslistindex'));
        $item2 = $item->addChild('Wyszukaj')->setAttributes(array('dropdown'=> true,'class'=>'dropdown'));

        $item2->setAttribute('dropdown', true);
        $item2->addChild('Wyszukaj po autorze', array('route'=>'aldor_search_author'));
        $item2->addChild('Wyszukaj po uzytkowniku', array('route'=>'aldor_search_user'));
        $item2->addChild('Wyszukaj frazę', array('route'=>'aldor_search_text'));
          return $menu;

    }

    /**
     * Builds the navList menu.
     *
     * @param \Knp\Menu\FactoryInterface $factory The menu factory
     * @param array                      $options The options array
     *
     * @return \Knp\Menu\ItemInterface The root item
     */
    public function navList(FactoryInterface $factory, array $options)
    {


        $em  = $this->container->get('doctrine')->getManager();
      $quotesList = $em->getRepository('AldorCytatySBundle:QuotesList')->getLastQouteList(3);
        $menu = $factory->createItem('root');
        $i = 0;
        foreach( $quotesList as $list)
        $menu ->addChild($i++.' Lista z '.  $list->getEnddate()->format('m d'),array('route' =>'aldor_quoteslist','routeParameters' => array('id' => $list->getId())));

        return $menu;
    }
public function navListSearch(FactoryInterface $factory, array $options)
    {


        $menu = $factory->createItem('root');

        $menu->addChild('Wyszukaj po autorze', array('route' => 'aldor_search_author'));

         $menu->addChild('Wyszukaj po użytkowniku', array('route' => 'aldor_search_user'));
        $menu->addChild('Wyszukaj fraze', array('route' => 'aldor_search_text'));
        $menu->setCurrentUri($this->container->get('request')->getRequestUri());

        return $menu;
    }

    /**
     * Builds the navListIcons menu.
     *
     * @param \Knp\Menu\FactoryInterface $factory The menu factory
     * @param array                      $options The options array
     *
     * @return \Knp\Menu\ItemInterface The root item
     */
    public function navListIcons(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $item = $menu->addChild('List Header');
        $item->addChild('.icon-home Home', array('uri' => '#'));
        $item->addChild('.icon-book Library', array('uri' => '#'));
        $item->addChild('.icon-briefcase Applications', array('uri' => '#'));
        $item = $menu->addChild('Another List Header');
        $item->addChild('.icon-user Profile', array('uri' => '#'));
        $item->addChild('.icon-cog Settings', array('uri' => '#'));
        $menu->addChild('d1', array('attributes' => array('divider' => true)));
        $menu->addChild('.icon-question-sign Help', array('uri' => '#'));

        return $menu;
    }

    /**
     * Builds the basic tabs menu.
     *
     * @param \Knp\Menu\FactoryInterface $factory The menu factory
     * @param array                      $options The options array
     *
     * @return \Knp\Menu\ItemInterface The root item
     */
    public function basicTabs(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $item = $menu->addChild('Home', array('uri' => '#'));
        $item->setCurrent(true);
        $item = $menu->addChild('Profile', array('uri' => '#'));
        $item = $menu->addChild('Messages', array('uri' => '#'));

        return $menu;
    }

    /**
     * Builds the basic pills menu.
     *
     * @param \Knp\Menu\FactoryInterface $factory The menu factory
     * @param array                      $options The options array
     *
     * @return \Knp\Menu\ItemInterface The root item
     */
    public function basicPills(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $item = $menu->addChild('Home', array('uri' => '#'));
        $item->setCurrent(true);
        $item = $menu->addChild('Profile', array('uri' => '#'));
        $item = $menu->addChild('Messages', array('uri' => '#'));

        return $menu;
    }

    /**
     * Builds the disabled state menu.
     *
     * @param \Knp\Menu\FactoryInterface $factory The menu factory
     * @param array                      $options The options array
     *
     * @return \Knp\Menu\ItemInterface The root item
     */
    public function disabledState(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $item = $menu->addChild('Clickable link 1', array('uri' => '#'));
        $item = $menu->addChild('Clickable link 2', array('uri' => '#'));
        $item = $menu->addChild('Disabled link', array(
            'uri'           => '#',
            'attributes'    => array('class' => 'disabled')
        ));

        return $menu;
    }

    /**
     * Builds the pull right menu.
     *
     * @param \Knp\Menu\FactoryInterface $factory The menu factory
     * @param array                      $options The options array
     *
     * @return \Knp\Menu\ItemInterface The root item
     */
    public function pullRight(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $item = $menu->addChild('Link 1', array('uri' => '#'));
        $item = $menu->addChild('Link 2', array('uri' => '#'));
        $item = $menu->addChild('Link 3', array(
            'uri'           => '#',
            'attributes'    => array('class' => 'pull-right')
        ));

        return $menu;
    }

    /**
     * Builds the stacked tabs menu.
     *
     * @param \Knp\Menu\FactoryInterface $factory The menu factory
     * @param array                      $options The options array
     *
     * @return \Knp\Menu\ItemInterface The root item
     */
    public function stackedTabs(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $item = $menu->addChild('Home', array('uri' => '#'));
        $item->setCurrent(true);
        $item = $menu->addChild('Profile', array('uri' => '#'));
        $item = $menu->addChild('Messages', array('uri' => '#'));

        return $menu;
    }

    /**
     * Builds the stacked pills menu.
     *
     * @param \Knp\Menu\FactoryInterface $factory The menu factory
     * @param array                      $options The options array
     *
     * @return \Knp\Menu\ItemInterface The root item
     */
    public function stackedPills(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

         $menu->addChild('Ho5me', array('route' => 'aldor_homepage'));
        $menu->addChild('Get 5started', array('route' => 'aldor_quote'));
        return $menu;
    }

    /**
     * Builds the tabs with dropdown menu.
     *
     * @param \Knp\Menu\FactoryInterface $factory The menu factory
     * @param array                      $options The options array
     *
     * @return \Knp\Menu\ItemInterface The root item
     */
    public function tabsDropdown(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $item = $menu->addChild('Home', array('uri' => '#'));
        $item->setCurrent(true);
        $item = $menu->addChild('Help', array('uri' => '#'));
        $dropdown = $menu->addChild('Dropdown');
            $dropdown->addChild('Action', array('uri' => '#'));
            $dropdown->addChild('Another action', array('uri' => '#'));
            $dropdown->addChild('Something else here', array('uri' => '#'));
            $dropdown->addChild('d1', array('attributes' => array('divider' => true)));
            $dropdown->addChild('Separated link', array('uri' => '#'));

        return $menu;
    }

    /**
     * Builds the pills with dropdown menu.
     *
     * @param \Knp\Menu\FactoryInterface $factory The menu factory
     * @param array                      $options The options array
     *
     * @return \Knp\Menu\ItemInterface The root item
     */
    public function pillsDropdown(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Home', array('route' => 'aldor_homepage'));
        $menu->addChild('Get started', array('route' => 'aldor_quote'));
        $dropdown = $menu->addChild('Dropdown');
            $dropdown->addChild('Action', array('route' => 'aldor_homepage'));


        return $menu;
    }

    /**
     * Builds the basic navbar menu.
     *
     * @param \Knp\Menu\FactoryInterface $factory The menu factory
     * @param array                      $options The options array
     *
     * @return \Knp\Menu\ItemInterface The root item
     */
    public function basicNavbar(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $item = $menu->addChild('Home', array('uri' => '#'));
        $item->setCurrent(true);
        $item = $menu->addChild('Link 1', array('uri' => '#'));
        $item = $menu->addChild('Link 2', array('uri' => '#'));

        return $menu;
    }

    /**
     * Builds the navbar with divider menu.
     *
     * @param \Knp\Menu\FactoryInterface $factory The menu factory
     * @param array                      $options The options array
     *
     * @return \Knp\Menu\ItemInterface The root item
     */
    public function dividerNavbar(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $item = $menu->addChild('Home', array('uri' => '#'));
        $item->setCurrent(true);
        $item = $menu->addChild('d1', array('attributes' => array('divider' => true)));
        $item = $menu->addChild('Link 1', array('uri' => '#'));
        $item = $menu->addChild('d2', array('attributes' => array('divider' => true)));
        $item = $menu->addChild('Link 2', array('uri' => '#'));

        return $menu;
    }

    /**
     * Builds the responsive navbar menu.
     *
     * @param \Knp\Menu\FactoryInterface $factory The menu factory
     * @param array                      $options The options array
     *
     * @return \Knp\Menu\ItemInterface The root item
     */
    public function responsiveNavbar(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $item = $menu->addChild('Home', array('uri' => '#'));
        $item->setCurrent(true);
        $menu->addChild('Link 1', array('uri' => '#'));
        $menu->addChild('Link 2', array('uri' => '#'));
        $dropdown = $menu->addChild('Dropdown');
        $dropdown->addChild('Action', array('uri' => '#'));
        $dropdown->addChild('Another action', array('uri' => '#'));
        $dropdown->addChild('Something else here', array('uri' => '#'));
        $dropdown->addChild('d1', array('attributes' => array('divider' => true)));
        $subDropdown = $dropdown->addChild('Nav header');
        $subDropdown->addChild('Separated link', array('uri' => '#'));
        $subDropdown->addChild('One more separated link', array('uri' => '#'));


        return $menu;
    }

    /**
     * Builds the right responsive navbar menu.
     *
     * @param \Knp\Menu\FactoryInterface $factory The menu factory
     * @param array                      $options The options array
     *
     * @return \Knp\Menu\ItemInterface The root item
     */
    public function responsiveNavbarRight(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');

        $menu->addChild('Link', array('uri' => '#'));
        $menu->addChild('d1', array('attributes' => array('divider' => true)));
        $dropdown = $menu->addChild('Dropdown');
        $dropdown->addChild('Action', array('uri' => '#'));
        $dropdown->addChild('Another action', array('uri' => '#'));
        $dropdown->addChild('Something else here', array('uri' => '#'));
        $dropdown->addChild('d1', array('attributes' => array('divider' => true)));
        $dropdown->addChild('Separated link', array('uri' => '#'));

        return $menu;
    }
}
