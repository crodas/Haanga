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

    public function PrintOut($args) {
        return "echo {$args[0]}";
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

    public function doReturn($args)
    {
        return "return " .$args[0];
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

