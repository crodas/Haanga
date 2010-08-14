<?php
$HAANGA_VERSION  = '1.0.3';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/with.tpl */
function haanga_6b7e79ed219629bc512aa130b0742545436edf01($vars, $return=FALSE, $blocks=array())
{
    global $test_global;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    foreach ($users as  $user) {
        echo '
    
        '.htmlentities(strtoupper($user['name'])).' == '.htmlentities(strtoupper($user['name'])).'
    
';
    }
    echo '
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}