<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/exec.tpl */
function haanga_dd5c8878b71dd3298b301bb14c576dd0b842f320($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo php_uname().'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}