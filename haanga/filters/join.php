<?php

class Join_Filter extends Haanga_Filter
{
    public function generator($compiler, $args)
    {
        return $compiler->expr_exec("implode", $args[1], $args[0]);
    }
}
