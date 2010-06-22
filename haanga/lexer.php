<?php

require dirname(__FILE__)."/parser.php";

function do_parsing($template)
{
    $a = new Haanga_Lexer($template);
    $parser = new Parser;
    for($i=0; ; $i++) {
        if  (!$a->yylex()) {
            break;
        }
        $parser->doParse($a->token, $a->value);
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
    function __construct($data)
    {
        $this->data = $data;
        $this->N = 0;
        $this->line = 1;
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
              5 => 1,
            );
        if ($this->N >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/^(\\{%)|^(\\{#)|^(\\{\\{)|^([ \r\t\n]+)|^(([^{]+.[^%{#])+)/";

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
        1 => array(0, "^(\\{#)|^(\\{\\{)|^([ \r\t\n]+)|^(([^{]+.[^%{#])+)"),
        2 => array(0, "^(\\{\\{)|^([ \r\t\n]+)|^(([^{]+.[^%{#])+)"),
        3 => array(0, "^([ \r\t\n]+)|^(([^{]+.[^%{#])+)"),
        4 => array(0, "^(([^{]+.[^%{#])+)"),
        5 => array(1, ""),
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

    $this->token = Parser::T_HTML;
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
              10 => 1,
              12 => 0,
              13 => 0,
              14 => 0,
            );
        if ($this->N >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/^(%\\})|^(for)|^(empty)|^(cycle)|^(ifchanged)|^(else)|^(endifchanged)|^(in)|^(endfor)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^('[^']+')|^(\"[^\"]+\")|^([ \r\t\n]+)/";

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
        1 => array(0, "^(for)|^(empty)|^(cycle)|^(ifchanged)|^(else)|^(endifchanged)|^(in)|^(endfor)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^('[^']+')|^(\"[^\"]+\")|^([ \r\t\n]+)"),
        2 => array(0, "^(empty)|^(cycle)|^(ifchanged)|^(else)|^(endifchanged)|^(in)|^(endfor)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^('[^']+')|^(\"[^\"]+\")|^([ \r\t\n]+)"),
        3 => array(0, "^(cycle)|^(ifchanged)|^(else)|^(endifchanged)|^(in)|^(endfor)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^('[^']+')|^(\"[^\"]+\")|^([ \r\t\n]+)"),
        4 => array(0, "^(ifchanged)|^(else)|^(endifchanged)|^(in)|^(endfor)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^('[^']+')|^(\"[^\"]+\")|^([ \r\t\n]+)"),
        5 => array(0, "^(else)|^(endifchanged)|^(in)|^(endfor)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^('[^']+')|^(\"[^\"]+\")|^([ \r\t\n]+)"),
        6 => array(0, "^(endifchanged)|^(in)|^(endfor)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^('[^']+')|^(\"[^\"]+\")|^([ \r\t\n]+)"),
        7 => array(0, "^(in)|^(endfor)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^('[^']+')|^(\"[^\"]+\")|^([ \r\t\n]+)"),
        8 => array(0, "^(endfor)|^(([a-zA-Z_][a-zA-Z_0-9]*))|^('[^']+')|^(\"[^\"]+\")|^([ \r\t\n]+)"),
        9 => array(0, "^(([a-zA-Z_][a-zA-Z_0-9]*))|^('[^']+')|^(\"[^\"]+\")|^([ \r\t\n]+)"),
        10 => array(1, "^('[^']+')|^(\"[^\"]+\")|^([ \r\t\n]+)"),
        12 => array(1, "^(\"[^\"]+\")|^([ \r\t\n]+)"),
        13 => array(1, "^([ \r\t\n]+)"),
        14 => array(1, ""),
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

    $this->token = Parser::T_FOR;
    }
    function yy_r2_3($yy_subpatterns)
    {

    $this->token = Parser::T_EMPTY;
    }
    function yy_r2_4($yy_subpatterns)
    {

    $this->token = Parser::T_CYCLE;
    }
    function yy_r2_5($yy_subpatterns)
    {

    $this->token = Parser::T_IFCHANGED;
    }
    function yy_r2_6($yy_subpatterns)
    {

    $this->token = Parser::T_ELSE;
    }
    function yy_r2_7($yy_subpatterns)
    {

    $this->token = Parser::T_ENDIFCHANGED;
    }
    function yy_r2_8($yy_subpatterns)
    {

    $this->token = Parser::T_IN;
    }
    function yy_r2_9($yy_subpatterns)
    {

    $this->token = Parser::T_CLOSEFOR;
    }
    function yy_r2_10($yy_subpatterns)
    {

    $this->token = Parser::T_ALPHA;
    }
    function yy_r2_12($yy_subpatterns)
    {

    $this->token = Parser::T_STRING;
    }
    function yy_r2_13($yy_subpatterns)
    {

    $this->token = Parser::T_STRING;
    }
    function yy_r2_14($yy_subpatterns)
    {

    return FALSE;
    }


    function yylex3()
    {
        $tokenMap = array (
              1 => 0,
              2 => 1,
              4 => 0,
            );
        if ($this->N >= strlen($this->data)) {
            return false; // end of input
        }
        $yy_global_pattern = "/^(\\}\\})|^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)/";

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
        1 => array(0, "^(([a-zA-Z_][a-zA-Z_0-9]*))|^([ \r\t\n]+)"),
        2 => array(1, "^([ \r\t\n]+)"),
        4 => array(1, ""),
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

    $this->token = Parser::T_ALPHA;
    }
    function yy_r3_4($yy_subpatterns)
    {

    return FALSE;
    }



    function yylex4()
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


    const IN_COMMENT = 4;
    function yy_r4_1($yy_subpatterns)
    {

    $this->token = Parser::T_COMMENT;
    $this->yypopstate();
    }

}
