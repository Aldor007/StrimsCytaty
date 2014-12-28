<?php
namespace Aldor\CytatySBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\CssSelector\CssSelector;
use Symfony\Component\HttpFoundation\Response;
use Aldor\CytatySBundle\Entity\Quote;
use Aldor\CytatySBundle\Entity\QuotesList;
use Aldor\CytatySBundle\Utils\QuoteParser as QuoteParser;
use Aldor\CytatySBundle\Utils\AuthorParser as AuthorParser;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

class QuoteCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('quote:collect')
            ->setDescription('Dodaje cytaty do bazy')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

              $em  = $this->getContainer()->get('doctrine')->getManager();
        $parse = new QuoteParser('http://strims.pl/s/Cytaty/wpisy/',$em);
        $parse->select('ul.entries>li>div.entry');

    }
}
