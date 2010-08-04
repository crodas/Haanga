<?php
/* Generated from ./assert_templates/object.tpl */
function haanga_c1df77e2249dc4876d6380db8edd1ed30a7f89cd($vars, $return=FALSE, $blocks=array())
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