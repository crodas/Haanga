<?php
/* Generated from ./assert_templates/nested_block.tpl */
function haanga_57c4ad33715ae7aa88250c99f9339224979afde7($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    $buffer2  = "";
    $buffer2 .= "\n";
    $buffer3  = "";
    $buffer3 .= "\nthis is inner1\n";
    $buffer2 .= (isset($blocks["inner1"]) ? (strpos($blocks["inner1"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["inner1"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer3, $blocks["inner1"])) : $buffer3)."\n";
    $buffer3  = "";
    $buffer3 .= "\nthis is inner2\n";
    $buffer2 .= (isset($blocks["inner2"]) ? (strpos($blocks["inner2"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["inner2"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer3, $blocks["inner2"])) : $buffer3)."\n";
    $buffer1 .= (isset($blocks["outer"]) ? (strpos($blocks["outer"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["outer"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer2, $blocks["outer"])) : $buffer2)."\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        print($buffer1);
    }
}