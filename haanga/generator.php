<?php

class Haanga_CodeGenerator
{
    protected $ident;
    protected $tab = "    ";

    function __construct()
    {
    }

    function getCode($op_code)
    {
        $this->ident = 0;
        $code = "";
        foreach ($op_code as $op) {
            $method = "php_{$op['op']}";
            if (!is_callable(array($this, $method))) {
                var_dump($code, $op);
                throw new Exception("CodeGenerator: Missing method $method");
            }
            switch ($op['op']) {
            case 'end_foreach':
            case 'end_if':
            case 'else':
                break;
            default:
                $code .= $this->ident();
            }
            $code .= $this->$method($op);
        }
        return $code;
    }

    protected function php_else()
    {
        $this->ident--;
        $code = $this->ident()."} else {";
        $this->ident++;
        return $code;
    }

    function php_php($op)
    {
        return $op[1];
    }

    function php_comment($op)
    {
        return "/*{$op['comment']}*/";
    }

    function php_function($op)
    {
        $this->ident++;
        return "function {$op['name']}_template(\$vars, \$blocks=array(), \$return=FALSE)\n{\n";
    }

    protected function ident()
    {
        $code = "\n";
        $code .= str_repeat($this->tab, $this->ident);

        return $code;
    }

    protected function php_ident($op)
    {
        $this->ident++;
        return "{";
    }

    protected function php_ident_end($op)
    {
        $this->ident--;
        return $this->ident()."}";
    }

    protected function php_if($op)
    {
        $code  = "if (".$this->php_generate_expr($op['expr']).") {";
        $this->ident++;
        return $code;
    }


    protected function php_end_block()
    {
        $this->ident--;
        return $this->ident()."}";    
    }

    protected function php_end_function($op)
    {
        return $this->php_end_block();
    }

    protected function php_end_if($op)
    {
        return $this->php_end_block();
    }

    protected function php_end_foreach($op)
    {
        return $this->php_end_block();
    }

    protected function php_foreach($op)
    {
        $code = "foreach (\${$op['array']} as ";
        if (!isset($op['key'])) {
            $code .= " \${$op['value']}";
        } else {
            $code .= " \${$op['key']} => \${$op['value']}";
        }

        $code .= ") {";
        $this->ident++;
        return $code;
    }


    protected function php_append_var($op)
    {
        return $this->php_declare($op, '.=');
    }

    protected function php_exec($op, $stmt=TRUE)
    {
        $code  = "";
        $code .= $op['name'].'(';
        if (isset($op['args'])) {
            $code .= $this->php_generate_list($op['args']);
        }
        $code .= ')';
        if ($stmt) {
            $code .=";";
        }
        return $code;
    }

    protected function php_generate_expr($expr)
    {
        $code = '';
        if (is_array($expr) && isset($expr['op'])) {
            if ($expr['op'] == 'expr') {
                $code .= "(";
                $code .= $this->php_generate_expr($expr[0]);
                $code .= ")";
            } else {
                $code .= $this->php_generate_expr($expr[0]);
                $code .= " {$expr['op']} ";
                $code .= $this->php_generate_expr($expr[1]);
            }
        } else {
            if (is_array($expr)) {
                if (isset($expr['var'])) {
                    $code .= '$'.$expr['var'];
                } else if (isset($expr['exec'])) {
                    $expr['name'] = $expr['exec'];
                    $code .= $this->php_exec($expr, FALSE);
                } else {
                    throw new Exception("don't know how to generate code for ".print_r($expr, TRUE));
                }
            } else {
                if ($expr === FALSE) {
                    $expr = 'FALSE';
                } else if ($expr === TRUE) {
                    $expr = 'TRUE';
                }
                $code .= $expr;
            }
        }
        return $code;
    }

    protected function php_generate_list($array)
    {
        $code = "";
        if (!is_array($array)) {
            var_dump(debug_backtrace());die();
        }
        foreach ($array as $value) {
            if (isset($value['string'])) {
                $string = addslashes($value['string']);
                $string = str_replace('$', '\\$', $string);
                $code .= '"'.$string.'"';
            } else if (isset($value['var'])) {
                if ($value['var'][0] == '\\') {
                    $code .= $value['var'];
                } else {
                    $code .= "\${$value['var']}";
                    if (isset($value['index'])) {
                        $code .= '["'.addslashes($value['index']).'"]';
                    }
                }
            } else {
                throw new exception("Don't know how to generate array for ".print_r($value, TRUE));
            }
            $code .= ",";
        }
        return substr($code, 0, strlen($code)-1);
    }

    protected function php_generate_string($op, $skip=0)
    {
        $code = "";
        for ($i=$skip; $i < count($op); $i++) {
            if (!isset($op[$i])) {
                continue;
            }
            $key   = key($op[$i]);
            $value = current($op[$i]); 
            switch ($key) {
            case 'array':
                $code .= "Array(";
                $code .= $this->php_generate_list($value);
                $code .= ")";
                break;
            case 'function':
            case 'exec':
                if (strlen($code) != 0) {
                    $code .= '.';
                }
                $code .= $value.'(';
                if (isset($op[$i]['args'])) {
                    $code .= $this->php_generate_list($op[$i]['args']);
                }
                $code .= ').';
                break;
            case 'php':
                if (strlen($code) != 0) {
                    $code .= '.';
                }
                $code .= $value.'.';
                break;
            case 'string':
                if ($code != "" && $code[strlen($code)-1] == '"') {
                    $code = substr($code, 0, strlen($code)-1);
                } else {
                    $code .= '"';
                }
                $html  = addslashes($value);
                $html  = str_replace(array('$', "\r", "\t", "\n"), array('\\$', '\r', '\t', '\n'), $html);
                $code .= $html.'"';
                break;
            case 'var':
                if ($code != "" && $code[strlen($code)-1] == '"') {
                    $code = substr($code, 0, strlen($code)-1);
                } else {
                    $code .= '"';
                }
                if ($value[0] == '\\') {
                    $code .= $value.'"';
                } else {
                    $code .= '{$'.$value.'}"';
                }
                break;
            case 'number':
                if (!is_numeric($value)) {
                    throw new Exception("$value is not a valid number");
                }
                $code .= $value;
                break;
            case 'expr':
                $code .= $this->php_generate_expr($value);
                break;
            default:
                throw new Exception("Don't know how to declare {$key} = {$value}");
            }
        }

        if ($code != "" && $code[strlen($code)-1] == '.') {
            $code = substr($code, 0, strlen($code)-1);
        }

        return $code;
    }

    protected function php_print($op)
    {
        return 'echo '.$this->php_generate_string($op).';';
    }

    protected function php_inc($op)
    {
        return "\${$op['name']}++;";
    }

    protected function php_declare($op, $assign=' =')
    {
        $code = "\${$op['name']} {$assign} ".$this->php_generate_string($op).";";
        return $code;
    }

    protected function php_return($op)
    {
        $code = "return ".$this->php_generate_string($op).";";
        return $code;
    }


    protected function php_cond_declare($op)
    {
        $code  = "\${$op['name']} = ";
        $code .= $this->php_generate_expr($op['expr']); 
        $code .= ' ? '.$this->php_generate_string($op['true']);
        $code .= ' : '.$this->php_generate_string($op['false']);
        $code .= ";";
        return $code;
    }

}
