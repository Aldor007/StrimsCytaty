<?php
/**
 *  Class to parser entry on strims pl
 */
namespace Aldor\CytatySBundle\Utils;

abstract class  HTMLParser
{
    protected $url;
    protected $document;
    protected $xpath;



        public function __construct($url)
        {
            $this->url = $url;
            $this->load($url);
        }
    public function load($url = null)
    {
        if($url != null) $this->url = $url;
        $this->document = new \DOMDocument();
       @$this->document->loadHTMLFile($this->url);
        $this->xpath = new \DOMXPath($this->document);

    }
    abstract public function select($cssselector);

}
