<?php
/* Generated from ./assert_templates/title.tpl */
function haanga_02538e36710a9b95d7e6c8d1e1bba6e65b566aa4($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "".htmlentities(ucwords(strtolower($title)))."\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}