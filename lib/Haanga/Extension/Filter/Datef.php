<?php

class Haanga_Extension_Filter_Datef
{
    static function generator($compiler, $args)
    {
        
        return hexec('date', $args[1], 
                     hexec('strtotime', $args[0]));
    }
}
    

