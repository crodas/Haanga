<?php
/* Load filter truncatewords definition */
Haanga::doInclude("/filters/truncatewords.php");
/* Generated from ./assert_templates/truncatewords.tpl */
function haanga_33ff616729fa5b4a494db28dee3c3f04cecdd01d($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "".htmlentities(ucwords(strtolower(Truncatewords_Filter::main($short_text, 2))))."\n".htmlentities(ucwords(strtolower(Truncatewords_Filter::main($text, 2))))."\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}