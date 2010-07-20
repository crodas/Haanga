<?php

class Date_Filter
{
    function generator($compiler, $args)
    {
        return hexec('date', $args[1], $args[0]);
    }
}
    

