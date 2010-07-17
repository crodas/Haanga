<?php

class Pluralize_Filter
{
    function generator($compiler, $args)
    {
        if (count($args) > 1) {
            if (!isset($args[1]['string'])) {
                throw new Haanga_CompilerException("pluralize: First parameter must be an string");
            }
            $parts    = explode(",", $args[1]['string']);
            $singular = "";
            if (count($parts) == 1) {
                $plural = $parts[0];
            } else {
                $singular = $parts[0];
                $plural   = $parts[1];
            }
        } else {
            $singular = "";
            $plural   = "s";
        }

        return $compiler->expr_cond(
            $compiler->expr("<=", $args[0], 1),
            $compiler->expr_str($singular),
            $compiler->expr_str($plural)
        );
    }
}
