<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/for_range5.tpl */
function haanga_ce579af7079d634f492d7742076d8a6ef88b4895($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    for ($i = $e['min']; $i >= $e['max']; $i += -2) {
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