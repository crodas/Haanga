<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/for_range.tpl */
function haanga_4d539b8ce541e6398b254786c86ca7fd1338ca04($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    for ($i = 1; $i <= 5; $i += 1) {
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