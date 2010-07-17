<?php

class Default_filter
{
    function generator($compiler, $args)
    {
        return $compiler->expr_cond(
            $compiler->expr('==', $compiler->expr_exec('empty',$args[0]), TRUE),
            $args[1],
            $args[0]
        );
    }
}
