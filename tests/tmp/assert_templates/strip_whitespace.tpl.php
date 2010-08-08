<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/strip_whitespace.tpl */
function haanga_d7c4d5b38d3a7e0818e446612beff5c975ed8985($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo "<b> Texto laargo </b> <pre>\nEste es un texto \n\ncon\n        espacios\n\n</pre> Another text ";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}