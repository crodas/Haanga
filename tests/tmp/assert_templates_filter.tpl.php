<?php
/* Generated from ./assert_templates/filter.tpl */
function haanga_7c948c919295fb106667df66f458e608eb775422($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo htmlentities(strtoupper($var))."\n".htmlentities(strtolower(strtoupper($var)))."\n".htmlentities(str_replace("u", "", $var))."\n".(is_array($var) ? count($var) : strlen($var))."\n".htmlentities(strtoupper((empty($foobar) == TRUE ? "default value" : $foobar)))."\n";
    $buffer1  = "\n    hola que \n";
    echo strtoupper($buffer1)."\n";
    $buffer1  = "TAL";
    echo strtolower($buffer1)."\n";
    $buffer1  = "\n    hello world\n";
    echo str_replace("e", "", strtolower(strtoupper($buffer1)))."\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}