<?php

class Safe_Filter
{
    function generator($compiler, $args)
    {
        $compiler->var_is_safe = TRUE;
        return current($args);
    }
}
