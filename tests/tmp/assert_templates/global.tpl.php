<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/global.tpl */
function haanga_7a375fb2704088e2b14f656c72d527d8203027fe($vars, $return=FALSE, $blocks=array())
{
    global $test_global;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo htmlentities($test_global["b"]).'
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}