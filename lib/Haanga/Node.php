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

/**
 *  Node Abstraction
 *
 */
abstract class Haanga_Node 
{
    protected $line;
    protected $attrs;
    protected $nodes;
    protected $parent;

    protected static $generator;

    public function __construct($nodes, $attrs=array(), $line=0)
    {
        if (!is_array($nodes)) {
            $nodes = array($nodes);
        }
        if (!is_array($attrs)) {
            $attrs = array($attrs);
        }

        // add reference to parent node
        foreach ($nodes as $node) {
            if ($node instanceof Haanga_Node) {
                $node->parent = $this;
            }
        }

        $this->nodes = $nodes;
        $this->attrs = $attrs;
        $this->line  = $line;
    }

    public function getAttributes()
    {
        return $this->attrs;
    }

    public function addAttribute($obj)
    {
        $this->attrs[] = self::convertNative($obj);
    }

    public function addNode(Haanga_Node $node)
    {
        $this->nodes[] = $node;
        return $this;
    }

    /**
     *  Get Parent node.
     *
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function getType()
    {
        return substr(get_class($this), strlen(__CLASS__) +1);
    }

    public function setLine($line)
    {
        $this->line = $line;
    }

    public static function setGenerator($generator)
    {
        self::$generator = $generator;
    }

    final public function __toString()
    {
        $generator = self::$generator;

        $class = 'generate' . $this->getType();
        $body  = $generator->nodes($this->nodes);
        return $generator->$class($this->getAttributes(), $body);
    }

    public static function convertNative($value)
    {
        if ($value instanceOf Haanga_Node) {
            return $value;
        } 
        
        switch ($value) {
        case '+': case '++': case '-': 
        case '*': case '/':case '%':
            return new Haanga_Node_Operator($value);
        }
        
        if (is_string($value)) {
            $value = new Haanga_Node_String($value);
        } else if (is_numeric($value)) {
            $value = new Haanga_Node_Number($value);
        } else {
            throw new Exception("Don't know how to convert {$value}");
        }
        return $value;
    }
}

abstract class Haanga_Node_Simple extends Haanga_Node
{
    public function __construct($name, $line=0)
    {
        parent::__construct(array(), array($name), $line);
    }
}

/**
 *  Abstraction for Basic nodes (those which requires 
 *  just one text parameter).
 *
 */
abstract class Haanga_Node_BlockSimple extends Haanga_Node
{
    public function __construct($text, $line=0)
    {
        if (!is_array($text)) {
            $text = array($text);
        }
        parent::__construct(array(), $text, $line);
    }
}

/**
 *  Abstraction for Basic nodes with one parameter
 *  and nodes.
 *
 */
abstract class Haanga_Node_Blocks extends Haanga_Node
{
    function __construct($expr, $stmts, $line=0)
    {
        parent::__construct($stmts, $expr, $line);
    }

    public function setBody(Array $stmts)
    {
        $this->attrs = $stmts;
    }
}

final class Haanga_Node_Bool extends Haanga_Node_BlockSimple
{
}

final class Haanga_Node_Number extends Haanga_Node_BlockSimple
{
}

final class Haanga_Node_String extends Haanga_Node_BlockSimple
{
}

final class Haanga_Node_Operator extends Haanga_Node_BlockSimple 
{
}

final class Haanga_Node_StmtList extends Haanga_Node_BlockSimple
{
    /**
     *  Push an Node into the StmtList
     */
    public function push(Haanga_Node $param)
    {
        $this->attrs[] = $param;
    }
}

final class Haanga_Node_Property extends Haanga_Node_Simple
{
}

final class Haanga_Node_doReturn extends Haanga_Node_Simple
{
}


final class Haanga_Node_Variable extends Haanga_Node
{
    public function __construct($def="", $line=0)
    {
        if (is_string($def)) {
            $def = array($def);
        } else {
            foreach ($def as $id => $value) {
                if ($id == 0 || $value InstanceOf Haanga_Node) {
                    continue;
                }

                $def[$id] = Haanga_Node::convertNative($value);
            }
        }
        parent::__construct(array(),  $def, $line);
    }
}

final class Haanga_Node_Assign extends Haanga_Node
{
    public function __construct(Haanga_Node_Variable $a, Haanga_Node_Expr $b, $line=0)
    {
        parent::__construct(array(), array($a, $b), $line);
    }
}

final class Haanga_Node_Print extends Haanga_Node_Simple
{
}

final class Haanga_Node_Expr extends Haanga_Node
{
    function __construct(array $expr, $line=0)
    {
        foreach ($expr as &$value) {
            if (!$value instanceof Haanga_Node) {
                $value = Haanga_Node::convertNative($value);
            }
        }
        parent::__construct(array(), $expr, $line);
    }
}

final class Haanga_Node_Function extends Haanga_Node_Blocks
{
    function __construct($name, Haanga_Node_StmtList $args=null, $stmts=array(), $line = 0)
    {
        parent::__construct(array($name, $args), $stmts, $line);
    }
}

final class Haanga_Node_If extends Haanga_Node_Blocks 
{
}

final class Haanga_Node_Else extends Haanga_Node_Blocks 
{
}

final class Haanga_Node_Exec extends Haanga_Node
{
    function __construct($name, Haanga_Node_StmtList $args=null, $line = 0)
    {
        parent::__construct(array(), array($name, $args), $line);
    }

    function addParameter(Haanga_Node $param)
    {
        if (is_null($this->attrs[1])) {
            $this->attrs[1] = new Haanga_Node_StmtList(array());
        }
        $this->attrs[1]->push($param);
    }
}

final class Haanga_Node_Foreach extends Haanga_Node_Blocks {
    function __construct(Haanga_Node_Variable $array, $key, Haanga_Node_Variable $value, array $body = array(), $line = 0)
    {
        if (!is_null($key) && !$key instanceof Haanga_Node_Variable) {
            throw new Exception("\$key must be an instace of Haanga_Node_Variable");
        }
        parent::__construct(array($array, $key, $value), $body, $line);
    }
}

final class Haanga_Node_Class extends Haanga_Node_Blocks
{
    public function __construct($name, $stmts, $line=0)
    {
        parent::__construct(array($name), $stmts, $line);
    }
}

