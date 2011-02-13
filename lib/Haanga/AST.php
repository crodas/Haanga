<?php
/*
  +---------------------------------------------------------------------------------+
  | Copyright (c) 2010 César Rodas and Menéame Comunicacions S.L.                   |
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

class Haanga_Generator_PHP {
    protected $ident = 0;

    public function string($args) {
        return  "'" . addslashes($args[0]) . "'";
    }

    public function operator($args) {
        return $args[0];
    }

    public function property($args) {
        return "->" . $args[0];
    }

    public function assign ($args) {
        return $args[0] . ' = ' . $args[1];
    }

    public function stmtList($args) {
        return implode(",", $args);
    }

    public function exec($args) {
        return "{$args[0]}({$args[1]})";
    }

    public function expr($args) {
        $prev  = null;
        $code  = '';
        foreach ($args as $val) {
            if ($prev && $prev->getType() != 'Operator') {
                switch ($val->getType()) {
                case "String":
                case "Variable":
                    $code .= ' . ';
                    break;
                default:
                    switch ($prev->getType()) {
                    case "String":
                    case "Variable":
                        $code .= ' . ';
                        break;
                    }
                }
            }
            if ($val->getType() == 'Expr') {
                $code .= '(' . $val . ')';
            } else {
                $code .= $val;
            }

            $prev  = $val;
        }
        return $code;
    }

    public function blockElse($args, $body) {
        return "else {$body}";
    }

    public function blockIf($args, $body) {
        return "if ({$args[0]}) {$body}";
    }


    public function blockFunction($args, $body) {
        $code = "function {$args[0]}({$args[1]}) {$body}";
        return $code;
    }

    public function blockClass($args, $body) {
        $code = "class {$args[0]} {$body}";
        return $code;
    }

    public function blockForEach($args, $body) {
        $code = "foreach ({$args[0]} as ";
        if (!empty($args[1])) {
            $code .= "{$args[1]} => ";
        }
        $code .= " {$args[2]}) {$body}";
        return $code;
    }

    public function nodes($array) {
        if (empty($array)) {
            return "";
        }
        $this->ident++;
        $pident = str_repeat("\t", $this->ident-1);
        $ident  = str_repeat("\t", $this->ident);
        $code  = "{\n";
        foreach ($array as $stmt) {
            if (empty($stmt)) {
                continue;
            }
            $code .= "{$ident}{$stmt}";
            if (!$stmt instanceof Haanga_Node_Blocks) {
                $code .= ";\n";
            }
        }
        $code .=  "{$pident}}\n";
        $this->ident--;
        return $code;
    }

    public function number($args) {
        return (string)$args[0];
    }

    public function variable($args) {
        foreach ($args as $value) {
            if (empty($var)) {
                $var = '$' . $value;
            } else {
                if ($value InstanceOf Haanga_Node_Property) {
                    $var .= $value;
                } else {
                    $var .= "[" .  $value  . "]";
                }
            }
        }
        return $var;
    }
}

Haanga_Node::setGenerator(new Haanga_Generator_PHP);


$def = array('cesar', new Haanga_Node_String('rodas'),  new Haanga_Node_Property('cesar'), 'david', 5, 9.99, new Haanga_Node_Property(new Haanga_Node_Variable('b')));
$var = new Haanga_Node_Variable($def);

$expr = new Haanga_Node_Expr(array(5, '+', 9));
$expr = new Haanga_Node_Expr(array(1, '+', $expr));
$assign1 = new Haanga_Node_Assign($var, $expr);
$assign2 = new Haanga_Node_Assign($var, new Haanga_Node_Expr(array('cesar', 'rodas', $expr, $var)));
$assign3 = new Haanga_Node_Assign($var, new Haanga_Node_Expr(array(5, 'cesar')));

$if = new Haanga_Node_blockIf($expr, array($assign1, $assign2));
$else = new Haanga_Node_blockElse(null, array($assign3));
$args  = new Haanga_Node_StmtList(array(5, 6));
$exec1 = new Haanga_Node_Exec('cesar', $args);
$exec2 = new Haanga_Node_Exec(new Haanga_Node_Variable(array('david', new Haanga_Node_Property('foo'))), $args);


$stmts = array($assign1, $assign2, $assign3, $exec1, $exec2, $if, $else);
$args  = new Haanga_Node_StmtList(array(new Haanga_Node_Assign(new Haanga_Node_Variable('cesar'), new Haanga_Node_Expr(array(5)))));
$for   = new Haanga_Node_blockForeach(new Haanga_Node_Variable('foo'), null, new Haanga_Node_Variable('each'), $stmts);
$fnc   = (new Haanga_Node_blockFunction('cesar', $args, $for));
$fnc   = new Haanga_Node_blockClass('david', $fnc);
die("<?php\n" . $fnc );
exit;

class Haanga_New_AST
{
    public $block = array();
    public $current = 0;

    public function __construct()
    {
        $this->initBlock('init');
    }

    public function end()
    {
        $this->endBlock();
        return $this;
    }

    protected function add(Array $value)
    {
        $this->block[ $this->current ]['ast'][] = $value;

        return $this;
    }

    protected function endBlock()
    {
        if (isset($this->block[$this->current])) {
            $current  = array_pop($this->block);
            $callback = array($this, 'end_' . $current['type']);
            $this->current--;
            if (is_callable($callback)) {
                call_user_func($callback, $current['ast']);
            }
        } else {
            throw new Exception("Invalid call of end()");
        }
    }

    protected function initBlock($name)
    {
        $this->block[] = array('type' => $name, 'ast' => array());
        $this->current = count($this->block) - 1;
    }

    public function pzFunction($name)
    {
        $this->initBlock('function');
        $this->add($name);
        return $this;
    }

    public function end_function($ast) 
    {
        $this->add(array('op' => 'function', 'name' => $ast[0]));
        foreach (array_slice($ast, 1) as $op) {
            $this->add($op);
        }
        $this->add(array('op' => 'end_function'));
    }

    public function pzReturn()
    {
        $this->initBlock('return');
        return $this;
    }

    public function end_return($ast)
    {
        $this->add(array('op' => 'return', $ast[0]));
    }

    public function exec($name=null)
    {
        $this->initBlock('exec');
        if (is_string($name) && !empty($name)) {
            $this->string($name);
        }
        return $this;
    }

    public function end_exec(Array $ast)
    {
        $exec = array('exec' => $ast[0], 'args' => array_slice($ast, 1));
        if ($this->current == 0) {
            $this->add(array('op' => 'expr', $exec));
        } else {
            $this->add($exec);
        }
    }

    public function string($value) 
    {
        $this->add(array('string' => $value));
        return $this;
    }

    public function number($value)
    {
        $this->add(array('number' => $value));
        return $this;
    }
}

$AST = new Haanga_New_AST;
$AST->pzFunction('foobar');

$AST->exec('print')->string('cesar')->number(5)->end();
$AST->exec('print')->string('david')->end();

$AST->pzReturn()->number(5)->end()->end();

var_dump($AST);

/**
 *  Simple AST (abstract syntax tree) helper class. This
 *  helps to generate array structure that is then translated by 
 *  the Haanga_Generator class.
 *
 */
class Haanga_AST
{
    public $stack = array();
    public $current = array();
    public $doesPrint = FALSE;


    // getLast() {{{
    /**
     *  Return a refernce to the last element
     *  of the AST stack.
     *
     *  @return array
     */
    function & getLast()
    {
        $f = array();
        if (count($this->stack) == 0) {
            return $f;
        }
        return $this->stack[count($this->stack)-1];
    }
    // }}}


    static protected function check_type($obj, $type)
    {
        if (is_string($obj)) {
            return FALSE;
        }
        if (is_object($obj)) {
            $obj = $obj->getArray();
        }
        return isset($obj[$type]);
    }

    public static function is_str($arr)
    {
        return self::check_type($arr, 'string');
    }

    public static function is_var($arr)
    {
        return self::check_type($arr, 'var');
    }

    public static function is_exec($arr)
    {
        return self::check_type($arr, 'exec');
    }

    public static function is_expr($arr)
    {
        return self::check_type($arr, 'op_expr');
    }


    public static function str($string)
    {
        return array("string" => $string);
    }

    public static function num($number)
    {
        return array("number" => $number);
    }

    function stack_size()
    {
        return count($this->stack);
    }

    function append_ast(Haanga_AST $obj)
    {
        $this->end();
        $obj->end();
        $this->stack = array_merge($this->stack, $obj->stack);

        return $this;
    }

    static function constant($str)
    {
        return array('constant' => $str);
    }

    function comment($str)
    {
        $this->stack[] = array("op" => "comment", 'comment' => $str);

        return $this;
    }

    function declare_function($name)
    {
        $this->stack[] = array('op' => 'function', 'name' => $name);

        return $this;
    }

    function do_return($name)
    {
        $this->getValue($name, $expr);
        $this->stack[] = array('op' => 'return', $expr);

        return $this;
    }

    function do_if($expr)
    {
        $this->getValue($expr, $vexpr);
        $this->stack[] = array('op' => 'if', 'expr' => $vexpr);

        return $this;
    }

    function do_else()
    {
        $this->stack[] = array('op' => 'else');

        return $this;
    }

    function do_endif()
    {
        $this->stack[] = array('op' => 'end_if');

        return $this;
    }

    function do_endfunction()
    {
        $this->stack[] = array('op' => 'end_function');

        return $this;
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
        if (count($var) == 1) {
            $var = $var[0];
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

    static function fromArrayGetAST($obj)
    {
        $class = __CLASS__;
        if ($obj InstanceOf $class) {
            return $obj;
        }
        foreach (array('op_expr', 'expr_cond', 'exec', 'var', 'string', 'number', 'constant') as $type) {
            if (isset($obj[$type])) {
                $nobj = new $class;
                $nobj->stack[] = $obj;
                return $nobj;
            }
        }
    }

    static function getValue($obj, &$value, $get_all=FALSE)
    {
        $class = __CLASS__;

        if ($obj InstanceOf $class) {
            $value = $obj->getArray($get_all);
        } else if (is_string($obj)) {
            $value = self::str($obj);
        } else if (is_numeric($obj) or $obj === 0) {
            $value = self::num($obj);
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
            throw new Exception("Imposible to get the value of the object");
        }
    }

    function getArray($get_all=FALSE)
    {
        $this->end();
        if ($get_all) {
            return $this->stack;
        }
        return isset($this->stack[0]) ?  $this->stack[0] : NULL;
    }

    function do_for($index, $min, $max, $step, Haanga_AST $body)
    {
        $def = array(
            'op'    => 'for',
            'index' => $index,
            'min'   => $min,
            'max'   => $max,
            'step'  => $step,
        );

        $this->stack[] = $def;
        $this->stack   = array_merge($this->stack, $body->getArray(TRUE));
        $this->stack[] = array('op' => 'end_for');

        return $this;
    }

    function do_foreach($array, $value, $key, Haanga_AST $body)
    {
        foreach (array('array', 'value', 'key') as $var) {
            if ($$var === NULL) {
                continue;
            }
            $var1 = & $$var;
            if (is_string($var1)) {
                $var1 = hvar($var1);
            }
            if (is_object($var1)) {
                $var1 = $var1->getArray();
            }
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

    function do_echo($stmt)
    {
        $this->getValue($stmt, $value);
        $this->stack[] = array('op' => 'print', $value);
        return $this;
    }

    function do_global($array)
    {
        $this->stack[] = array('op' => 'global',  'vars' => $array);

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

    function decl_raw($name, $value)
    {
        if (is_string($name)) {
            $name = hvar($name);
        }
        $this->getValue($name, $name);
        $array = array('op' => 'declare', 'name' => $name['var']);
        foreach (func_get_args() as $id => $value) {
            if ($id != 0) {
                $array[] = $value;
            }
        }
        $this->stack[] = $array;
        return $this;
    }

    function decl($name, $value)
    {
        if (is_string($name)) {
            $name = hvar($name);
        }
        $this->getValue($name, $name);
        $array = array('op' => 'declare', 'name' => $name['var']);
        foreach (func_get_args() as $id => $value) {
            if ($id != 0) {
                $this->getValue($value, $stmt);
                $array[] = $stmt;
            }
        }
        $this->stack[] = $array;
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
    return new Haanga_AST;
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
    return Haanga_AST::Constant($str);
}

// hvar() {{{
/**
 *  Create the representation of a variable
 *
 *  @return Haanga_AST
 */
function hvar()
{
    $args = func_get_args();
    return hvar_ex($args);
}

function hvar_ex($args)
{
    $code = hcode();
    return call_user_func_array(array($code, 'v'), $args);
}
// }}}

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: sw=4 ts=4 fdm=marker
 * vim<600: sw=4 ts=4
 */
