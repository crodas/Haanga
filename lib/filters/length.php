<?php

class Length_Filter
{
    function generator($compiler, $args)
    {
        if ($compiler->is_string($args[0])) {
            return $compiler->expr_exec('strlen', $args[0]);
        }
        return $compiler->expr_cond(
            $compiler->expr('==',  $compiler->expr_exec('is_array', $args[0]), TRUE),
            $compiler->expr_exec('count', $args[0]),
            $compiler->expr_exec('strlen', $args[0])
        );
    }
}
