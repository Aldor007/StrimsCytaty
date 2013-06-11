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

        $i =0;
        $document = new \DOMDocument();
        $document->loadHTMLFile('http://strims.pl/s/Cytaty/wpisy/');

        $xpath = new \DOMXPath($document);
          $em  = $this->getContainer()->get('doctrine')->getManager();
                   $name = '';
        $qoutes = array();
        $authorParser = new AuthorParser('a');




        foreach ($xpath->query(CssSelector::toXpath('ul.entries>li>div.entry')) as $node)
        {
            // printf("%s (%s)\n", $node->nodeValue, $node->getAttribute('id'));
            $text = $xpath->query(CssSelector::toXpath('div.markdown'),$node)->item(0)->nodeValue;
                $user =  $xpath->query(CssSelector::toXpath('span.bold'),$node)->item(0)->nodeValue;
            $like =  $xpath->query(CssSelector::toXpath('a.like>span.entry_vote_count'),$node)->item(0)->nodeValue;
            $dislike =  $xpath->query(CssSelector::toXpath('a.dislike>span.entry_vote_count'),$node)->item(0)->nodeValue;
            $date =  $xpath->query(CssSelector::toXpath('span.color_gray_light span'),$node)->item(0)->getAttribute('title');
            // $dat = substr($date,strpos($date,'j ')+1);
            $authorParser->textToParse = $text;
            $tab = $authorParser->getAuthorAndText();
            $author = $tab['author'];
            $text = $tab['text'];
            $date = DateHelper::makeDate($date);
             $url = $xpath->query(CssSelector::toXpath('a.color_gray'),$node)->item(0)->getAttribute('href');

            $exist = $em->getRepository('AldorCytatySBundle:Quote')->findByUrl($url);
          //  if($exist == null)
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
            $qoutes[$i++] = $quote;

                   $em->persist($quote);

            }

        }
    $em->flush();

    }
}
