<?php
/* Generated from ./assert_templates/filter.tpl */
function haanga_7c948c919295fb106667df66f458e608eb775422($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "".htmlentities(strtoupper($var))."\n".htmlentities(strtolower(strtoupper($var)))."\n".htmlentities(str_replace("u", "", $var))."\n".(is_array($var) == TRUE ? count($var) : strlen($var))."\n".htmlentities(strtoupper((empty($foobar) == TRUE ? "default value" : $foobar)))."\n";
    $buffer2  = "\n    hola que \n";
    $buffer1 .= strtoupper($buffer2)."\n";
    $buffer2  = "TAL";
    $buffer1 .= strtolower($buffer2)."\n";
    $buffer2  = "\n    hello world\n";
    $buffer1 .= str_replace("e", "", strtolower(strtoupper($buffer2)))."\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}