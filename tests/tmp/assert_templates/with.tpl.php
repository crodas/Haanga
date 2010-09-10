<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/with.tpl */
function haanga_6b7e79ed219629bc512aa130b0742545436edf01($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    foreach ($users as  $user) {
        echo '
    
        '.htmlspecialchars(strtoupper($user['name'])).' == '.htmlspecialchars(strtoupper($user['name'])).'
    
';
    }
    echo '
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}