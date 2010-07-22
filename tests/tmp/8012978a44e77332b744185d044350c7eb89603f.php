<?php
/* Generated from ./assert_templates/subtemplate.tpl */
function haanga_8012978a44e77332b744185d044350c7eb89603f($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    $buffer2  = "";
    $buffer2 .= "My Title - {{block.1b3231655cebb7a1f783eddf27d254ca}}";
    $blocks["title"]  = (isset($blocks["title"]) ? (strpos($blocks["title"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["title"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer2, $blocks["title"])) : $buffer2);
    $buffer2  = "";
    $buffer2 .= "\n    {{block.1b3231655cebb7a1f783eddf27d254ca}}\n\n    :-)\n";
    $blocks["main.menu"]  = (isset($blocks["main.menu"]) ? (strpos($blocks["main.menu"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["main.menu"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer2, $blocks["main.menu"])) : $buffer2);
    $buffer1 .= Haanga::Load("assert_templates/base.tpl", $vars, TRUE, $blocks);
    if ($return == TRUE) {
        return $buffer1;
    } else {
        print($buffer1);
    }
}