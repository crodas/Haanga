<?php

/**
 *  
 *
 */
abstract class Haanga_Node 
{
    protected $line;
    protected $attrs;
    protected $nodes;

    protected static $generator;

    public function __construct(array $nodes, Array $attrs=array(), $line=0)
    {
        $this->nodes = $nodes;
        $this->attrs = $attrs;
        $this->line  = $line;
    }

    public function getAttributes()
    {
        return $this->attrs;
    }

    public function addNode(Haanga_Node $node)
    {
        $this->nodes[] = $node;
        return $this;
    }

    public function getType()
    {
        return substr(get_class($this), strlen(__CLASS__) +1);
    }

    public static function setGenerator($generator)
    {
        self::$generator = $generator;
    }

    final public function __toString()
    {
        $generator = self::$generator;

        $class = $this->getType();
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

abstract class Haanga_Node_Basic extends Haanga_Node
{
    public function __construct($text, $line=0)
    {
        if (!is_array($text)) {
            $text = array($text);
        }
        parent::__construct(array(), $text, $line);
    }
}

abstract class Haanga_Node_BasicStmts extends Haanga_Node
{
    function __construct($expr, $stmts, $line=0)
    {
        parent::__construct($stmts, array($expr), $line);
    }
}

final class Haanga_Node_Number extends Haanga_Node_Basic
{
}

final class Haanga_Node_String extends Haanga_Node_Basic
{
}

final class Haanga_Node_Operator extends Haanga_Node_Basic 
{
}

final class Haanga_Node_StmtList extends Haanga_Node_Basic
{
}

final class Haanga_Node_Property extends Haanga_Node
{
    public function __construct($name, $line=0)
    {
        parent::__construct(array(), array($name), $line);
    }
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

final class Haanga_Node_defFunction extends Haanga_Node
{
    function __construct($name, Haanga_Node_StmtList $args=null, array $stmts=array(), $line = 0)
    {
        parent::__construct($stmts, array($name, $args), $line);
    }
}

final class Haanga_Node_defIf extends Haanga_Node_BasicStmts 
{
}

final class Haanga_Node_defElse extends Haanga_Node_BasicStmts 
{
}
