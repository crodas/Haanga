<?php

function base_template($vars, $blocks=array()) {
    extract($vars);
    echo "<script>\nvar i = 5 % 4;\nfunction foo_bar  () {\n    cesar {\$rodas}\n}\n</script>\n";
    /* Testing Comment */
    echo "\n<table>\n";
    if (!is_array($some_list) OR count($some_list) == 0) {
        echo " \n<tr> \n    <td>\n        Dear {$user} you found a bug ;-)\n    </td>\n</tr>\n";
    } else  {
        $forcounter_1  = 1;
        $forcounter0_1  = 0;
        foreach ($some_list as  $var) {
            $def_cycle_0  = Array('row1 cesar','row2',);
            $index_0  = (!isset($index_0) ? 0 : ($index_0 + 1) % sizeof($def_cycle_0));
            echo "\n\n    <tr class=\"{$def_cycle_0[$index_0]}\">\n        <td style=\"background-color: ";
            if (!isset($ifchanged1[0]) || $ifchanged1[0] != $var) {
                $def_cycle_1  = Array('red','back',);
                $index_1  = (!isset($index_1) ? 0 : ($index_1 + 1) % sizeof($def_cycle_1));
                echo " {$def_cycle_1[$index_1]} ";
                $ifchanged1  = Array($var,);
            } else  {
                $def_cycle_2  = Array('gray','white',);
                $index_2  = (!isset($index_2) ? 0 : ($index_2 + 1) % sizeof($def_cycle_2));
                echo " {$def_cycle_2[$index_2]} ";
            }
            echo "\">\n            Foobar {$var}\n            ";
            $buffer1  = "";
            $buffer1 .= "\n            ";
            $buffer2  = "";
            $buffer2 .= "\n            Date {$var} foo \n            dasdasdasdasdasldaksdhasd\n            asdlkasjdlkasjdlkasjdlkajdas\n                        dasa\n            ";
            if (!isset($ifchanged2) OR $buffer2 != $ifchanged2) {
                $buffer1 .= "{$buffer2}";
                $ifchanged2  = $buffer2;
            }
            $buffer1 .= "\n            out of ifchanged\n            ";
            echo strtoupper(strtolower($buffer1))."\n        </td>\n        <td>\n            {$forcounter0_1}\n        </td>\n        <td>\n        ";
            $forcounter_2  = 1;
            $forcounter0_2  = 0;
            foreach ($some_list as  $var) {
                echo "\n        Strlen: ";
                $buffer1  = "";
                $buffer1 .= "\n            ";
                $buffer2  = "";
                $buffer2 .= "\n            ";
                /* Define a custom filter (AKA call a PHP function */
                $buffer2 .= "\n            i must be uppercase\n            ";
                $buffer1 .= strtoupper($buffer2)."\n        ";
                echo strlen($buffer1)."\n            {$forcounter_2}<br/>\n            {$forcounter0_2}<br/>\n        ";
                $forcounter_2  = $forcounter_2 + 1;
                $forcounter0_2  = $forcounter0_2 + 1;
            }
            echo "\n        </td>\n        <td>\n        ";
            if (!isset($blocks) || !isset($blocks["td"])) {
                echo " \n            ";
                $buffer1  = "";
                $buffer1 .= "\n                Testing block with filter {$forcounter_1} :-)\n            ";
                echo strtoupper(strtolower($buffer1))."\n        ";
            } else  {
                echo "{$blocks["td"]}";
            }
            echo "\n        </td>\n    </tr>\n";
            $forcounter_1  = $forcounter_1 + 1;
            $forcounter0_1  = $forcounter0_1 + 1;
        }
    }
    echo "\n    </tr>\n</table>\n";
}


function subtemplate_template($vars, $blocks=array()) {
    extract($vars);
    $buffer1  = "";
    $buffer1 .= "\n    New content by {$user}\n    ";
    $forcounter_3  = 1;
    foreach ($some_list as  $var) {
        $buffer1 .= " \n        {$forcounter_3}\n    ";
        $forcounter_3  = $forcounter_3 + 1;
    }
    $buffer1 .= "\n";
    $blocks["td"]  = "{$ob_start1}";
    base_template($vars, $blocks);
}

$arr = array('some_list' => array(1, 2, 3, 3, 4, 4, 5), 'user' => 'crodas');
base_template($arr);
echo "\n\n------------------------------\n\n";
subtemplate_template($arr);
