<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/custom_tag.tpl */
function haanga_d10dbccd9d65b519706f053a50a078dbb3e14070($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo date("Y")."\n";
    $foo  = date("U");
    echo htmlentities(date("Y", $foo))."\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}