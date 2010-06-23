<?php

function base_template($vars, $blocks=array()) {
    extract($vars);
    echo "<script>\nvar i = 5 % 4;\nfunction foo_bar  () {\n    cesar {\$rodas}\n}\n</script>\n";
    /* Testing Comment */
    echo "\n";
    echo "<table>\n";
    if (!is_array($some_list) OR count($some_list) == 0) {
        echo " \n";
        echo "<tr> \n    <td>\n        Dear ";
        echo "{$var}";
        echo " ";
        echo "you found a bug ;-)\n    </td>\n</tr>\n";
    } else  {
        $forcounter_1 = 1;
        $forcounter0_1 = 0;
        foreach ($some_list as  $var) {
            echo "\n\n    ";
            $def_cycle_0 = Array('row1 cesar','row2',);
            $index_0 = (!isset($index_0) ? 0 : ($index_0 + 1) % sizeof($def_cycle_0));
            echo "<tr class=\"{$var}";
            echo "\">\n        <td style=\"background-color: ";
            if (!isset($ifchanged_0[0]) || $ifchanged_0[0] != $var) {
                $def_cycle_1 = Array('red','back',);
                $index_1 = (!isset($index_1) ? 0 : ($index_1 + 1) % sizeof($def_cycle_1));
                echo " {$var}";
                echo " ";
                $ifchanged_0 = Array($var,);
            } else  {
                $def_cycle_2 = Array('gray','white',);
                $index_2 = (!isset($index_2) ? 0 : ($index_2 + 1) % sizeof($def_cycle_2));
                echo " {$var}";
                echo " ";
            }
            echo "\">\n            Foobar ";
            echo "{$var}";
            echo "\n            ";
            $ob_start_1 = "";
            $ob_start_1 .= "\n            ";
            $block = ob_start();
            $ob_start_1 .= "Date {$var} foo ";
            $output_1 = ob_get_clean();
            if (!isset($ifchanged_1) OR $output_1 != $ifchanged_1) {
                echo "{$var}";
                $ifchanged_1 = $output_1;
            }
            $ob_start_1 .= "\n            ";
            echo strtoupper(strtolower($ob_start_1));
            echo "\n        ";
            echo "</td>\n        <td>\n            ";
            echo "{$var}";
            echo "\n        ";
            echo "</td>\n        <td>\n        ";
            $forcounter_2 = 1;
            $forcounter0_2 = 0;
            foreach ($some_list as  $var) {
                echo "\n        ";
                echo "Strlen: ";
                $ob_start_1 = "";
                $ob_start_1 .= "\n            ";
                $ob_start_2 = "";
                $ob_start_2 .= "\n            ";
                /* Define a custom filter (AKA call a PHP function */
                $ob_start_2 .= "\n            i must be uppercase\n            ";
                $ob_start_1 .= strtoupper($ob_start_2)."\n        ";
                echo strlen($ob_start_1);
                echo "\n            ";
                echo "{$var}";
                echo "<br/>\n            ";
                echo "{$var}";
                echo "<br/>\n        ";
                $forcounter_2 = $forcounter_2 + 1;
                $forcounter0_2 = $forcounter0_2 + 1;
            }
            echo "\n        ";
            echo "</td>\n        <td>\n        ";
            if (!isset($blocks) || !isset($blocks["td"])) {
                echo " \n            ";
                $ob_start_1 = "";
                $ob_start_1 .= "\n                Testing block with filter {$var} :-)\n            ";
                echo strtoupper(strtolower($ob_start_1));
                echo "\n        ";
            } else  {
                echo "{$var}";
            }
            echo "\n        ";
            echo "</td>\n    </tr>\n";
            $forcounter_1 = $forcounter_1 + 1;
            $forcounter0_1 = $forcounter0_1 + 1;
        }
    }
    echo "\n    ";
    echo "</tr>\n</table>\n";
}


function subtemplate_template($vars, $blocks=array()) {
    extract($vars);
    ob_start();
    echo "\n    ";
    echo "New content by ";
    echo "{$var}";
    echo "\n    ";
    $forcounter_3 = 1;
    foreach ($some_list as  $var) {
        echo " \n        ";
        echo "{$var}";
        echo "\n    ";
        $forcounter_3 = $forcounter_3 + 1;
    }
    echo "\n";
    $blocks["td"] = ob_get_clean();
    base_template($vars, $blocks);
}

$arr = array('some_list' => array(1, 2, 3, 3, 4, 4, 5), 'user' => 'crodas');
base_template($arr);
echo "\n\n------------------------------\n\n";
subtemplate_template($arr);
