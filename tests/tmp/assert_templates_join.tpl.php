<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/join.tpl */
function haanga_1d992f3d68f25e0f67960320816915d87f8e6120($vars, $return=FALSE, $blocks=array())
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