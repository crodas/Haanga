<?php
$HAANGA_VERSION  = '1.0.4';
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/templatetag.tpl */
function haanga_e8adad36286908587f35889b124b818b834c1e4f($vars, $return=FALSE, $blocks=array())
{
    global $test_global, $global1;
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo '{%foo%}
{%foo%}
{{foo}}
{foo}
{#foo#}
';
    if ($return == TRUE) {
        return ob_get_clean();
    }
}