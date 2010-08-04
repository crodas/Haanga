<?php
/* Generated from ./assert_templates/with.tpl */
function haanga_6b7e79ed219629bc512aa130b0742545436edf01($vars, $return=FALSE, $blocks=array())
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