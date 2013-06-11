<?php
namespace Aldor\CytatySBundle\Utils;

class HTMLParser
{

     private $knowSeparationChars= array('~','[',' —','-');
     private $encoding = 'utf-8';
     private $textToParse;
     private $text;
     public function __construct($textForParser)
    {
        $this->textToParse = $textForParser;
    }
    public function __set($key, $value)
    {
        $this->textToParse = $value;
    }
    private function mb_explode($delimiter, $string, $limit = -1, $encoding = 'auto') {
        if(!is_array($delimiter)) {
            $delimiter = array($delimiter);
        }
        if(strtolower($encoding) === 'auto') {
            $encoding = mb_internal_encoding();
        }
        if(is_array($string) || $string instanceof Traversable) {
            $result = array();
            foreach($string as $key => $val) {
                $result[$key] = mb_explode($delimiter, $val, $limit, $encoding);
            }
            return $result;
        }

        $result = array();
        $currentpos = 0;
        $string_length = mb_strlen($string, $encoding);
        while($limit < 0 || count($result) < $limit) {
            $minpos = $string_length;
            $delim_index = null;
            foreach($delimiter as $index => $delim) {
                if(($findpos = mb_strpos($string, $delim, $currentpos, $encoding)) !== false) {
                    if($findpos < $minpos) {
                        $minpos = $findpos;
                        $delim_index = $index;
                    }
                }
            }
            $result[] = mb_substr($string, $currentpos, $minpos - $currentpos, $encoding);
            if($delim_index === null) {
                break;
            }
            $currentpos = $minpos + mb_strlen($delimiter[$delim_index], $encoding);
        }
        return $result;
    }
      private function getseparationChar()
    {
        foreach($this->knowSeparationChars as $sepchar)
            if(mb_strpos($this->textToParse,$sepchar,0,'utf-8'))
                return $sepchar;
        return false;
    }

    public  function getAuthorAndText()
    {

        $separationChar = $this->getseparationChar();
        if($separationChar === false)
            return array('author'=>'Brak danych','text'=> $this->textToParse) ;
        $positionSeparator = mb_strpos($this->textToParse,$separationChar,0,$this->encoding);
        $tmp = array();
        $tmp = explode($separationChar,$this->textToParse);//,$this->encoding);
        $author = $tmp[1];
        $text = $tmp[0];

        if($separationChar == '[')
        {
            $endSerparatorPos = mb_strpos($author,$separationChar,0,$this->encoding);
            $author = mb_substr($author,$endSerparatorPos,mb_strlen($author,$this->encoding)-$endSerparatorPos-1,$this->encoding);
        }
       return array('author' => $author,'text' => $text);
    }


}
