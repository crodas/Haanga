<?php
/* Load filter truncatewords definition */
require_once("/home/crodas/projects/playground/haanga/lib/Haanga/Extension/Filter/Truncatewords.php");
/* Generated from ./assert_templates/truncatewords.tpl */
function haanga_33ff616729fa5b4a494db28dee3c3f04cecdd01d($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "".htmlentities(ucwords(strtolower(Haanga_Extension_Filter_Truncatewords::main($short_text, 2))))."\n".htmlentities(ucwords(strtolower(Haanga_Extension_Filter_Truncatewords::main($text, 2))))."\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        print($buffer1);
    }
}