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
    protected $safe  = false;
    
    protected $exec = array(
        'lower' => 'strtolower',
        'upper' => 'strtoupper',
    );

    public function generateString($args) {
        return  "'" . addslashes($args[0]) . "'";
    }

    public function generateOperator($args) {
        return $args[0];
    }

    public function generateProperty($args) {
        return "->" . $args[0];
    }

    public function generateAssign ($args) {
        return $args[0] . ' = ' . $args[1];
    }

    public function generateStmtList($args) {
        return implode(",", $args);
    }

    public function generateExec($args) {
        if (isset($this->exec[$args[0]])) {
            $args[0] = $this->exec[$args[0]];
        }
        return "{$args[0]}({$args[1]})";
    }

    public function generateExpr($args) {
        $prev  = null;
        $code  = '';
        if ($args[0]->getType() != 'Operator') {
            if ($args[0]->getType() == 'Expr') {
                return "(" . $args[0] . ")";
            } else {
                throw new Exception("Malformed Expr");
            }
        }
        switch ((string)$args[0]) {
        case 'in':
            $code = "(strpos({$args[2]}, {$args[1]}) !== false)";
            break;
        case '?':
            $code = "{$args[1]} ? {$args[2]} : {$args[3]}";
            break;
        default:
            $code = $args[1] . $args[0] . $args[2];
        }
        return $code;
    }

    public function generatePrint($args) {
        if ($args[0] InstanceOf Haanga_Node_String) {
            list($value) = $args[0]->getAttributes();
            $value = trim($value);
            if (empty($value)) {
                return '';
            }
        }
        return "echo {$args[0]}";
    }

    public function generateElse($args, $body) {
        return "else {$body}";
    }

    public function generateIf($args, $body) {
        return "if ({$args[0]}) {$body}";
    }


    public function generateFunction($args, $body) {
        $code = "function {$args[0]}({$args[1]}) {$body}";
        return $code;
    }

    public function blockClass($args, $body) {
        $code = "class {$args[0]} {$body}";
        return $code;
    }

    public function generateForEach($args, $body) {
        $code = "foreach ({$args[0]} as ";
        if (!empty($args[1])) {
            $code .= "{$args[1]} => ";
        }
        $code .= " {$args[2]}) {$body}";
        return $code;
    }

    public function generateComment($string)
    {
        return "/* $string[0] */\n";
    }

    public function doReturn($args)
    {
        return "return " .$args[0];
    }

    public function nodes($array, $newBlock=true) {
        if (empty($array)) {
            return "";
        }
        if ($newBlock) {
            $this->ident++;
            $code  = "{\n";
        } else {
            $code = '';
        }
            
        $pident = str_repeat("\t", $this->ident-1);
        $ident  = str_repeat("\t", $this->ident);
        foreach ($array as $stmt) {
            if (empty($stmt)) {
                continue;
            }
            $current = "$stmt";
            if (empty($current)) {
                continue;
            }
            $code .= "{$ident}{$current}";
            if (!$stmt instanceof Haanga_Node_Blocks && substr($code, -1) != "\n") {
                $code .= ";\n";
            }
        }
        if ($newBlock) {
            $code .=  "{$pident}}\n";
            $this->ident--;
        }
        return $code;
    }

    public function generateNumber($args) {
        return (string)$args[0];
    }

    public function generateVariable($args) {
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

    public function exec_length($obj)
    {
        $id = '$s' . uniqid();
        return "is_array($id = {$obj[1]}) ? count($id) : strlen($id)";
    }

    public function exec_haanga_include($obj, $body) {
        return "Haanga::Load({$obj[1]}, \$vars, \$blocks)";
    }

    public function exec_haanga_ifchanged($obj, $nodes) {
        static $id = 0;
        $id++;
        $var    = "\$haanga_ifchanged_{$id}";
        $buffer = "\$haanga_buffer_{$id}";


        $ident = str_repeat("\t", $this->ident);

        /* check if the content has changed */
        if (empty($nodes['params'])) {
            /* run the code in a buffer */
            $code  = "ob_start();\n";
            $code .= $this->nodes($nodes['body'], false);
            $code .= "{$ident}$buffer = ob_get_clean();\n";
            $code .= "{$ident}if (empty($var) || {$var} != $buffer) {\n";
            $code .= "{$ident}\techo {$buffer};\n";
            $code .= "{$ident}\t$var = {$buffer};\n";
            $code .= "{$ident}}";
        } else {
            /* check for variables */
            $expr   = "empty($var) || (";
            $assign = "{$ident}\t$var = array(";
            foreach ($nodes['params']->getAttributes() as $id => $check) {
                $name    = "{$var}[$id]";
                $expr   .= "empty($name) || $name != $check && ";
                $assign .= "$id => $check,";
            }
            $assign .= ");\n";
            $expr    = substr($expr, 0, -4) . ")";
            $code    = "if ($expr) {\n";

            $this->ident++;
            $code .= $this->nodes($nodes['body'], false);
            $this->ident--;
            $code .= "{$assign}{$ident}}";
        }

        /* else */
        if (!empty($nodes['else'])) {
            $code .= " else " . $this->nodes($nodes['else']);
        }

        return $code;
    }

    public function exec_firstof($obj)
    {
        $args  = $obj[1]->getAttributes();
        $count = count($args);
        $args  = array_reverse($args);
        for ($i=0; $i < $count; $i++) {
            if (isset($expr) && $args[$i] InstanceOf Haanga_Node_Variable) {
                $expr = new Haanga_Node_Expr(array(
                    new Haanga_Node_Operator('?'), 
                    new Haanga_Node_Exec('!empty', new Haanga_Node_StmtList(array($args[$i]))), 
                    $args[$i],
                    $expr, 
                ));
                // ( $expr )
                $expr = new Haanga_Node_Expr(array($expr));
            } else {
                $expr = $args[$i];
            }
        }

        // generate print 
        return $this->generatePrint(array($expr));
    }

    public function exec_safe($obj)
    {
        $this->safe = true;
        $code       = (string)$obj[1];
        $this->safe = false;
        return $code;
    }

}

Haanga_Node::setGenerator(new Haanga_Generator_PHP);
