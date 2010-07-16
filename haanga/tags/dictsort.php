<?php

class Dictsort_Tag
{

    /**
     *  Sorted a nested array by '$sort_by'
     *  property on each sub-array. , if you want 
     *  to see the original php file look filters/dictsort.php
     */
    function generator($cmp, $args, $redirected)
    {
        if (!$redirected) {
            throw new CompilerException("dictsort must be redirected to a variable using AS <varname>");
        }

        /* set redirected as a variable */
        $redirected = $cmp->expr_var($redirected);
        $field      = $cmp->expr_var('field');
        $key        = $cmp->expr_var('key');

        /* create list of statements */
        $out   = array();
        $out[] = $cmp->op_declare($redirected, $args[0]);
        $out[] = $cmp->op_declare('field', $cmp->expr_array());
        $out[] = $cmp->op_foreach($redirected, 'item', $key);
        $out[] = $cmp->op_declare($cmp->expr_var('field', $key), $cmp->expr_var('item', $args[1]));
        $out[] = $cmp->op_end('foreach');
        $out[] = $cmp->op_expr($cmp->expr_exec('array_multisort', $cmp->expr_var('field'), $cmp->expr_const('SORT_ASC'), $redirected));

        return new ArrayIterator($out);
    }
}
