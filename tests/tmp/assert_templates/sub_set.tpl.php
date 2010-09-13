<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/sub_set.tpl */
function haanga_c0e0fadb893787a4c67d48dcc8457a9f7955fc06($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo htmlspecialchars($bar).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}