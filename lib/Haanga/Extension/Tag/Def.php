<?php


class Haanga_Extension_Tag_Def
{
    public $is_block = TRUE;

    static function generator($cmp, $args)
    {
        if (count($args) != 2) {
            $cmp->Error("Define filter must have one parameter");
        }
 
        /* get new code object */
        $code = hcode();
        /* redirect buffer to $args[1] */
        $code->decl($args[1], hexec('json_decode', $args[0], true));
        /* telling to Haanga that we're handling the output */
        $code->doesPrint = TRUE;
        return $code;
    }
}

