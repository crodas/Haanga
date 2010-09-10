<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/pluralize.tpl */
function haanga_8c184871ca921f028f7795f4ca92714bb3dce1c7($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo 'message'.($num1 <= 1 ? '' : 's').'
walrus'.($num1 <= 1 ? '' : 'es').'
cherr'.($num1 <= 1 ? 'y' : 'ies').'
message'.($num2 <= 1 ? '' : 's').'
walrus'.($num2 <= 1 ? '' : 'es').'
cherr'.($num2 <= 1 ? 'y' : 'ies').'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}