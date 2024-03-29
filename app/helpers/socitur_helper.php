<?php
if(!function_exists('jsonPosts'))
{
    function jsonPosts($variable = null)
    {
        $jsonData = json_decode(file_get_contents('php://input'), true);
        if(empty($variable))
        {
            if(empty($jsonData))
            {
                return false;
            }
            else
            {
                return $jsonData;
            }
        }
        else
        {
            if(empty($jsonData[$variable]))
            {
                return false;
            }
            else
            {
                return $jsonData[$variable];
            }
        }
    }
}

if(!function_exists('x_time'))
{
    function x_time($datetime)
    {
        $datetime =  strtotime($datetime);
        $datetime_farki = time() - $datetime;
        $seconds = $datetime_farki;
        $minutes = round($datetime_farki/60);
        $hours = round($datetime_farki/3600);
        $day = round($datetime_farki/86400);
        $week = round($datetime_farki/604800);
        $month = round($datetime_farki/2419200);
        $year = round($datetime_farki/29030400);
        if( $seconds < 60 ){
            if ($seconds == 0){
                return "az önce";
            } else {
                return $seconds .' saniye önce';
            }
        } else if ( $minutes < 60 ){
            return $minutes .' dakika önce';
        } else if ( $hours < 24 ){
            return $hours.' saat önce';
        } else if ( $day < 7 ){
            return $day .' gün önce';
        } else if ( $week < 4 ){
            return $week.' hafta önce';
        } else if ( $month < 12 ){
            return $month .' ay önce';
        } else {
            return $year.' yıl önce';
        }
    }
}
