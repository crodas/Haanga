<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/with.tpl */
function haanga_ad6dd0eee474a04063740442710df73ac63054c4($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    foreach ($users as  $user) {
        echo "\n    \n        ".htmlentities(strtoupper($user["name"]))." == ".htmlentities(strtoupper($user["name"]))."\n    \n";
    }
    echo "\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}