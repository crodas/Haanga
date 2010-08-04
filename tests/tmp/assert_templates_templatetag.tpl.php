<?php
/* Generated from ./assert_templates/templatetag.tpl */
function haanga_e8adad36286908587f35889b124b818b834c1e4f($vars, $return=FALSE, $blocks=array())
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