<?php
namespace Aldor\CytatySBundle\Utils;

class SearchHelper
{
public static function str_insert($insertstring, $intostring, $offset) {
   $part1 = mb_substr($intostring, 0, $offset,'utf-8');
   $part2 = mb_substr($intostring, $offset,mb_strlen($intostring,'utf-8'),'utf-8');

   $part1 = $part1 . $insertstring;
   $whole = $part1 . $part2;
   return $whole;
}
public  static function findAndMark($text,$textToFind,$startmark,$endmark) {
         $position = mb_strpos( mb_strtolower($text, 'utf-8'), mb_strtolower($textToFind,'utf-8'),0,'utf-8');
         /*$text = explode ($textToFind,$text);
         $text[0] = $text[0].$startmark;

        $text =substr_replace($text,$endmark,$position+strlen($textToFind),0);
         $text =substr_replace($text,$startmark,$position,0);*/
         $text = SearchHelper::str_insert($endmark,$text,$position+mb_strlen($textToFind,'utf-8'));
         $text = SearchHelper::str_insert($startmark,$text,$position);

        return $text;



         }

}
