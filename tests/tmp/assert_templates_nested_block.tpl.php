<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/nested_block.tpl */
function haanga_4585ff94701bdef1ce77b7424b41025158a67871($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    $buffer1  = "\n";
    $buffer2  = "\nthis is inner1\n";
    $buffer1 .= (isset($blocks["inner1"]) ? (strpos($blocks["inner1"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["inner1"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer2, $blocks["inner1"])) : $buffer2)."\n";
    $buffer2  = "\nthis is inner2\n";
    $buffer1 .= (isset($blocks["inner2"]) ? (strpos($blocks["inner2"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["inner2"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer2, $blocks["inner2"])) : $buffer2)."\n";
    echo (isset($blocks["outer"]) ? (strpos($blocks["outer"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["outer"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer1, $blocks["outer"])) : $buffer1)."\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}