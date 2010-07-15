<?php
/* Generated from ./assert_templates/first_of.tpl */
function haanga_a826d0f6cb5e39095560cc1bd5fd99cec2771f48($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "".(isset($variable1) == TRUE ? $variable1 : (isset($variable2) == TRUE ? $variable2 : "default"))."\n".(isset($variable1) == TRUE ? $variable1 : (isset($variablex) == TRUE ? $variablex : "default"))."\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}