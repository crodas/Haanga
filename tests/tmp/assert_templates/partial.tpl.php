<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/partial.tpl */
function haanga_1e7ad0daf3a6652932dc9adf0aecfb68ab0bfa2e($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo 'Partial part
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}