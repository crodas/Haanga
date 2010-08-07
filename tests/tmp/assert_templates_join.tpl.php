<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/join.tpl */
function haanga_f6d8b225f8cf7b12fbd65c42a75f7f526fd5f76b($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo htmlentities(implode(" // ", $array))."\n".htmlentities(implode("", $array))."\n".htmlentities(implode(" // ", array_reverse($array, TRUE)))."\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}