<?php
$HAANGA_VERSION  = '1.0.3';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/loop_object.tpl */
function haanga_2def2b6ad1167d6f400b0d9db576e1c9d2b51fa9($vars, $return=FALSE, $blocks=array())
{
    global $test_global;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    $obj_arr  = get_object_vars($obj);
    foreach ($obj_arr as  $prop => $value) {
        echo '
    '.htmlentities($prop).' '.htmlentities($value).'
';
    }
    echo '

';
    foreach ($objects as  $i) {
        echo '
    '.htmlentities($i->foo).'
';
    }
    echo '
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}