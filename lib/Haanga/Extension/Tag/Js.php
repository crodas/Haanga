<?php

class Haanga_Extension_Tag_Js
{
    public $is_block = FALSE;

    static function generator($cmp, $args, $redirected)
    {
        $src = end($args[0]);
        $code = hcode();
        $js  =   '<script type="text/javascript" src="' . PUBLIC_PATH . "javascript/$src". '.js"></script>';
        $cmp->do_print($code,  Haanga_AST::str($js));
        return $code;
    }
}
