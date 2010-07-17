<?php

class FirstOf_Tag
{
    /**
     *  firstof tag
     *
     */
    function generator($cmp, $args)
    {
        $texpr = array();
        foreach ($args as $var) {
            if (isset($var['string'])) {
                $texpr[] = $var;
                break;
            }
            $texpr[] = $cmp->expr_cond(
                $cmp->expr_exec('empty', $var),
                "",
                $var
            );
        }
        $texpr = array_reverse($texpr);
        for ($i=1; $i < count($texpr); $i++) {
           $texpr[$i]['true'] = $texpr[$i-1]; 
        }
        return $texpr[$i-1];
    }
}
