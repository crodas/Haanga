<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/templatetag.tpl */
function haanga_7815438511476032dbbb4ae0e5bffcd2762094b9($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo "{%foo%}\n{%foo%}\n{{foo}}\n{foo}\n{#foo#}\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}