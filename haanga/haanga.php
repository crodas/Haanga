<?php

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
    protected $strip_whitespaces=TRUE;
    protected $force_whitespaces=0;

    function __construct()
    {
        $this->generator = new Haanga_CodeGenerator;
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

    /**
     *  Compile a file
     *
     *  @param string $file File path
     *
     *  @return Generated PHP code
     */
    final function compile_file($file, $use_func = TRUE)
    {
        $this->reset();
        if (!is_readable($file)) {
            throw new Exception("$file is not a file");
        }
        $this->_base_dir = dirname($file);
        $this->_file     = basename($file);
        $name = strstr(basename($file),'.', TRUE);
        return $this->compile(file_get_contents($file), $use_func ? $name : NULL);
    }

    function get_template_name()
    {
        return $this->name;
    }

    final function compile($code, $name=NULL)
    {
        $this->name = $name;

        $parsed = do_parsing($code);
        $code   = "";
        $this->subtemplate = FALSE;
        if ($parsed[0]['operation'] == 'base') {
            $base = $parsed[0][0];

            if (!isset($base['string'])) {
                throw new Exception("Dynamic inheritance is not supported yet");
            }
            $file = $base['string'];
            list($this->subtemplate, $new_code) = $this->compile_required_template($file);
            $code .= $new_code."\n\n";
            unset($parsed[0]);
        }
        if ($name) {
            if (isset($this->_file)) {
                $op_code[] = array('op' => 'comment', 'comment' =>  "Generated from {$this->_base_dir}/{$this->_file}");
            }
            $op_code[] = array('op' => 'function', 'name' => $name);
            $op_code[] = array('op' => 'exec',  'name' =>  'extract', 'args' => array(array('var' => 'vars')) );
        }
        $this->ob_start($op_code);
        $this->generate_op_code($parsed, $op_code);
        if ($this->subtemplate) {
            $this->generate_op_print(array('php' => $this->subtemplate.'_template($vars, $blocks, TRUE)'), $op_code);
        }
        $this->ob_start--;

        /* Add last part */
        $expr = array(
            'op' => '==',
            array('var' => 'return'),
            TRUE
        );
        $op_code[] = array('op' => 'if', 'expr' => $expr);
        $op_code[] = array('op' => 'return', array('var'=> 'buffer1'));
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
        $this->generate_op_print(array('php' => $name.'_template($vars, $blocks, TRUE)'), $out);
    }


    protected function generate_op_html($details, &$out)
    {
        $this->generate_op_print($details, $out);
    }

    protected function generate_op_cycle($details, &$out)
    {
        static $cycle = 0;
        $last = count($out)-1;
        if ($last >= 0 && $out[$last]['op'] == 'print') {
            /* If there is a print declared previously, we pop it
               and add it after the cycle declaration
             */
            $print = $out[$last];
            array_pop($out);
        }

        /* isset($var) == FALSE */
        $expr = array(
            'op' => '==',
            array(
                'exec' => 'isset',
                'args' => array(
                    array('var' => 'index_'.$cycle)
                )
            ),
            FALSE
        );

        /* ($foo + 1) % count($bar) */
        $inc = array('expr' => array(
            'op' => '%',
            array(
                'op' => 'expr',
                array(
                    'op' => '+',
                    array('var' => 'index_'.$cycle),
                    1,
                ),
            ),
            array(
                'exec' => 'count',
                'args' => array(
                    array('var' => 'def_cycle_'.$cycle),
                ),
            )
        ));

        $out[] = array('op' => 'declare', 'name' => 'def_cycle_'.$cycle, array('array' => $details['vars']));
        $out[] = array('op' => 'cond_declare', 'name' => 'index_'.$cycle, 'expr' => $expr, 'true' => array(array('number' => 0)), 'false' => array($inc)); 
        $var  = array('variable' => "def_cycle_{$cycle}[\$index_{$cycle}]");
        $this->generate_op_print($var, $out);
        $cycle++;
    }

    protected function generate_op_comment($details, &$out)
    {
        $out[] = array('op' => 'comment', 'comment' => $details['comment']);
    }

    protected function generate_op_php($details, &$out)
    {
        $out[] = array('php', $details['php']);
    }

    protected function get_isset_var_expr($var)
    {
        return array(
                'op' => '==',
                array(
                    'exec' => 'isset',
                    'args' => array(
                        array('var' => $var),
                    ),
                ),
                TRUE
            );
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

        if (!$this->subtemplate) {
            $out[] = array('op' => 'if', 'expr' => $this->get_isset_var_expr("blocks['{$details['name']}']"));
            $this->generate_op_print(array('variable' => $buffer_var), $out);
            $var = 'blocks["'.$details['name'].'"]';
            $out[] = array('op' => 'else');

            $out[] = array('op' => 'if', 'expr' => $this->get_isset_var_expr($var));
            $out[] = array('op' => 'declare', 'name' => $var, array('exec' => 'str_replace', 'args' => array(array('string' => '$parent_value'), array('var' => $buffer_var), array('var'=> $var.'[0]')))); 
            $out[] = array('op' => 'end_if');
            $this->generate_op_print(array('variable' => $var), $out);
            $out[] = array('op' => 'end_if');
        } else {
            $this->blocks[] = $details['name'];
            if ($this->block_super > 0) {
                $out[] = array('op'=> 'comment', 'comment' => 'declared as array because this block it needs to access parent block\'s contents');
                $out[] = array('op' => 'declare', 'name' => 'blocks["'.$details['name'].'"]', array('array' => array(array('var' => $buffer_var)) ) );
                $this->block_super--;
            } else {
                $out[] = array('op' => 'declare', 'name' => 'blocks["'.$details['name'].'"]', array('var' => $buffer_var));
            }
            $this->in_block--;
        }
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
                    $variable = 'forcounter_'.$this->forid;
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
            $content = array('var' => $this->generate_variable_name($details['variable']));
        } else if (isset($details['html']))  {
            $html = $details['html'];
            if ($this->strip_whitespaces && $this->force_whitespaces == 0) {
                $html = str_replace("\n", " ", $html);
                $html = preg_replace("/\s\s+/", " ", $html);
            }
            $content = array('string' => $html);
        } else if (isset($details['php'])) {
            $content = array('php' => $details['php']);
        } else if (isset($details['function'])) {
            $content = array('function' =>  $details['function'][0], 'args' => $details['function'][1]);
        } else {
            throw new Exception("don't know how to generate code for ".print_r($details, TRUE));
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
            $expr = array('op' => '==', 
                array(
                    'exec' => 'count', 
                    'args' => array(
                        array('var' => "{$details['array']}"),
                    )
                ),
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
            $var   = 'forcounter_'.$oid;
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
        $out[] = array('op' => 'foreach', 'array' => $details['array'], 'value' => $details['variable']);
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
            $expr = array(
                'op' => 'OR',
                array(
                    'op' => '==',
                    array(
                        'exec' => 'isset',
                        'args' => array(
                             array('var' => $var1)
                        ),
                    ),
                    FALSE
                ),
                array(
                    'op' => '!=',
                    array('var' => $var1),
                    array('var' => $var2),
                )
            );
            $this->generate_op_code($details['body'], $out);
            $this->ob_start--;
            $out[] = array('op' => 'if', 'expr' => $expr);
            $this->generate_op_print(array('variable' => $var2), $out);
            $out[] = array('op' => 'declare','name' => $var1, array('var' => $var2));
        } else {
            /* beauty :-) */
            if (count($details['check']) !== 1) {
                throw new Exception("unexpected error");
            }
            foreach ($details['check'] as $id=>$type) {
                if (!isset($type['var'])) {
                    throw new Exception("Invalid error {$type['var']}");
                }
                $expr = array(
                    'op' => 'OR',
                    array(
                        'op' => '==',
                        array(
                            'exec' => 'isset',
                            'args' => array(
                                array('var' => "{$var1}[{$id}]")
                            ),
                        ),
                        FALSE
                    ),
                    array(
                        'op' => '!=',
                        array('var' => "{$var1}[{$id}]"),
                        array('var' => $type['var']),
                    )
                );
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
            $new_args = array(array('var' => 'var'));
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
        $details['functions'] = array_reverse($details['functions']);        $func = "";
        foreach ($details['functions'] as $f) {
            $func .= "{$f['var']}(";
        }
        $func   .= '$buffer'.$this->ob_start.str_repeat(')', count($details['functions']));;
        $this->ob_start--;
        $this->generate_op_print(array('php' => $func), $out);
    }

    final static function main_cli()
    {
        $argv = $GLOBALS['argv'];
        $haanga = new Haanga_Main;
        $code = $haanga->compile_file($argv[1]);

echo <<<EOF
<?php
$code

\$arr = array('some_list' => array(1, 2, 3, 3, 4, 4, 4, 5), 'user' => 'crodas');
base_template(\$arr);
echo "\\n\\n------------------------------\\n\\n";
subtemplate_template(\$arr);
echo "\\n\\n------------------------------\\n\\n";
index_template(\$arr);

EOF;
    }

}



