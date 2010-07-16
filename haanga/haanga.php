<?php
/*
  +---------------------------------------------------------------------------------+
  | Copyright (c) 2010 Haanga                                                       |
  +---------------------------------------------------------------------------------+
  | Redistribution and use in source and binary forms, with or without              |
  | modification, are permitted provided that the following conditions are met:     |
  | 1. Redistributions of source code must retain the above copyright               |
  |    notice, this list of conditions and the following disclaimer.                |
  |                                                                                 |
  | 2. Redistributions in binary form must reproduce the above copyright            |
  |    notice, this list of conditions and the following disclaimer in the          |
  |    documentation and/or other materials provided with the distribution.         |
  |                                                                                 |
  | 3. All advertising materials mentioning features or use of this software        |
  |    must display the following acknowledgement:                                  |
  |    This product includes software developed by César D. Rodas.                  |
  |                                                                                 |
  | 4. Neither the name of the César D. Rodas nor the                               |
  |    names of its contributors may be used to endorse or promote products         |
  |    derived from this software without specific prior written permission.        |
  |                                                                                 |
  | THIS SOFTWARE IS PROVIDED BY CÉSAR D. RODAS ''AS IS'' AND ANY                   |
  | EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED       |
  | WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE          |
  | DISCLAIMED. IN NO EVENT SHALL CÉSAR D. RODAS BE LIABLE FOR ANY                  |
  | DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES      |
  | (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;    |
  | LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND     |
  | ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT      |
  | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS   |
  | SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE                     |
  +---------------------------------------------------------------------------------+
  | Authors: César Rodas <crodas@php.net>                                           |
  +---------------------------------------------------------------------------------+
*/

define('HAANGA_DIR', dirname(__FILE__));

// Load needed files {{{
require HAANGA_DIR."/lexer.php";
require HAANGA_DIR."/generator.php";
require HAANGA_DIR."/extensions.php";
require HAANGA_DIR."/tags.php";
require HAANGA_DIR."/filters.php";
// }}}

// Exception Class {{{
/**
 *  Exception class
 *
 */
class Haanga_CompilerException extends Exception
{
}
// }}}


class Haanga_Main
{

    // properties {{{
    protected static $block_var=NULL;
    protected $generator;
    protected $forloop = array();
    protected $forid = 0;
    protected $sub_template = FALSE;
    protected $name;
    protected $blocks=array();
    /**
     *  number of blocks :-)
     */
    protected $in_block=0;
    /**
     *  output buffers :-)
     */
    protected $ob_start=0;
    protected $append;
    protected $prepend_op;
    /**
     *  Table which contains all variables 
     *  aliases defined in the template
     */
    protected $var_alias;
    /**
     *  Flag the current variable as safe. This means
     *  that escape won't be called if autoescape is 
     *  activated (which is activated by default)
     */
    public $var_is_safe=FALSE;
    protected $autoescape=TRUE;
    protected $force_whitespaces=0;
    /**
     *  Debug file
     */
    protected $debug;
    // }}}

    function __construct()
    {
        $this->generator = new Haanga_CodeGenerator;
        if (self::$block_var===NULL) {
            self::$block_var = '{{block.'.md5('super').'}}';
        }
    }

    // setDebug($file) {{{
    function setDebug($file)
    {
        $this->debug = $file;
    }
    // }}}

    // reset() {{{
    function reset()
    {
        $avoid_cleaning = array('strip_whitespaces' => 1, 'block_var' => 1, 'autoescape'=>1);
        foreach (array_keys(get_object_vars($this)) as $key) {
            if (isset($avoid_cleaning[$key])) {
                continue;
            }
            $this->$key = NULL;
        }
        $this->generator = new Haanga_CodeGenerator;
        $this->blocks = array();
        $this->cycle  = array();
    }
    // }}}

    // get_template_name() {{{
    final function get_template_name()
    {
        return $this->name;
    }
    // }}}

    // Set template name {{{
    function set_template_name($path)
    {
        return ($this->name = strstr(basename($path),'.', TRUE));
    }
    // }}}

    // get_function_name(string $name) {{{
    function get_function_name($name)
    {
        return "{$name}_template";
    }
    // }}}

    // Compile ($code, $name=NULL) {{{
    final function compile($code, $name=NULL)
    {
        $this->name = $name;

        $parsed = do_parsing($code);
        $code   = "";
        $this->subtemplate = FALSE;

        if ($parsed[0]['operation'] == 'base') {
            /* {% base ... %} found */
            $base  = $parsed[0][0];
            $code .= $this->get_base_template($base); 
            unset($parsed[0]);
        }

        if ($name) {
            if (isset($this->_file)) {
                $op_code[] = $this->op_comment("Generated from {$this->_base_dir}/{$this->_file}");
            }
            $op_code[] = $this->op_declare_function($this->get_function_name($name));
            $op_code[] = $this->op_expr($this->expr_exec('extract', $this->expr_var('vars')));
        }

        $this->ob_start($op_code);
        $this->generate_op_code($parsed, $op_code);
        if ($this->subtemplate) {
            $expr = $this->expr_call_base_template();
            $this->generate_op_print(array('expr' => $expr), $op_code);
        }
        $this->ob_start--;

        /* Add last part */
        $expr = $this->expr('==', $this->expr_var('return'), TRUE);
        $op_code[] = $this->op_if($expr);
        $op_code[] = $this->op_return($this->expr_var('buffer1'));
        $op_code[] = $this->op_else();
        $this->generate_op_print(array('variable' => 'buffer1'), $op_code);
        $op_code[] = $this->op_end('if');

        if ($name) {
            $op_code[] = $this->op_end('function');
        }
        
        if (count($this->prepend_op)) {
            $op_code = array_merge($this->prepend_op, $op_code);
        }

        $code .= $this->generator->getCode($op_code);
        if (!empty($this->append)) {
            $code .= $this->append;
        }
        if (!empty($this->debug)) {
            file_put_contents($this->debug, print_r($op_code, TRUE));
        }
        return $code;
    }
    // }}}

    // compile_file($file) {{{
    /**
     *  Compile a file
     *
     *  @param string $file File path
     *
     *  @return Generated PHP code
     */
    final function compile_file($file) 
    {
        if (!is_readable($file)) {
            throw new Haanga_CompilerException("$file is not a file");
        }
        $this->_base_dir = dirname($file);
        $this->_file     = basename($file);
        $name            = $this->set_template_name($file);
        return $this->compile(file_get_contents($file), $name);
    }
    // }}}

    // is_expr methods {{{
    function is_expr(Array $cmd, $type=NULL)
    {
        if (isset($cmd['op_expr'])) {
            if (!$type || $type == $cmd['op_expr']) {
                return TRUE;
            }
        }
        return FALSE;
    }

    function is_exec(Array $cmd)
    {
        return $this->is_expr($cmd, 'exec');
    }

    function is_var(Array $cmd)
    {
        return isset($cmd['var']);
    }
    // }}}

    // op_* helper methods {{{
    /**
     *  Return an stand alone expression
     *
     */
    function op_expr($expr)
    {
        return array('op' => 'expr', $expr);
    }

    function op_comment($comment)
    {
        return array('op' => 'comment', 'comment' => $comment);
    }

    function op_foreach($array, $value, $key=NULL)
    {
        foreach (array('array', 'value', 'key') as $var) {
            $var = &$$var;
            if (is_array($var) && isset($var['var'])) {
                $var = $var['var'];
            }
            unset($var);
        }
        $def = array('op' => 'foreach', 'array' => $array, 'value' => $value);
        if ($key) {
            $def['key'] = $key;
        }
        return $def;
    }

    function op_if($expr)
    {
        return array('op' => 'if', 'expr' => $expr);
    }

    function op_else()
    {
        return array('op' => 'else');
    }

    function op_return($expr)
    {
        return array('op' => 'return', $expr);
    }

    function op_end($op)
    {
        return array('op' => "end_{$op}");
    }

    function op_declare($name, $value)
    {
        if (is_array($name)) {
            if (isset($name['var'])) {
                $name = $name['var'];
            }
        }

        if (is_array($value)) {
            if (isset($value['op_expr'])) {
                $value = array('expr' => $value);
            }
        }

        return array('op' => 'declare', 'name' => $name, $value);
    }

    function op_append($name, $expr)
    {
        return array('op' => 'append_var', 'name' => $name, $expr);
    }


    function op_inc($name)
    {
        return array('op' => 'inc', 'name' => $name);
    }

    function op_declare_function($name)
    {
        return array('op' => 'function', 'name' => $name);
    }

    //}}}

    // expr_* helper methods {{{
    function expr_cond($expr, $true, $false)
    {
        return array('expr_cond' => $expr, 'true' => $true, 'false' => $false);
    }

    function expr_const($name)
    {
        return array('constant' => $name);
    }

    /**
     *  Generate code to call base template
     *
     */
    function expr_call_base_template()
    {
        return $this->expr_exec(
            $this->get_function_name($this->subtemplate),
            $this->expr_var('vars'),
            $this->expr_TRUE(),
            $this->expr_var('blocks')
        );
    }

    /**
     *  return a function call for isset($var) === $isset
     *
     *  @return array
     */
    final function expr_isset($var, $isset=TRUE)
    {
        return $this->expr('==', $this->expr_exec('isset', $this->expr_var($var)), $isset);
    }

    final function expr_isset_ex($var, $isset=TRUE)
    {
        return $this->expr('==', $this->expr_exec('isset', $var), $isset);
    }

    final function expr_array()
    {
        $def = array();
        foreach (func_get_args() as $arg) {
            if (count($arg) == 2) {
                if (!is_array($arg[0])) {
                    $arg[0] = $this->expr_str($arg[0]);
                }
                $arg = array('key' => $arg);
            }
            $def[] = $arg;
        }
        return array("array" => $def);
    }

    final function expr_array_first($values)
    {
        $def = array();
        foreach ($values as $arg) {
            if (count($arg) == 2) {
                if (!is_array($arg[0])) {
                    $arg[0] = $this->expr_str($arg[0]);
                }
                $arg = array('key' => $arg);
            }
            $def[] = $arg;
        }
        return array("array" => $def);
    }


    /**
     *  return an number definition of $num
     *
     *  @return array
     */
    final function expr_number($num=0)
    {
        return array('number' =>$num);
    }

    /**
     *  return an string definition of $str
     *
     *  @return array
     */
    final function expr_str($str='')
    {
        return array('string' => $str);
    }

    /**
     *  Generate expression that for
     *  boolean TRUE
     *
     *  @return array
     */
    final function expr_TRUE()
    {
        return array('expr' => TRUE);
    }

    /**
     *  Generate expression that for
     *  boolean FALSE
     *
     *  @return array
     */
    final function expr_FALSE()
    {
        return array('expr' => FALSE);
    }

    /**
     *  Return expr for variable reference
     *
     *  @return array
     */
    final function expr_var($var)
    {
        return array('var' => func_get_args());
    }

    /**
     *  Return expr for variable reference
     *
     *  @return array
     */
    final function expr_var_ex(Array $var)
    {
        return array('var' => $var);
    }

    /**
     *  Generate expression for
     *  a function calling inside an expression
     *
     *  @return array
     */
    final function expr_exec($function)
    {
        $args = func_get_args();
        unset($args[0]);
        $args = array_values($args);

        return array(
            'exec' => $function,
            'args' => $args
        );
    }



    /**
     *  Generate a generic expression
     *  
     *  @return array
     */
    final function expr($operation, $expr1, $expr2=NULL) 
    {
        $expr = array('op_expr' => $operation, $expr1);
        if ($expr2 !== NULL) {
            $expr[] = $expr2;
        }

        return $expr;
    }
    // }}}

    // get_base_template($base) {{{
    /**
     *  Handle {% base  "" %} definition. By default only 
     *  static (string) are supported, but this can be overrided
     *  on subclasses.
     *
     *  This method load the base class, compile it and return
     *  the generated code.
     *
     *  @param array $base Base structure
     *
     *  @return string Generated source code
     */
    function get_base_template($base)
    {
        if (!isset($base['string'])) {
            throw new Haanga_CompilerException("Dynamic inheritance is not supported for compilated templates");
        }
        $file = $base['string'];
        list($this->subtemplate, $new_code) = $this->compile_required_template($file);
        return $new_code."\n\n";
    }
    // }}}

    // {% base "foo.html" %} {{{
    protected function generate_op_base()
    {
        throw new exception("{% base %} can be only as first statement");
    }
    // }}}

    // Main Loop {{{
    protected function generate_op_code($parsed, &$out)
    {
        if (!is_array($parsed)) {
            throw new Haanga_CompilerException("Invalid \$parsed array");
        }
        foreach ($parsed as $op) {
            if (!isset($op['operation'])) {
                throw new Haanga_CompilerException("Malformed $parsed array");
            }
            if ($this->subtemplate && $this->in_block == 0 && $op['operation'] != 'block') {
                /* ignore most of tokens in subtemplates */
                continue;
            }
            $method = "generate_op_".$op['operation'];
            if (!is_callable(array($this, $method))) {
                throw new Haanga_CompilerException("Compiler: Missing method $method");
            }
            $this->$method($op, $out);
        }
    }
    // }}}

    // Check the current expr  {{{
    protected function check_expr(&$expr)
    {
        if (is_array($expr) && isset($expr['op_expr'])) {
            if ($expr['op_expr'] == 'in') {
                if (isset($expr[1]['string'])) {
                    $expr = $this->expr("!==",
                        $this->expr_exec("strpos", $expr[1], $expr[0]),
                        FALSE
                    );
                } else {
                    $expr = $this->expr("!==", $this->expr_cond(
                        $this->expr("==", $this->expr_exec("is_array", $expr[1]), TRUE),
                        $this->expr_exec("array_search", $expr[0], $expr[1]),
                        $this->expr_exec("strpos", $expr[1], $expr[0])
                    ), FALSE);

                }
            }
            $this->check_expr($expr[0]);
            $this->check_expr($expr[1]);
        } else {
            if (is_array($expr)) {
                if (isset($expr['var'])) {
                    $expr = $this->generate_variable_name($expr['var']);
                } else if (isset($expr['var_filter'])) {
                    foreach ($expr['var_filter'] as $id => $f) {
                        if ($id == 0) {
                            $exec = $this->generate_variable_name($f);
                        } else {
                            $exec = $this->expr_exec($f, $exec);
                        }
                    }
                    $expr = $exec;
                } else if (isset($expr['args'])) {
                    /* check every arguments */
                    foreach ($expr['args'] as &$v) {
                        $this->check_expr($v);
                    }
                    unset($v);
                } else  if (isset($expr['expr_cond'])) {
                    /* Check expr conditions */
                    $this->check_expr($expr['expr_cond']);
                    $this->check_expr($expr['true']);
                    $this->check_expr($expr['false']);
                }
            } 
        }
    }
    // }}}

    // {% if <expr> %} HTML {% else %} TWO {% endif $} {{{
    protected function generate_op_if($details, &$out)
    {
        $this->check_expr($details['expr']);
        $out[] = $this->op_if($details['expr']);
        $this->generate_op_code($details['body'], $out);
        if (isset($details['else'])) {
            $out[] = $this->op_else();
            $this->generate_op_code($details['else'], $out);
        }
        $out[] = $this->op_end('if');
    }
    // }}}

    // Overload template {{{
    protected function compile_required_template($file)
    {
        if (!is_file($file)) {
            if (isset($this->_base_dir)) {
                $file = $this->_base_dir.'/'.$file;
            }
        }
        if (!is_file($file)) {
            throw new Haanga_CompilerException("can't find {$file} file template");
        }
        $class = get_class($this);
        $comp  = new  $class;
        $comp->reset();
        $code = $comp->compile_file($file);
        return array($comp->get_template_name(), $code);
    }
    // }}}
    
    // include "file.html" | include <var1> {{{
    protected function generate_op_include($details, &$out)
    {
        if (!$details[0]['string']) {
            throw new Haanga_CompilerException("Dynamic inheritance is not supported for compilated templates");
        }
        list($name,$code) = $this->compile_required_template($details[0]['string']);
        $this->append .= "\n\n{$code}";
        $expr = $this->expr_exec(
            $this->get_function_name($this->subtemplate),
            $this->expr_var('vars'),
            $this->expr_var('blocks'),
            $this->expr_TRUE()
        );
        $this->generate_op_print($expr, $op_code);
        $this->generate_op_print($expr, $out);
    }
    // }}}

    // Handle HTML code {{{
    protected function generate_op_html($details, &$out)
    {
        $this->generate_op_print($details, $out);
    }
    // }}}

    // get_var_filtered {{{
    /**
     *  This method handles all the filtered variable (piped_list(X)'s 
     *  output in the parser.
     *
     *  
     *  @param array $variable      (Output of piped_list(B) (parser))
     *  @param array &$varname      Variable name
     *  @param bool  $accept_string  TRUE is string output are OK (ie: block.parent)
     *
     *  @return expr  
     *
     */
    function get_filtered_var($variable, &$varname, $accept_string=FALSE)
    {
        $this->var_is_safe = FALSE;
        if (count($variable) > 1) {
            $count  = count($variable);
            $target = $this->generate_variable_name($variable[0]);
            
            if (!isset($target['var'])) {
                /* block.super can't have any filter */
                throw new Haanga_CompilerException("This variable can't have any filter");
            }

            for ($i=1; $i < $count; $i++) {
                $func_name = $variable[$i];
                if ($func_name == 'escape') {
                    /* to avoid double cleaning */
                    $this->var_is_safe = TRUE;
                }
                $args = array(isset($exec) ? $exec : $target);
                $exec = $this->do_filtering($func_name, $args);
            }
            unset($variable);
            $varname = $args[0];
            $details = $exec;
        } else {
            $details = $this->generate_variable_name($variable[0]);
            $varname = $variable[0];

            if (!isset($details['var']) && !$accept_string) {
                /* generate_variable_name didn't replied a variable, weird case
                    currently just used for {{block.super}}.
                */
                throw new Haanga_CompilerException("Invalid variable name {$variable[0]}");
            }
        }

        return $details;
    }
    // }}}

    // generate_op_print_var {{{
    /**
     *  Generate code to print a variable with its filters, if there is any.
     *
     *  All variable (except those flagged as |safe) are automatically 
     *  escaped if autoescape is "on".
     *
     */
    protected function generate_op_print_var($details, &$out)
    {

        $details = $this->get_filtered_var($details['variable'], $variable, TRUE);

        if (!isset($details['var']) && !isset($details['exec'])) {
            /* generate_variable_name didn't replied a variable, weird case
                currently just used for {{block.super}}.
            */
            $this->generate_op_print($details, $out);
            return;
        }


        if (!$this->var_is_safe && $this->autoescape) {
            $args    = array($details);
            $details = $this->do_filtering('escape', $args);
        }

        $this->generate_op_print($details, $out);
    }
    // }}}

    // is_last_op_print($out) {{{
    /**
     *  Return TRUE if the last stacked operation
     *  is a print (declare or append_var).
     *
     *  @param array $out Stack of operations
     *
     *  @return bool
     */
    protected function is_last_op_print($out)
    {
        $last   = count($out)-1;
        $sprint = array('print', 'declare', 'append_var');
        return $last >= 0 && array_search($out[$last]['op'], $sprint) !== FALSE;
    }
    // }}}

    // first_of var1 var2 'name' {{{
    protected function generate_op_first_of($details, &$out)
    {
        $texpr = array();
        foreach ($details['vars'] as $var) {
            if (isset($var['string'])) {
                $texpr[] = $var;
                break;
            }
            $texpr[] = $this->expr_cond(
                $this->expr_isset($var['var']),
                $var,
                ""
            );
        }
        $texpr = array_reverse($texpr);
        for ($i=1; $i < count($texpr); $i++) {
           $texpr[$i]['false'] = $texpr[$i-1]; 
        }
        $expr = $texpr[$i-1];

        $this->generate_op_print($expr, $out);
    }
    // }}}

    // {# something #} {{{
    protected function generate_op_comment($details, &$out)
    {
        if ($this->is_last_op_print($out)) {
            /* If there is a print declared previously, we pop it
               and add it after the cycle declaration
             */
            $old_print = array_pop($out);
        }
        $out[] = $this->op_comment($details['comment']);
        if (isset($old_print)) {
            $out[] = $old_print;
        }
    }
    // }}} 

    // {% block 'name' %} ... {% endblock %} {{{
    protected function generate_op_block($details, &$out)
    {
        $this->in_block++;
        $this->blocks[] = $details['name'];
        $block_name = $this->expr_var('blocks', $details['name']);

        $this->ob_start($out);
        $buffer_var = 'buffer'.$this->ob_start;

        $this->generate_op_code($details['body'], $body);

        $out = array_merge($out, $body);
        $this->ob_start--;

        $buffer = $this->expr_var($buffer_var);

        /* {{{ */
        /**
         *  isset previous block (parent block)?
         *  TRUE
         *      has reference to self::$block_var ?
         *      TRUE    
         *          replace self::$block_var for current block value (buffer)
         *      FALSE
         *          print parent block
         *  FALSE
         *      print current block
         *
         */
        $declare = $this->expr_cond(
            $this->expr_isset_ex($block_name),
            $this->expr_cond(
                $this->expr("===", $this->expr_exec('strpos', $block_name, 
                        $this->expr_str(self::$block_var)
                    ), $this->expr_FALSE()
                ),
                $block_name,
                $this->expr_exec('str_replace', 
                    $this->expr_str(self::$block_var),
                    $buffer,
                    $block_name
                )
            ),
            $buffer
        );
        /* }}} */

        if (!$this->subtemplate) {
            $this->generate_op_print($declare, $out);
        } else {
            $out[] = $this->op_declare($block_name, $declare);
            if ($this->in_block > 1) {
                $this->generate_op_print($block_name, $out);
            }
        }
        array_pop($this->blocks);
        $this->in_block--;

    } 
    // }}}

    // regroup <var1> by <field> as <foo> {{{
    protected function generate_op_regroup($details, &$out)
    {
        $out[] = $this->op_comment("Temporary sorting");
        $array = $this->get_filtered_var($details['array'], $varname);

        if (isset($array['exec'])) {
            $varname = $this->expr_var($details['as']);
            $out[]   = $this->op_declare($varname, $array); 
        }
        $var = $this->expr_var('item', $details['row']);

        $out[] = $this->op_declare('temp_group', $this->expr_array());
        $out[] = $this->op_foreach($varname, 'item');


        $out[] = $this->op_declare(array('temp_group', $var, NULL),  $this->expr_var('item'));
        $out[] = $this->op_end('foreach');

        $out[] = $this->op_comment("Proper format");
        $out[] = $this->op_declare($details['as'], $this->expr_array_first(array()));
        $out[] = $this->op_foreach('temp_group', 'item', 'group');

        $array = $this->expr_array(
            array("grouper", $this->expr_var('group')),
            array("list",    $this->expr_var('item'))
        );
        
        $out[] = $this->op_declare(array($details['as'], NULL), $array );

        $out[] = $this->op_end('foreach');
        $out[] = $this->op_comment("Sorting done");
    }
    // }}}

    // Get variable name {{{
    protected function generate_variable_name($variable)
    {
        if (is_array($variable)) {
            switch ($variable[0]) {
            case 'forloop':
                if (!$this->forid) {
                    throw new Haanga_CompilerException("Invalid forloop reference outside of a loop");
                }
                switch ($variable[1]) {
                case 'counter':
                    $this->forloop[$this->forid]['counter'] = TRUE; 
                    $variable = 'forcounter1_'.$this->forid;
                    break;
                case 'counter0':
                    $this->forloop[$this->forid]['counter0'] = TRUE; 
                    $variable = 'forcounter0_'.$this->forid;
                    break;
                case 'last':
                    $this->forloop[$this->forid]['counter'] = TRUE; 
                    $this->forloop[$this->forid]['last']    = TRUE;
                    $variable = 'islast_'.$this->forid;
                    break;
                case 'first':
                    $this->forloop[$this->forid]['first']    = TRUE;
                    $variable = 'isfirst_'.$this->forid;
                    break;
                case 'revcounter':
                    $this->forloop[$this->forid]['revcounter'] = TRUE;
                    $variable = 'revcount_'.$this->forid;
                    break;
                case 'revcounter0':
                    $this->forloop[$this->forid]['revcounter0'] = TRUE;
                    $variable = 'revcount0_'.$this->forid;
                    break;
                case 'parentloop':
                    unset($variable[1]);
                    $this->forid--;
                    $variable = $this->generate_variable_name(array_values($variable));
                    $variable = $variable['var'];
                    $this->forid++;
                    break;
                default:
                    throw new Haanga_CompilerException("Unexpected forloop.{$variable[1]}");
                }
                /* no need to escape it */
                $this->var_is_safe = TRUE;
                break;
            case 'block':
                if ($this->in_block == 0) {
                    throw new Haanga_CompilerException("Can't use block.super outside a block");
                }
                if (!$this->subtemplate) {
                    throw new Haanga_CompilerException("Only subtemplates can call block.super");
                }
                /* no need to escape it */
                $this->var_is_safe = TRUE;
                return $this->expr_str(self::$block_var);
                break;
            } 

        } else if (isset($this->var_alias[$variable])) {
            $variable = $this->var_alias[$variable];
        }

        return $this->expr_var($variable);
    }
    // }}}

    // Print {{{
    public function generate_op_print($details, &$out)
    {
        $last = count($out)-1;
        if (isset($details['variable'])) {
            $content = $this->generate_variable_name($details['variable']);
        } else if (isset($details['html']))  {
            $html = $details['html'];
            $content = $this->expr_str($html);
        } else {
            $content = $details;
        }

        $var_name = 'buffer'.$this->ob_start;
        
        if ($this->ob_start == 0) {
            $operation = 'print';
        } else {
            $operation = 'append_var';
        }

        if ($last >= 0 && $out[$last]['op'] == $operation && ($operation != 'append_var' || $out[$last]['name'] === $var_name)) {
            /* try to append this to the previous print if it exists */
            $out[$last][] = $content;
        } else {
            if ($this->ob_start == 0) {
                $out[] = array('op' => 'print', $content);
            } else {
                if (isset($out[$last]) && $out[$last]['op'] == 'declare' && $out[$last]['name'] == $var_name) {
                    /* override an empty declaration of a empty buffer 
                       if the next operation is an 'append'
                    */
                    $out[$last][] = $content;
                } else {
                    $out[] = $this->op_append('buffer'.$this->ob_start, $content);
                }
            }
        }
    }
    // }}}

    // for [<key>,]<val> in <array> {{{
    protected function generate_op_loop($details, &$out)
    {
        if (isset($details['empty'])) {
            $expr = $this->expr('==',
                $this->expr_exec('count', $this->expr_var($details['array'])),
                0
            );

            $out[] = $this->op_if($expr);
            $this->generate_op_code($details['empty'], $out);
            $out[] = $this->op_else();
        }

        /* ForID */
        $oldid       = $this->forid;
        $this->forid = $oldid+1;

        $this->forloop[$this->forid] = array();

        /* Loop body */
        $for_loop_body = array();
        $this->generate_op_code($details['body'], $for_loop_body);

        $oid  = $this->forid;
        $size = $this->expr_var('psize_'.$oid);
        
        // counter {{{
        if (isset($this->forloop[$oid]['counter'])) {
            $var   = 'forcounter1_'.$oid;
            $out[] = $this->op_declare($var, $this->expr_number(1));
            $for_loop_body[] = $this->op_inc($var);
        }
        // }}}

        // counter0 {{{
        if (isset($this->forloop[$oid]['counter0'])) {
            $var   = 'forcounter0_'.$oid;
            $out[] = $this->op_declare($var, $this->expr_number(0) );
            $for_loop_body[] = $this->op_inc($var);
        }
        // }}}

        // last {{{
        if (isset($this->forloop[$oid]['last'])) {
            if (!isset($cnt)) {
                $cnt = $this->op_declare('psize_'.$oid, $this->expr_exec('count', $this->expr_var($details['array'])));
                $out[] = $cnt;
            }
            $var  = 'islast_'.$oid;
            $expr = $this->op_declare($var, $this->expr("==", $this->expr_var('forcounter1_'.$oid), $size));

            $out[] = $expr;

            $for_loop_body[] = $expr;
        }
        // }}}

        // first {{{
        if (isset($this->forloop[$oid]['first'])) {
            $out[] = $this->op_declare('isfirst_'.$oid, $this->expr_TRUE());

            $for_loop_body[] = $this->op_declare('isfirst_'.$oid, $this->expr_FALSE());
        }
        // }}}

        // revcounter {{{
        if (isset($this->forloop[$oid]['revcounter'])) {
            if (!isset($cnt)) {
                $cnt   = $this->op_declare('psize_'.$oid, $this->expr_exec('count', $this->expr_var($details['array'])));
                $out[] = $cnt;
            }
            $var = $this->expr_var('revcount_'.$oid);
            $out[] = $this->op_declare($var, $size );

            $for_loop_body[] = $this->op_declare($var, $this->expr("-", $var, $this->expr_number(1)));
        }
         // }}}

        // revcounter0 {{{
        if (isset($this->forloop[$oid]['revcounter0'])) {
            if (!isset($cnt)) {
                $cnt = $this->op_declare('psize_'.$oid, $this->expr_exec('count', $this->expr_var($details['array'])));
                $out[] = $cnt;
            }
            $var = $this->expr_var('revcount0_'.$oid);
            $out[] = $this->op_declare($var, $this->expr("-", $size, $this->expr_number(1)));

            $for_loop_body[] = $this->op_declare($var, $this->expr("-", $var, $this->expr_number(1)));
        }
        // }}}

        /* Restore old ForID */
        $this->forid = $oldid;

        /* Merge loop body  */
        $array = $this->get_filtered_var($details['array'], $varname);
        $loop  = $this->op_foreach($array, $details['variable'], $details['index']);

        $out[] = $loop;
        $out   = array_merge($out, $for_loop_body);
        $out[] = $this->op_end('foreach');
        if (isset($details['empty'])) {
            $out[] = $this->op_end('if');
        }
    }
    // }}}

    // ifchanged [<var1> <var2] {{{
    protected function generate_op_ifchanged($details, &$out)
    {
        static $ifchanged = 0;

        $ifchanged++;
        $var1 = 'ifchanged'.$ifchanged;
        if (!isset($details['check'])) {
            /* ugly */
            $this->ob_start($out);
            $var2 = 'buffer'.$this->ob_start;

            $expr = $this->expr('OR',
                $this->expr_isset($var1, FALSE),
                $this->expr('!=', 
                    $this->expr_var($var1),
                    $this->expr_var($var2)
                )
            );

            $this->generate_op_code($details['body'], $out);
            $this->ob_start--;
            $out[] = $this->op_if($expr);
            $this->generate_op_print(array('variable' => $var2), $out);
            $out[] = $this->op_declare($var1, $this->expr_var($var2));
        } else {
            /* beauty :-) */
            foreach ($details['check'] as $id=>$type) {
                if (!isset($type['var'])) {
                    throw new Haanga_CompilerException("Unexpected string {$type['string']}, expected a varabile");
                }
                $this_expr = $this->expr('OR',
                    $this->expr_isset("{$var1}[{$id}]", FALSE),
                    $this->expr('!=', 
                        $this->expr_var("{$var1}[{$id}]"),
                        $this->expr_var($type['var'])
                    )
                );
                if (isset($expr)) {
                    $this_expr = $this->expr('AND', 
                        $this->expr('expr', $this_expr),
                        $expr
                    );
                }

                $expr = $this_expr;

            }
            $out[] = $this->op_if($expr);
            $this->generate_op_code($details['body'], $out);
            $out[] = $this->op_declare($var1, $this->expr_array_first($details['check']));
        }

        if (isset($details['else'])) {
            $out[] = $this->op_else();
            $this->generate_op_code($details['else'], $out);
        }
        $out[] = $this->op_end('if');
    }
    // }}}

    // autoescape ON|OFF {{{
    function generate_op_autoescape($details, &$out)
    {
        $old_autoescape   = $this->autoescape;
        $this->autoescape = strtolower($details['value']) == 'on';
        $this->generate_op_code($details['body'], $out);
        $this->autoescape = $old_autoescape;
    }
    // }}}

    // ob_Start(array &$out) {{{
    /**
     *  Start a new buffering  
     *
     */
    function ob_start(&$out)
    {
        $this->ob_start++;
        $out[] = $this->op_declare('buffer'.$this->ob_start, array('string' => ''));
    }
    // }}}

    // Custom Tags {{{
    function get_custom_tag($name)
    {
        $function = $this->get_function_name().'_tag_'.$name;
        $this->append .= "\n\n".Haanga_Extensions::getInstance('Haanga_Tag')->getFunctionBody($name, $function);
        return $function;
    }

    /**
     *  Generate needed code for custom tags (tags that aren't
     *  handled by the compiler).
     *
     */
    function generate_op_custom_tag($details, &$out)
    {
        static $tags;
        if (!$tags) {
            $tags = Haanga_Extensions::getInstance('Haanga_Tag');
        }

        $tag_name    = $details['name'];
        $tagFunction = $tags->getFunctionAlias($tag_name); 

        if (!$tagFunction && !$tags->hasGenerator($tag_name)) {
            $function = $this->get_custom_tag($tag_name, isset($details['as']));
        } else {
            $function = $tagFunction;
        }

        if (isset($details['body'])) {
            /* 
               if the custom tag has 'body' 
               then it behave the same way as a filter
            */
            $this->ob_start($out);
            $this->generate_op_code($details['body'], $out);
            $target = $this->expr_var('buffer'.$this->ob_start);
            if ($tags->hasGenerator($tag_name)) {
                $exec = $tags->generator($tag_name, $this, array($target));
            } else {
                $exec = $this->expr_exec($function, $target);
            }
            $this->ob_start--;
            $this->generate_op_print($exec, $out);
            return;
        }

        $var  = isset($details['as']) ? $details['as'] : NULL;
        $args = array_merge(array($function), $details['list']);

        if ($tags->hasGenerator($tag_name)) {
            $exec = $tags->generator($tag_name, $this, $details['list'], $var);
            if ($exec InstanceOf ArrayIterator) {
                /* 
                   The generator returned more than one statement,
                   so we assume the output is already handled
                   by one of those stmts.
                */
                $out = array_merge($out, $exec->getArrayCopy());
                return;
            }
        } else {
            $exec = call_user_func_array(array($this, 'expr_exec'), $args);
        }
        
        if (isset($details['for'])) {
            $new_args = array($this->expr_var('var'));
            $print['function'][1] = $new_args;
            $arr['args'] = $new_args;

            if ($var) {
                $out[] = $this->op_declare($var, $this->expr_str());
            }

            $out[] = $this->op_foreach($details['for'], 'var');
            if ($var) {
                $out[] = $this->append_var($var, $exec);
            } else {
                $this->generate_op_print($exec, $out);
            }
            $out[] = $this->op_end('foreach');
        } else {
            if ($var) {
                $out[] = $this->op_declare($var, $exec);
            } else {
                $this->generate_op_print($exec, $out);
            }
        }
    }
    // }}}

    // with <variable> as <var> {{{
    /**
     *
     *
     */
    function generate_op_alias($details, &$out)
    {
        $this->var_alias[ $details['as'] ] = $details['var'];
        $this->generate_op_code($details['body'], $out);
        unset($this->var_alias[ $details['as'] ] );
    }
    // }}}

    // Custom Filters {{{
    function get_custom_filter($name)
    {
        $function = $this->get_function_name().'_filter_'.$name;
        $this->append .= "\n\n".Haanga_Extensions::getInstance('Haanga_Filter')->getFunctionBody($name, $function);
        return $function;
    }


    function do_filtering($name, $args)
    {
        static $filter;
        if (!$filter) {
            $filter = Haanga_Extensions::getInstance('Haanga_Filter');
        }
        
        if (is_array($name)) {
            /*
               prepare array for ($func_name, $arg1, $arg2 ... ) 
               where $arg1 = last expression and $arg2.. $argX is 
               defined in the template 
             */
            $args = array_merge($args, $name['args']);
            $name = $name[0]; 
        }

        if (!$filter->isValid($name)) {
            throw new Haanga_CompilerException("{$name} is an invalid filter");
        }
        if ($filter->hasGenerator($name)) {
            return $filter->generator($name, $this, $args);
        }
        $fnc = $filter->getFunctionAlias($name);
        if (!$fnc) {
            $fnc = $this->get_custom_filter($name);
        }
        $args = array_merge(array($fnc), $args);
        $exec = call_user_func_array(array($this, 'expr_exec'), $args);

        return $exec;
    }

    function generate_op_filter($details, &$out)
    {
        $this->ob_start($out);
        $this->generate_op_code($details['body'], $out);
        $target = $this->expr_var('buffer'.$this->ob_start);
        foreach ($details['functions'] as $f) {
            $param = (isset($exec) ? $exec : $target);
            $exec  = $this->do_filtering($f, array($param));
        }
        $this->ob_start--;
        $this->generate_op_print($exec, $out);
    }
    // }}}

    final static function main_cli()
    {
        $argv = $GLOBALS['argv'];
        $haanga = new Haanga_Main;
        $code = $haanga->compile_file($argv[1]);
        echo "<?php\n\n$code\n";
    }

}


/**
 *  Runtime compiler
 *
 */
final class Haanga_Main_Runtime extends Haanga_Main
{

    // get_function_name($name=NULL) {{{
    /**
     *
     *
     */
    function get_function_name($name=NULL)
    {
        if ($name === NULL) {
            $name = $this->name;
        }
        return "haanga_".sha1($name);
    }
    // }}}

    // set_template_name($path) {{{
    function set_template_name($path)
    {
        return $path;
    }
    // }}}

    // Override {% include %} {{{
    protected function generate_op_include($details, &$out)
    {
        $expr = $this->expr_exec(
            'Haanga::Load', 
            $details[0],
            $this->expr_var('vars'),
            $this->expr_TRUE(),
            $this->expr_var('blocks')
        );
        $this->generate_op_print(array('expr' => $expr), $out);
    }
    // }}}

    // {% base "" %} {{{
    function expr_call_base_template()
    {
        return $this->expr_exec(
            'Haanga::Load',
            $this->subtemplate,
            $this->expr_var('vars'),
            $this->expr_TRUE(),
            $this->expr_var('blocks')
        );
    }
    // }}}

    // get_base_template($base) {{{
    function get_base_template($base)
    {
        $this->subtemplate = $base;
    }
    // }}}

    // Override get_Custom_tag {{{
    /**
     *  
     *
     */
    function get_custom_tag($name)
    {
        $loaded = &$this->tags;

        if (!isset($loaded[$name])) {
            $this->prepend_op[] = $this->op_comment("Load tag {$name} definition");
            $this->prepend_op[] = $this->op_expr($this->expr_exec("Haanga::doInclude", $this->Expr_str(Haanga_Extensions::getInstance('Haanga_Tag')->getFilePath($name, FALSE)))); 
            $loaded[$name] = TRUE;
        }

        $name = ucfirst($name);

        return "{$name}_Tag::main";
    }
    // }}}

    // Override get_custom_filter {{{
    function get_custom_filter($name)
    {
        $loaded = &$this->filters;

        if (!isset($loaded[$name])) {
            $this->prepend_op[] = $this->op_comment("Load filter {$name} definition");
            $this->prepend_op[] = $this->op_expr($this->expr_exec("Haanga::doInclude", $this->Expr_str(Haanga_Extensions::getInstance('Haanga_Filter')->getFilePath($name, FALSE)))); 
            $loaded[$name] = TRUE;
        }

        $name = ucfirst($name);

        return "{$name}_Filter::main";
    }
    // }}}
    
}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: sw=4 ts=4 fdm=marker
 * vim<600: sw=4 ts=4
 */
