<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/intval.tpl */
function haanga_97d0fec2255e31f51478c5d222c422dc247322f7($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo htmlspecialchars(intval($float)).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}