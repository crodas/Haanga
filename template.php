<?php
function template($var, $partial=array()) {
    extract($var);

    echo "<script>
var i = 5 % 4;
function foo_bar  () {
    cesar {\$rodas}
}
</script>

<table>
";
    if (!is_array($some_list) OR count($some_list) == 0)
    {
        echo " 
<tr> 
    <td>
        Dear {$user} you found a bug ;-)
    </td>
</tr>
";
        
    }
    else
    {
        foreach ($some_list as  $var)
        {
            $def_cycle_0 = Array('row1 cesar','row2',);
            $index_0 = (!isset($index_0) ? 0 : ($index_0 + 1) % sizeof($def_cycle_0));
            echo "
    <tr class=\"{$def_cycle_0[$index_0]}\">
        <td style=\"background-color: ";
            if (!isset($ifchanged_0[0]) || $ifchanged_0[0] != $var)
            {
                $def_cycle_1 = Array('red','back',);
                $index_1 = (!isset($index_1) ? 0 : ($index_1 + 1) % sizeof($def_cycle_1));
                echo " {$def_cycle_1[$index_1]} ";
                $ifchanged_0 = Array($var,);
                
            }
            else
            {
                $def_cycle_2 = Array('gray','white',);
                $index_2 = (!isset($index_2) ? 0 : ($index_2 + 1) % sizeof($def_cycle_2));
                echo " {$def_cycle_2[$index_2]} ";
                
            }
            echo "\">
            Foobar {$var}
            ";
            ob_start();
            echo "
            ";
            $block = ob_start();
            echo "Date {$var} foo ";
            $output_1 = ob_get_clean();
            if (!isset($ifchanged_1) OR $output_1 != $ifchanged_1)
            {
                echo "{$output_1}";
                $ifchanged_1 = $output_1;
                
            }
            echo "
            ".strtoupper(strtolower(ob_get_clean()))."
        </td>
        <td>
        ";
            ob_start();
            echo "
            ";
            if (!isset($partial) || !isset($partial["td"]))
            {
                echo " Testing block with filter ";
                
            }
            else
            {
                echo "{$partial["td"]}";
                
            }
            echo "
        ".strtoupper(strtolower(ob_get_clean()))."
        </td>
";
            
        }
        
    }
    echo "
    </tr>
</table>
";
}

template(array('some_list' => array(1, 2,2, 3, 4, 4)));

