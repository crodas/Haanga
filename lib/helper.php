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

class HCode
{
    public $stack;

    public $current = array();


    function &getLast()
    {
        if (count($this->stack) == 0) {
            return array();
        }
        return $this->stack[count($this->stack)-1];
    }

    function is_str($arr)
    {
        return isset($arr['string']);
    }

    function str($string)
    {
        return array("string" => $string);
    }

    function num($number)
    {
        return array("number" => $number);
    }

    function constant($str)
    {
        return array('constant' => $str);
    }

    function v()
    {
        $var = array();
        foreach (func_get_args() as $id => $def) {
            if ($id == 0) {
                $var[$id] = $def;
            } else {
                $this->getValue($def, $value);
                $var[$id] = $value;
            }
        }
        $this->current = array('var' => $var);

        return $this;
    }

    final function __get($property)
    {
        $property = strtolower($property);
        if (isset($this->current[$property])) {
            return $this->current[$property];
        }
        return FALSE;
    }

    protected function getValue($obj, &$value, $get_all=FALSE)
    {
        $class = __CLASS__;

        if ($obj InstanceOf $class) {
            $value = $obj->getArray($get_all);
        } else if (is_string($obj)) {
            $value = $this->str($obj);
        } else if (is_numeric($obj) or $obj === 0) {
            $value = $this->num($obj);
        } else if ($obj === FALSE) {
            $value = array('expr' => FALSE);
        } else if ($obj === TRUE) {
            $value = array('expr' => TRUE);
        } else if (is_array($obj)) {
            foreach (array('exec', 'var', 'string', 'number', 'constant') as $type) {
                if (isset($obj[$type])) {
                    $value = $obj;
                    return;
                }
            }
            $h     = hcode()->arr();
            $first = 0;
            foreach($obj as $key => $value) {
                if ($key === $first) {
                    $key = NULL;
                    $first++;
                }
                $h->element($key, $value);
            }
            $value = $h->getArray();
        } else if ($obj === NULL) {
            $value = array();
        } else {
            var_Dump($obj);
            throw new Exception("Imposible to get the value of the object");
        }
    }

    function getArray($get_all=FALSE)
    {
        $this->end();
        if ($get_all) {
            return $this->stack;
        }
        return $this->stack[0];
    }

    function for_each($array, $value, $key, HCode $body)
    {
        foreach (array('array', 'value', 'key') as $var) {
            if ($$var === NULL) {
                continue;
            }
            $var1 = & $$var;
            if (is_string($var1)) {
                $var1 = hvar($var1);
            }
            $var1 = $var1->getArray();
            $var1 = $var1['var'];
        }
        $def = array('op' => 'foreach', 'array' => $array, 'value' => $value);
        if ($key) {
            $def['key'] = $key;
        }
        $this->stack[] = $def;
        $this->stack   = array_merge($this->stack, $body->getArray(TRUE));
        $this->stack[] = array('op' => 'end_foreach');

        return $this;
    }

    function do_exec()
    {
        $params = func_get_args();
        $exec   = call_user_func_array('hexec', $params);
        $this->stack[] = array('op' => 'expr', $exec->getArray());

        return $this;
    }

    function exec($function)
    {
        $this->current = array('exec' => $function, 'args' => array());
        foreach (func_get_args() as $id => $param) {
            if ($id > 0) {
                $this->param($param);
            }
        }
        return $this;
    }

    function expr($operation, $term1, $term2=NULL)
    {
        $this->getValue($term1, $value1);
        if ($term2 !== NULL) {
            $this->getValue($term2, $value2);
        } else {
            $value2 = NULL;
        }
        $this->current = array('op_expr' => $operation, $value1, $value2);

        return $this;
    }

    function expr_cond($expr, $if_true, $if_false)
    {
        $this->getValue($expr, $vExpr);
        $this->getValue($if_true, $vIfTrue);
        $this->getValue($if_false, $vIfFalse);

        $this->current = array('expr_cond' => $vExpr, 'true' => $vIfTrue, 'false' => $vIfFalse);

        return $this;
    }


    function arr()
    {
        $this->current = array('array' => array());

        return $this;
    }

    function element($key=NULL, $value)
    {
        $last = & $this->current;

        if (!isset($last['array'])) {
            throw new Exception("Invalid call to element()");
        }

        $this->getValue($value, $val);
        if ($key !== NULL) {
            $this->getValue($key, $kval);
            $val = array('key' => array($kval, $val));
        }
        $last['array'][] = $val;
    }

    function decl($name, $value)
    {
        if (is_string($name)) {
            $name = hvar($name);
        }
        $this->getValue($value, $stmt);
        $this->getValue($name, $name);
        $this->stack[] = array('op' => 'declare', 'name' => $name['var'], $stmt);
        return $this;
    }

    function append($name, $value)
    {
        if (is_string($name)) {
            $name = hvar($name);
        }
        $this->getValue($value, $stmt);
        $this->getValue($name, $name);
        $this->stack[] = array('op' => 'append_var', 'name' => $name['var'], $stmt);
        return $this;
    }

    function param($param)
    {
        $last = & $this->current;

        if (!isset($last['exec'])) {
            throw new Exception("Invalid call to param()");
        }
        
        $this->getValue($param, $value);
        $last['args'][] = $value;

        return $this;
    }

    function end()
    {
        if (count($this->current) > 0) {
            $this->stack[] = $this->current;
            $this->current = array();
        }

        return $this;
    }
}

function hcode()
{
    return new HCode;
}

function hexpr($term1, $op='expr', $term2=NULL, $op2=NULL)
{
    $code = hcode();
    switch ($op2) {
    case '+':
    case '-':
    case '/':
    case '*':
    case '%':
    case '||':
    case '&&':
    case '<':
    case '>':
    case '<=':
    case '>=':
    case '==':
    case '!=':
        /* call recursive to resolve term2 */
        $args = func_get_args();
        $term2 = call_user_func_array('hexpr', array_slice($args, 2));
        break;
    }
    return $code->expr($op, $term1, $term2);
}

function hexpr_cond($expr, $if_true, $if_false)
{
    $code = hcode();
    $code->expr_cond($expr, $if_true, $if_false);

    return $code;
}

function hexec()
{
    $code = hcode();
    $args = func_get_args();
    return call_user_func_array(array($code, 'exec'), $args);
}

function hconst($str)
{
    return HCode::Constant($str);
}

function hvar()
{
    $code = hcode();
    $args = func_get_args();
    return call_user_func_array(array($code, 'v'), $args);
}

