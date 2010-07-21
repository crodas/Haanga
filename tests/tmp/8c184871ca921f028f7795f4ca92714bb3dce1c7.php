<?php
/* Generated from ./assert_templates/pluralize.tpl */
function haanga_8c184871ca921f028f7795f4ca92714bb3dce1c7($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "message".($num1 <= 1 ? "" : "s")."\nwalrus".($num1 <= 1 ? "" : "es")."\ncherr".($num1 <= 1 ? "y" : "ies")."\nmessage".($num2 <= 1 ? "" : "s")."\nwalrus".($num2 <= 1 ? "" : "es")."\ncherr".($num2 <= 1 ? "y" : "ies")."\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        print($buffer1);
    }
}