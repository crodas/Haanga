<?php
/* Generated from ./assert_templates/join.tpl */
function haanga_1d992f3d68f25e0f67960320816915d87f8e6120($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "".htmlentities(implode(" // ", $array))."\n".htmlentities(implode("", $array))."\n".htmlentities(implode(" // ", array_reverse($array, TRUE)))."\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        print($buffer1);
    }
}