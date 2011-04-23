<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/for_range4.tpl */
function haanga_862550ab5e80dc16c8f0f5fafed8f6b4d4b7e56f($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    for ($i = $min; $i >= $max; $i += -2) {
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