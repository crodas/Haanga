<?php

require "lexer.php";
require "generator.php";

class Haanga
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

    function __construct()
    {
        $this->generator = new Haanga_CodeGenerator;
    }

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
        $name = strstr(basename($file),'.', TRUE);
        return $this->compile(file_get_contents($file), $name);
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
        if (isset($parsed['base'])) {
            if (!isset($parsed['base']['string'])) {
                throw new Exception("Dynamic inheritance is not supported yet");
            }
            $file = $parsed['base']['string'];
            list($this->subtemplate, $new_code) = $this->compile_required_template($file);
            $code .= $new_code;
            unset($parsed['base']);
        }
        if ($name) {
            if (isset($this->_file)) {
                $op_code[] = array('php', "/* Generated from {$this->_file} */");
            }
            $op_code[] = array('function', $name);
            $op_code[] = array('ident');
            $op_code[] = array('php', 'extract($vars);');
        }
        $this->ob_start($op_code);
        $this->generate_op_code($parsed, $op_code);
        if ($this->subtemplate) {
            $this->generate_op_print(array('php' => $this->subtemplate.'_template($vars, $blocks, TRUE)'), $op_code);
        }
        $this->ob_start--;
        /* Add last part */
        $op_code[] = array('if', '$return');
        $op_code[] = array('ident');
        $op_code[] = array('php', 'return $buffer1;');
        $op_code[] = array('ident_end');
        $op_code[] = array('else');
        $op_code[] = array('ident');
        $this->generate_op_print(array('variable' => 'buffer1'), $op_code);
        $op_code[] = array('ident_end');

        if ($name) {
            $op_code[] = array('ident_end');
        }
        $code .= $this->generator->getCode($op_code);
        if (!empty($this->append)) {
            $code .= $this->append;
        }
        return $code;
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

    protected function generate_expr($expr)
    {
        //print_r($expr);die();
        $code = '';
        if (is_array($expr) && isset($expr['op'])) {
            $code .= $this->generate_expr($expr[0]);
            $code .= " {$expr['op']} ";
            $code .= $this->generate_expr($expr[1]);
        } else {
            if (is_array($expr)) {
                if (isset($expr['var'])) {
                    $code .= '$'.$this->generate_variable_name($expr['var']);
                }
            } else {
                $code .= $expr;
            }
        }
        return $code;
    }


    protected function generate_op_if($details, &$out)
    {
        $expr  = $this->generate_expr($details['expr']);
        $out[] = array('if', $expr);
        $out[] = array('ident');
        $this->generate_op_code($details['body'], $out);
        $out[] = array('ident_end');
        if (isset($details['else'])) {
            $out[] = array('else');
            $out[] = array('ident');
            $this->generate_op_code($details['else'], $out);
            $out[] = array('ident_end');
        }


    }

    protected function compile_required_template($file)
    {
        if (isset($this->_base_dir)) {
            $file = $this->_base_dir.'/'.$file;
       }
        if (!is_file($file)) {
            throw new Exception("can't find {$file} file template");
        }
        $comp = new Haanga;
        $code = $comp->compile_file($file)."\n\n";
        return array($comp->get_template_name(), $code);
    }
    
    protected function generate_op_include($details, &$out)
    {
        if (!$details[0]['string']) {
            throw new Exception("Dynamic includes are not supported yet");
        }
        list($name,$this->append) = $this->compile_required_template($details[0]['string']);
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
        if ($last >= 0 && $out[$last][0] == 'print') {
            /* If there is a print declared previously, we pop it
               and add it after the cycle declaration
             */
            $print = $out[$last];
            array_pop($out);
        }

        $out[] = array('declare', 'def_cycle_'.$cycle, array('array', $details['vars']));
        $out[] = array('declare', 'index_'.$cycle, array('php', '(!isset($index_'.$cycle.') ? 0 : ($index_'.$cycle.' + 1) % sizeof($def_cycle_'.$cycle.'))')); 
        $var  = array('variable' => "def_cycle_{$cycle}[\$index_{$cycle}]");
        $this->generate_op_print($var, $out);
        $cycle++;
        return;
        var_dump($var);die();
        if (isset($print)) {
            $print[] = $var;
            $out[]   = $print;
        } else {
            $out[] = array('print', $var);
        }
    }

    protected function generate_op_php($details, &$out)
    {
        $out[] = array('php', $details['php']);
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
            $out[] = array('if', '!isset($blocks["'.$details['name'].'"])');
            $out[] = array('ident');
            $this->generate_op_print(array('variable' => $buffer_var), $out);
            $var = 'blocks["'.$details['name'].'"]';
            $out[] = array('ident_end');
            $out[] = array('else');
            $out[] = array('ident');

            $out[] = array('if', 'is_array($'.$var.')');
            $out[] = array('ident');
            $out[] = array('declare', $var, array('function', 'str_replace', 'args' => array(array('string' => '$parent_value'), array('var' => $buffer_var), array('var'=> $var.'[0]')))); 
            $out[] = array('ident_end');
            $this->generate_op_print(array('variable' => $var), $out);
            $out[] = array('ident_end');
        } else {
            $this->blocks[] = $details['name'];
            if ($this->block_super > 0) {
                $out[] = array('php', '/* declared as array because this block it needs to access parent block\'s contents */');
                $out[] = array('declare', 'blocks["'.$details['name'].'"]', array('array', array(array('var' => $buffer_var)) ) );
                $this->block_super--;
            } else {
                $out[] = array('declare', 'blocks["'.$details['name'].'"]', array('var', $buffer_var));
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

        }
        return $variable;
    }

    protected function generate_op_print($details, &$out)
    {
        $last = count($out)-1;
        if (isset($details['variable'])) {
            $content = array('var', $this->generate_variable_name($details['variable']));
        } else if (isset($details['html']))  {
            $content = array('string', $details['html']);
        } else if (isset($details['php'])) {
            $content = array('php', $details['php']);
        } else {
            throw new Exception("don't know how to generate code for ".print_r($details, TRUE));
        }

        $var_name = 'buffer'.$this->ob_start;
        
        if ($this->ob_start == 0) {
            $operation = 'print';
        } else {
            $operation = 'append_var';
        }

        if ($last >= 0 && $out[$last][0] == $operation && ($operation != 'append_var' || $out[$last][1] === $var_name)) {
            /* try to append this to the previous print if it exists */
            $out[$last][] = $content;
        } else {
            if ($this->ob_start == 0) {
                $out[] = array('print', $content);
            } else {
                if (isset($out[$last]) && $out[$last][0] == 'declare' && $out[$last][1] == $var_name) {
                    /* override an empty declaration of a empty buffer 
                       if the next operation is an 'append'
                    */
                    $out[$last][] = $content;
                } else {
                    $out[] = array('append_var', 'buffer'.$this->ob_start, $content);
                }
            }
        }
    }

    protected function generate_op_loop($details, &$out)
    {
        static $id = 0;
        $id++;
        if (isset($details['empty'])) {
            $out[] = array('if', "count(\${$details['array']}) == 0");
            $out[] = array('ident');
            $this->generate_op_code($details['empty'], $out);
            $out[] = array('ident_end');
            $out[] = array('else');
            $out[] = array('ident');
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
            $out[] = array('declare', $var, array('php', 1) );
            $for_loop_body[] = array('declare', $var, array('php', '$'.$var.' + 1'));

        }
        if (isset($this->forloop_counter0[$oid])) {
            $var   = 'forcounter0_'.$oid;
            $out[] = array('declare', $var, array('php', 0));
            $for_loop_body[] = array('declare', $var, array('php', '$'.$var.' + 1'));
        }

        /* Restore old ForID */
        $this->forid = $oldid;

        /* Merge loop body  */
        $out[] = array('foreach', $details['array'], $this->generate_variable_name($details['variable']));
        $out[] = array('ident');
        $out   = array_merge($out, $for_loop_body);
        $out[] = array('ident_end');
        if (isset($details['empty'])) {
            $out[] = array('ident_end');
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
            $this->generate_op_code($details['body'], $out);
            $this->ob_start--;
            $out[] = array('if', "!isset(\${$var1})", "OR", "\${$var2} != \${$var1}");
            $out[] = array('ident');
            $this->generate_op_print(array('variable' => $var2), $out);
            $out[] = array('declare', $var1, array('php', "\${$var2}"));
            $out[] = array('ident_end');
        } else {
            /* beauty :-) */
            $if = array('if');
            foreach ($details['check'] as $id=>$type) {
                if (!isset($type['var'])) {
                    throw new Exception("Invalid error {$type['var']}");
                }
                $if[] = "!isset(\${$var1}[{$id}])";
                $if[] = '||';
                $if[] = "\${$var1}[{$id}] != \${$type['var']}";
                $if[] = "||";
            }
            array_pop($if);
            $out[] = $if;
            $out[] = array('ident');
            $this->generate_op_code($details['body'], $out);
            $out[] = array('declare', $var1, array('array', $details['check']));
            $out[] = array('ident_end');
        }

        if (isset($details['else'])) {
            $out[] = array('else');
            $out[] = array('ident');
            $this->generate_op_code($details['else'], $out);
            $out[] = array('ident_end');
        }

    }

    function ob_start(&$out)
    {
        $this->ob_start++;
        $out[] = array('declare', 'buffer'.$this->ob_start, array('string', ''));
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
        $haanga = new Haanga;
        $code = $haanga->compile_file($argv[1]);

echo <<<EOF
<?php
$code

\$arr = array('some_list' => array(1, 2, 3, 3, 4, 4, 4, 5), 'user' => 'crodas');
base_template(\$arr);
echo "\\n\\n------------------------------\\n\\n";
subtemplate_template(\$arr);
echo "\\n\\n------------------------------\\n\\n";
subsubtemplate_template(\$arr);

EOF;
    }

}



