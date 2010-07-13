<?php

class Date_Filter
{
    function generator($compiler, $args)
    {
        return $compiler->expr_exec('date', $args[1], $args[0]);
    }
}
    

