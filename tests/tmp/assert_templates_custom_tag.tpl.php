<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/custom_tag.tpl */
function haanga_baec81b80b564f187961ccdbd08683c553ed4bc8($vars, $return=FALSE, $blocks=array())
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