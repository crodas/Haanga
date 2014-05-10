<?php

class Haanga_Extension_Tag_Css
{
    public $is_block = FALSE;

    static function generator($cmp, $args, $redirected)
    {
        $src = end($args[0]);
        $media = isset($args[1]['string']) ? "media={$args[1]['string']}":'';
        $code = hcode();
        $cmp->do_print($code, Haanga_AST::str('<link href="' . PUBLIC_PATH . 'css/'));
        $cmp->do_print($code, Haanga_AST::is_str($args[0]) ? Haanga_AST::str($src): hvar($src));
        $cmp->do_print($code, Haanga_AST::str(".css\" rel=\"stylesheet\" type=\"text/css\" $media/>"));
        return $code;
    }
}
