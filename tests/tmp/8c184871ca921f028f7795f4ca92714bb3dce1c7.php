<?php
/* Generated from ./assert_templates/pluralize.tpl */
function haanga_8c184871ca921f028f7795f4ca92714bb3dce1c7($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "message".htmlentities(($num1 <= 1 ? "" : "s"))."\nwalrus".htmlentities(($num1 <= 1 ? "" : "es"))."\ncherr".htmlentities(($num1 <= 1 ? "y" : "ies"))."\nmessage".htmlentities(($num2 <= 1 ? "" : "s"))."\nwalrus".htmlentities(($num2 <= 1 ? "" : "es"))."\ncherr".htmlentities(($num2 <= 1 ? "y" : "ies"))."\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}