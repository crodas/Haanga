<?php

class Haanga_Extension_Filter_Inarray
{
    static function generator($compiler, $args)
    {
        return hexec('in_array', $args[0], $args[1]);
    }
}
