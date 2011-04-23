<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/for_range3.tpl */
function haanga_859654b3095e22d09c8658e87249d91cf6234bff($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    for ($i = 5; $i >= 1; $i += -2) {
        echo '
    '.$i.'
';
    }
    echo '
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}