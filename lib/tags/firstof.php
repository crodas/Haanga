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
        foreach ($args as $arg) {
            if (HCode::is_str($arg)) {
                $texpr[] = $arg;
                break;
            }
            $texpr[] = hexpr_cond(hexec('empty', $arg), "", $arg)->getArray();
        }
        $texpr = array_reverse($texpr);
        for ($i=1; $i < count($texpr); $i++) {
            $texpr[$i]['true'] = $texpr[$i-1]; 
        }
        return $texpr[$i-1];
    }
}
