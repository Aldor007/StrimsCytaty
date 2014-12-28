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

class QuoteVotesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('quote:votes:update')
            ->setDescription('Uaktualnia glosy w bazie')
            ->addArgument(
                'date',
                InputArgument::OPTIONAL,
                'date from'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $i =0;
        $document = new \DOMDocument();



          $em  = $this->getContainer()->get('doctrine')->getManager();
        $date = $input->getArgument('date');
        print_r($date);
        if($date != null )
            $quotes = $em->getRepository('AldorCytatySBundle:Quote')->getQuotesAfter(new \DateTime('- 7 day'));
        else
        $quotes = $em->getRepository('AldorCytatySBundle:Quote')->findAll();


        foreach($quotes as $quote)
        {

            $document->loadHTMLFile('http://strims.pl'.$quote->getUrl());
        $xpath = new \DOMXPath($document);
                   $name = '';
        $page = $xpath->query(CssSelector::toXpath('div.entry'));
        if($page != null)
        foreach ($page as $node)
        {
            // printf("%s (%s)\n", $node->nodeValue, $node->getAttribute('id'));
                $like =  $xpath->query(CssSelector::toXpath('a.like>span.entry_vote_count'),$node)->item(0)->nodeValue;
            $dislike =  $xpath->query(CssSelector::toXpath('a.dislike>span.entry_vote_count'),$node)->item(0)->nodeValue;
                     $quote->setUpvotes($like);
            $quote->setDownvotes($dislike);
            $quote->setVotes($like-$dislike);

                   $em->persist($quote);

        }
        else
        {
            $em-remove($quote);
        }
        }
    $em->flush();

    }
}
