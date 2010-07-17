<?php
/* Generated from ./assert_templates/first_of.tpl */
function haanga_a826d0f6cb5e39095560cc1bd5fd99cec2771f48($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "".(empty($variable1) ? (empty($variable2) ? "default" : $variable2) : $variable1)."\n".(empty($variable1) ? (empty($variablex) ? "default" : $variablex) : $variable1)."\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}