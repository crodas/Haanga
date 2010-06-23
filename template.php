<?php

function base_template($vars, $blocks=array()) {
    extract($vars);
    echo "<script>\nvar i = 5 % 4;\nfunction foo_bar  () {\n    cesar {\$rodas}\n}\n</script>\n\n<table>\n";
    if (!is_array($some_list) OR count($some_list) == 0) {
        echo " \n<tr> \n    <td>\n        Dear {$user} you found a bug ;-)\n    </td>\n</tr>\n";
    } else  {
        $forcounter_1 = 1;
        $forcounter0_1 = 0;
        foreach ($some_list as  $var) {
            $def_cycle_0 = Array('row1 cesar','row2',);
            $index_0 = (!isset($index_0) ? 0 : ($index_0 + 1) % sizeof($def_cycle_0));
            echo "\n\n    <tr class=\"{$def_cycle_0[$index_0]}\">\n        <td style=\"background-color: ";
            if (!isset($ifchanged_0[0]) || $ifchanged_0[0] != $var) {
                $def_cycle_1 = Array('red','back',);
                $index_1 = (!isset($index_1) ? 0 : ($index_1 + 1) % sizeof($def_cycle_1));
                echo " {$def_cycle_1[$index_1]} ";
                $ifchanged_0 = Array($var,);
            } else  {
                $def_cycle_2 = Array('gray','white',);
                $index_2 = (!isset($index_2) ? 0 : ($index_2 + 1) % sizeof($def_cycle_2));
                echo " {$def_cycle_2[$index_2]} ";
            }
            echo "\">\n            Foobar {$var}\n            ";
            ob_start();
            echo "\n            ";
            $block = ob_start();
            echo "Date {$var} foo ";
            $output_1 = ob_get_clean();
            if (!isset($ifchanged_1) OR $output_1 != $ifchanged_1) {
                echo "{$output_1}";
                $ifchanged_1 = $output_1;
            }
            echo "\n            ";
            echo "".strtoupper(strtolower(ob_get_clean()))."\n        </td>\n        <td>\n            {$forcounter0_1}\n        </td>\n        <td>\n        ";
            $forcounter_2 = 1;
            $forcounter0_2 = 0;
            foreach ($some_list as  $var) {
                echo "\n            {$forcounter_2}<br/>\n            {$forcounter0_2}<br/>\n        ";
                $forcounter_2 = $forcounter_2 + 1;
                $forcounter0_2 = $forcounter0_2 + 1;
            }
            echo "\n        </td>\n        <td>\n        ";
            if (!isset($blocks) || !isset($blocks["td"])) {
                echo " \n            ";
                ob_start();
                echo "\n                Testing block with filter {$forcounter_1} :-)\n            ";
                echo "".strtoupper(strtolower(ob_get_clean()))."\n        ";
            } else  {
                echo "{$blocks["td"]}";
            }
            echo "\n        </td>\n";
            $forcounter_1 = $forcounter_1 + 1;
            $forcounter0_1 = $forcounter0_1 + 1;
        }
    }
    echo "\n    </tr>\n</table>\n";
}


function subtemplate_template($vars, $blocks=array()) {
    extract($vars);
    ob_start();
    echo "\n    New content\n";
    $td = ob_get_clean();
    base_template($vars, array('td' => $td, ));
}

$arr = array('some_list' => array(1, 2, 3, 4, 5), 'user' => 'crodas');
base_template($arr);
echo "\n\n------------------------------\n\n";
subtemplate_template($arr);
