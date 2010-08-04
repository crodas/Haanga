<?php
/* Generated from ./assert_templates/first_of.tpl */
function haanga_a826d0f6cb5e39095560cc1bd5fd99cec2771f48($vars, $return=FALSE, $blocks=array())
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