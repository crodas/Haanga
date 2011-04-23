<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/try_include.tpl */
function haanga_2918f6e9aedbd5d32e8a5d091ed1985fcf7008e3($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo Haanga::Safe_Load('foobar-tpl.tpl', $vars, TRUE, Array()).'
'.Haanga::Safe_Load('assert_templates/partial.tpl', $vars, TRUE, Array()).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}