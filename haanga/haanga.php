<?php

require "lexer.php";
require "generator.php";

class Haanga
{
    protected $generator;

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
    function compile_file($file)
    {
        if (!is_readable($file)) {
            throw new Exception("$file is not a file");
        }
        return $this->compile(file_get_contents($file));
    }

    function compile($code)
    {
        $parsed = do_parsing($code);
        $this->generate_op_code($parsed, $op_code);
        return $this->generator->getCode($op_code);
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
        if ($out[$last][0] == 'print') {
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
        if ($out[$last][0] == 'print') {
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
        $out[] = array('if', '!isset($partial)', '||', '!isset($partial["'.$details['name'].'"])');
        $out[] = array('ident');
        $this->generate_op_code($details['body'], $out);
        $out[] = array('ident_end');
        $out[] = array('else');
        $out[] = array('ident');
        $out[] = array('print', array('var' => 'partial["'.$details['name'].'"]'));
        $out[] = array('ident_end');
    }

    protected function generate_op_print($details, &$out)
    {
        $last    = count($out)-1;
        $content = array('var' => $details['variable']);
        if ($out[$last][0] == 'print') {
            /* try to append this to the previous print if it exists */
            $out[$last][] = $content;
        } else {
            $out[] = array('print', $content);
        }
    }

    protected function generate_op_loop($details, &$out)
    {
        if (isset($details['empty'])) {
            $out[] = array('if', "!is_array(\${$details['array']})", "OR", "count(\${$details['array']}) == 0");
            $out[] = array('ident');
            $this->generate_op_code($details['empty'], $out);
            $out[] = array('ident_end');
        }
        $out[] = array('else');
        $out[] = array('ident');
        $out[] = array('foreach', $details['array'], $details['variable']);
        $out[] = array('ident');
        $this->generate_op_code($details['body'], $out);
        $out[] = array('ident_end');
        $out[] = array('ident_end');
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
        $last    = count($out)-1;
        if ($out[$last][0] == 'print') {
            /* try to append this to the previous print if it exists */
            $out[$last][] = $content;
        } else {
            $out[] = array('print', $content);
        }
    }

}

$haanga = new Haanga;
$code = $haanga->compile_file('../template.tpl');

echo "<?php
function template(\$var, \$partial=array()) {
    extract(\$var);
$code
}

template(array('some_list' => array(1, 2,2, 3, 4, 4)));

";
