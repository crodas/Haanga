<?php

class Join_Filter extends Haanga_Filter
{
    public function generator($compiler, $args)
    {
        if (count($args) == 1) {
            $args[1] = "";
        }
        return hexec("implode", $args[1], $args[0]);
    }
}
