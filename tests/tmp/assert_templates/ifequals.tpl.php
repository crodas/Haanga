<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/ifequals.tpl */
function haanga_0c118610d6837670c71af0327fb53e43cea00877($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    if (1 == 2) {
        echo '
    Equals
';
    } else {
        echo '
    Non Equals
';
    }
    echo '
';
    if (1 != 2) {
        echo '
    Non Equals
';
    } else {
        echo '
    Equals
';
    }
    echo '
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}