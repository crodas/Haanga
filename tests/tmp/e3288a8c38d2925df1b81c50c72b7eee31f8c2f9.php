<?php
/* Load filter dictsort definition */
Haanga::doInclude("/filters/dictsort.php");
/* Generated from ./assert_templates/regroup.tpl */
function haanga_e3288a8c38d2925df1b81c50c72b7eee31f8c2f9($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    $sorted_users  = Array();
    $users  = Dictsort_Filter::main($users, "age");
    /* Temporary sorting */
    foreach ($users as  $item) {
        $temp_group[$item["age"]][]  = $item;
    }
    /* Proper format */
    foreach ($temp_group as  $group => $item) {
        $sorted_users[]  = Array("grouper" => $group, "list" => $item);
    }
    /* Sorting done */
    $buffer1 .= "\n\n";
    $forcounter1_1  = 1;
    foreach ($sorted_users as  $user) {
        $buffer1 .= "\n    ".htmlentities($user["grouper"])."\n    ";
        $forcounter1_2  = 1;
        $psize_2  = count($user["list"]);
        $islast_2  = $forcounter1_2 == $psize_2;
        $isfirst_2  = TRUE;
        $revcount_2  = $psize_2;
        $revcount0_2  = $psize_2 - 1;
        foreach ($user["list"] as  $u) {
            $buffer1 .= "\n        ".$forcounter1_2."-".$revcount_2."-".$revcount0_2." (".$forcounter1_1."). ".htmlentities(ucfirst($u["name"]))." (";
            if ($isfirst_2) {
                $buffer1 .= "first";
            } else {
                if ($islast_2) {
                    $buffer1 .= "last";
                }
            }
            $buffer1 .= ")\n    ";
            $forcounter1_2++;
            $islast_2  = $forcounter1_2 == $psize_2;
            $isfirst_2  = FALSE;
            $revcount_2  = $revcount_2 - 1;
            $revcount0_2  = $revcount0_2 - 1;
        }
        $buffer1 .= "\n";
        $forcounter1_1++;
    }
    $buffer1 .= "\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}