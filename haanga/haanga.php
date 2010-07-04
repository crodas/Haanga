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

require "lexer.php";
require "generator.php";

class Haanga_Main
{
    protected $generator;
    protected $forloop_counter;
    protected $forloop_counter0;
    protected $forid = FALSE;
    protected $sub_template = FALSE;
    protected $name;
    protected $blocks=array();
    protected $in_block=0;
    protected $ob_start=0;
    protected $block_super=0;
    protected $append;
    protected $_var_alias;
    protected $strip_whitespaces=FALSE;
    protected $force_whitespaces=0;
    protected $debug;

    function __construct()
    {
        $this->generator = new Haanga_CodeGenerator;
    }

    function setDebug($file)
    {
        $this->debug = $file;
    }

    function reset()
    {
        $avoid_cleaning = array('strip_whitespaces' => 1);
        foreach (array_keys(get_object_vars($this)) as $key) {
            if (isset($avoid_cleaning[$key])) {
                continue;
            }
            $this->$key = NULL;
        }
        $this->generator = new Haanga_CodeGenerator;
        $this->blocks = array();
    }

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
            throw new Exception("$file is not a file");
        }
        $this->_base_dir = dirname($file);
        $this->_file     = basename($file);
        $name            = $this->set_template_name($file);
        return $this->compile(file_get_contents($file), $name);
    }
    // }}}

    final function get_template_name()
    {
        return $this->name;
    }

    function set_template_name($path)
    {
        return strstr(basename($path),'.', TRUE);
    }

    function get_function_name($name)
    {
        return "{$name}_template";
    }

    // expr_* helper methods {{{
    /**
     *  Return an stand alone expression
     *
     */
    function expr_expr($expr)
    {
        return array('op' => 'expr', $expr);

    }

    function expr_cond($expr, $true, $false)
    {
        return array('expr_cond' => $expr, 'true' => $true, 'false' => $false);
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

    protected function expr_array()
    {
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


    /**
     *  return an string definition of $str
     *
     *  @return array
     */
    final function expr_str($str)
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
     *  Generate expression for
     *  a function calling
     *
     *  @return array
     */
    final function expr_exec($function)
    {
        $args = func_get_args();
        unset($args[0]);
        $args = array_values($args);
        $function = strtolower($function);

        switch ($function) {
        case 'upper':
            $function = 'strtoupper';
            break;
        case 'lower':
            $function = 'strtolower';
            break; 
        case 'safe':
            $function = 'htmlentities';
            break;
        case 'striptags':
            $function = 'strip_tags';
            break;
        case 'linebreaksbr':
            $function = 'nl2br';
            break;
        default:
            $override = array($this, 'override_function_'.$function);
            if (is_callable($override)) {
                return call_user_func($override, $args);
            }
            if (is_callable(array($this, 'is_function_safe'))) {
                $function = $this->is_function_safe($function);
            }
        }

        if (!is_string($function) || empty($function)) {
            throw new Exception("{$function} filter is not allowed");
        }
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
        $expr = array('op' => $operation, $expr1);
        if ($expr2 !== NULL) {
            $expr[] = $expr2;
        }

        return $expr;
    }
    // }}}

    /**
     *
     *
     */
    function get_base_template($base)
    {
        if (!isset($base['string'])) {
            throw new Exception("Dynamic inheritance is not supported yet");
        }
        $file = $base['string'];
        list($this->subtemplate, $new_code) = $this->compile_required_template($file);
        return $new_code."\n\n";
    }

    final function compile($code, $name=NULL)
    {
        $this->name = $name;

        $parsed = do_parsing($code);
        $code   = "";
        $this->subtemplate = FALSE;
        if ($parsed[0]['operation'] == 'base') {
            $base  = $parsed[0][0];
            $code .= $this->get_base_template($base); 
            unset($parsed[0]);
        }
        if ($name) {
            if (isset($this->_file)) {
                $op_code[] = array('op' => 'comment', 'comment' =>  "Generated from {$this->_base_dir}/{$this->_file}");
            }
            $op_code[] = array('op' => 'function', 'name' => $this->get_function_name($name));
            $op_code[] = $this->expr_expr($this->expr_exec('extract', $this->expr_var('vars')));
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
        $op_code[] = array('op' => 'if', 'expr' => $expr);
        $op_code[] = array('op' => 'return', $this->expr_var('buffer1'));
        $op_code[] = array('op' => 'else');
        $this->generate_op_print(array('variable' => 'buffer1'), $op_code);
        $op_code[] = array('op' => 'end_if');

        if ($name) {
            $op_code[] = array('op' => 'end_function');
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

    protected function generate_op_base()
    {
        throw new exception("{% base %} can be only as first statmenet");
    }

    protected function generate_op_code($parsed, &$out)
    {
        if (!is_array($parsed)) {
            throw new Exception("Invalid \$parsed array");
        }
        foreach ($parsed as $op) {
            if (!isset($op['operation'])) {
                throw new Exception("Malformed \$parsed array");
            }
            if ($this->subtemplate && $this->in_block == 0 && $op['operation'] != 'block') {
                /* ignore most of tokens in subtemplates */
                continue;
            }
            $method = "generate_op_".$op['operation'];
            if (!is_callable(array($this, $method))) {
                throw new Exception("Compiler: Missing method $method");
            }
            $this->$method($op, $out);
        }
    }

    protected function check_expr(&$expr)
    {
        if (is_array($expr) && isset($expr['op'])) {
            $this->check_expr($expr[0]);
            $this->check_expr($expr[1]);
        } else {
            if (is_array($expr)) {
                if (isset($expr['var'])) {
                    $expr['var'] = $this->generate_variable_name($expr['var']);
                } else if (isset($expr['var_filter'])) {
                    foreach ($expr['var_filter'] as $id => $f) {
                        if ($id == 0) {
                            $exec = array('var' => $this->generate_variable_name($f));
                        } else {
                            $exec = $this->expr_exec($f, $exec);
                        }
                    }
                    $expr = $exec;
                }
            } 
        }
    }


    protected function generate_op_if($details, &$out)
    {
        $this->check_expr($details['expr']);
        $out[] = array('op' => 'if', 'expr' => $details['expr']);
        $this->generate_op_code($details['body'], $out);
        if (isset($details['else'])) {
            $out[] = array('op' => 'else');
            $this->generate_op_code($details['else'], $out);
        }
        $out[] = array('op' => 'end_if');
    }

    protected function compile_required_template($file)
    {
        if (isset($this->_base_dir)) {
            $file = $this->_base_dir.'/'.$file;
        }
        if (!is_file($file)) {
            throw new Exception("can't find {$file} file template");
        }
        $class = get_class($this);
        $comp  = new  $class;
        $comp->reset();
        $code = $comp->compile_file($file);
        return array($comp->get_template_name(), $code);
    }
    
    protected function generate_op_include($details, &$out)
    {
        if (!$details[0]['string']) {
            throw new Exception("Dynamic includes are not supported yet");
        }
        list($name,$code) = $this->compile_required_template($details[0]['string']);
        $this->append .= "\n\n{$code}";
        $expr = $this->expr_exec(
            $this->get_function_name($this->subtemplate),
            $this->expr_var('vars'),
            $this->expr_var('blocks'),
            $this->expr_TRUE()
        );
        $this->generate_op_print(array('expr' => $expr), $op_code);
        $this->generate_op_print(array('expr' => $expr), $out);
    }


    protected function generate_op_html($details, &$out)
    {
        $this->generate_op_print($details, $out);
    }

    protected function generate_op_print_var($details, &$out)
    {
        if (count($details['variable']) > 1) {
            $count  = count($details['variable']);
            $target = call_user_func_array(array($this, 'expr_var'), $details['variable'][0]);
            for ($i=1; $i < $count; $i++) {
                $func_name = $details['variable'][$i];
                $args      = (isset($exec) ? $exec : $target);
                if (is_array($func_name)) {
                    /* prepare array for ($func_name, $arg1, $arg2 ... ) 
                       where $arg1 = last expression and $arg2.. $argX is 
                       defined in the template */
                    $nargs = array($func_name[0]);
                    $nargs = array_merge($nargs, array($args), $func_name['args']);
                    $exec = call_user_func_array(array($this ,'expr_exec'), $nargs);
                } else {
                    $exec = $this->expr_exec($func_name, $args);
                }
            }
            unset($details['variable']);
            $details = $exec;
        } else {
            $details['variable'] = $details['variable'][0];
        }

        $this->generate_op_print($details, $out);
    }

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

    protected function generate_op_cycle($details, &$out)
    {
        static $cycle = 0;
        if ($this->is_last_op_print($out)) {
            /* If there is a print declared previously, we pop it
               and add it after the cycle declaration
             */
            $old_print = array_pop($out);
        }

        /* isset($var) == FALSE */
        $expr = $this->expr('==', $this->expr_exec('isset', $this->expr_var('index_'.$cycle)), FALSE);

        /* ($foo + 1) % count($bar) */
        $inc = $this->expr('%',
                $this->expr('expr',
                    $this->expr('+', $this->expr_var('index_'.$cycle), 1)
                ),
                $this->expr_exec('count', $this->expr_var('def_cycle_'.$cycle))
        );

        $out[] = array('op' => 'declare', 'name' => 'def_cycle_'.$cycle, array('array' => $details['vars']));
        $out[] = array('op' => 'declare', 'name' => 'index_'.$cycle, $this->expr_cond($expr, array('number' => 0), array('expr' => $inc))); 
        $var  = $this->expr_var("def_cycle_{$cycle}", $this->expr_var("index_{$cycle}"));
        if (isset($old_print)) {
            $out[] = $old_print;
        }
        if (!isset($details['as'])) {
            $this->generate_op_print(array("variable" => $var['var']), $out);
        } else {
            $out[] = array('op' => 'declare', 'name' => $details['as'], $this->expr($var));
            
        }
        $cycle++;
    }

    protected function generate_op_comment($details, &$out)
    {
        if ($this->is_last_op_print($out)) {
            /* If there is a print declared previously, we pop it
               and add it after the cycle declaration
             */
            $old_print = array_pop($out);
        }
        $out[] = array('op' => 'comment', 'comment' => $details['comment']);
        if (isset($old_print)) {
            $out[] = $old_print;
        }
    }

    protected function generate_op_block($details, &$out)
    {
        $this->ob_start($out);
        $buffer_var = 'buffer'.$this->ob_start;
        if ($this->subtemplate) {
            $this->in_block++;
        } 
        $this->generate_op_code($details['body'], $out);
        $this->ob_start--;

        $var   = $this->expr_var("blocks", $details['name']);
        if (!$this->subtemplate) {
            $var1  = $this->expr_var("blocks", $details['name'], 0);

            $out[] = array('op' => 'if', 'expr' => $this->expr_isset_ex($var, FALSE));
            $this->generate_op_print(array('variable' => $buffer_var), $out);
            $out[] = array('op' => 'else');

            $out[] = array('op' => 'if', 'expr' => $this->expr("==", $this->expr_exec("is_array", $var), TRUE));
            $out[] = array('op' => 'declare', 'name' => $var['var'], array('exec' => 'str_replace', 'args' => array(array('string' => '$parent_value'), $this->expr_var($buffer_var), $var))); 
            $out[] = array('op' => 'end_if');
            $this->generate_op_print(array('variable' => $var['var']), $out);
            $out[] = array('op' => 'end_if');
        } else {
            $this->blocks[] = $details['name'];
            if ($this->block_super > 0) {
                $out[] = array('op'=> 'comment', 'comment' => 'declared as array because this block needs to access parent block\'s contents');
                $out[] = array('op' => 'declare', 'name' => $var['var'], array('array' => array($this->expr_var($buffer_var)) ) );
                $this->block_super--;
            } else {
                $out[] = array('op' => 'declare', 'name' => 'blocks["'.$details['name'].'"]', $this->expr_var($buffer_var));
            }
            $this->in_block--;
        }
    }

    protected function generate_op_regroup($details, &$out)
    {
        $out[] = array('op' => 'declare', 'name' => $details['as'], array('array' => array()));
        $var = $this->expr_var('item', $details['row']);

        $out[] = array('op' => 'comment', 'comment' => "Temporary sorting");
        $out[] = array('op' => 'foreach', 'array' => $details['array'], 'value' => 'item');


        $out[] = array('op' => 'declare', 'name' => array('temp_group', $var, NULL),  $this->expr_var('item'));
        $out[] = array('op' => 'end_foreach');
        $out[] = array('op' => 'comment', 'comment' => "Proper format");

        $out[] = array('op' => 'foreach', 'array' => 'temp_group', 'key' => 'group', 'value' => 'item');
        $array = $this->expr_array(
            array("grouper", $this->expr_var('group')),
            array("list",    $this->expr_var('item'))
        );
        
        $out[] = array('op' => 'declare', 'name' => array($details['as'], NULL), $array );

        $out[] = array('op' => 'end_foreach');
        $out[] = array('op' => 'comment', 'comment' => "Sorting done");
    }

    protected function generate_variable_name($variable)
    {
        if (is_array($variable)) {
            switch ($variable[0]) {
            case 'forloop':
                if ($this->forid === FALSE) {
                    throw new Exception("Invalid forloop reference outside of a loop");
                }
                switch ($variable[1]) {
                case 'counter':
                    $this->forloop_counter[$this->forid] = TRUE; 
                    $variable = 'forcounter1_'.$this->forid;
                    break;
                case 'counter0':
                    $this->forloop_counter0[$this->forid] = TRUE; 
                    $variable = 'forcounter0_'.$this->forid;
                    break;
                default:
                    throw new Exception("Unexpected forloop.{$variable[1]}");
                }
                break;
            case 'super':
                if ($variable[1] == 'block') {
                    $variable = '\\$parent_value';
                    $this->block_super++;
                }
                break;
            } 

        } else if (isset($this->_var_alias[$variable])) {
            $variable = $this->_var_alias[$variable];
        }
        return $variable;
    }

    protected function generate_op_print($details, &$out)
    {
        $last = count($out)-1;
        if (isset($details['variable'])) {
            $content = $this->expr_var($this->generate_variable_name($details['variable']));
        } else if (isset($details['html']))  {
            $html = $details['html'];
            if ($this->strip_whitespaces && $this->force_whitespaces == 0) {
                $html = str_replace("\n", " ", $html);
                $html = preg_replace("/\s\s+/", " ", $html);
            }
            $content = array('string' => $html);
        } else if (isset($details['function'])) {
            $content = $this->expr_exec($details['function'][0], $details['function'][1]);
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
                    $out[] = array('op' => 'append_var', 'name' => 'buffer'.$this->ob_start, $content);
                }
            }
        }
    }

    protected function generate_op_loop($details, &$out)
    {
        static $id = 0;
        $id++;
        if (isset($details['empty'])) {
            $expr = $this->expr('==',
                $this->expr_exec('count', $this->expr_var($details['array'])),
                0
            );

            $out[] = array('op' => 'if', "expr" => $expr);
            $this->generate_op_code($details['empty'], $out);
            $out[] = array('op' => 'else');
        }

        /* ForID */
        $oldid       = $this->forid;
        $this->forid = $id;

        /* Loop body */
        $for_loop_body = array();
        $this->generate_op_code($details['body'], $for_loop_body);

        $oid = $this->forid;
        if (isset($this->forloop_counter[$oid])) {
            $var   = 'forcounter1_'.$oid;
            $out[] = array('op' => 'declare', 'name' => $var, array('number' => 1) );
            $for_loop_body[] = array('op' => 'inc', 'name' => $var);

        }
        if (isset($this->forloop_counter0[$oid])) {
            $var   = 'forcounter0_'.$oid;
            $out[] = array('op' => 'declare', 'name' => $var, array('number' => 0) );
            $for_loop_body[] = array('op' => 'inc', 'name' => $var);
        }

        /* Restore old ForID */
        $this->forid = $oldid;

        /* Merge loop body  */
        $loop = array('op' => 'foreach', 'array' => $details['array'], 'value' => $details['variable']);
        if (isset($details['index'])) {
            $loop['key'] = $details['index'];
        }
        $out[] = $loop;
        $out   = array_merge($out, $for_loop_body);
        $out[] = array('op' => 'end_foreach');
        if (isset($details['empty'])) {
            $out[] = array('op' => 'end_if');
        }
    }

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
            $out[] = array('op' => 'if', 'expr' => $expr);
            $this->generate_op_print(array('variable' => $var2), $out);
            $out[] = array('op' => 'declare','name' => $var1, $this->expr_var($var2));
        } else {
            /* beauty :-) */
            foreach ($details['check'] as $id=>$type) {
                if (!isset($type['var'])) {
                    throw new Exception("Invalid error {$type['var']}");
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
            $out[] = array('op' => 'if', 'expr' => $expr);
            $this->generate_op_code($details['body'], $out);
            $out[] = array('op' => 'declare', 'name' => $var1, array('array' => $details['check']));
        }

        if (isset($details['else'])) {
            $out[] = array('op' => 'else');
            $this->generate_op_code($details['else'], $out);
        }
        $out[] = array('op' => 'end_if');
    }

    function ob_start(&$out)
    {
        $this->ob_start++;
        $out[] = array('op' => 'declare', 'name' => 'buffer'.$this->ob_start, array('string' => ''));
    }

    function generate_op_function($details, &$out)
    {
        $var   = isset($details['as']) ? $details['as'] : NULL;
        $arr   = array('function' =>  $details['name'], 'args' => $details['list']);
        $print = array('function' => array($details['name'], $details['list']));
        
        if (isset($details['for'])) {
            $new_args = array($this->expr_var('var'));
            $print['function'][1] = $new_args;
            $arr['args'] = $new_args;

            if ($var) {
                $out[] = array('op' => 'declare', 'name' => $var, array('string' => ''));
            }

            $out[] = array('op' => 'foreach', 'array' => $details['for'], 'value' => 'var');
            if ($var) {
                $out[] = array('op' => 'append_var', 'name' => $var, $arr);
            } else {
                $this->generate_op_print($print, $out);
            }
            $out[] = array('op' => 'end_foreach');
        } else {
            if ($var) {
                $out[] = array('op' => 'declare', 'name' => $var, $arr);
            } else {
                $this->generate_op_print($print, $out);
            }
        }
    }

    function generate_op_alias($details, &$out)
    {
        $this->_var_alias[ $details['as'] ] = $details['var'];
        $this->generate_op_code($details['body'], $out);
        unset($this->_var_alias[ $details['as'] ] );
    }


    function generate_op_filter($details, &$out)
    {
        $this->ob_start($out);
        $this->generate_op_code($details['body'], $out);
        $target = $this->expr_var('buffer'.$this->ob_start);
        foreach ($details['functions'] as $f) {
            $exec = $this->expr_exec($f, (isset($exec) ? $exec : $target));
        }
        $this->ob_start--;
        $this->generate_op_print(array('expr' => $exec), $out);
    }

    final static function main_cli()
    {
        $argv = $GLOBALS['argv'];
        $haanga = new Haanga_Main;
        $code = $haanga->compile_file($argv[1]);
        echo "<?php\n\n$code\n";
    }

}


final class Haanga_Main_Runtime extends Haanga_Main
{
    function get_function_name($name)
    {
        return "haanga_".sha1($name);
    }

    function set_template_name($path)
    {
        return $path;
    }

    protected function generate_op_include($details, &$out)
    {
        if (!$details[0]['string']) {
            throw new Exception("Dynamic includes are not supported yet");
        }
        $expr = $this->expr_exec(
            'Haanga::Load', 
            $details[0],
            $this->expr_var('vars'),
            $this->expr_TRUE(),
            $this->expr_var('blocks')
        );
        $this->generate_op_print(array('expr' => $expr), $op_code);
        $this->generate_op_print(array('expr' => $expr), $out);
    }

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

    function get_base_template($base)
    {
        $this->subtemplate = $base;
    }

    /* Custom functions (which generate PHP code)  {{{ */

    // default() {{{ 
    /**
     *  Default gets one paramenter 
     *
     */
    function override_function_default($args)
    {
        return $this->expr_cond(
            $this->expr('==', array('exec' => 'empty', 'args' => array($args[0])), TRUE),
            $args[1],
            $args[0]
        );
    }
    // }}}

    // length() {{{
    /**
     *  length() 
     *
     *  Length() should return the size of a string 
     *  and an array.
     *
     */
    function override_function_length($args)
    {
        return $this->expr_cond(
            $this->expr('==', array('exec' => 'is_array', 'args' => $args), TRUE),
            array('exec' => 'count', 'args' => $args),
            array('exec' => 'strlen', 'args' => $args)
        );
    }
    // }}}

    /* }}} */

}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: sw=4 ts=4 fdm=marker
 * vim<600: sw=4 ts=4
 */
