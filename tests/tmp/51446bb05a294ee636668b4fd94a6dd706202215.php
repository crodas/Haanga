<?php
/* Generated from ./assert_templates/spaceless.tpl */
function haanga_51446bb05a294ee636668b4fd94a6dd706202215($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    $buffer2  = "\n<p>\n    <a href=\"foo/\"> Foo </a>\n            </p>    ";
    $buffer1 .= preg_replace(Array("/>[ \\t\\r\\n]+</sU", "/^[ \\t\\r\\n]+</sU", "/>[ \\t\\r\\n]+\$/sU"), Array("><", "<", ">"), $buffer2)."\n===========================\n";
    $buffer2  = "\n<b>\n    <pre>\n    Something cool\n\n    </pre>\n\n\n\n\n\n\n\n\n</b> ";
    $buffer1 .= preg_replace(Array("/>[ \\t\\r\\n]+</sU", "/^[ \\t\\r\\n]+</sU", "/>[ \\t\\r\\n]+\$/sU"), Array("><", "<", ">"), $buffer2)."\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}