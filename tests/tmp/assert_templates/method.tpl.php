<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/method.tpl */
function haanga_f81c9f0e9effd460454499c94e9b5ac06ff75347($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo htmlspecialchars($Object->method()).'
'.htmlspecialchars(strtoupper($Object->method())).'
'.htmlspecialchars($Object->bar).'
'.htmlspecialchars(strtoupper($Object->bar)).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}