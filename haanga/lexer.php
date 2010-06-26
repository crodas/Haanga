<?php

require dirname(__FILE__)."/parser.php";

function do_parsing($template, $ignore_whitespace=FALSE)
{
    $lexer  = new Haanga_Lexer($template, $ignore_whitespace);
    $parser = new Parser;
    try {
        for($i=0; ; $i++) {
            if  (!$lexer->yylex()) {
                break;
            }
            $parser->doParse($lexer->token, $lexer->value);
        }
    } catch (Exception $e) {
        throw new Exception($e->getMessage(). ' on line '.$lexer->getLine());
    }
    $parser->doParse(0, 0);
    return $parser->body;
}

class Haanga_Lexer
{
    private $data;
    private $N;
    public $token;
    public $value;
    private $line;
    private $state = 1;
    private $ignore_whitespace;

    function __construct($data, $whitespace=FALSE)
    {
        $this->data              = $data;
        $this->N                 = 0;
        $this->ignore_whitespace = $whitespace;
        $this->line              = 1;
    }

    function getLine()
    {
        return $this->line;
    }


    private $_yy_state = 1;
    private $_yy_stack = array();

    function yylex()
    {
        return $this->{'yylex' . $this->_yy_state}();
    }

    function yypushstate($state)
    {
        array_push($this->_yy_stack, $this->_yy_state);
        $this->_yy_state = $state;
    }

    function yypopstate()
    {
        $this->_yy_state = array_pop($this->_yy_stack);
    }

    function yybegin($state)
    {
        $this->_yy_state = $state;
    }



    function yylex1()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
              3 => 0,
              4 => 0,
              5 => 2,
            );
        if ($this->N >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/^(\\{%)|^(\\{#)|^(\\{\\{)|^([ \r\t\n]+)|^(([^{]+(.[^%{#])?)+)/";

        do {
            if (preg_match($yy_global_pattern, substr($this->data, $this->N), $yymatches)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        'an empty string.  Input "' . substr($this->data,
                        $this->N, 5) . '... state IN_HTML');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                        $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $r = $this->{'yy_r1_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    if ($this->N >= strlen($this->data)) {
                        return false; // end of input
                    }
                    // skip this token
                    continue;
                } else {                    $yy_yymore_patterns = array(
        1 => array(0, "^(\\{#)|^(\\{\\{)|^([ \r\t\n]+)|^(([^{]+(.[^%{#])?)+)"),
        2 => array(0, "^(\\{\\{)|^([ \r\t\n]+)|^(([^{]+(.[^%{#])?)+)"),
        3 => array(0, "^([ \r\t\n]+)|^(([^{]+(.[^%{#])?)+)"),
        4 => array(0, "^(([^{]+(.[^%{#])?)+)"),
        5 => array(2, ""),
    );

                    // yymore is needed
                    do {
                        if (!strlen($yy_yymore_patterns[$this->token][1])) {
                            throw new Exception('cannot do yymore for the last token');
                        }
                        $yysubmatches = array();
                        if (preg_match('/' . $yy_yymore_patterns[$this->token][1] . '/',
                              substr($this->data, $this->N), $yymatches)) {
                            $yysubmatches = $yymatches;
                            $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                            next($yymatches); // skip global match
                            $this->token += key($yymatches) + $yy_yymore_patterns[$this->token][0]; // token number
                            $this->value = current($yymatches); // token value
                            $this->line = substr_count($this->value, "\n");
                            if ($tokenMap[$this->token]) {
                                // extract sub-patterns for passing to lex function
                                $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                    $tokenMap[$this->token]);
                            } else {
                                $yysubmatches = array();
                            }
                        }
                    	$r = $this->{'yy_r1_' . $this->token}($yysubmatches);
                    } while ($r !== null && !is_bool($r));
			        if ($r === true) {
			            // we have changed state
			            // process this token in the new state
			            return $this->yylex();
                    } elseif ($r === false) {
                        $this->N += strlen($this->value);
                        $this->line += substr_count($this->value, "\n");
                        if ($this->N >= strlen($this->data)) {
                            return false; // end of input
                        }
                        // skip this token
                        continue;
			        } else {
	                    // accept
	                    $this->N += strlen($this->value);
	                    $this->line += substr_count($this->value, "\n");
	                    return true;
			        }
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                    ': ' . $this->data[$this->N]);
            }
            break;
        } while (true);

    } // end function


    const IN_HTML = 1;
    function yy_r1_1($yy_subpatterns)
    {

    $this->token = Parser::T_OPEN_TAG;
    $this->yypushstate(self::IN_CODE);
    }
    function yy_r1_2($yy_subpatterns)
    {

    $this->token = Parser::T_COMMENT_OPEN;
    $this->yypushstate(self::IN_COMMENT);
    }
    function yy_r1_3($yy_subpatterns)
    {

    $this->token = Parser::T_PRINT_OPEN;
    $this->yypushstate(self::IN_PRINT);
    }
    function yy_r1_4($yy_subpatterns)
    {

    if ($this->ignore_whitespace) {
        $this->token = Parser::T_HTML;
        $this->N    += strlen($this->value);
        $this->value = ' ';
        
    } else {
        $this->token = Parser::T_HTML;
    }
    }
    function yy_r1_5($yy_subpatterns)
    {

    $this->token = Parser::T_HTML;
    }


    function yylex2()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
              3 => 0,
              4 => 0,
              5 => 0,
              6 => 0,
              7 => 0,
              8 => 0,
              9 => 0,
              10 => 0,
              11 => 0,
              12 => 0,
              13 => 0,
              14 => 0,
              15 => 0,
              16 => 0,
              17 => 0,
              18 => 0,
              19 => 0,
              20 => 0,
              21 => 0,
              22 => 0,
              23 => 0,
              24 => 0,
              25 => 0,
              26 => 0,
              27 => 0,
              28 => 0,
              29 => 0,
              30 => 0,
              31 => 0,
              32 => 0,
              33 => 0,
              34 => 0,
              35 => 1,
              37 => 0,
              38 => 0,
              39 => 1,
              41 => 2,
              44 => 1,
              46 => 0,
            );
        if ($this->N >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/^(%\\})|^(\\.)|^(for[^a-zA-Z0-9])|^(empty[^a-zA-Z0-9])|^(cycle[^a-zA-Z0-9])|^(block[^a-zA-Z0-9])|^(\\|)|^(filter[^a-zA-Z0-9])|^(endfilter[^a-zA-Z0-9])|^(endblock[^a-zA-Z0-9])|^(ifchanged[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endifchanged[^a-zA-Z0-9])|^(in[^a-zA-Z0-9])|^(endfor[^a-zA-Z0-9])|^(with[^a-zA-Z0-9])|^(endwith[^a-zA-Z0-9])|^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)/";

        do {
            if (preg_match($yy_global_pattern, substr($this->data, $this->N), $yymatches)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        'an empty string.  Input "' . substr($this->data,
                        $this->N, 5) . '... state IN_CODE');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                        $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $r = $this->{'yy_r2_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    if ($this->N >= strlen($this->data)) {
                        return false; // end of input
                    }
                    // skip this token
                    continue;
                } else {                    $yy_yymore_patterns = array(
        1 => array(0, "^(\\.)|^(for[^a-zA-Z0-9])|^(empty[^a-zA-Z0-9])|^(cycle[^a-zA-Z0-9])|^(block[^a-zA-Z0-9])|^(\\|)|^(filter[^a-zA-Z0-9])|^(endfilter[^a-zA-Z0-9])|^(endblock[^a-zA-Z0-9])|^(ifchanged[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endifchanged[^a-zA-Z0-9])|^(in[^a-zA-Z0-9])|^(endfor[^a-zA-Z0-9])|^(with[^a-zA-Z0-9])|^(endwith[^a-zA-Z0-9])|^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        2 => array(0, "^(for[^a-zA-Z0-9])|^(empty[^a-zA-Z0-9])|^(cycle[^a-zA-Z0-9])|^(block[^a-zA-Z0-9])|^(\\|)|^(filter[^a-zA-Z0-9])|^(endfilter[^a-zA-Z0-9])|^(endblock[^a-zA-Z0-9])|^(ifchanged[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endifchanged[^a-zA-Z0-9])|^(in[^a-zA-Z0-9])|^(endfor[^a-zA-Z0-9])|^(with[^a-zA-Z0-9])|^(endwith[^a-zA-Z0-9])|^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        3 => array(0, "^(empty[^a-zA-Z0-9])|^(cycle[^a-zA-Z0-9])|^(block[^a-zA-Z0-9])|^(\\|)|^(filter[^a-zA-Z0-9])|^(endfilter[^a-zA-Z0-9])|^(endblock[^a-zA-Z0-9])|^(ifchanged[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endifchanged[^a-zA-Z0-9])|^(in[^a-zA-Z0-9])|^(endfor[^a-zA-Z0-9])|^(with[^a-zA-Z0-9])|^(endwith[^a-zA-Z0-9])|^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        4 => array(0, "^(cycle[^a-zA-Z0-9])|^(block[^a-zA-Z0-9])|^(\\|)|^(filter[^a-zA-Z0-9])|^(endfilter[^a-zA-Z0-9])|^(endblock[^a-zA-Z0-9])|^(ifchanged[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endifchanged[^a-zA-Z0-9])|^(in[^a-zA-Z0-9])|^(endfor[^a-zA-Z0-9])|^(with[^a-zA-Z0-9])|^(endwith[^a-zA-Z0-9])|^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        5 => array(0, "^(block[^a-zA-Z0-9])|^(\\|)|^(filter[^a-zA-Z0-9])|^(endfilter[^a-zA-Z0-9])|^(endblock[^a-zA-Z0-9])|^(ifchanged[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endifchanged[^a-zA-Z0-9])|^(in[^a-zA-Z0-9])|^(endfor[^a-zA-Z0-9])|^(with[^a-zA-Z0-9])|^(endwith[^a-zA-Z0-9])|^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        6 => array(0, "^(\\|)|^(filter[^a-zA-Z0-9])|^(endfilter[^a-zA-Z0-9])|^(endblock[^a-zA-Z0-9])|^(ifchanged[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endifchanged[^a-zA-Z0-9])|^(in[^a-zA-Z0-9])|^(endfor[^a-zA-Z0-9])|^(with[^a-zA-Z0-9])|^(endwith[^a-zA-Z0-9])|^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        7 => array(0, "^(filter[^a-zA-Z0-9])|^(endfilter[^a-zA-Z0-9])|^(endblock[^a-zA-Z0-9])|^(ifchanged[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endifchanged[^a-zA-Z0-9])|^(in[^a-zA-Z0-9])|^(endfor[^a-zA-Z0-9])|^(with[^a-zA-Z0-9])|^(endwith[^a-zA-Z0-9])|^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        8 => array(0, "^(endfilter[^a-zA-Z0-9])|^(endblock[^a-zA-Z0-9])|^(ifchanged[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endifchanged[^a-zA-Z0-9])|^(in[^a-zA-Z0-9])|^(endfor[^a-zA-Z0-9])|^(with[^a-zA-Z0-9])|^(endwith[^a-zA-Z0-9])|^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        9 => array(0, "^(endblock[^a-zA-Z0-9])|^(ifchanged[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endifchanged[^a-zA-Z0-9])|^(in[^a-zA-Z0-9])|^(endfor[^a-zA-Z0-9])|^(with[^a-zA-Z0-9])|^(endwith[^a-zA-Z0-9])|^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        10 => array(0, "^(ifchanged[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endifchanged[^a-zA-Z0-9])|^(in[^a-zA-Z0-9])|^(endfor[^a-zA-Z0-9])|^(with[^a-zA-Z0-9])|^(endwith[^a-zA-Z0-9])|^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        11 => array(0, "^(else[^a-zA-Z0-9])|^(endifchanged[^a-zA-Z0-9])|^(in[^a-zA-Z0-9])|^(endfor[^a-zA-Z0-9])|^(with[^a-zA-Z0-9])|^(endwith[^a-zA-Z0-9])|^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        12 => array(0, "^(endifchanged[^a-zA-Z0-9])|^(in[^a-zA-Z0-9])|^(endfor[^a-zA-Z0-9])|^(with[^a-zA-Z0-9])|^(endwith[^a-zA-Z0-9])|^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        13 => array(0, "^(in[^a-zA-Z0-9])|^(endfor[^a-zA-Z0-9])|^(with[^a-zA-Z0-9])|^(endwith[^a-zA-Z0-9])|^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        14 => array(0, "^(endfor[^a-zA-Z0-9])|^(with[^a-zA-Z0-9])|^(endwith[^a-zA-Z0-9])|^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        15 => array(0, "^(with[^a-zA-Z0-9])|^(endwith[^a-zA-Z0-9])|^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        16 => array(0, "^(endwith[^a-zA-Z0-9])|^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        17 => array(0, "^(as)|^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        18 => array(0, "^(if[^a-zA-Z0-9])|^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        19 => array(0, "^(else[^a-zA-Z0-9])|^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        20 => array(0, "^(endif[^a-zA-Z0-9])|^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        21 => array(0, "^(\\()|^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        22 => array(0, "^(\\))|^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        23 => array(0, "^(%)|^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        24 => array(0, "^(&&)|^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        25 => array(0, "^(AND)|^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        26 => array(0, "^(,)|^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        27 => array(0, "^(==)|^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        28 => array(0, "^(!=)|^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        29 => array(0, "^(\\+)|^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        30 => array(0, "^(\\*)|^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        31 => array(0, "^(\/)|^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        32 => array(0, "^(')|^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        33 => array(0, "^(\")|^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        34 => array(0, "^(end([a-zA-Z][a-zA-Z0-9]*))|^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        35 => array(1, "^(extends[^a-zA-Z0-9])|^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        37 => array(1, "^(include[^a-zA-Z0-9])|^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        38 => array(1, "^(([0-9])+)|^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        39 => array(2, "^(([0-9])+\\.([0-9])+)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        41 => array(4, "^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        44 => array(5, "^([ \r\t\n]+)"),
        46 => array(5, ""),
    );

                    // yymore is needed
                    do {
                        if (!strlen($yy_yymore_patterns[$this->token][1])) {
                            throw new Exception('cannot do yymore for the last token');
                        }
                        $yysubmatches = array();
                        if (preg_match('/' . $yy_yymore_patterns[$this->token][1] . '/',
                              substr($this->data, $this->N), $yymatches)) {
                            $yysubmatches = $yymatches;
                            $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                            next($yymatches); // skip global match
                            $this->token += key($yymatches) + $yy_yymore_patterns[$this->token][0]; // token number
                            $this->value = current($yymatches); // token value
                            $this->line = substr_count($this->value, "\n");
                            if ($tokenMap[$this->token]) {
                                // extract sub-patterns for passing to lex function
                                $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                    $tokenMap[$this->token]);
                            } else {
                                $yysubmatches = array();
                            }
                        }
                    	$r = $this->{'yy_r2_' . $this->token}($yysubmatches);
                    } while ($r !== null && !is_bool($r));
			        if ($r === true) {
			            // we have changed state
			            // process this token in the new state
			            return $this->yylex();
                    } elseif ($r === false) {
                        $this->N += strlen($this->value);
                        $this->line += substr_count($this->value, "\n");
                        if ($this->N >= strlen($this->data)) {
                            return false; // end of input
                        }
                        // skip this token
                        continue;
			        } else {
	                    // accept
	                    $this->N += strlen($this->value);
	                    $this->line += substr_count($this->value, "\n");
	                    return true;
			        }
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                    ': ' . $this->data[$this->N]);
            }
            break;
        } while (true);

    } // end function


    const IN_CODE = 2;
    function yy_r2_1($yy_subpatterns)
    {

    $this->token = Parser::T_CLOSE_TAG;
    $this->yypopstate();
    }
    function yy_r2_2($yy_subpatterns)
    {

    $this->token = Parser::T_DOT;
    }
    function yy_r2_3($yy_subpatterns)
    {

    $this->token = Parser::T_FOR;
    }
    function yy_r2_4($yy_subpatterns)
    {

    $this->token = Parser::T_EMPTY;
    }
    function yy_r2_5($yy_subpatterns)
    {

    $this->token = Parser::T_CYCLE;
    }
    function yy_r2_6($yy_subpatterns)
    {

    $this->token = Parser::T_BLOCK;
    }
    function yy_r2_7($yy_subpatterns)
    {

    $this->token = Parser::T_PIPE;
    }
    function yy_r2_8($yy_subpatterns)
    {

    $this->token = Parser::T_FILTER;
    }
    function yy_r2_9($yy_subpatterns)
    {

    $this->token = Parser::T_END_FILTER;
    }
    function yy_r2_10($yy_subpatterns)
    {

    $this->token = Parser::T_END_BLOCK;
    }
    function yy_r2_11($yy_subpatterns)
    {

    $this->token = Parser::T_IFCHANGED;
    }
    function yy_r2_12($yy_subpatterns)
    {

    $this->token = Parser::T_ELSE;
    }
    function yy_r2_13($yy_subpatterns)
    {

    $this->token = Parser::T_ENDIFCHANGED;
    }
    function yy_r2_14($yy_subpatterns)
    {

    $this->token = Parser::T_IN;
    }
    function yy_r2_15($yy_subpatterns)
    {

    $this->token = Parser::T_CLOSEFOR;
    }
    function yy_r2_16($yy_subpatterns)
    {

    $this->token = Parser::T_WITH;
    }
    function yy_r2_17($yy_subpatterns)
    {

    $this->token = Parser::T_ENDWITH;
    }
    function yy_r2_18($yy_subpatterns)
    {

    $this->token = Parser::T_AS;
    }
    function yy_r2_19($yy_subpatterns)
    {

    $this->token = Parser::T_IF;
    }
    function yy_r2_20($yy_subpatterns)
    {

    $this->token = Parser::T_ELSE;
    }
    function yy_r2_21($yy_subpatterns)
    {

    $this->token = Parser::T_ENDIF;
    }
    function yy_r2_22($yy_subpatterns)
    {

    $this->token = Parser::T_LPARENT;
    }
    function yy_r2_23($yy_subpatterns)
    {

    $this->token = Parser::T_RPARENT;
    }
    function yy_r2_24($yy_subpatterns)
    {

    $this->token = Parser::T_MOD;
    }
    function yy_r2_25($yy_subpatterns)
    {
 
    $this->token = Parser::T_AND;
    }
    function yy_r2_26($yy_subpatterns)
    {

    $this->token = Parser::T_AND;
    }
    function yy_r2_27($yy_subpatterns)
    {

    $this->token = Parser::T_COMMA;
    }
    function yy_r2_28($yy_subpatterns)
    {

    $this->token = Parser::T_EQ;
    }
    function yy_r2_29($yy_subpatterns)
    {

    $this->token = Parser::T_NE;
    }
    function yy_r2_30($yy_subpatterns)
    {

    $this->token = Parser::T_PLUS;
    }
    function yy_r2_31($yy_subpatterns)
    {

    $this->token = Parser::T_TIMES;
    }
    function yy_r2_32($yy_subpatterns)
    {

    $this->token = Parser::T_DIV;
    }
    function yy_r2_33($yy_subpatterns)
    {

    $this->token = Parser::T_STRING_SINGLE_INIT;
    $this->yypushstate(self::IN_STRING_SINGLE);
    }
    function yy_r2_34($yy_subpatterns)
    {

    $this->token = Parser::T_STRING_DOUBLE_INIT;
    $this->yypushstate(self::IN_STRING_DOUBLE);
    }
    function yy_r2_35($yy_subpatterns)
    {

    $this->token = Parser::T_CUSTOM_END;
    }
    function yy_r2_37($yy_subpatterns)
    {

    $this->token = Parser::T_EXTENDS;
    }
    function yy_r2_38($yy_subpatterns)
    {

    $this->token = Parser::T_INCLUDE;
    }
    function yy_r2_39($yy_subpatterns)
    {

    $this->token = Parser::T_NUMERIC;
    }
    function yy_r2_41($yy_subpatterns)
    {

    $this->token = Parser::T_NUMERIC;
    }
    function yy_r2_44($yy_subpatterns)
    {

    $this->token = Parser::T_ALPHA;
    }
    function yy_r2_46($yy_subpatterns)
    {

    return FALSE;
    }


    function yylex3()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
              3 => 0,
              4 => 1,
              6 => 0,
            );
        if ($this->N >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/^(\\}\\})|^(\\|)|^(\\.)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)/";

        do {
            if (preg_match($yy_global_pattern, substr($this->data, $this->N), $yymatches)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        'an empty string.  Input "' . substr($this->data,
                        $this->N, 5) . '... state IN_PRINT');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                        $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $r = $this->{'yy_r3_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    if ($this->N >= strlen($this->data)) {
                        return false; // end of input
                    }
                    // skip this token
                    continue;
                } else {                    $yy_yymore_patterns = array(
        1 => array(0, "^(\\|)|^(\\.)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        2 => array(0, "^(\\.)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        3 => array(0, "^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        4 => array(1, "^([ \r\t\n]+)"),
        6 => array(1, ""),
    );

                    // yymore is needed
                    do {
                        if (!strlen($yy_yymore_patterns[$this->token][1])) {
                            throw new Exception('cannot do yymore for the last token');
                        }
                        $yysubmatches = array();
                        if (preg_match('/' . $yy_yymore_patterns[$this->token][1] . '/',
                              substr($this->data, $this->N), $yymatches)) {
                            $yysubmatches = $yymatches;
                            $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                            next($yymatches); // skip global match
                            $this->token += key($yymatches) + $yy_yymore_patterns[$this->token][0]; // token number
                            $this->value = current($yymatches); // token value
                            $this->line = substr_count($this->value, "\n");
                            if ($tokenMap[$this->token]) {
                                // extract sub-patterns for passing to lex function
                                $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                    $tokenMap[$this->token]);
                            } else {
                                $yysubmatches = array();
                            }
                        }
                    	$r = $this->{'yy_r3_' . $this->token}($yysubmatches);
                    } while ($r !== null && !is_bool($r));
			        if ($r === true) {
			            // we have changed state
			            // process this token in the new state
			            return $this->yylex();
                    } elseif ($r === false) {
                        $this->N += strlen($this->value);
                        $this->line += substr_count($this->value, "\n");
                        if ($this->N >= strlen($this->data)) {
                            return false; // end of input
                        }
                        // skip this token
                        continue;
			        } else {
	                    // accept
	                    $this->N += strlen($this->value);
	                    $this->line += substr_count($this->value, "\n");
	                    return true;
			        }
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                    ': ' . $this->data[$this->N]);
            }
            break;
        } while (true);

    } // end function


    const IN_PRINT = 3;
    function yy_r3_1($yy_subpatterns)
    {

    $this->token = Parser::T_PRINT_CLOSE;
    $this->yypopstate();
    }
    function yy_r3_2($yy_subpatterns)
    {

    $this->token = Parser::T_PIPE;
    }
    function yy_r3_3($yy_subpatterns)
    {

    $this->token = Parser::T_DOT;
    }
    function yy_r3_4($yy_subpatterns)
    {

    $this->token = Parser::T_ALPHA;
    }
    function yy_r3_6($yy_subpatterns)
    {

    return FALSE;
    }



    function yylex4()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
              3 => 0,
              4 => 0,
            );
        if ($this->N >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/^(\\\\\")|^(\\\\')|^(\")|^([^\"\\\\]+)/";

        do {
            if (preg_match($yy_global_pattern, substr($this->data, $this->N), $yymatches)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        'an empty string.  Input "' . substr($this->data,
                        $this->N, 5) . '... state IN_STRING_DOUBLE');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                        $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $r = $this->{'yy_r4_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    if ($this->N >= strlen($this->data)) {
                        return false; // end of input
                    }
                    // skip this token
                    continue;
                } else {                    $yy_yymore_patterns = array(
        1 => array(0, "^(\\\\')|^(\")|^([^\"\\\\]+)"),
        2 => array(0, "^(\")|^([^\"\\\\]+)"),
        3 => array(0, "^([^\"\\\\]+)"),
        4 => array(0, ""),
    );

                    // yymore is needed
                    do {
                        if (!strlen($yy_yymore_patterns[$this->token][1])) {
                            throw new Exception('cannot do yymore for the last token');
                        }
                        $yysubmatches = array();
                        if (preg_match('/' . $yy_yymore_patterns[$this->token][1] . '/',
                              substr($this->data, $this->N), $yymatches)) {
                            $yysubmatches = $yymatches;
                            $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                            next($yymatches); // skip global match
                            $this->token += key($yymatches) + $yy_yymore_patterns[$this->token][0]; // token number
                            $this->value = current($yymatches); // token value
                            $this->line = substr_count($this->value, "\n");
                            if ($tokenMap[$this->token]) {
                                // extract sub-patterns for passing to lex function
                                $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                    $tokenMap[$this->token]);
                            } else {
                                $yysubmatches = array();
                            }
                        }
                    	$r = $this->{'yy_r4_' . $this->token}($yysubmatches);
                    } while ($r !== null && !is_bool($r));
			        if ($r === true) {
			            // we have changed state
			            // process this token in the new state
			            return $this->yylex();
                    } elseif ($r === false) {
                        $this->N += strlen($this->value);
                        $this->line += substr_count($this->value, "\n");
                        if ($this->N >= strlen($this->data)) {
                            return false; // end of input
                        }
                        // skip this token
                        continue;
			        } else {
	                    // accept
	                    $this->N += strlen($this->value);
	                    $this->line += substr_count($this->value, "\n");
	                    return true;
			        }
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                    ': ' . $this->data[$this->N]);
            }
            break;
        } while (true);

    } // end function


    const IN_STRING_DOUBLE = 4;
    function yy_r4_1($yy_subpatterns)
    {

    $this->token = Parser::T_STRING_CONTENT;
    $this->value = "\"";
    $this->N    += 1;
    }
    function yy_r4_2($yy_subpatterns)
    {

    $this->token = Parser::T_STRING_CONTENT;
    $this->value = "'";
    $this->N    += 1;
    }
    function yy_r4_3($yy_subpatterns)
    {

    $this->token = Parser::T_STRING_DOUBLE_END;
    $this->yypopstate();
    }
    function yy_r4_4($yy_subpatterns)
    {

    $this->token = Parser::T_STRING_CONTENT;
    }



    function yylex5()
    {
        $tokenMap = array (
              1 => 0,
              2 => 0,
              3 => 0,
              4 => 0,
            );
        if ($this->N >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/^(\\\\')|^(\\\\\")|^(')|^([^'\\\\]+)/";

        do {
            if (preg_match($yy_global_pattern, substr($this->data, $this->N), $yymatches)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        'an empty string.  Input "' . substr($this->data,
                        $this->N, 5) . '... state IN_STRING_SINGLE');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                        $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $r = $this->{'yy_r5_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    if ($this->N >= strlen($this->data)) {
                        return false; // end of input
                    }
                    // skip this token
                    continue;
                } else {                    $yy_yymore_patterns = array(
        1 => array(0, "^(\\\\\")|^(')|^([^'\\\\]+)"),
        2 => array(0, "^(')|^([^'\\\\]+)"),
        3 => array(0, "^([^'\\\\]+)"),
        4 => array(0, ""),
    );

                    // yymore is needed
                    do {
                        if (!strlen($yy_yymore_patterns[$this->token][1])) {
                            throw new Exception('cannot do yymore for the last token');
                        }
                        $yysubmatches = array();
                        if (preg_match('/' . $yy_yymore_patterns[$this->token][1] . '/',
                              substr($this->data, $this->N), $yymatches)) {
                            $yysubmatches = $yymatches;
                            $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                            next($yymatches); // skip global match
                            $this->token += key($yymatches) + $yy_yymore_patterns[$this->token][0]; // token number
                            $this->value = current($yymatches); // token value
                            $this->line = substr_count($this->value, "\n");
                            if ($tokenMap[$this->token]) {
                                // extract sub-patterns for passing to lex function
                                $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                    $tokenMap[$this->token]);
                            } else {
                                $yysubmatches = array();
                            }
                        }
                    	$r = $this->{'yy_r5_' . $this->token}($yysubmatches);
                    } while ($r !== null && !is_bool($r));
			        if ($r === true) {
			            // we have changed state
			            // process this token in the new state
			            return $this->yylex();
                    } elseif ($r === false) {
                        $this->N += strlen($this->value);
                        $this->line += substr_count($this->value, "\n");
                        if ($this->N >= strlen($this->data)) {
                            return false; // end of input
                        }
                        // skip this token
                        continue;
			        } else {
	                    // accept
	                    $this->N += strlen($this->value);
	                    $this->line += substr_count($this->value, "\n");
	                    return true;
			        }
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                    ': ' . $this->data[$this->N]);
            }
            break;
        } while (true);

    } // end function


    const IN_STRING_SINGLE = 5;
    function yy_r5_1($yy_subpatterns)
    {

    $this->token = Parser::T_STRING_CONTENT;
    $this->value = "'";
    $this->N    += 1;
    }
    function yy_r5_2($yy_subpatterns)
    {

    $this->token = Parser::T_STRING_CONTENT;
    $this->value = "\"";
    $this->N    += 1;
    }
    function yy_r5_3($yy_subpatterns)
    {

    $this->token = Parser::T_STRING_SINGLE_END;
    $this->yypopstate();
    }
    function yy_r5_4($yy_subpatterns)
    {

    $this->token = Parser::T_STRING_CONTENT;
    }



    function yylex6()
    {
        $tokenMap = array (
              1 => 1,
            );
        if ($this->N >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/^(([^#]+#\\})+)/";

        do {
            if (preg_match($yy_global_pattern, substr($this->data, $this->N), $yymatches)) {
                $yysubmatches = $yymatches;
                $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                if (!count($yymatches)) {
                    throw new Exception('Error: lexing failed because a rule matched' .
                        'an empty string.  Input "' . substr($this->data,
                        $this->N, 5) . '... state IN_COMMENT');
                }
                next($yymatches); // skip global match
                $this->token = key($yymatches); // token number
                if ($tokenMap[$this->token]) {
                    // extract sub-patterns for passing to lex function
                    $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                        $tokenMap[$this->token]);
                } else {
                    $yysubmatches = array();
                }
                $this->value = current($yymatches); // token value
                $r = $this->{'yy_r6_' . $this->token}($yysubmatches);
                if ($r === null) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    // accept this token
                    return true;
                } elseif ($r === true) {
                    // we have changed state
                    // process this token in the new state
                    return $this->yylex();
                } elseif ($r === false) {
                    $this->N += strlen($this->value);
                    $this->line += substr_count($this->value, "\n");
                    if ($this->N >= strlen($this->data)) {
                        return false; // end of input
                    }
                    // skip this token
                    continue;
                } else {                    $yy_yymore_patterns = array(
        1 => array(0, ""),
    );

                    // yymore is needed
                    do {
                        if (!strlen($yy_yymore_patterns[$this->token][1])) {
                            throw new Exception('cannot do yymore for the last token');
                        }
                        $yysubmatches = array();
                        if (preg_match('/' . $yy_yymore_patterns[$this->token][1] . '/',
                              substr($this->data, $this->N), $yymatches)) {
                            $yysubmatches = $yymatches;
                            $yymatches = array_filter($yymatches, 'strlen'); // remove empty sub-patterns
                            next($yymatches); // skip global match
                            $this->token += key($yymatches) + $yy_yymore_patterns[$this->token][0]; // token number
                            $this->value = current($yymatches); // token value
                            $this->line = substr_count($this->value, "\n");
                            if ($tokenMap[$this->token]) {
                                // extract sub-patterns for passing to lex function
                                $yysubmatches = array_slice($yysubmatches, $this->token + 1,
                                    $tokenMap[$this->token]);
                            } else {
                                $yysubmatches = array();
                            }
                        }
                    	$r = $this->{'yy_r6_' . $this->token}($yysubmatches);
                    } while ($r !== null && !is_bool($r));
			        if ($r === true) {
			            // we have changed state
			            // process this token in the new state
			            return $this->yylex();
                    } elseif ($r === false) {
                        $this->N += strlen($this->value);
                        $this->line += substr_count($this->value, "\n");
                        if ($this->N >= strlen($this->data)) {
                            return false; // end of input
                        }
                        // skip this token
                        continue;
			        } else {
	                    // accept
	                    $this->N += strlen($this->value);
	                    $this->line += substr_count($this->value, "\n");
	                    return true;
			        }
                }
            } else {
                throw new Exception('Unexpected input at line' . $this->line .
                    ': ' . $this->data[$this->N]);
            }
            break;
        } while (true);

    } // end function


    const IN_COMMENT = 6;
    function yy_r6_1($yy_subpatterns)
    {

    $this->token = Parser::T_COMMENT;
    $this->yypopstate();
    }

}
