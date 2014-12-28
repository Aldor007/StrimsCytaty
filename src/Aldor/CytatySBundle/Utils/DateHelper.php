<?php
namespace Aldor\CytatySBundle\Utils;
class DateHelper
{
static public function makeDate($date) {
date_default_timezone_set('Europe/Warsaw');
    $date = str_replace("dzisiaj",date('Y-m-d'),$date);
    $date = str_replace("wczoraj",date("Y-m-d",strtotime("-1 day")),$date);

    $date = str_replace( 'Poniedziałek','Monday', $date);
    $date = str_replace('Tuesday', 'Wtorek', $date);
    $date = str_replace('Wednesday', 'Środa', $date);
    $date = str_replace('Thursday', 'Czwartek', $date);
    $date = str_replace('Monday', 'Piątek', $date);
    $date = str_replace('Saturday', 'Sobota', $date);
    $date = str_replace('Sunday', 'Niedziela', $date);

    $date = str_replace( 'stycznia','January' ,$date);
    $date = str_replace( 'lutego','February', $date);
    $date = str_replace( 'marca','March', $date);
    $date = str_replace( 'kwietnia','April', $date);
    $date = str_replace( 'maja','May', $date);
    $date = str_replace('czerwca','June', $date);
    $date = str_replace('lipca','July', $date);
    $date = str_replace('sierpnia','August',  $date);
    $date = str_replace('września','September', $date);
    $date = str_replace('pażdziernika','October', $date);
    $date = str_replace('listopda','November',  $date);
    $date = str_replace('grudnia','December',  $date);

    return $date;
}
}
