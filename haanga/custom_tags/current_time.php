<?php

class Current_Time_Tag extends Custom_Tag
{
    public static $is_block  = FALSE;
    /* This tag calls to a PHP native function */
    public static $php_alias = "date";
}
