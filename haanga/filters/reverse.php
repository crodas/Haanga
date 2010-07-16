<?php

class Reverse_Filter
{
    function generator($compiler, $args)
    {
        if (count($args) != 1) {
            throw new CompilerException("Reverse only needs one parameter");
        }
        return $compiler->expr_exec('array_reverse', 
            $args[0], $compiler->expr_TRUE());
    }
}
