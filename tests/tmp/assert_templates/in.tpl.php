<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/in.tpl */
function haanga_8815cff61dc42c8002f44fd73612611e6bc333e6($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    if (strpos('cesar d. rodas', 'd.') !== FALSE) {
        echo '
    Here
';
    }
    echo '
';
    if ((is_array($names) ? array_search('d.', $names) : strpos($names, 'd.')) !== FALSE) {
        echo '
    Here
';
    }
    echo '
';
    if (strpos('cesar d. rodas', $search) !== FALSE) {
        echo '
    Here
';
    }
    echo '
';
    if ((is_array($names) ? array_search($search, $names) : strpos($names, $search)) !== FALSE) {
        echo '
    Here
';
    }
    echo '
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}