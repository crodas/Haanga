<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/for_range1.tpl */
function haanga_6153c3274a39928f85c724583ea8ab169cbc4b9b($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    for ($i = 1; $i <= 5; $i += 2) {
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