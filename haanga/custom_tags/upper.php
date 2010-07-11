<?php

class Upper_Tag extends Custom_Tag
{
    public static $is_block  = TRUE;
    /* This tag calls to a PHP native function */
    public static $php_alias = "strtoupper"; 
}
