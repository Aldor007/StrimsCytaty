<?php
// src/Acme/DemoBundle/Command/GreetCommand.php
namespace Aldor\CytatySBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class QouteCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('cytaty:zbieraj')
            ->setDescription('Dodaje cytaty do bazy')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $i =0;
        $document = new \DOMDocument();
        $document->loadHTMLFile('http://strims.pl/s/Cytaty/wpisy/');

        $xpath = new \DOMXPath($document);
          $em = $this->getDoctrine()->getManager();
                   $name = '';
        $qoutes = array();
        $authorParser = new AuthorParser('a');
         $em = $this->getDoctrine()->getManager();




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
            $quote->setVotes($like-$dislike);
            $qoutes[$i++] = $quote;

                   $em->persist($quote);
                    $em->flush();

            }

        }
}
