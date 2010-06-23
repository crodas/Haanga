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
            $base = $parsed['base']['string'];
            $base = substr($base, 1, strlen($base)-2);
            if (isset($this->_base_dir)) {
                $base = $this->_base_dir.'/'.$base;
            }
            if (!is_file($base)) {
                throw new Exception("can't find {$base} base template");
            }
            $comp  = new Haanga;
            $code .= $comp->compile_file($base)."\n\n";
            unset($parsed['base']);
            $this->subtemplate = $comp->get_template_name();
        }
        if ($name) {
            $op_code[] = array('function', $name);
            $op_code[] = array('ident');
            $op_code[] = array('php', 'extract($vars);');
        }
        $this->generate_op_code($parsed, $op_code);
        if ($this->subtemplate) {
            $arr = '';
            foreach ($this->blocks as $block) {
                $arr .= "'$block' => \${$block}, ";
            }
            $op_code[] = array('php', $this->subtemplate.'_template($vars, array('.$arr.'));');
        }

        if ($name) {
            $op_code[] = array('ident_end');
        }
        $code .= $this->generator->getCode($op_code);
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

    protected function generate_op_html($details, &$out)
    {
        $last    = count($out)-1;
        $content = str_replace('$', '\\$', addslashes($details['html']));
        $content = str_replace(array("\r", "\t", "\n"), array('\r', '\t', '\n'), $content);
        if ($last >= 0  && $out[$last][0] == 'print') {
            /* try to append this to the previous print if it exists */
            $out[$last][] = $content;
        } else {
            $out[] = array('print', $content);
        }
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

        $out[] = array('declare', 'def_cycle_'.$cycle, 'array', $details['vars']);
        $out[] = array('declare', 'index_'.$cycle, 'php', '(!isset($index_'.$cycle.') ? 0 : ($index_'.$cycle.' + 1) % sizeof($def_cycle_'.$cycle.'))' ); 
        $var  = array('var' => "def_cycle_{$cycle}[\$index_{$cycle}]");
        if (isset($print)) {
            $print[] = $var;
            $out[]   = $print;
        } else {
            $out[] = array('print', $var);
        }
        $cycle++;
    }

    protected function generate_op_comment($details, &$out)
    {
    }

    protected function generate_op_php($details, &$out)
    {
        $out[] = array('php', $details['php']);
    }

    protected function generate_op_block($details, &$out)
    {
        if (!$this->subtemplate) {
            $out[] = array('if', '!isset($blocks)', '||', '!isset($blocks["'.$details['name'].'"])');
            $out[] = array('ident');
        } else {
            $out[] = array('php', 'ob_start();');
            $this->in_block++;
        }
        $this->generate_op_code($details['body'], $out);
        if (!$this->subtemplate) {
            $out[] = array('ident_end');
            $out[] = array('else');
            $out[] = array('ident');
            $out[] = array('print', array('var' => 'blocks["'.$details['name'].'"]'));
            $out[] = array('ident_end');
        } else {
            $this->blocks[] = $details['name'];
            $out[] = array('declare', $details['name'], 'php', 'ob_get_clean()');
            $this->in_block--;
        }
    }

    protected function generate_variable_name($variable)
    {
        if (is_array($variable)) {
            if ($variable[0] == 'forloop') {
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
            }
        }
        return $variable;
    }

    protected function generate_op_print($details, &$out)
    {
        $last    = count($out)-1;
        $content = array('var' => $this->generate_variable_name($details['variable']));
        if ($last >= 0 && $out[$last][0] == 'print') {
            /* try to append this to the previous print if it exists */
            $out[$last][] = $content;
        } else {
            $out[] = array('print', $content);
        }
    }

    protected function generate_op_loop($details, &$out)
    {
        static $id = 0;
        $id++;
        if (isset($details['empty'])) {
            $out[] = array('if', "!is_array(\${$details['array']})", "OR", "count(\${$details['array']}) == 0");
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
            $out[] = array('declare', $var, 'php', 1);
            $for_loop_body[] = array('declare', $var, 'php', '$'.$var.' + 1');

        }
        if (isset($this->forloop_counter0[$oid])) {
            $var   = 'forcounter0_'.$oid;
            $out[] = array('declare', $var, 'php', 0);
            $for_loop_body[] = array('declare', $var, 'php', '$'.$var.' + 1');
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

        $var1 = 'ifchanged_'.$ifchanged;
        $var2 = 'output_'.$ifchanged;
        if (!isset($details['check'])) {
            /* ugly */
            $out[] = array('declare', 'block', 'php', 'ob_start()');
            $this->generate_op_code($details['body'], $out);
            $out[] = array('declare', $var2, 'php', 'ob_get_clean()');
            $out[] = array('if', "!isset(\${$var1})", "OR", "\${$var2} != \${$var1}");
            $out[] = array('ident');
            $out[] = array('print', array('var' => $var2));
            $out[] = array('declare', $var1, 'php', "\${$var2}");
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
            $out[] = array('declare', $var1, 'array', $details['check']);
            $out[] = array('ident_end');
        }

        if (isset($details['else'])) {
            $out[] = array('else');
            $out[] = array('ident');
            $this->generate_op_code($details['else'], $out);
            $out[] = array('ident_end');
        }

        $ifchanged++;
    }

    function generate_op_filter($details, &$out)
    {
        $out[] = array('php', 'ob_start();');
        $this->generate_op_code($details['body'], $out);
        $details['functions'] = array_reverse($details['functions']);
        $func = "";
        foreach ($details['functions'] as $f) {
            $func .= "{$f['var']}(";
        }
        $func   .= 'ob_get_clean()'.str_repeat(')', count($details['functions']));;
        $content = array('php' => $func);
        $out[]   = array('print', $content);
    }

}

$haanga = new Haanga;
$code = $haanga->compile_file('../template.tpl');


echo <<<EOF
<?php
$code
    \$arr = array('some_list' => array(1, 2, 3, 4, 5), 'user' => 'crodas');
    base_template(\$arr);
    echo "\\n\\n------------------------------\\n\\n";
    template_template(\$arr);
EOF;
