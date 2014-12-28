<?php
/**
 *  Class to parser entry on strims pl
 */
use Symfony\Component\CssSelector\CssSelector;
use Symfony\Component\HttpFoundation\Response;
use Aldor\CytatySBundle\Entity\Quote;
use Aldor\CytatySBundle\Entity\QuotesList;
use Aldor\CytatySBundle\Utils\DateHelper as DateHelper;
use Aldor\CytatySBundle\Utils\AuthorParser as AuthorParser;
use Doctrine\Common\Collections\ArrayCollection as ArrayCollection;

class QuoteParser extends HTMLParser
{
    private $em;

       public function __construct($url,$em)
        {
            parent::__construct($url);
            $this->em = $em;
                // code...
        }
    public function select($cssselector)
    {
          $i =0;
                        $name = '';
        $authorParser = new AuthorParser('a');
        foreach ($this->xpath->query(CssSelector::toXpath('ul.entries>li>div.entry')) as $node)
        {
            // printf("%s (%s)\n", $node->nodeValue, $node->getAttribute('id'));
            $text = $this->xpath->query(CssSelector::toXpath('div.markdown'),$node)->item(0)->nodeValue;
                $user =  $this->xpath->query(CssSelector::toXpath('span.bold'),$node)->item(0)->nodeValue;
            $like =  $this->xpath->query(CssSelector::toXpath('a.like>span.entry_vote_count'),$node)->item(0)->nodeValue;
            $dislike =  $this->xpath->query(CssSelector::toXpath('a.dislike>span.entry_vote_count'),$node)->item(0)->nodeValue;
            $date =  $xpath->query(CssSelector::toXpath('span.color_gray_light span'),$node)->item(0)->getAttribute('title');
            $authorParser->textToParse = $text;
            $tab = $authorParser->getAuthorAndText();
            $author = $tab['author'];
            $text = $tab['text'];
            $date = DateHelper::makeDate($date);
             $url = $xpath->query(CssSelector::toXpath('a.color_gray'),$node)->item(0)->getAttribute('href');

            $exist = $this->em->getRepository('AldorCytatySBundle:Quote')->findByUrl($url);
            if($exist == null)
            {

            $quote = new Quote();

            $quote->setUser($user);
            $quote->setDate(new \DateTime($date));
            $quote->setAuthor($author);
            $quote->setText($text);
            $quote->setUrl($url);
            $quote->setUpvotes($like);
            $quote->setDownvotes($dislike);
            if(isset($tab['additionalinfo']))
            $quote->setAdditionalinfo($tab['additionalinfo']);
            $quote->setVotes($like-$dislike);

                   $this->em->persist($quote);

            }
            else
            {
            $exist[0]->setUpvotes($like);
            $exist[0]->setDownvotes($dislike);
            $exist[0]->setVotes($like-$dislike);
                   $em->persist($exist[0]);

            }

        }
    $this->em->flush();

    }



}
