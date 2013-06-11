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
use Aldor\CytatySBundle\Utils\DateHelper as DateHelper;
use Aldor\CytatySBundle\Utils\AuthorParser as AuthorParser;
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




        $entities = $em->getRepository('AldorCytatySBundle:Quote')->getQuoteToList($quoteList->getStartdate(),$quoteList->getEnddate());
        $quotesCount = 0;
        $votes = array();
        $quotesinlistcount = 0;
        foreach($entities as $quote)
        {
            if($quote->getVotes()>$minVotes)
            {
                $quote->setQuoteslist($quoteList);
                $em->persist($quote);
                if(isset($votes[$quote->getVotes()] ))
                    $votes[$quote->getVotes()] = $votes[$quote->getVotes()] +1 ;
                else
                    $votes[$quote->getVotes()] = 1;
                $quotesinlistcount++;


            }
            $quotesCount++;
        }
        $quoteList->setQuotecount($quotesCount);
        $averge = 0;
        $stats = "Wpisów $quotesinlistcount".'/'."$quotesCount <br/>";
        foreach($votes as $vote => $occurr)
        {
            $stats = $stats."Wpis $vote wystąpił $occurr razy <br/> ";
            $averge = $averge + intval($vote)*intval($occurr);
        }
        $averge = round($averge/$quotesCount,2);
        $stats .= "Średnia: $averge";
        $quoteList->setStats($stats);

          $em->persist($quoteList);
        $em->flush();

    }
}
