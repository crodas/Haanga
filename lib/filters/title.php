<?php

class Title_Filter
{
    function generator($compiler, $args)
    {
        if (count($args) != 1) {
            throw new Haanga_CompilerException("title filter only needs one parameter");
        }
        return $compiler->expr_exec('ucwords',
                $compiler->expr_exec('strtolower', $args[0])
        );
    }
}
