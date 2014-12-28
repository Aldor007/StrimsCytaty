<?php

namespace Aldor\CytatySBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * QuotesList
 */
class QuotesList
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $startdate;

    /**
     * @var \DateTime
     */
    private $enddate;

    /**
     * @var integer
     */
    private $quotecount;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $quotes;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->quotes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set startdate
     *
     * @param \DateTime $startdate
     * @return QuotesList
     */
    public function setStartdate($startdate)
    {
        $this->startdate = $startdate;

        return $this;
    }

    /**
     * Get startdate
     *
     * @return \DateTime
     */
    public function getStartdate()
    {
        return $this->startdate;
    }

    /**
     * Set enddate
     *
     * @param \DateTime $enddate
     * @return QuotesList
     */
    public function setEnddate($enddate)
    {
        $this->enddate = $enddate;

        return $this;
    }

    /**
     * Get enddate
     *
     * @return \DateTime
     */
    public function getEnddate()
    {
        return $this->enddate;
    }

    /**
     * Set quotecount
     *
     * @param integer $quotecount
     * @return QuotesList
     */
    public function setQuotecount($quotecount)
    {
        $this->quotecount = $quotecount;

        return $this;
    }

    /**
     * Get quotecount
     *
     * @return integer
     */
    public function getQuotecount()
    {
        return $this->quotecount;
    }

    /**
     * Add quotes
     *
     * @param \Aldor\CytatySBundle\Entity\Quote $quotes
     * @return QuotesList
     */
    public function addQuote(\Aldor\CytatySBundle\Entity\Quote $quotes)
    {
        $this->quotes[] = $quotes;

        return $this;
    }

    /**
     * Remove quotes
     *
     * @param \Aldor\CytatySBundle\Entity\Quote $quotes
     */
    public function removeQuote(\Aldor\CytatySBundle\Entity\Quote $quotes)
    {
        $this->quotes->removeElement($quotes);
    }

    /**
     * Get quotes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuotes()
    {
        return $this->quotes;
    }
    /**
     * @var string
     */
    private $quotesliststt;

    public function __toString() {
        if($this->startdate)
        return 'Lista od '.$this->startdate->format(" d.m").'do '.$this->enddate->format('d.m');
        return 'Lista';
    }

    /**
     * Set quotesliststt
     *
     * @param string $quotesliststt
     * @return QuotesList
     */
    public function setQuotesliststt($quotesliststt)
    {
        $this->quotesliststt = $quotesliststt;

        return $this;
    }

    /**
     * Get quotesliststt
     *
     * @return string
     */
    public function getQuotesliststt()
    {
        return $this->quotesliststt;
    }
    /**
     * @var string
     */
    private $stats;


    /**
     * Set stats
     *
     * @param string $stats
     * @return QuotesList
     */
    public function setStats($stats)
    {
        $this->stats = $stats;

        return $this;
    }

    /**
     * Get stats
     *
     * @return string
     */
    public function getStats()
    {
        return $this->stats;
    }

    public function getStatsHTML()
    {

        $decode = json_decode($this->stats,true);

        $string = array();
        $string['heading'] = 'Wpisów '.$decode['OnList'].'/'.$decode['All'];
        $string['items'] =array();
        $items = $decode['Items'];
        foreach($items as $item)
        {
            array_push($string['items'],'Wpis z '.$item['votes'].' wystąpił '.$item['occurr'].' razy');

        }

        $string['footer'] = 'Średnia '.$decode['Averge'];
     //   $string = print_r($string,true);

        return $string;
    }
public function datediffInWeeks()
{
    return floor($this->startdate->diff($this->enddate)->days/7);
}

}
