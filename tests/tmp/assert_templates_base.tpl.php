<?php
/* Generated from /home/crodas/projects/playground/haanga/tests/assert_templates/base.tpl */
function haanga_0973e977b0eefa529a50d92858e8018a5f8af960($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    if ($return == TRUE) {
        ob_start();
    }
    echo "<html>\n<head>\n    <title>";
    $buffer1  = "Default Title";
    echo (isset($blocks["title"]) ? (strpos($blocks["title"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["title"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer1, $blocks["title"])) : $buffer1)."</title>\n</head>\n\n<body>\n    <h1>Menu</h1>\n    ";
    $buffer1  = "\n    <ul>\n        ";
    foreach ($menu as  $item) {
        $buffer1 .= "\n            <li><a href=\"".$item["url"]."\">".htmlentities($item["name"])."</a></li>\n        ";
    }
    $buffer1 .= "\n    </ul>\n    ";
    echo (isset($blocks["main.menu"]) ? (strpos($blocks["main.menu"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["main.menu"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer1, $blocks["main.menu"])) : $buffer1)."\n    ";
    $buffer1  = "".Haanga::Load("assert_templates/partial.tpl", $vars, TRUE, $blocks);
    echo (isset($blocks["main.include-end"]) ? (strpos($blocks["main.include-end"], "{{block.1b3231655cebb7a1f783eddf27d254ca}}") === FALSE ? $blocks["main.include-end"] : str_replace("{{block.1b3231655cebb7a1f783eddf27d254ca}}", $buffer1, $blocks["main.include-end"])) : $buffer1)."\n</body>\n</html>\n";
    if ($return == TRUE) {
        return ob_get_clean();
    }
}