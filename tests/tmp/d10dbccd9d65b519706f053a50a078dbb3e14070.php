<?php
/* Generated from ./assert_templates/custom_tag.tpl */
function haanga_d10dbccd9d65b519706f053a50a078dbb3e14070($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "".date("Y")."\n";
    $foo  = date("U");
    $buffer1 .= htmlentities(date("Y", $foo))."\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        print($buffer1);
    }
}