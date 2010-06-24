<?php

function base_template($vars, $blocks=array(), $return=FALSE) {
    extract($vars);
    $buffer1  = "";
    $buffer1 .= "<script>\nvar i = 5 % 4;\nfunction foo_bar  () {\n    cesar {\$rodas}\n}\n</script>\n";
    /* Testing Comment */
    $buffer1 .= "\n<table>\n";
    if (!is_array($some_list) OR count($some_list) == 0) {
        $buffer1 .= " \n<tr> \n    <td>\n        Dear {$user} you found a bug ;-)\n    </td>\n</tr>\n";
    } else  {
        $forcounter_1  = 1;
        $forcounter0_1  = 0;
        foreach ($some_list as  $var) {
            $buffer1 .= "\n\n    <tr class=\"";
            $def_cycle_0  = Array('row1 cesar','row2',);
            $index_0  = (!isset($index_0) ? 0 : ($index_0 + 1) % sizeof($def_cycle_0));
            $buffer1 .= "{$def_cycle_0[$index_0]}\">\n        <td style=\"background-color: ";
            if (!isset($ifchanged1[0]) || $ifchanged1[0] != $var) {
                $buffer1 .= " ";
                $def_cycle_1  = Array('red','back',);
                $index_1  = (!isset($index_1) ? 0 : ($index_1 + 1) % sizeof($def_cycle_1));
                $buffer1 .= "{$def_cycle_1[$index_1]} ";
                $ifchanged1  = Array($var,);
            } else  {
                $buffer1 .= " ";
                $def_cycle_2  = Array('gray','white',);
                $index_2  = (!isset($index_2) ? 0 : ($index_2 + 1) % sizeof($def_cycle_2));
                $buffer1 .= "{$def_cycle_2[$index_2]} ";
            }
            $buffer1 .= "\">\n            Foobar {$var}\n            ";
            $buffer2  = "";
            $buffer2 .= "\n            ";
            $buffer3  = "";
            $buffer3 .= "\n            cesar\n            ";
            $buffer4  = "";
            $buffer4 .= "\n            Date {$var} foo \n            dasdasdasdasdasldaksdhasd\n            asdlkasjdlkasjdlkasjdlkajdas\n                        dasa\n            ";
            if (!isset($ifchanged3) OR $buffer4 != $ifchanged3) {
                $buffer3 .= "{$buffer4}";
                $ifchanged3  = $buffer4;
            }
            $buffer3 .= "\n            ";
            if (!isset($ifchanged2) OR $buffer3 != $ifchanged2) {
                $buffer2 .= "{$buffer3}";
                $ifchanged2  = $buffer3;
            }
            $buffer2 .= "\n            out of ifchanged\n            ";
            $buffer1 .= strtoupper(strtolower($buffer2))."\n        </td>\n        <td>\n            {$forcounter0_1}\n        </td>\n        <td>\n        ";
            $forcounter_2  = 1;
            $forcounter0_2  = 0;
            foreach ($some_list as  $var) {
                $buffer1 .= "\n        Strlen: ";
                $buffer2  = "";
                $buffer2 .= "\n            ";
                $buffer3  = "";
                $buffer3 .= "\n            ";
                /* Define a custom filter (AKA call a PHP function */
                $buffer3 .= "\n            i must be uppercase\n            ";
                $buffer2 .= strtoupper($buffer3)."\n        ";
                $buffer1 .= strlen($buffer2)."\n            {$forcounter_2}<br/>\n            {$forcounter0_2}<br/>\n        ";
                $forcounter_2  = $forcounter_2 + 1;
                $forcounter0_2  = $forcounter0_2 + 1;
            }
            $buffer1 .= "\n        </td>\n        <td>\n        ";
            if (!isset($blocks) || !isset($blocks["td"])) {
                $buffer1 .= " \n            ";
                $buffer2  = "";
                $buffer2 .= "\n                Testing block with filter {$forcounter_1} :-)\n            ";
                $buffer1 .= strtoupper(strtolower($buffer2))."\n        ";
            } else  {
                $buffer1 .= "{$blocks["td"]}";
            }
            $buffer1 .= "\n        </td>\n    </tr>\n";
            $forcounter_1  = $forcounter_1 + 1;
            $forcounter0_1  = $forcounter0_1 + 1;
        }
    }
    $buffer1 .= "\n    </tr>\n</table>\n";
    if ($return) {
        return $buffer1;
    } else  {
        echo "{$buffer1}";
    }
}


function subtemplate_template($vars, $blocks=array(), $return=FALSE) {
    extract($vars);
    $buffer1  = "";
    $buffer2  = "";
    $buffer2 .= "\n    New content by {$user}\n    ";
    $forcounter_3  = 1;
    foreach ($some_list as  $var) {
        $buffer2 .= " \n        ";
        /* if forloop.counter % 2 == 0 */
        $buffer2 .= "\n            Par\n        ";
        /* else */
        $buffer2 .= "\n            Inpar\n        ";
        /* endif */
        $buffer2 .= "\n        {$forcounter_3}\n    ";
        $forcounter_3  = $forcounter_3 + 1;
    }
    $buffer2 .= "\n";
    $blocks["td"]  = "{$buffer2}";
    $buffer1 .= base_template($vars, $blocks);;
    if ($return) {
        return $buffer1;
    } else  {
        echo "{$buffer1}";
    }
}

$arr = array('some_list' => array(1, 2, 3, 3, 4, 4, 4, 5), 'user' => 'crodas');
base_template($arr);
echo "\n\n------------------------------\n\n";
subtemplate_template($arr);
