<?php

class Haanga_Extension_Tag_Partial
{
    static function generator($cmp, $args, $declared)
    {
        $name = hvar('var_'.uniqid());
        $code = hcode();
        foreach ($args as $value) {
            $arr[$value['var']] = $value;
        }
        $code->decl($name, $arr);
        $exec = hexec('Haanga::Safe_Load', $args[0], $name, TRUE, array());
        $cmp->do_print($code, $exec);
        return $code;
    }
}
