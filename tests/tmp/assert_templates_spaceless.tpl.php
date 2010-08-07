<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/spaceless.tpl */
function haanga_f51ac87bbd60a3c3e24c65a52e121e9a0fe6f98a($vars, $return=FALSE, $blocks=array())
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