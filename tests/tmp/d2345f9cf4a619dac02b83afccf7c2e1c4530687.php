<?php
/* Load tag dummy definition */
require_once("/home/crodas/projects/playground/haanga/contrib/dummy.php");
/* Generated from ./assert_templates/dummy.tpl */
function haanga_d2345f9cf4a619dac02b83afccf7c2e1c4530687($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "\n";
    $buffer2  = "\n    testing DUMMY TaG\n";
    $buffer1 .= Haanga_Extension_Tag_Dummy::main($buffer2)."\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        print($buffer1);
    }
}