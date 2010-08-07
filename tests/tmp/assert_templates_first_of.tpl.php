<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/first_of.tpl */
function haanga_22f405c6f695534fb899aba67e3cb2bd13c20c39($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo (empty($xvar) == FALSE ? $xvar : (empty($variable1) == FALSE ? $variable1 : (empty($variable2) == FALSE ? $variable2 : "default")))."\n".(empty($xvar) == FALSE ? $xvar : (empty($variable1) == FALSE ? $variable1 : (empty($variablex) == FALSE ? $variablex : "default")))."\n".(empty($xvar) == FALSE ? $xvar : (empty($variable1) == FALSE ? $variable1 : (empty($variable2) == FALSE ? $variable2 : "default")))."\n".(empty($xvar) == FALSE ? $xvar : (empty($variable1) == FALSE ? $variable1 : (empty($variablex) == FALSE ? $variablex : "default")))."\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}