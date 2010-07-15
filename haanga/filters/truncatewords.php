<?php

class Truncatewords_Filter
{
    function main($text, $limit)
    {
        $words = explode(" ", $text, $limit+1);
        if (count($words) == $limit+1) {
            $words[$limit] = '...';
        }
        return implode(" ", $words);
    }
}
