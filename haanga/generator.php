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
            $method = "php_{$op[0]}";

            if (!is_callable(array($this, $method))) {
                throw new Exception("CodeGenerator: Missing method $method");
            }
            switch ($op[0]) {
            case 'ident':
            case 'ident_end':
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
        return " else ";
    }

    function php_php($op)
    {
        return $op[1];
    }

    function php_function($op)
    {
        return "function {$op[1]}_template(\$vars, \$blocks=array(), \$return=FALSE)";
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
        return " {";
    }

    protected function php_ident_end($op)
    {
        $this->ident--;
        return $this->ident()."}";
    }

    protected function php_if($op)
    {
        unset($op[0]);
        $code  = "if (".implode(" ", $op).")";
        return $code;
    }


    protected function php_foreach($op)
    {
        $code = "foreach (\${$op[1]} as ";
        if (count($op) == 3) {
            $code .= " \${$op[2]}";
        } else {
            $code .= " \${$op[2]} => \${$op[3]}";
        }

        $code .= ")";
        return $code;
    }

    protected function php_append_var($op)
    {
        return $this->php_declare($op, '.=');
    }

    protected function php_generate_list($array)
    {
        $code = "";
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

    protected function php_generate_string($op, $skip=2)
    {
        $code = "";
        for ($i=$skip; $i < count($op); $i++) {
            switch ($op[$i][0]) {
            case 'array':
                $code .= "Array(";
                $code .= $this->php_generate_list($op[$i][1]);
                $code .= ")";
                break;
            case 'function':
                $code .= $op[$i][1].'(';
                $code .= $this->php_generate_list($op[$i]['args']);
                $code .= ')';
                break;
            case 'php':
                if (strlen($code) != 0) {
                    $code .= '.';
                }
                $code .= $op[$i][1].'.';
                break;
            case 'string':
                if ($code != "" && $code[strlen($code)-1] == '"') {
                    $code = substr($code, 0, strlen($code)-1);
                } else {
                    $code .= '"';
                }
                $html  = addslashes($op[$i][1]);
                $html  = str_replace(array('$', "\r", "\t", "\n"), array('\\$', '\r', '\t', '\n'), $html);
                $code .= $html.'"';
                break;
            case 'var':
                if ($code != "" && $code[strlen($code)-1] == '"') {
                    $code = substr($code, 0, strlen($code)-1);
                } else {
                    $code .= '"';
                }
                if ($op[$i][1][0] == '\\') {
                    $code .= $op[$i][1].'"';
                } else {
                    $code .= '{$'.$op[$i][1].'}"';
                }
                break;
            default:
                throw new Exception("Don't know how to declare {$op[$i][0]} = {$op[$i][1]}");
            }
        }

        if ($code != "" && $code[strlen($code)-1] == '.') {
            $code = substr($code, 0, strlen($code)-1);
        }

        return $code;
    }

    protected function php_print($op)
    {
        return 'echo '.$this->php_generate_string($op, 1).';';
    }

    protected function php_declare($op, $assign=' =')
    {
        $code = "\${$op[1]} {$assign} ".$this->php_generate_string($op,2).";";
        return $code;
    }
}
