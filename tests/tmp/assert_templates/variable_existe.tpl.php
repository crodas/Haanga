<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/variable_existe.tpl */
function haanga_d0e8258f9bf65ffe46eddfe8347bb2467fc069ea($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    if ((empty($var->exists) == TRUE ? "" : $var->exists)) {
        echo " Yes ";
    } else {
        echo " No ";
    }
    echo "\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}