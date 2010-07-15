<?php
/* Generated from ./assert_templates/regroup.tpl */
function haanga_e3288a8c38d2925df1b81c50c72b7eee31f8c2f9($vars, $return=FALSE, $blocks=array())
{
    extract($vars);
    $buffer1  = "";
    $sorted_users  = Array();
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
    $forcounter1_6  = 1;
    foreach ($sorted_users as  $user) {
        $buffer1 .= "\n    ".htmlentities($user["grouper"])."\n    ";
        $forcounter1_7  = 1;
        $psize_7  = count($user["list"]);
        $islast_7  = $forcounter1_7 == $psize_7;
        $isfirst_7  = TRUE;
        $revcount_7  = count($user["list"]);
        $revcount0_7  = count($user["list"]) - 1;
        foreach ($user["list"] as  $u) {
            $buffer1 .= "\n        ".htmlentities($forcounter1_7)."-".htmlentities($revcount_7)."-".htmlentities($revcount0_7)." (".htmlentities($forcounter1_6)."). ".htmlentities(ucfirst($u["name"]))." (";
            if ($isfirst_7) {
                $buffer1 .= "first";
            } else {
                if ($islast_7) {
                    $buffer1 .= "last";
                }
            }
            $buffer1 .= ")\n    ";
            $forcounter1_7++;
            $islast_7  = $forcounter1_7 == $psize_7;
            $isfirst_7  = FALSE;
            $revcount_7  = $revcount_7 - 1;
            $revcount0_7  = $revcount0_7 - 1;
        }
        $buffer1 .= "\n";
        $forcounter1_6++;
    }
    $buffer1 .= "\n";
    if ($return == TRUE) {
        return $buffer1;
    } else {
        echo $buffer1;
    }
}