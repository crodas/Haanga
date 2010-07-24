<?php

class Title_Filter
{
    function generator($compiler, $args)
    {
        if (count($args) != 1) {
            throw new Haanga_CompilerException("title filter only needs one parameter");
        }

        return hexec('ucwords', hexec('strtolower', $args[0]));
    }
}
