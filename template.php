<?php

/* Generated from base.html */
function base_template($vars, $blocks=array(), $return=FALSE)
{
    extract($vars);
    $buffer1  = "<script>\nvar i = 5 % 4;\nfunction foo_bar  () {\n    cesar {\$rodas}\n}\n</script>\n";
    /* Testing Comment */
    $buffer1 .= "\n<table>\n";
    if (count($some_list) == 0) {
        $buffer1 .= " \n<tr> \n    <td>\n        Dear {$user} you found a bug ;-)\n    </td>\n</tr>\n";
    } else {
        $forcounter_1  = 1;
        $forcounter0_1  = 0;
        foreach ($some_list as  $var) {
            $buffer1 .= "\n\n    <tr class=\"";
            $def_cycle_0  = Array("row1 \' cesar","row2");
            $index_0  = (!isset($index_0) ? 0 : ($index_0 + 1) % sizeof($def_cycle_0));
            $buffer1 .= "{$def_cycle_0[$index_0]}\">\n        <td style=\"background-color: ";
            if (!isset($ifchanged1[0]) || $ifchanged1[0] != $var) {
                $buffer1 .= " ";
                $def_cycle_1  = Array("red","back");
                $index_1  = (!isset($index_1) ? 0 : ($index_1 + 1) % sizeof($def_cycle_1));
                $buffer1 .= "{$def_cycle_1[$index_1]} ";
                $ifchanged1  = Array($var);
            } else {
                $buffer1 .= " ";
                $def_cycle_2  = Array("gray","white");
                $index_2  = (!isset($index_2) ? 0 : ($index_2 + 1) % sizeof($def_cycle_2));
                $buffer1 .= "{$def_cycle_2[$index_2]} ";
            }
            $buffer1 .= "\">\n            Foobar {$var}\n            ";
            $buffer2  = "\n            ";
            $buffer3  = "\n            cesar\n            ";
            $buffer4  = "\n            Date {$var} foo \n            dasdasdasdasdasldaksdhasd\n            asdlkasjdlkasjdlkasjdlkajdas\n                        dasa\n            ";
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
            $buffer2  = "\n            test\n            ";
            $buffer3  = "foo";
            if (!isset($blocks["foo"])) {
                $buffer2 .= "{$buffer3}";
            } else {
                if (is_array($blocks["foo"])) {
                    $blocks["foo"]  = str_replace("\$parent_value",$buffer3,$blocks["foo"][0]);
                }
                $buffer2 .= "{$blocks["foo"]}";
            }
            $buffer2 .= "\n        Strlen: ";
            $buffer3  = "\n        ";
            $forcounter_2  = 1;
            $forcounter0_2  = 0;
            foreach ($some_list as  $var) {
                $buffer3 .= "\n            ";
                $buffer4  = "\n            ";
                /* Define a custom filter (AKA call a PHP function) */
                $buffer4 .= "\n            i must be uppercase\n            ";
                $buffer3 .= strtoupper($buffer4)."\n            {$forcounter_2}<br/>\n            {$forcounter0_2}<br/>\n        ";
                $forcounter_2  = $forcounter_2 + 1;
                $forcounter0_2  = $forcounter0_2 + 1;
            }
            $buffer3 .= "\n        ";
            $buffer2 .= strlen($buffer3)."\n\n        ";
            if (!isset($blocks["test"])) {
                $buffer1 .= "{$buffer2}";
            } else {
                if (is_array($blocks["test"])) {
                    $blocks["test"]  = str_replace("\$parent_value",$buffer2,$blocks["test"][0]);
                }
                $buffer1 .= "{$blocks["test"]}";
            }
            $buffer1 .= "\n        </td>\n        <td>\n        ";
            $buffer2  = " \n            ";
            $buffer3  = "\n                Testing block with filter {$forcounter_1} :-)\n            ";
            $buffer2 .= strtoupper(strtolower($buffer3))."\n        ";
            if (!isset($blocks["td"])) {
                $buffer1 .= "{$buffer2}";
            } else {
                if (is_array($blocks["td"])) {
                    $blocks["td"]  = str_replace("\$parent_value",$buffer2,$blocks["td"][0]);
                }
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
    } else {
        echo "{$buffer1}";
    }
}


/* Generated from subtemplate.html */
function subtemplate_template($vars, $blocks=array(), $return=FALSE)
{
    extract($vars);
    $buffer1  = "";
    $buffer2  = "\n    New content by {$user}\n    ".include_template($vars, $blocks, TRUE)."\n";
    $blocks["td"]  = "{$buffer2}";
    $buffer2  = "\n    simplest output\n    [\$parent_value]\n";
    /* declared as array because this block it needs to access parent block's contents */
    $blocks["foo"]  = Array($buffer2);
    $buffer1 .= base_template($vars, $blocks, TRUE);
    if ($return) {
        return $buffer1;
    } else {
        echo "{$buffer1}";
    }
}
/* Generated from include.html */
function include_template($vars, $blocks=array(), $return=FALSE)
{
    extract($vars);
    $buffer1  = "    ";
    $forcounter_3  = 1;
    foreach ($some_list as  $var) {
        $buffer1 .= " \n        ";
        if ($forcounter_3 % 2 == 0 AND 1 == 1) {
            $buffer1 .= "\n            Par\n        ";
        } else {
            $buffer1 .= "\n            Inpar\n        ";
        }
        $buffer1 .= "\n        {$forcounter_3}\n    ";
        $forcounter_3  = $forcounter_3 + 1;
    }
    $buffer1 .= "\n";
    if ($return) {
        return $buffer1;
    } else {
        echo "{$buffer1}";
    }
}




/* Generated from ./subsubtemplate.html */
function subsubtemplate_template($vars, $blocks=array(), $return=FALSE)
{
    extract($vars);
    $buffer1  = "";
    $buffer2  = "\n    hello\n";
    $blocks["test"]  = "{$buffer2}";
    $buffer1 .= subtemplate_template($vars, $blocks, TRUE);
    if ($return) {
        return $buffer1;
    } else {
        echo "{$buffer1}";
    }
}

$arr = array('some_list' => array(1, 2, 3, 3, 4, 4, 4, 5), 'user' => 'crodas');
base_template($arr);
echo "\n\n------------------------------\n\n";
subtemplate_template($arr);
echo "\n\n------------------------------\n\n";
subsubtemplate_template($arr);
