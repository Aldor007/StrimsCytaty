<?php
// src/Acme/DemoBundle/Command/GreetCommand.php
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
use Aldor\CytatySBundle\Utils\QuotesListMake as QuotesListMake;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

class QuotelistCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('quotelist:make')
            ->setDescription('Tworzy liste')
            ->addArgument('minvotes', InputArgument::OPTIONAL, 'Minmum')

        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $i =0;
             $em  = $this->getContainer()->get('doctrine')->getManager();
       $quoteList = new QuotesList();
        $quoteList->setStartdate(new \DateTime('- 7 day'));
        $quoteList->setEnddate(new \DateTime());
        $minVotes = $input->getArgument('minvotes');
        if(!$minVotes)
            $minVotes =  $this->getContainer()->getParameter('votes_limit');
        $makeList = new QuotesListMake($minVotes,$em);
        $makeList->make($quoteList);



    }
}
