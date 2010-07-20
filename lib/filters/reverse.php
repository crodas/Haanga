<?php

class Reverse_Filter
{
    function generator($compiler, $args)
    {
        if (count($args) != 1) {
            throw new Haanga_CompilerException("Reverse only needs one parameter");
        }

        return hexec('array_reverse', $args[0], TRUE);
    }
}
