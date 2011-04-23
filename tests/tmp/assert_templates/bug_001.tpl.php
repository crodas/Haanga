<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/bug_001.tpl */
function haanga_715ccf083fda98adcfc4c99d2f583a6d19336adc($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo htmlspecialchars($date_end).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}