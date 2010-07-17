<?php

class Join_Filter extends Haanga_Filter
{
    public function generator($compiler, $args)
    {
        if (count($args) == 1) {
            $args[1] = $compiler->expr_str();
        }
        return $compiler->expr_exec("implode", $args[1], $args[0]);
    }
}
