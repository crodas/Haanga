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

    function php_comment($op)
    {
        return "/* {$op['comment']} */";
    }

    function php_function($op)
    {
        $this->ident++;
        return "function {$op['name']}(\$vars, \$return=FALSE, \$blocks=array())\n{\n";
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

    protected function php_expr($op)
    {
        return $this->php_generate_expr($op[0]).";";
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
        $op['array'] = $this->php_get_varname($op['array']);
        $op['value'] = $this->php_get_varname($op['value']);
        $code = "foreach ({$op['array']} as ";
        if (!isset($op['key'])) {
            $code .= " {$op['value']}";
        } else {
            $op['key'] = $this->php_get_varname($op['key']);
            $code     .= " {$op['key']} => {$op['value']}";
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
                $code .= $this->php_generate_declare(array($expr));
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
        foreach ($array as $value) {
            $code .= $this->php_generate_declare(array($value));
            $code .= ",";
        }
        return substr($code, 0, strlen($code)-1);
    }

    protected function php_generate_declare($op, $skip=0)
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
                if (strlen($code) != 0 && $code[strlen($code) -1] != '.') {
                    $code .= '.';
                }
                $value = array('name' => $value, 'args' => $op[$i]['args']);
                $code .= $this->php_exec($value, FALSE);
                $code .= '.';
                break;
            case 'key':
                $code .= $this->php_generate_declare(array($value[0]))." => ".$this->php_generate_declare(array($value[1]));
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
                if (strlen($code) != 0 && $code[strlen($code) -1] != '.') {
                    $code .= '.';
                }
                $code .= $this->php_get_varname($value).'.';
                break;
            case 'number':
                if (!is_numeric($value)) {
                    throw new Exception("$value is not a valid number");
                }
                $code .= $value;
                break;
            case 'expr':
                if (strlen($code) != 0) {
                    $code .= '.';
                }
                $code .= $this->php_generate_expr($value);
                $code .= ".";
                break;
            case 'expr_cond':
                if (strlen($code) != 0) {
                    $code .= '.';
                }
                $code .= "(";
                $code .= $this->php_generate_expr($value);
                $code .= " ? ";
                $code .= $this->php_generate_declare(array($op[$i]['true']));
                $code .= " : ";
                $code .= $this->php_generate_declare(array($op[$i]['false']));
                $code .= ").";
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
        return 'echo '.$this->php_generate_declare($op).';';
    }

    protected function php_inc($op)
    {
        return "\${$op['name']}++;";
    }

    protected function php_declare($op, $assign=' =')
    {
        $op['name'] = $this->php_get_varname($op['name']);
        $code = "{$op['name']} {$assign} ".$this->php_generate_declare($op).";";
        return $code;
    }

    protected function php_get_varname($var)
    {
        if (is_array($var)) {
            if (!is_string($var[0])) {
                if (count($var) == 1) {
                    return $this->php_get_varname($var[0]);
                } else {
                    throw new Exception("Invalid variable definition ".print_r($var, TRUE));
                }
            } 
            $var_str = $this->php_get_varname($var[0]);
            for ($i=1; $i < count($var); $i++) {
                $var_str .= "[";
                if (is_string($var[$i])) {
                    $var_str .= '"'.$var[$i].'"';
                } else if (is_array($var[$i])) {
                    if (isset($var[$i]['var'])) {
                        $var_str .= $this->php_get_varname($var[$i]['var']);
                    } else if (isset($var[$i]['string'])) {
                        $var_str .= '"'.addslashes($var[$i]['string']).'"';
                    }
                }
                $var_str .= "]";
            }
            return $var_str;
        } else {
            if ($var[0] == "\$") {
                /* hack to the system */
                return $this->php_generate_declare(array(array('string' => $var)));
            }
            return "\$".$var;
        }
    }

    protected function php_return($op)
    {
        $code = "return ".$this->php_generate_declare($op).";";
        return $code;
    }

}
