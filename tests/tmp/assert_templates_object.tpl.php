<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/object.tpl */
function haanga_717af4700b61ef385b9b8789af8d5b196ea2c250($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo htmlentities($obj->name)."\n".htmlentities($obj->obj["name"])."\n".htmlentities($arr["obj"]->name)."\n".htmlentities($arr["obj"]->obj["name"])."\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}