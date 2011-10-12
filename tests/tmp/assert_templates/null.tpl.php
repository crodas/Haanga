<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/null.tpl */
function haanga_6f20b287cab4452d498e463a2d6b3728739ade29($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    foreach ($obj as  $k => $val) {
        echo '
    ';
        if (is_null($val)) {
            echo '
        '.htmlspecialchars($k).' is null
    ';
        } else {
            echo '
        '.htmlspecialchars($k).' is not null
    ';
        }
        echo '
';
    }
    echo '
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}