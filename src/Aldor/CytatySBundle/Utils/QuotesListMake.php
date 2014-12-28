<?php
namespace Aldor\CytatySBundle\Utils;
use Aldor\CytatySBundle\Entity\QuotesList as QuotesList;

 class  QuotesListMake
{
    protected $minVotes;
    protected $em;



        public function __construct($minvotes,$em)
        {
            $this->set($minvotes,$em);
        }
    public function set($minvotes,$em)
    {
        $this->minVotes = $minvotes;
        $this->em = $em;
    }
    public function make( QuotesList $quoteList)
    {

     $entities = $this->em->getRepository('AldorCytatySBundle:Quote')->getQuoteToList($quoteList->getStartdate(),$quoteList->getEnddate());
        $quotesCount = 0;
        $votes = array();
        $quotesinlistcount = 0;
        foreach($entities as $quote)
        {
            if($quote->getVotes()>$this->minVotes)
            {
                $quote->setQuoteslist($quoteList);
                $this->em->persist($quote);
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
        $stats =  array('OnList'=>$quotesinlistcount,'All'=>$quotesCount,'Items'=>array(),'Averge'=>'0');

        foreach($votes as $vote => $occurr)
        {
            array_push($stats['Items'],array('votes'=>$vote,'occurr'=>$occurr));
            $averge = $averge + intval($vote)*intval($occurr);
        }
        $averge = round($averge/$quotesCount,2);
        $stats['Averge']=$averge;

        $quoteList->setStats(json_encode($stats));

          $this->em->persist($quoteList);
        $this->em->flush();



        }
}


