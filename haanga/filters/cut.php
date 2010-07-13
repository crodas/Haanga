<?php

Class Cut_Filter
{
    function main($string, $cut)
    {
        return str_replace($cut, "", $string);
    }
}
