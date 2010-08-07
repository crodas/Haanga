<?php
/* Load filter truncatewords definition */
require_once("/home/crodas/projects/playground/haanga/lib/Haanga/Extension/Filter/Truncatewords.php");
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/truncatewords.tpl */
function haanga_5aa26e3d6b16f5a15c0b3d772973328d5d0b4c83($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo htmlentities(ucwords(strtolower(Haanga_Extension_Filter_Truncatewords::main($short_text, 2))))."\n".htmlentities(ucwords(strtolower(Haanga_Extension_Filter_Truncatewords::main($text, 2))))."\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}