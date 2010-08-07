<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/variable_existe.tpl */
function haanga_e7e202dbc6662ce7290f8da886bcde2660e244c5($vars, $return=FALSE, $blocks=array())
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