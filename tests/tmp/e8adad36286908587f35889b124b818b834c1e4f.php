<?php
/* Generated from ./assert_templates/templatetag.tpl */
function haanga_e8adad36286908587f35889b124b818b834c1e4f($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    $buffer1 .= "{%foo";
    $buffer1 .= "%}\n";
    $buffer1 .= "{%foo";
    $buffer1 .= "%}\n";
    $buffer1 .= "{{foo";
    $buffer1 .= "}}\n";
    $buffer1 .= "{foo";
    $buffer1 .= "}\n";
    $buffer1 .= "{#foo";
    $buffer1 .= "#}\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        print($buffer1);
    }
}