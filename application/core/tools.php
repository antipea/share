<?php

/**
 * User: sasha
 * Date: 14.08.18
 * Time: 17:37
 */
class Tools
{
    public static function formatNumber($number)
    {
        $number = trim(str_replace(" ", "", $number));
        $number = str_replace(',', '.', $number);

        $ch = explode(",", $number);

        if (count($ch) == 2) {
            $ch[1] = substr($ch[1], 0, 2);
            return number_format($number, 0, ",", "") . ".{$ch[1]}";
        } else {
            return number_format($number, 2, ",", "");
        }
    }
}