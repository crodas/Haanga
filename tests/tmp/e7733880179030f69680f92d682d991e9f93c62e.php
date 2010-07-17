<?php
/* Generated from ./assert_templates/if_else_simple.tpl */
function haanga_e7733880179030f69680f92d682d991e9f93c62e($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    if (1 + 2 == 3) {
        $buffer1 .= "True";
    } else {
        $buffer1 .= "False";
    }
    $buffer1 .= "\n";
    if (strtoupper($var) == $var) {
        $buffer1 .= "True";
    } else {
        $buffer1 .= "False";
    }
    $buffer1 .= "\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}