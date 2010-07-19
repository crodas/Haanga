<?php

class Cycle_Tag
{
    public $is_block = FALSE;

    function generator($cmp, $args, $declared)
    {
        static $cycle = 0;
        if (!isset($cmp->cycle)) {
            $cmp->cycle = array();
        }
        $index = 'index_'.$cycle;
        $def   = 'def_cycle_'.$cycle; 
        $out   = array();

        if (count($args) == 1 && $cmp->is_var($args[0]) && isset($cmp->cycle[$args[0]['var']])) {
            $id    = $cmp->cycle[$args[0]['var']];
            $index = 'index_'.$id;
            $def   = 'def_cycle_'.$id; 
        } else {
            $out[] = $cmp->op_declare($def, $cmp->expr_array_ex($args));
        }

        /* isset($var) == FALSE */
        $expr = $cmp->expr('==', $cmp->expr_exec('isset', $cmp->expr_var($index)), FALSE);
        /* ($foo + 1) % count($bar) */
        $inc = $cmp->expr('%',
            $cmp->expr('expr',
                $cmp->expr('+', $cmp->expr_var($index), 1)
            ),
            $cmp->expr_exec('count', $cmp->expr_var($def))
        );

        if (!$declared) {
            if (isset($id)) {
                $out[] = $cmp->op_declare($index, $inc);
            } else {
                $out[] = $cmp->op_declare($index, $cmp->expr_cond($expr, $cmp->expr_number(0), array('expr' => $inc))); 
            }
            $var   = $cmp->expr_var($def, $cmp->expr_var($index));
            $cmp->generate_op_print(array("variable" => $var['var']), $out);
        } else {
            $out[] = $cmp->op_declare($index, $cmp->expr_number(-1));
            $cmp->cycle[$declared] = $cycle;
        }

        $cycle++;

        return new ArrayIterator($out);

    }
}
