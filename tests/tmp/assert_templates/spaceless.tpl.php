<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/spaceless.tpl */
function haanga_51446bb05a294ee636668b4fd94a6dd706202215($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    $buffer1  = "\n<p>\n    <a href=\"foo/\"> Foo </a>\n            </p>    ";
    echo preg_replace(Array("/>[ \\t\\r\\n]+</sU", "/^[ \\t\\r\\n]+</sU", "/>[ \\t\\r\\n]+\$/sU"), Array("><", "<", ">"), $buffer1)."\n===========================\n";
    $buffer1  = "\n<b>\n    <pre>\n    Something cool\n\n    </pre>\n\n\n\n\n\n\n\n\n</b> ";
    echo preg_replace(Array("/>[ \\t\\r\\n]+</sU", "/^[ \\t\\r\\n]+</sU", "/>[ \\t\\r\\n]+\$/sU"), Array("><", "<", ">"), $buffer1)."\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}