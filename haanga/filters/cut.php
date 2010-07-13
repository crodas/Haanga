<?php

Class Cut_Filter
{

    /**
     *  We implement "cut" filter at compilation time, to 
     *  avoid senseless includes for simple things.
     *
     *  We can also define an "php_alias" that will simple
     *  call this function (therefore it must exists at
     *  rendering time).
     *
     *  Also a Main() static method could be declared, this will
     *  included at runtime  or copied as a function if the CLI is used (more
     *  or less django style).
     *  
     */
    function generator($compiler, $args)
    {
        return $compiler->expr_exec("str_replace", $args[1], $compiler->expr_str(), $args[0]);
    }
}
