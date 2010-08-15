<?php
/* Driver template for the PHP_Haanga_rGenerator parser generator. (PHP port of LEMON)
*/

/**
 * This can be used to store both the string representation of
 * a token, and any useful meta-data associated with the token.
 *
 * meta-data should be stored as an array
 */
class Haanga_yyToken implements ArrayAccess
{
    public $string = '';
    public $metadata = array();

    function __construct($s, $m = array())
    {
        if ($s instanceof Haanga_yyToken) {
            $this->string = $s->string;
            $this->metadata = $s->metadata;
        } else {
            $this->string = (string) $s;
            if ($m instanceof Haanga_yyToken) {
                $this->metadata = $m->metadata;
            } elseif (is_array($m)) {
                $this->metadata = $m;
            }
        }
    }

    function __toString()
    {
        return $this->_string;
    }

    function offsetExists($offset)
    {
        return isset($this->metadata[$offset]);
    }

    function offsetGet($offset)
    {
        return $this->metadata[$offset];
    }

    function offsetSet($offset, $value)
    {
        if ($offset === null) {
            if (isset($value[0])) {
                $x = ($value instanceof Haanga_yyToken) ?
                    $value->metadata : $value;
                $this->metadata = array_merge($this->metadata, $x);
                return;
            }
            $offset = count($this->metadata);
        }
        if ($value === null) {
            return;
        }
        if ($value instanceof Haanga_yyToken) {
            if ($value->metadata) {
                $this->metadata[$offset] = $value->metadata;
            }
        } elseif ($value) {
            $this->metadata[$offset] = $value;
        }
    }

    function offsetUnset($offset)
    {
        unset($this->metadata[$offset]);
    }
}

/** The following structure represents a single element of the
 * parser's stack.  Information stored includes:
 *
 *   +  The state number for the parser at this level of the stack.
 *
 *   +  The value of the token stored at this level of the stack.
 *      (In other words, the "major" token.)
 *
 *   +  The semantic value stored at this level of the stack.  This is
 *      the information used by the action routines in the grammar.
 *      It is sometimes called the "minor" token.
 */
class Haanga_yyStackEntry
{
    public $stateno;       /* The state-number */
    public $major;         /* The major token value.  This is the code
                     ** number for the token at this stack level */
    public $minor; /* The user-supplied minor token value.  This
                     ** is the value of the token  */
};

// code external to the class is included here
#line 2 "lib/Haanga/Compiler/Parser.y"

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
#line 136 "lib/Haanga/Compiler/Parser.php"

// declare_class is output here
#line 39 "lib/Haanga/Compiler/Parser.y"
 class Haanga_Compiler_Parser #line 141 "lib/Haanga/Compiler/Parser.php"
{
/* First off, code is included which follows the "include_class" declaration
** in the input file. */
#line 40 "lib/Haanga/Compiler/Parser.y"

    protected $lex;
    protected $file;

    function __construct($lex, $file='')
    {
        $this->lex  = $lex;
        $this->file = $file;
    }

    function Error($text)
    {
        throw new Haanga_Compiler_Exception($text.' in '.$this->file.':'.$this->lex->getLine());
    }

#line 162 "lib/Haanga/Compiler/Parser.php"

/* Next is all token values, as class constants
*/
/* 
** These constants (all generated automatically by the parser generator)
** specify the various kinds of tokens (terminals) that the parser
** understands. 
**
** Each symbol here is a terminal symbol in the grammar.
*/
    const T_OPEN_TAG                     =  1;
    const T_NOT                          =  2;
    const T_AND                          =  3;
    const T_OR                           =  4;
    const T_EQ                           =  5;
    const T_NE                           =  6;
    const T_GT                           =  7;
    const T_GE                           =  8;
    const T_LT                           =  9;
    const T_LE                           = 10;
    const T_IN                           = 11;
    const T_PLUS                         = 12;
    const T_MINUS                        = 13;
    const T_TIMES                        = 14;
    const T_DIV                          = 15;
    const T_MOD                          = 16;
    const T_HTML                         = 17;
    const T_COMMENT_OPEN                 = 18;
    const T_COMMENT                      = 19;
    const T_PRINT_OPEN                   = 20;
    const T_PRINT_CLOSE                  = 21;
    const T_EXTENDS                      = 22;
    const T_CLOSE_TAG                    = 23;
    const T_INCLUDE                      = 24;
    const T_AUTOESCAPE                   = 25;
    const T_OFF                          = 26;
    const T_ON                           = 27;
    const T_END_AUTOESCAPE               = 28;
    const T_CUSTOM_TAG                   = 29;
    const T_AS                           = 30;
    const T_CUSTOM_BLOCK                 = 31;
    const T_CUSTOM_END                   = 32;
    const T_SPACEFULL                    = 33;
    const T_WITH                         = 34;
    const T_ENDWITH                      = 35;
    const T_LOAD                         = 36;
    const T_FOR                          = 37;
    const T_COMMA                        = 38;
    const T_CLOSEFOR                     = 39;
    const T_EMPTY                        = 40;
    const T_IF                           = 41;
    const T_ENDIF                        = 42;
    const T_ELSE                         = 43;
    const T_IFCHANGED                    = 44;
    const T_ENDIFCHANGED                 = 45;
    const T_IFEQUAL                      = 46;
    const T_END_IFEQUAL                  = 47;
    const T_IFNOTEQUAL                   = 48;
    const T_END_IFNOTEQUAL               = 49;
    const T_BLOCK                        = 50;
    const T_END_BLOCK                    = 51;
    const T_NUMERIC                      = 52;
    const T_FILTER                       = 53;
    const T_END_FILTER                   = 54;
    const T_REGROUP                      = 55;
    const T_BY                           = 56;
    const T_PIPE                         = 57;
    const T_COLON                        = 58;
    const T_TRUE                         = 59;
    const T_FALSE                        = 60;
    const T_INTL                         = 61;
    const T_RPARENT                      = 62;
    const T_STRING_SINGLE_INIT           = 63;
    const T_STRING_SINGLE_END            = 64;
    const T_STRING_DOUBLE_INIT           = 65;
    const T_STRING_DOUBLE_END            = 66;
    const T_STRING_CONTENT               = 67;
    const T_LPARENT                      = 68;
    const T_OBJ                          = 69;
    const T_ALPHA                        = 70;
    const T_DOT                          = 71;
    const T_BRACKETS_OPEN                = 72;
    const T_BRACKETS_CLOSE               = 73;
    const YY_NO_ACTION = 332;
    const YY_ACCEPT_ACTION = 331;
    const YY_ERROR_ACTION = 330;

/* Next are that tables used to determine what action to take based on the
** current state and lookahead token.  These tables are used to implement
** functions that take a state number and lookahead value and return an
** action integer.  
**
** Suppose the action integer is N.  Then the action is determined as
** follows
**
**   0 <= N < self::YYNSTATE                              Shift N.  That is,
**                                                        push the lookahead
**                                                        token onto the stack
**                                                        and goto state N.
**
**   self::YYNSTATE <= N < self::YYNSTATE+self::YYNRULE   Reduce by rule N-YYNSTATE.
**
**   N == self::YYNSTATE+self::YYNRULE                    A syntax error has occurred.
**
**   N == self::YYNSTATE+self::YYNRULE+1                  The parser accepts its
**                                                        input. (and concludes parsing)
**
**   N == self::YYNSTATE+self::YYNRULE+2                  No such action.  Denotes unused
**                                                        slots in the yy_action[] table.
**
** The action table is constructed as a single large static array $yy_action.
** Given state S and lookahead X, the action is computed as
**
**      self::$yy_action[self::$yy_shift_ofst[S] + X ]
**
** If the index value self::$yy_shift_ofst[S]+X is out of range or if the value
** self::$yy_lookahead[self::$yy_shift_ofst[S]+X] is not equal to X or if
** self::$yy_shift_ofst[S] is equal to self::YY_SHIFT_USE_DFLT, it means that
** the action is not in the table and that self::$yy_default[S] should be used instead.  
**
** The formula above is for computing the action when the lookahead is
** a terminal symbol.  If the lookahead is a non-terminal (as occurs after
** a reduce action) then the static $yy_reduce_ofst array is used in place of
** the static $yy_shift_ofst array and self::YY_REDUCE_USE_DFLT is used in place of
** self::YY_SHIFT_USE_DFLT.
**
** The following are the tables generated in this section:
**
**  self::$yy_action        A single table containing all actions.
**  self::$yy_lookahead     A table containing the lookahead for each entry in
**                          yy_action.  Used to detect hash collisions.
**  self::$yy_shift_ofst    For each state, the offset into self::$yy_action for
**                          shifting terminals.
**  self::$yy_reduce_ofst   For each state, the offset into self::$yy_action for
**                          shifting non-terminals after a reduce.
**  self::$yy_default       Default action for each state.
*/
    const YY_SZ_ACTTAB = 1089;
static public $yy_action = array(
 /*     0 */    42,    8,   43,  129,  176,  127,  176,   34,   72,   36,
 /*    10 */   200,  158,   83,   97,   78,   79,  115,  236,  143,   24,
 /*    20 */    49,  139,   35,  207,   30,  102,   31,  138,   56,  239,
 /*    30 */   115,   45,   42,   48,   43,  129,   21,  211,   75,   34,
 /*    40 */    84,   36,   85,  158,   83,  205,   78,   79,  218,  153,
 /*    50 */   163,   24,  236,  143,   35,   49,   30,  194,   31,  169,
 /*    60 */    56,  164,   41,   45,   42,   48,   43,  129,   99,  203,
 /*    70 */    88,   34,  187,   36,  231,  158,   83,  225,   78,   79,
 /*    80 */    40,  198,  187,   24,  162,  150,   35,   63,   30,   55,
 /*    90 */    31,  169,   56,  164,   41,   45,   42,   48,   43,  129,
 /*   100 */    77,   50,   50,   34,  232,   36,  195,  158,   83,   50,
 /*   110 */    78,   79,   27,   27,   27,   24,   82,  136,   35,  214,
 /*   120 */    30,  142,   31,  169,   56,  164,   41,   45,   42,   48,
 /*   130 */    43,  129,  230,  147,  197,   34,  208,   36,  101,  158,
 /*   140 */    83,  228,   78,   79,  331,   67,  240,   24,  221,  149,
 /*   150 */    35,  145,   30,   50,   31,  169,   56,  164,   41,   45,
 /*   160 */    42,   48,   43,  129,   86,  199,  202,   34,   50,   36,
 /*   170 */    50,  158,   83,  229,   78,   79,  170,  170,  223,   24,
 /*   180 */    96,  166,   35,  168,   30,  238,   31,  169,   56,  164,
 /*   190 */    41,   45,   42,   48,   43,  129,    3,  204,  217,   34,
 /*   200 */   202,   36,  216,  158,   83,   98,   78,   79,  184,  244,
 /*   210 */   220,   24,  236,  143,   35,   49,   30,  201,   31,  122,
 /*   220 */    56,   60,  190,   45,   42,   48,   43,  129,   18,  215,
 /*   230 */    90,   34,  224,   36,  104,  158,   83,   95,   78,   79,
 /*   240 */   100,  222,  193,   24,  236,  143,   35,   49,   30,   91,
 /*   250 */    31,  169,   56,  164,   41,   45,  140,   48,   42,   15,
 /*   260 */    43,  129,  180,  126,   87,   34,  237,   36,  175,  158,
 /*   270 */    83,  242,   78,   79,  115,  236,  143,   24,   49,   19,
 /*   280 */    35,  207,   30,  227,   31,  209,   56,  125,  173,   45,
 /*   290 */    42,   48,   43,  129,   12,  236,  143,   34,   49,   36,
 /*   300 */   137,  158,   83,  114,   78,   79,   58,   71,  151,   24,
 /*   310 */   236,  143,   35,   49,   30,  112,   31,  169,   56,  164,
 /*   320 */    41,   45,   42,   48,   43,  129,    2,  118,  167,   34,
 /*   330 */   120,   36,  121,  158,   83,   73,   78,   79,  185,  113,
 /*   340 */   124,   24,  236,  143,   35,   49,   30,  117,   31,   62,
 /*   350 */    56,   66,  213,   45,   42,   48,   43,  129,  176,  133,
 /*   360 */   176,   34,   51,   36,  131,  158,   83,  132,   78,   79,
 /*   370 */   115,   59,  119,   24,  172,    5,   35,  207,   30,  116,
 /*   380 */    31,  169,   56,  164,   41,   45,   42,   48,   43,  129,
 /*   390 */     1,  236,  143,   34,   49,   36,   69,  158,   83,  205,
 /*   400 */    78,   79,  212,   68,   70,   24,  236,  143,   35,   49,
 /*   410 */    30,   61,   31,  141,   56,   53,   54,   45,   42,   48,
 /*   420 */    43,  129,   17,   65,   52,   34,   64,   36,   57,  158,
 /*   430 */    83,  185,   78,   79,  185,  154,  185,   24,  236,  143,
 /*   440 */    35,   49,   30,  185,   31,  130,   56,  185,  185,   45,
 /*   450 */    42,   48,   43,  129,   14,  185,  115,   34,  185,   36,
 /*   460 */   185,  158,   83,  207,   78,   79,  185,  210,  185,   24,
 /*   470 */   236,  143,   35,   49,   30,  134,   31,  122,   56,  185,
 /*   480 */   190,   45,   42,   48,   43,  129,  185,  128,  185,   34,
 /*   490 */   185,   36,  161,  158,   83,  185,   78,   79,  115,  157,
 /*   500 */   185,   24,   80,    4,   35,  207,   30,  185,   31,  122,
 /*   510 */    56,  185,  190,   45,   42,   48,   43,  129,  185,  236,
 /*   520 */   143,   34,   49,   36,  185,  158,   83,  185,   78,   79,
 /*   530 */   185,  185,  185,   24,  185,    6,   35,  135,   30,  185,
 /*   540 */    31,  169,   56,  164,   41,   45,   42,   48,   43,  129,
 /*   550 */   185,  236,  143,   34,   49,   36,  185,  158,   83,  185,
 /*   560 */    78,   79,  185,  243,  185,   24,  185,   16,   35,  165,
 /*   570 */    30,  185,   31,  122,   56,  185,  190,   45,   42,   48,
 /*   580 */    43,  129,   11,  236,  143,   34,   49,   36,  185,  158,
 /*   590 */    83,  160,   78,   79,  185,  152,  185,   24,  236,  143,
 /*   600 */    35,   49,   30,  185,   31,  122,   56,  185,  190,   45,
 /*   610 */    42,   48,   43,  129,  185,  185,  185,   34,  185,   36,
 /*   620 */   159,  158,   83,  185,   78,   79,  185,  155,  185,   24,
 /*   630 */   185,   13,   35,   47,   30,  185,   31,  122,   56,  185,
 /*   640 */   190,   45,   42,   48,   43,  129,    7,  236,  143,   34,
 /*   650 */    49,   36,  185,  158,   83,   20,   78,   79,  185,  185,
 /*   660 */    76,   24,  236,  143,   35,   49,   30,  185,   31,  185,
 /*   670 */    56,  236,  143,   45,   49,   48,  185,   22,   26,   29,
 /*   680 */    29,   29,   29,   29,   29,   29,   28,   28,   27,   27,
 /*   690 */    27,  169,  185,  164,   41,   46,  185,   89,  185,  185,
 /*   700 */   185,   22,   26,   29,   29,   29,   29,   29,   29,   29,
 /*   710 */    28,   28,   27,   27,   27,   22,   26,   29,   29,   29,
 /*   720 */    29,   29,   29,   29,   28,   28,   27,   27,   27,   26,
 /*   730 */    29,   29,   29,   29,   29,   29,   29,   28,   28,   27,
 /*   740 */    27,   27,  235,  185,  185,  185,  185,  185,  176,   81,
 /*   750 */   176,  185,  185,  169,  185,  164,   41,   44,  219,  185,
 /*   760 */   189,  156,  177,  186,  178,  183,  179,  245,  233,  234,
 /*   770 */   185,  192,  226,  185,   93,   23,  185,  185,  191,  191,
 /*   780 */    75,  185,   84,  185,   85,  185,  185,  185,  185,  205,
 /*   790 */    29,   29,   29,   29,   29,   29,   29,   28,   28,   27,
 /*   800 */    27,   27,  176,  185,  176,  185,  146,  185,  185,  185,
 /*   810 */   185,  185,  185,  103,  185,  185,  241,  115,  185,  176,
 /*   820 */   181,  176,  196,  188,  207,  174,  122,   38,   44,  190,
 /*   830 */   185,  185,  182,  182,   75,  185,   84,  185,   85,  185,
 /*   840 */   185,   25,  192,  205,  185,  185,  185,  185,  185,  191,
 /*   850 */   191,   75,  185,   84,  146,   85,  206,  185,   10,  185,
 /*   860 */   205,  185,  176,   74,  176,  115,  185,  185,  181,  185,
 /*   870 */   110,  188,  207,   94,  236,  143,  241,   49,  185,  176,
 /*   880 */   185,  176,  185,  185,  185,  192,  122,   39,   44,  190,
 /*   890 */   185,  185,  191,  191,   75,  176,   84,  176,   85,  185,
 /*   900 */   185,  185,  192,  205,  185,  185,  185,  185,  185,  191,
 /*   910 */   191,   75,  185,   84,  146,   85,   92,  185,  144,  185,
 /*   920 */   205,  185,  176,  185,  176,  115,  185,    9,  181,  185,
 /*   930 */   106,  188,  207,  105,  185,  185,  205,  185,  185,  176,
 /*   940 */   185,  176,  185,  236,  143,  192,   49,  185,  185,  185,
 /*   950 */   146,  185,  191,  191,   75,  185,   84,  185,   85,  185,
 /*   960 */   185,  115,  192,  205,  181,  185,  108,  188,  207,  191,
 /*   970 */   191,   75,  185,   84,  146,   85,  241,  185,  185,  185,
 /*   980 */   205,  185,  176,  185,  176,  115,  122,   37,  181,  190,
 /*   990 */   109,  188,  207,  146,  185,  185,  185,  185,  185,  176,
 /*  1000 */   185,  176,  185,  185,  115,  174,  185,  181,  185,  123,
 /*  1010 */   188,  207,  182,  182,   75,  185,   84,  185,   85,  185,
 /*  1020 */   185,  185,  192,  205,  185,  146,  185,  185,  185,  191,
 /*  1030 */   191,   75,  185,   84,  146,   85,  115,  185,  185,  181,
 /*  1040 */   205,  107,  188,  207,  146,  115,  146,  185,  181,  185,
 /*  1050 */   111,  188,  207,  185,  146,  115,  185,  115,  181,  185,
 /*  1060 */   181,  148,  207,   33,  207,  115,  185,  185,  181,  185,
 /*  1070 */   146,  171,  207,  185,  185,  185,  185,  185,  185,  185,
 /*  1080 */   185,  115,  185,  185,  181,  185,  185,   32,  207,
    );
    static public $yy_lookahead = array(
 /*     0 */    22,    1,   24,   25,   29,   79,   31,   29,   76,   31,
 /*    10 */    73,   33,   34,   23,   36,   37,   90,   17,   18,   41,
 /*    20 */    20,   43,   44,   97,   46,   23,   48,   49,   50,   23,
 /*    30 */    90,   53,   22,   55,   24,   25,    1,   97,   61,   29,
 /*    40 */    63,   31,   65,   33,   34,   70,   36,   37,   23,   39,
 /*    50 */    40,   41,   17,   18,   44,   20,   46,   70,   48,   69,
 /*    60 */    50,   71,   72,   53,   22,   55,   24,   25,   23,   64,
 /*    70 */    23,   29,   67,   31,   23,   33,   34,   23,   36,   37,
 /*    80 */    58,   66,   67,   41,   42,   43,   44,   76,   46,   76,
 /*    90 */    48,   69,   50,   71,   72,   53,   22,   55,   24,   25,
 /*   100 */    56,   57,   57,   29,   23,   31,   70,   33,   34,   57,
 /*   110 */    36,   37,   14,   15,   16,   41,   30,   43,   44,   23,
 /*   120 */    46,   47,   48,   69,   50,   71,   72,   53,   22,   55,
 /*   130 */    24,   25,   21,   52,   62,   29,   23,   31,   23,   33,
 /*   140 */    34,   23,   36,   37,   75,   76,   23,   41,   23,   43,
 /*   150 */    44,   45,   46,   57,   48,   69,   50,   71,   72,   53,
 /*   160 */    22,   55,   24,   25,   23,   66,   67,   29,   57,   31,
 /*   170 */    57,   33,   34,   19,   36,   37,   26,   27,   23,   41,
 /*   180 */    23,   43,   44,   45,   46,   23,   48,   69,   50,   71,
 /*   190 */    72,   53,   22,   55,   24,   25,    1,   64,   23,   29,
 /*   200 */    67,   31,   23,   33,   34,   23,   36,   37,   23,   80,
 /*   210 */    23,   41,   17,   18,   44,   20,   46,   23,   48,   90,
 /*   220 */    50,   51,   93,   53,   22,   55,   24,   25,    1,   23,
 /*   230 */    23,   29,   23,   31,   23,   33,   34,   23,   36,   37,
 /*   240 */    23,   23,   23,   41,   17,   18,   44,   20,   46,   23,
 /*   250 */    48,   69,   50,   71,   72,   53,   54,   55,   22,    1,
 /*   260 */    24,   25,   23,   79,   23,   29,   23,   31,   23,   33,
 /*   270 */    34,   23,   36,   37,   90,   17,   18,   41,   20,    1,
 /*   280 */    44,   97,   46,   23,   48,   23,   50,   51,   23,   53,
 /*   290 */    22,   55,   24,   25,    1,   17,   18,   29,   20,   31,
 /*   300 */    32,   33,   34,   90,   36,   37,   76,   76,   93,   41,
 /*   310 */    17,   18,   44,   20,   46,   90,   48,   69,   50,   71,
 /*   320 */    72,   53,   22,   55,   24,   25,    1,   90,   28,   29,
 /*   330 */    90,   31,   90,   33,   34,   76,   36,   37,   77,   90,
 /*   340 */    90,   41,   17,   18,   44,   20,   46,   90,   48,   76,
 /*   350 */    50,   76,   23,   53,   22,   55,   24,   25,   29,   79,
 /*   360 */    31,   29,   76,   31,   98,   33,   34,   98,   36,   37,
 /*   370 */    90,   76,   90,   41,   42,    1,   44,   97,   46,   90,
 /*   380 */    48,   69,   50,   71,   72,   53,   22,   55,   24,   25,
 /*   390 */     1,   17,   18,   29,   20,   31,   76,   33,   34,   70,
 /*   400 */    36,   37,   93,   76,   76,   41,   17,   18,   44,   20,
 /*   410 */    46,   76,   48,   49,   50,   76,   76,   53,   22,   55,
 /*   420 */    24,   25,    1,   76,   76,   29,   76,   31,   76,   33,
 /*   430 */    34,   99,   36,   37,   99,   39,   99,   41,   17,   18,
 /*   440 */    44,   20,   46,   99,   48,   79,   50,   99,   99,   53,
 /*   450 */    22,   55,   24,   25,    1,   99,   90,   29,   99,   31,
 /*   460 */    99,   33,   34,   97,   36,   37,   99,   80,   99,   41,
 /*   470 */    17,   18,   44,   20,   46,   47,   48,   90,   50,   99,
 /*   480 */    93,   53,   22,   55,   24,   25,   99,   79,   99,   29,
 /*   490 */    99,   31,   32,   33,   34,   99,   36,   37,   90,   80,
 /*   500 */    99,   41,   30,    1,   44,   97,   46,   99,   48,   90,
 /*   510 */    50,   99,   93,   53,   22,   55,   24,   25,   99,   17,
 /*   520 */    18,   29,   20,   31,   99,   33,   34,   99,   36,   37,
 /*   530 */    99,   99,   99,   41,   99,    1,   44,   45,   46,   99,
 /*   540 */    48,   69,   50,   71,   72,   53,   22,   55,   24,   25,
 /*   550 */    99,   17,   18,   29,   20,   31,   99,   33,   34,   99,
 /*   560 */    36,   37,   99,   80,   99,   41,   99,    1,   44,   45,
 /*   570 */    46,   99,   48,   90,   50,   99,   93,   53,   22,   55,
 /*   580 */    24,   25,    1,   17,   18,   29,   20,   31,   99,   33,
 /*   590 */    34,   35,   36,   37,   99,   80,   99,   41,   17,   18,
 /*   600 */    44,   20,   46,   99,   48,   90,   50,   99,   93,   53,
 /*   610 */    22,   55,   24,   25,   99,   99,   99,   29,   99,   31,
 /*   620 */    32,   33,   34,   99,   36,   37,   99,   80,   99,   41,
 /*   630 */    99,    1,   44,   11,   46,   99,   48,   90,   50,   99,
 /*   640 */    93,   53,   22,   55,   24,   25,    1,   17,   18,   29,
 /*   650 */    20,   31,   99,   33,   34,    1,   36,   37,   99,   99,
 /*   660 */    38,   41,   17,   18,   44,   20,   46,   99,   48,   99,
 /*   670 */    50,   17,   18,   53,   20,   55,   99,    3,    4,    5,
 /*   680 */     6,    7,    8,    9,   10,   11,   12,   13,   14,   15,
 /*   690 */    16,   69,   99,   71,   72,   11,   99,   23,   99,   99,
 /*   700 */    99,    3,    4,    5,    6,    7,    8,    9,   10,   11,
 /*   710 */    12,   13,   14,   15,   16,    3,    4,    5,    6,    7,
 /*   720 */     8,    9,   10,   11,   12,   13,   14,   15,   16,    4,
 /*   730 */     5,    6,    7,    8,    9,   10,   11,   12,   13,   14,
 /*   740 */    15,   16,   23,   99,   99,   99,   99,   99,   29,   30,
 /*   750 */    31,   99,   99,   69,   99,   71,   72,   38,   78,   99,
 /*   760 */    62,   81,   82,   83,   84,   85,   86,   87,   88,   89,
 /*   770 */    99,   52,   92,   99,   94,    2,   99,   99,   59,   60,
 /*   780 */    61,   99,   63,   99,   65,   99,   99,   99,   99,   70,
 /*   790 */     5,    6,    7,    8,    9,   10,   11,   12,   13,   14,
 /*   800 */    15,   16,   29,   99,   31,   99,   79,   99,   99,   99,
 /*   810 */    99,   99,   99,   23,   99,   99,   80,   90,   99,   29,
 /*   820 */    93,   31,   95,   96,   97,   52,   90,   91,   38,   93,
 /*   830 */    99,   99,   59,   60,   61,   99,   63,   99,   65,   99,
 /*   840 */    99,   68,   52,   70,   99,   99,   99,   99,   99,   59,
 /*   850 */    60,   61,   99,   63,   79,   65,   23,   99,    1,   99,
 /*   860 */    70,   99,   29,   30,   31,   90,   99,   99,   93,   99,
 /*   870 */    95,   96,   97,   23,   17,   18,   80,   20,   99,   29,
 /*   880 */    99,   31,   99,   99,   99,   52,   90,   91,   38,   93,
 /*   890 */    99,   99,   59,   60,   61,   29,   63,   31,   65,   99,
 /*   900 */    99,   99,   52,   70,   99,   99,   99,   99,   99,   59,
 /*   910 */    60,   61,   99,   63,   79,   65,   23,   99,   52,   99,
 /*   920 */    70,   99,   29,   99,   31,   90,   99,    1,   93,   99,
 /*   930 */    95,   96,   97,   23,   99,   99,   70,   99,   99,   29,
 /*   940 */    99,   31,   99,   17,   18,   52,   20,   99,   99,   99,
 /*   950 */    79,   99,   59,   60,   61,   99,   63,   99,   65,   99,
 /*   960 */    99,   90,   52,   70,   93,   99,   95,   96,   97,   59,
 /*   970 */    60,   61,   99,   63,   79,   65,   80,   99,   99,   99,
 /*   980 */    70,   99,   29,   99,   31,   90,   90,   91,   93,   93,
 /*   990 */    95,   96,   97,   79,   99,   99,   99,   99,   99,   29,
 /*  1000 */    99,   31,   99,   99,   90,   52,   99,   93,   99,   95,
 /*  1010 */    96,   97,   59,   60,   61,   99,   63,   99,   65,   99,
 /*  1020 */    99,   99,   52,   70,   99,   79,   99,   99,   99,   59,
 /*  1030 */    60,   61,   99,   63,   79,   65,   90,   99,   99,   93,
 /*  1040 */    70,   95,   96,   97,   79,   90,   79,   99,   93,   99,
 /*  1050 */    95,   96,   97,   99,   79,   90,   99,   90,   93,   99,
 /*  1060 */    93,   96,   97,   96,   97,   90,   99,   99,   93,   99,
 /*  1070 */    79,   96,   97,   99,   99,   99,   99,   99,   99,   99,
 /*  1080 */    99,   90,   99,   99,   93,   99,   99,   96,   97,
);
    const YY_SHIFT_USE_DFLT = -64;
    const YY_SHIFT_MAX = 172;
    static public $yy_shift_ofst = array(
 /*     0 */   -64,  138,   74,  -22,  106,   10,   42,  588,  556,  460,
 /*    10 */   300,  236,  170,  364,  428,  524,  332,  396,  492,  202,
 /*    20 */   268,  620,  773,  773,  773,  773,  773,  773,  773,  773,
 /*    30 */   953,  953,  953,  953,  833,  893,  910,  719,  850,  790,
 /*    40 */   970,  970,  970,  970,  970,  -25,  -25,  -25,  -25,  -25,
 /*    50 */   -25,  630,  645,  857,  654,  926,  866,  421,  374,  325,
 /*    60 */   329,  293,  453,  227,    0,  278,  258,   35,  195,  389,
 /*    70 */   581,  534,  502,  566,  -25,  -23,  -25,  -25,  -23,  -25,
 /*    80 */   -25,  -25,  -25,  -25,    5,   15,  -64,  -64,  -64,  -64,
 /*    90 */   -64,  -64,  -64,  -64,  -64,  -64,  -64,  -64,  -64,  -64,
 /*   100 */   -64,  -64,  -64,  -64,  -64,  -64,  698,  674,  712,  725,
 /*   110 */   785,  785,  622,  118,   86,   22,   54,  472,  182,  -10,
 /*   120 */   248,  684,  312,   98,  312,   81,  113,   45,   96,  150,
 /*   130 */   111,  133,   99,   44,  175,  239,  226,  219,  218,  241,
 /*   140 */   243,  262,  260,  154,  217,  185,   52,  194,  214,  211,
 /*   150 */   207,   72,  209,  206,  179,  245,  265,  -63,    2,  162,
 /*   160 */     6,  123,  155,  157,   36,   25,   47,   51,  187,  -13,
 /*   170 */   115,  141,  125,
);
    const YY_REDUCE_USE_DFLT = -75;
    const YY_REDUCE_MAX = 105;
    static public $yy_reduce_ofst = array(
 /*     0 */    69,  680,  680,  680,  680,  680,  680,  680,  680,  680,
 /*    10 */   680,  680,  680,  680,  680,  680,  680,  680,  680,  680,
 /*    20 */   680,  680,  895,  871,  946,  835,  775,  727,  914,  955,
 /*    30 */   967,  991,  965,  975,  896,  796,  736,  483,  483,  483,
 /*    40 */   387,  419,  515,  547,  129,  -74,  184,  408,  280,  366,
 /*    50 */   -60,  261,  261,  261,  261,  261,  282,  261,  261,  261,
 /*    60 */   289,  261,  261,  261,  261,  261,  261,  261,  261,  261,
 /*    70 */   261,  261,  261,  261,  249,  215,  242,  213,  309,  225,
 /*    80 */   237,  240,  250,  257,  266,  269,  295,  286,  275,  231,
 /*    90 */   259,  273,  320,  230,  340,  327,  352,  335,  350,  347,
 /*   100 */   328,  339,  348,  -68,   11,   13,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 43, 44, 45, 46, 48, 50, 53, 55, ),
        /* 2 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 43, 44, 46, 47, 48, 50, 53, 55, ),
        /* 3 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 43, 44, 46, 48, 49, 50, 53, 55, ),
        /* 4 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 43, 44, 45, 46, 48, 50, 53, 55, ),
        /* 5 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 39, 40, 41, 44, 46, 48, 50, 53, 55, ),
        /* 6 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 42, 43, 44, 46, 48, 50, 53, 55, ),
        /* 7 */ array(22, 24, 25, 29, 31, 32, 33, 34, 36, 37, 41, 44, 46, 48, 50, 53, 55, ),
        /* 8 */ array(22, 24, 25, 29, 31, 33, 34, 35, 36, 37, 41, 44, 46, 48, 50, 53, 55, ),
        /* 9 */ array(22, 24, 25, 29, 31, 32, 33, 34, 36, 37, 41, 44, 46, 48, 50, 53, 55, ),
        /* 10 */ array(22, 24, 25, 28, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 50, 53, 55, ),
        /* 11 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 50, 51, 53, 55, ),
        /* 12 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 50, 51, 53, 55, ),
        /* 13 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 49, 50, 53, 55, ),
        /* 14 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 47, 48, 50, 53, 55, ),
        /* 15 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 45, 46, 48, 50, 53, 55, ),
        /* 16 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 42, 44, 46, 48, 50, 53, 55, ),
        /* 17 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 39, 41, 44, 46, 48, 50, 53, 55, ),
        /* 18 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 45, 46, 48, 50, 53, 55, ),
        /* 19 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 50, 53, 54, 55, ),
        /* 20 */ array(22, 24, 25, 29, 31, 32, 33, 34, 36, 37, 41, 44, 46, 48, 50, 53, 55, ),
        /* 21 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 50, 53, 55, ),
        /* 22 */ array(2, 29, 31, 52, 59, 60, 61, 63, 65, 68, 70, ),
        /* 23 */ array(2, 29, 31, 52, 59, 60, 61, 63, 65, 68, 70, ),
        /* 24 */ array(2, 29, 31, 52, 59, 60, 61, 63, 65, 68, 70, ),
        /* 25 */ array(2, 29, 31, 52, 59, 60, 61, 63, 65, 68, 70, ),
        /* 26 */ array(2, 29, 31, 52, 59, 60, 61, 63, 65, 68, 70, ),
        /* 27 */ array(2, 29, 31, 52, 59, 60, 61, 63, 65, 68, 70, ),
        /* 28 */ array(2, 29, 31, 52, 59, 60, 61, 63, 65, 68, 70, ),
        /* 29 */ array(2, 29, 31, 52, 59, 60, 61, 63, 65, 68, 70, ),
        /* 30 */ array(29, 31, 52, 59, 60, 61, 63, 65, 70, ),
        /* 31 */ array(29, 31, 52, 59, 60, 61, 63, 65, 70, ),
        /* 32 */ array(29, 31, 52, 59, 60, 61, 63, 65, 70, ),
        /* 33 */ array(29, 31, 52, 59, 60, 61, 63, 65, 70, ),
        /* 34 */ array(23, 29, 30, 31, 52, 59, 60, 61, 63, 65, 70, ),
        /* 35 */ array(23, 29, 31, 52, 59, 60, 61, 63, 65, 70, ),
        /* 36 */ array(23, 29, 31, 52, 59, 60, 61, 63, 65, 70, ),
        /* 37 */ array(23, 29, 30, 31, 38, 52, 59, 60, 61, 63, 65, 70, ),
        /* 38 */ array(23, 29, 31, 38, 52, 59, 60, 61, 63, 65, 70, ),
        /* 39 */ array(23, 29, 31, 38, 52, 59, 60, 61, 63, 65, 70, ),
        /* 40 */ array(29, 31, 52, 59, 60, 61, 63, 65, 70, ),
        /* 41 */ array(29, 31, 52, 59, 60, 61, 63, 65, 70, ),
        /* 42 */ array(29, 31, 52, 59, 60, 61, 63, 65, 70, ),
        /* 43 */ array(29, 31, 52, 59, 60, 61, 63, 65, 70, ),
        /* 44 */ array(29, 31, 52, 59, 60, 61, 63, 65, 70, ),
        /* 45 */ array(29, 31, 70, ),
        /* 46 */ array(29, 31, 70, ),
        /* 47 */ array(29, 31, 70, ),
        /* 48 */ array(29, 31, 70, ),
        /* 49 */ array(29, 31, 70, ),
        /* 50 */ array(29, 31, 70, ),
        /* 51 */ array(1, 17, 18, 20, ),
        /* 52 */ array(1, 17, 18, 20, ),
        /* 53 */ array(1, 17, 18, 20, ),
        /* 54 */ array(1, 17, 18, 20, ),
        /* 55 */ array(1, 17, 18, 20, ),
        /* 56 */ array(29, 31, 52, 70, ),
        /* 57 */ array(1, 17, 18, 20, ),
        /* 58 */ array(1, 17, 18, 20, ),
        /* 59 */ array(1, 17, 18, 20, ),
        /* 60 */ array(23, 29, 31, 70, ),
        /* 61 */ array(1, 17, 18, 20, ),
        /* 62 */ array(1, 17, 18, 20, ),
        /* 63 */ array(1, 17, 18, 20, ),
        /* 64 */ array(1, 17, 18, 20, ),
        /* 65 */ array(1, 17, 18, 20, ),
        /* 66 */ array(1, 17, 18, 20, ),
        /* 67 */ array(1, 17, 18, 20, ),
        /* 68 */ array(1, 17, 18, 20, ),
        /* 69 */ array(1, 17, 18, 20, ),
        /* 70 */ array(1, 17, 18, 20, ),
        /* 71 */ array(1, 17, 18, 20, ),
        /* 72 */ array(1, 17, 18, 20, ),
        /* 73 */ array(1, 17, 18, 20, ),
        /* 74 */ array(29, 31, 70, ),
        /* 75 */ array(61, 63, 65, ),
        /* 76 */ array(29, 31, 70, ),
        /* 77 */ array(29, 31, 70, ),
        /* 78 */ array(61, 63, 65, ),
        /* 79 */ array(29, 31, 70, ),
        /* 80 */ array(29, 31, 70, ),
        /* 81 */ array(29, 31, 70, ),
        /* 82 */ array(29, 31, 70, ),
        /* 83 */ array(29, 31, 70, ),
        /* 84 */ array(64, 67, ),
        /* 85 */ array(66, 67, ),
        /* 86 */ array(),
        /* 87 */ array(),
        /* 88 */ array(),
        /* 89 */ array(),
        /* 90 */ array(),
        /* 91 */ array(),
        /* 92 */ array(),
        /* 93 */ array(),
        /* 94 */ array(),
        /* 95 */ array(),
        /* 96 */ array(),
        /* 97 */ array(),
        /* 98 */ array(),
        /* 99 */ array(),
        /* 100 */ array(),
        /* 101 */ array(),
        /* 102 */ array(),
        /* 103 */ array(),
        /* 104 */ array(),
        /* 105 */ array(),
        /* 106 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 62, ),
        /* 107 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 23, ),
        /* 108 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 109 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 110 */ array(5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 111 */ array(5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 112 */ array(11, 38, 69, 71, 72, ),
        /* 113 */ array(23, 69, 71, 72, ),
        /* 114 */ array(30, 69, 71, 72, ),
        /* 115 */ array(58, 69, 71, 72, ),
        /* 116 */ array(23, 69, 71, 72, ),
        /* 117 */ array(30, 69, 71, 72, ),
        /* 118 */ array(23, 69, 71, 72, ),
        /* 119 */ array(23, 69, 71, 72, ),
        /* 120 */ array(23, 69, 71, 72, ),
        /* 121 */ array(11, 69, 71, 72, ),
        /* 122 */ array(69, 71, 72, ),
        /* 123 */ array(14, 15, 16, ),
        /* 124 */ array(69, 71, 72, ),
        /* 125 */ array(23, 52, ),
        /* 126 */ array(23, 57, ),
        /* 127 */ array(23, 57, ),
        /* 128 */ array(23, 57, ),
        /* 129 */ array(26, 27, ),
        /* 130 */ array(21, 57, ),
        /* 131 */ array(64, 67, ),
        /* 132 */ array(66, 67, ),
        /* 133 */ array(56, 57, ),
        /* 134 */ array(23, ),
        /* 135 */ array(23, ),
        /* 136 */ array(23, ),
        /* 137 */ array(23, ),
        /* 138 */ array(23, ),
        /* 139 */ array(23, ),
        /* 140 */ array(23, ),
        /* 141 */ array(23, ),
        /* 142 */ array(23, ),
        /* 143 */ array(19, ),
        /* 144 */ array(23, ),
        /* 145 */ array(23, ),
        /* 146 */ array(57, ),
        /* 147 */ array(23, ),
        /* 148 */ array(23, ),
        /* 149 */ array(23, ),
        /* 150 */ array(23, ),
        /* 151 */ array(62, ),
        /* 152 */ array(23, ),
        /* 153 */ array(23, ),
        /* 154 */ array(23, ),
        /* 155 */ array(23, ),
        /* 156 */ array(23, ),
        /* 157 */ array(73, ),
        /* 158 */ array(23, ),
        /* 159 */ array(23, ),
        /* 160 */ array(23, ),
        /* 161 */ array(23, ),
        /* 162 */ array(23, ),
        /* 163 */ array(23, ),
        /* 164 */ array(70, ),
        /* 165 */ array(23, ),
        /* 166 */ array(23, ),
        /* 167 */ array(23, ),
        /* 168 */ array(23, ),
        /* 169 */ array(70, ),
        /* 170 */ array(23, ),
        /* 171 */ array(23, ),
        /* 172 */ array(23, ),
        /* 173 */ array(),
        /* 174 */ array(),
        /* 175 */ array(),
        /* 176 */ array(),
        /* 177 */ array(),
        /* 178 */ array(),
        /* 179 */ array(),
        /* 180 */ array(),
        /* 181 */ array(),
        /* 182 */ array(),
        /* 183 */ array(),
        /* 184 */ array(),
        /* 185 */ array(),
        /* 186 */ array(),
        /* 187 */ array(),
        /* 188 */ array(),
        /* 189 */ array(),
        /* 190 */ array(),
        /* 191 */ array(),
        /* 192 */ array(),
        /* 193 */ array(),
        /* 194 */ array(),
        /* 195 */ array(),
        /* 196 */ array(),
        /* 197 */ array(),
        /* 198 */ array(),
        /* 199 */ array(),
        /* 200 */ array(),
        /* 201 */ array(),
        /* 202 */ array(),
        /* 203 */ array(),
        /* 204 */ array(),
        /* 205 */ array(),
        /* 206 */ array(),
        /* 207 */ array(),
        /* 208 */ array(),
        /* 209 */ array(),
        /* 210 */ array(),
        /* 211 */ array(),
        /* 212 */ array(),
        /* 213 */ array(),
        /* 214 */ array(),
        /* 215 */ array(),
        /* 216 */ array(),
        /* 217 */ array(),
        /* 218 */ array(),
        /* 219 */ array(),
        /* 220 */ array(),
        /* 221 */ array(),
        /* 222 */ array(),
        /* 223 */ array(),
        /* 224 */ array(),
        /* 225 */ array(),
        /* 226 */ array(),
        /* 227 */ array(),
        /* 228 */ array(),
        /* 229 */ array(),
        /* 230 */ array(),
        /* 231 */ array(),
        /* 232 */ array(),
        /* 233 */ array(),
        /* 234 */ array(),
        /* 235 */ array(),
        /* 236 */ array(),
        /* 237 */ array(),
        /* 238 */ array(),
        /* 239 */ array(),
        /* 240 */ array(),
        /* 241 */ array(),
        /* 242 */ array(),
        /* 243 */ array(),
        /* 244 */ array(),
        /* 245 */ array(),
);
    static public $yy_default = array(
 /*     0 */   248,  330,  330,  330,  330,  330,  330,  330,  330,  330,
 /*    10 */   330,  330,  330,  330,  330,  330,  330,  330,  330,  330,
 /*    20 */   330,  330,  330,  330,  330,  330,  330,  330,  330,  330,
 /*    30 */   330,  330,  330,  330,  330,  330,  330,  330,  330,  330,
 /*    40 */   330,  330,  330,  330,  330,  330,  330,  330,  330,  330,
 /*    50 */   330,  330,  330,  330,  330,  330,  330,  330,  330,  330,
 /*    60 */   330,  330,  330,  330,  330,  330,  330,  246,  330,  330,
 /*    70 */   330,  330,  330,  330,  330,  330,  330,  330,  330,  330,
 /*    80 */   330,  330,  330,  330,  330,  330,  248,  248,  248,  248,
 /*    90 */   248,  248,  248,  248,  248,  248,  248,  248,  248,  248,
 /*   100 */   248,  248,  248,  248,  248,  248,  330,  330,  317,  318,
 /*   110 */   319,  321,  330,  330,  330,  298,  330,  330,  330,  330,
 /*   120 */   330,  330,  302,  320,  294,  330,  330,  330,  330,  330,
 /*   130 */   330,  330,  330,  330,  330,  330,  330,  330,  330,  330,
 /*   140 */   330,  330,  330,  330,  330,  330,  306,  330,  330,  330,
 /*   150 */   330,  330,  330,  330,  330,  330,  330,  330,  330,  330,
 /*   160 */   330,  330,  330,  330,  330,  330,  330,  330,  330,  330,
 /*   170 */   330,  330,  330,  254,  307,  260,  329,  255,  257,  259,
 /*   180 */   284,  309,  308,  258,  282,  247,  256,  316,  324,  323,
 /*   190 */   305,  304,  303,  270,  325,  326,  322,  310,  312,  314,
 /*   200 */   327,  292,  315,  311,  313,  328,  265,  296,  276,  288,
 /*   210 */   297,  295,  274,  289,  275,  277,  278,  286,  283,  249,
 /*   220 */   281,  280,  287,  279,  253,  290,  273,  285,  266,  251,
 /*   230 */   252,  264,  291,  262,  263,  267,  250,  293,  271,  272,
 /*   240 */   269,  301,  268,  299,  300,  261,
);
/* The next thing included is series of defines which control
** various aspects of the generated parser.
**    self::YYNOCODE      is a number which corresponds
**                        to no legal terminal or nonterminal number.  This
**                        number is used to fill in empty slots of the hash 
**                        table.
**    self::YYFALLBACK    If defined, this indicates that one or more tokens
**                        have fall-back values which should be used if the
**                        original value of the token will not parse.
**    self::YYSTACKDEPTH  is the maximum depth of the parser's stack.
**    self::YYNSTATE      the combined number of states.
**    self::YYNRULE       the number of rules in the grammar
**    self::YYERRORSYMBOL is the code number of the error symbol.  If not
**                        defined, then do no error processing.
*/
    const YYNOCODE = 100;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 246;
    const YYNRULE = 84;
    const YYERRORSYMBOL = 74;
    const YYERRSYMDT = 'yy0';
    const YYFALLBACK = 0;
    /** The next table maps tokens into fallback tokens.  If a construct
     * like the following:
     * 
     *      %fallback ID X Y Z.
     *
     * appears in the grammer, then ID becomes a fallback token for X, Y,
     * and Z.  Whenever one of the tokens X, Y, or Z is input to the parser
     * but it does not parse, the type of the token is changed to ID and
     * the parse is retried before an error is thrown.
     */
    static public $yyFallback = array(
    );
    /**
     * Turn parser tracing on by giving a stream to which to write the trace
     * and a prompt to preface each trace message.  Tracing is turned off
     * by making either argument NULL 
     *
     * Inputs:
     * 
     * - A stream resource to which trace output should be written.
     *   If NULL, then tracing is turned off.
     * - A prefix string written at the beginning of every
     *   line of trace output.  If NULL, then tracing is
     *   turned off.
     *
     * Outputs:
     * 
     * - None.
     * @param resource
     * @param string
     */
    static function Trace($TraceFILE, $zTracePrompt)
    {
        if (!$TraceFILE) {
            $zTracePrompt = 0;
        } elseif (!$zTracePrompt) {
            $TraceFILE = 0;
        }
        self::$yyTraceFILE = $TraceFILE;
        self::$yyTracePrompt = $zTracePrompt;
    }

    /**
     * Output debug information to output (php://output stream)
     */
    static function PrintTrace()
    {
        self::$yyTraceFILE = fopen('php://output', 'w');
        self::$yyTracePrompt = '';
    }

    /**
     * @var resource|0
     */
    static public $yyTraceFILE;
    /**
     * String to prepend to debug output
     * @var string|0
     */
    static public $yyTracePrompt;
    /**
     * @var int
     */
    public $yyidx;                    /* Index of top element in stack */
    /**
     * @var int
     */
    public $yyerrcnt;                 /* Shifts left before out of the error */
    /**
     * @var array
     */
    public $yystack = array();  /* The parser's stack */

    /**
     * For tracing shifts, the names of all terminals and nonterminals
     * are required.  The following table supplies these names
     * @var array
     */
    static public $yyTokenName = array( 
  '$',             'T_OPEN_TAG',    'T_NOT',         'T_AND',       
  'T_OR',          'T_EQ',          'T_NE',          'T_GT',        
  'T_GE',          'T_LT',          'T_LE',          'T_IN',        
  'T_PLUS',        'T_MINUS',       'T_TIMES',       'T_DIV',       
  'T_MOD',         'T_HTML',        'T_COMMENT_OPEN',  'T_COMMENT',   
  'T_PRINT_OPEN',  'T_PRINT_CLOSE',  'T_EXTENDS',     'T_CLOSE_TAG', 
  'T_INCLUDE',     'T_AUTOESCAPE',  'T_OFF',         'T_ON',        
  'T_END_AUTOESCAPE',  'T_CUSTOM_TAG',  'T_AS',          'T_CUSTOM_BLOCK',
  'T_CUSTOM_END',  'T_SPACEFULL',   'T_WITH',        'T_ENDWITH',   
  'T_LOAD',        'T_FOR',         'T_COMMA',       'T_CLOSEFOR',  
  'T_EMPTY',       'T_IF',          'T_ENDIF',       'T_ELSE',      
  'T_IFCHANGED',   'T_ENDIFCHANGED',  'T_IFEQUAL',     'T_END_IFEQUAL',
  'T_IFNOTEQUAL',  'T_END_IFNOTEQUAL',  'T_BLOCK',       'T_END_BLOCK', 
  'T_NUMERIC',     'T_FILTER',      'T_END_FILTER',  'T_REGROUP',   
  'T_BY',          'T_PIPE',        'T_COLON',       'T_TRUE',      
  'T_FALSE',       'T_INTL',        'T_RPARENT',     'T_STRING_SINGLE_INIT',
  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',  'T_STRING_DOUBLE_END',  'T_STRING_CONTENT',
  'T_LPARENT',     'T_OBJ',         'T_ALPHA',       'T_DOT',       
  'T_BRACKETS_OPEN',  'T_BRACKETS_CLOSE',  'error',         'start',       
  'body',          'code',          'stmts',         'filtered_var',
  'var_or_string',  'stmt',          'for_stmt',      'ifchanged_stmt',
  'block_stmt',    'filter_stmt',   'if_stmt',       'custom_tag',  
  'alias',         'ifequal',       'varname',       'params',      
  'regroup',       'string',        'for_def',       'expr',        
  'fvar_or_string',  'varname_args',  's_content',   
    );

    /**
     * For tracing reduce actions, the names of all rules are required.
     * @var array
     */
    static public $yyRuleName = array(
 /*   0 */ "start ::= body",
 /*   1 */ "body ::= body code",
 /*   2 */ "body ::=",
 /*   3 */ "code ::= T_OPEN_TAG stmts",
 /*   4 */ "code ::= T_HTML",
 /*   5 */ "code ::= T_COMMENT_OPEN T_COMMENT",
 /*   6 */ "code ::= T_PRINT_OPEN filtered_var T_PRINT_CLOSE",
 /*   7 */ "stmts ::= T_EXTENDS var_or_string T_CLOSE_TAG",
 /*   8 */ "stmts ::= stmt T_CLOSE_TAG",
 /*   9 */ "stmts ::= for_stmt",
 /*  10 */ "stmts ::= ifchanged_stmt",
 /*  11 */ "stmts ::= block_stmt",
 /*  12 */ "stmts ::= filter_stmt",
 /*  13 */ "stmts ::= if_stmt",
 /*  14 */ "stmts ::= T_INCLUDE var_or_string T_CLOSE_TAG",
 /*  15 */ "stmts ::= custom_tag",
 /*  16 */ "stmts ::= alias",
 /*  17 */ "stmts ::= ifequal",
 /*  18 */ "stmts ::= T_AUTOESCAPE T_OFF|T_ON T_CLOSE_TAG body T_OPEN_TAG T_END_AUTOESCAPE T_CLOSE_TAG",
 /*  19 */ "custom_tag ::= T_CUSTOM_TAG T_CLOSE_TAG",
 /*  20 */ "custom_tag ::= T_CUSTOM_TAG T_AS varname T_CLOSE_TAG",
 /*  21 */ "custom_tag ::= T_CUSTOM_TAG params T_CLOSE_TAG",
 /*  22 */ "custom_tag ::= T_CUSTOM_TAG params T_AS varname T_CLOSE_TAG",
 /*  23 */ "custom_tag ::= T_CUSTOM_BLOCK T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  24 */ "custom_tag ::= T_CUSTOM_BLOCK params T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  25 */ "custom_tag ::= T_SPACEFULL T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  26 */ "alias ::= T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_ENDWITH T_CLOSE_TAG",
 /*  27 */ "stmt ::= regroup",
 /*  28 */ "stmt ::= T_LOAD string",
 /*  29 */ "for_def ::= T_FOR varname T_IN filtered_var T_CLOSE_TAG",
 /*  30 */ "for_def ::= T_FOR varname T_COMMA varname T_IN filtered_var T_CLOSE_TAG",
 /*  31 */ "for_stmt ::= for_def body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  32 */ "for_stmt ::= for_def body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  33 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  34 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  35 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  36 */ "ifchanged_stmt ::= T_IFCHANGED params T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  37 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  38 */ "ifchanged_stmt ::= T_IFCHANGED params T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  39 */ "ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_END_IFEQUAL T_CLOSE_TAG",
 /*  40 */ "ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_END_IFEQUAL T_CLOSE_TAG",
 /*  41 */ "ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_END_IFNOTEQUAL T_CLOSE_TAG",
 /*  42 */ "ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_END_IFNOTEQUAL T_CLOSE_TAG",
 /*  43 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  44 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  45 */ "block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  46 */ "block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_NUMERIC T_CLOSE_TAG",
 /*  47 */ "filter_stmt ::= T_FILTER filtered_var T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  48 */ "regroup ::= T_REGROUP filtered_var T_BY varname T_AS varname",
 /*  49 */ "filtered_var ::= filtered_var T_PIPE varname_args",
 /*  50 */ "filtered_var ::= varname_args",
 /*  51 */ "varname_args ::= varname T_COLON var_or_string",
 /*  52 */ "varname_args ::= varname",
 /*  53 */ "params ::= params var_or_string",
 /*  54 */ "params ::= params T_COMMA var_or_string",
 /*  55 */ "params ::= var_or_string",
 /*  56 */ "var_or_string ::= varname",
 /*  57 */ "var_or_string ::= T_NUMERIC",
 /*  58 */ "var_or_string ::= T_TRUE|T_FALSE",
 /*  59 */ "var_or_string ::= string",
 /*  60 */ "fvar_or_string ::= filtered_var",
 /*  61 */ "fvar_or_string ::= T_NUMERIC",
 /*  62 */ "fvar_or_string ::= T_TRUE|T_FALSE",
 /*  63 */ "fvar_or_string ::= string",
 /*  64 */ "string ::= T_INTL string T_RPARENT",
 /*  65 */ "string ::= T_STRING_SINGLE_INIT T_STRING_SINGLE_END",
 /*  66 */ "string ::= T_STRING_DOUBLE_INIT T_STRING_DOUBLE_END",
 /*  67 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  68 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  69 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  70 */ "s_content ::= T_STRING_CONTENT",
 /*  71 */ "expr ::= T_NOT expr",
 /*  72 */ "expr ::= expr T_AND expr",
 /*  73 */ "expr ::= expr T_OR expr",
 /*  74 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  75 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN expr",
 /*  76 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  77 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  78 */ "expr ::= fvar_or_string",
 /*  79 */ "varname ::= varname T_OBJ T_ALPHA",
 /*  80 */ "varname ::= varname T_DOT T_ALPHA",
 /*  81 */ "varname ::= varname T_BRACKETS_OPEN var_or_string T_BRACKETS_CLOSE",
 /*  82 */ "varname ::= T_ALPHA",
 /*  83 */ "varname ::= T_CUSTOM_TAG|T_CUSTOM_BLOCK",
    );

    /**
     * This function returns the symbolic name associated with a token
     * value.
     * @param int
     * @return string
     */
    function tokenName($tokenType)
    {
        if ($tokenType === 0) {
            return 'End of Input';
        }
        if ($tokenType > 0 && $tokenType < count(self::$yyTokenName)) {
            return self::$yyTokenName[$tokenType];
        } else {
            return "Unknown";
        }
    }

    /**
     * The following function deletes the value associated with a
     * symbol.  The symbol can be either a terminal or nonterminal.
     * @param int the symbol code
     * @param mixed the symbol's value
     */
    static function yy_destructor($yymajor, $yypminor)
    {
        switch ($yymajor) {
        /* Here is inserted the actions which take place when a
        ** terminal or non-terminal is destroyed.  This can happen
        ** when the symbol is popped from the stack during a
        ** reduce or during error processing or when a parser is 
        ** being destroyed before it is finished parsing.
        **
        ** Note: during a reduce, the only symbols destroyed are those
        ** which appear on the RHS of the rule, but which are not used
        ** inside the C code.
        */
            default:  break;   /* If no destructor action specified: do nothing */
        }
    }

    /**
     * Pop the parser's stack once.
     *
     * If there is a destructor routine associated with the token which
     * is popped from the stack, then call it.
     *
     * Return the major token number for the symbol popped.
     * @param Haanga_yyParser
     * @return int
     */
    function yy_pop_parser_stack()
    {
        if (!count($this->yystack)) {
            return;
        }
        $yytos = array_pop($this->yystack);
        if (self::$yyTraceFILE && $this->yyidx >= 0) {
            fwrite(self::$yyTraceFILE,
                self::$yyTracePrompt . 'Popping ' . self::$yyTokenName[$yytos->major] .
                    "\n");
        }
        $yymajor = $yytos->major;
        self::yy_destructor($yymajor, $yytos->minor);
        $this->yyidx--;
        return $yymajor;
    }

    /**
     * Deallocate and destroy a parser.  Destructors are all called for
     * all stack elements before shutting the parser down.
     */
    function __destruct()
    {
        while ($this->yyidx >= 0) {
            $this->yy_pop_parser_stack();
        }
        if (is_resource(self::$yyTraceFILE)) {
            fclose(self::$yyTraceFILE);
        }
    }

    /**
     * Based on the current state and parser stack, get a list of all
     * possible lookahead tokens
     * @param int
     * @return array
     */
    function yy_get_expected_tokens($token)
    {
        $state = $this->yystack[$this->yyidx]->stateno;
        $expected = self::$yyExpectedTokens[$state];
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return $expected;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return array_unique($expected);
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate])) {
                        $expected += self::$yyExpectedTokens[$nextstate];
                            if (in_array($token,
                                  self::$yyExpectedTokens[$nextstate], true)) {
                            $this->yyidx = $yyidx;
                            $this->yystack = $stack;
                            return array_unique($expected);
                        }
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new Haanga_yyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return array_unique($expected);
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return $expected;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
        return array_unique($expected);
    }

    /**
     * Based on the parser state and current parser stack, determine whether
     * the lookahead token is possible.
     * 
     * The parser will convert the token value to an error token if not.  This
     * catches some unusual edge cases where the parser would fail.
     * @param int
     * @return bool
     */
    function yy_is_expected_token($token)
    {
        if ($token === 0) {
            return true; // 0 is not part of this
        }
        $state = $this->yystack[$this->yyidx]->stateno;
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return true;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return true;
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate]) &&
                          in_array($token, self::$yyExpectedTokens[$nextstate], true)) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        return true;
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new Haanga_yyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        if (!$token) {
                            // end of input: this is valid
                            return true;
                        }
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return false;
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return true;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
        $this->yyidx = $yyidx;
        $this->yystack = $stack;
        return true;
    }

    /**
     * Find the appropriate action for a parser given the terminal
     * look-ahead token iLookAhead.
     *
     * If the look-ahead token is YYNOCODE, then check to see if the action is
     * independent of the look-ahead.  If it is, return the action, otherwise
     * return YY_NO_ACTION.
     * @param int The look-ahead token
     */
    function yy_find_shift_action($iLookAhead)
    {
        $stateno = $this->yystack[$this->yyidx]->stateno;
     
        /* if ($this->yyidx < 0) return self::YY_NO_ACTION;  */
        if (!isset(self::$yy_shift_ofst[$stateno])) {
            // no shift actions
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_shift_ofst[$stateno];
        if ($i === self::YY_SHIFT_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            if (count(self::$yyFallback) && $iLookAhead < count(self::$yyFallback)
                   && ($iFallback = self::$yyFallback[$iLookAhead]) != 0) {
                if (self::$yyTraceFILE) {
                    fwrite(self::$yyTraceFILE, self::$yyTracePrompt . "FALLBACK " .
                        self::$yyTokenName[$iLookAhead] . " => " .
                        self::$yyTokenName[$iFallback] . "\n");
                }
                return $this->yy_find_shift_action($iFallback);
            }
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    /**
     * Find the appropriate action for a parser given the non-terminal
     * look-ahead token $iLookAhead.
     *
     * If the look-ahead token is self::YYNOCODE, then check to see if the action is
     * independent of the look-ahead.  If it is, return the action, otherwise
     * return self::YY_NO_ACTION.
     * @param int Current state number
     * @param int The look-ahead token
     */
    function yy_find_reduce_action($stateno, $iLookAhead)
    {
        /* $stateno = $this->yystack[$this->yyidx]->stateno; */

        if (!isset(self::$yy_reduce_ofst[$stateno])) {
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_reduce_ofst[$stateno];
        if ($i == self::YY_REDUCE_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    /**
     * Perform a shift action.
     * @param int The new state to shift in
     * @param int The major token to shift in
     * @param mixed the minor token to shift in
     */
    function yy_shift($yyNewState, $yyMajor, $yypMinor)
    {
        $this->yyidx++;
        if ($this->yyidx >= self::YYSTACKDEPTH) {
            $this->yyidx--;
            if (self::$yyTraceFILE) {
                fprintf(self::$yyTraceFILE, "%sStack Overflow!\n", self::$yyTracePrompt);
            }
            while ($this->yyidx >= 0) {
                $this->yy_pop_parser_stack();
            }
            /* Here code is inserted which will execute if the parser
            ** stack ever overflows */
            return;
        }
        $yytos = new Haanga_yyStackEntry;
        $yytos->stateno = $yyNewState;
        $yytos->major = $yyMajor;
        $yytos->minor = $yypMinor;
        array_push($this->yystack, $yytos);
        if (self::$yyTraceFILE && $this->yyidx > 0) {
            fprintf(self::$yyTraceFILE, "%sShift %d\n", self::$yyTracePrompt,
                $yyNewState);
            fprintf(self::$yyTraceFILE, "%sStack:", self::$yyTracePrompt);
            for($i = 1; $i <= $this->yyidx; $i++) {
                fprintf(self::$yyTraceFILE, " %s",
                    self::$yyTokenName[$this->yystack[$i]->major]);
            }
            fwrite(self::$yyTraceFILE,"\n");
        }
    }

    /**
     * The following table contains information about every rule that
     * is used during the reduce.
     *
     * <pre>
     * array(
     *  array(
     *   int $lhs;         Symbol on the left-hand side of the rule
     *   int $nrhs;     Number of right-hand side symbols in the rule
     *  ),...
     * );
     * </pre>
     */
    static public $yyRuleInfo = array(
  array( 'lhs' => 75, 'rhs' => 1 ),
  array( 'lhs' => 76, 'rhs' => 2 ),
  array( 'lhs' => 76, 'rhs' => 0 ),
  array( 'lhs' => 77, 'rhs' => 2 ),
  array( 'lhs' => 77, 'rhs' => 1 ),
  array( 'lhs' => 77, 'rhs' => 2 ),
  array( 'lhs' => 77, 'rhs' => 3 ),
  array( 'lhs' => 78, 'rhs' => 3 ),
  array( 'lhs' => 78, 'rhs' => 2 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 3 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 7 ),
  array( 'lhs' => 87, 'rhs' => 2 ),
  array( 'lhs' => 87, 'rhs' => 4 ),
  array( 'lhs' => 87, 'rhs' => 3 ),
  array( 'lhs' => 87, 'rhs' => 5 ),
  array( 'lhs' => 87, 'rhs' => 6 ),
  array( 'lhs' => 87, 'rhs' => 7 ),
  array( 'lhs' => 87, 'rhs' => 6 ),
  array( 'lhs' => 88, 'rhs' => 9 ),
  array( 'lhs' => 81, 'rhs' => 1 ),
  array( 'lhs' => 81, 'rhs' => 2 ),
  array( 'lhs' => 94, 'rhs' => 5 ),
  array( 'lhs' => 94, 'rhs' => 7 ),
  array( 'lhs' => 82, 'rhs' => 5 ),
  array( 'lhs' => 82, 'rhs' => 9 ),
  array( 'lhs' => 86, 'rhs' => 7 ),
  array( 'lhs' => 86, 'rhs' => 11 ),
  array( 'lhs' => 83, 'rhs' => 6 ),
  array( 'lhs' => 83, 'rhs' => 7 ),
  array( 'lhs' => 83, 'rhs' => 10 ),
  array( 'lhs' => 83, 'rhs' => 11 ),
  array( 'lhs' => 89, 'rhs' => 8 ),
  array( 'lhs' => 89, 'rhs' => 12 ),
  array( 'lhs' => 89, 'rhs' => 8 ),
  array( 'lhs' => 89, 'rhs' => 12 ),
  array( 'lhs' => 84, 'rhs' => 7 ),
  array( 'lhs' => 84, 'rhs' => 8 ),
  array( 'lhs' => 84, 'rhs' => 7 ),
  array( 'lhs' => 84, 'rhs' => 8 ),
  array( 'lhs' => 85, 'rhs' => 7 ),
  array( 'lhs' => 92, 'rhs' => 6 ),
  array( 'lhs' => 79, 'rhs' => 3 ),
  array( 'lhs' => 79, 'rhs' => 1 ),
  array( 'lhs' => 97, 'rhs' => 3 ),
  array( 'lhs' => 97, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 2 ),
  array( 'lhs' => 91, 'rhs' => 3 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 80, 'rhs' => 1 ),
  array( 'lhs' => 80, 'rhs' => 1 ),
  array( 'lhs' => 80, 'rhs' => 1 ),
  array( 'lhs' => 80, 'rhs' => 1 ),
  array( 'lhs' => 96, 'rhs' => 1 ),
  array( 'lhs' => 96, 'rhs' => 1 ),
  array( 'lhs' => 96, 'rhs' => 1 ),
  array( 'lhs' => 96, 'rhs' => 1 ),
  array( 'lhs' => 93, 'rhs' => 3 ),
  array( 'lhs' => 93, 'rhs' => 2 ),
  array( 'lhs' => 93, 'rhs' => 2 ),
  array( 'lhs' => 93, 'rhs' => 3 ),
  array( 'lhs' => 93, 'rhs' => 3 ),
  array( 'lhs' => 98, 'rhs' => 2 ),
  array( 'lhs' => 98, 'rhs' => 1 ),
  array( 'lhs' => 95, 'rhs' => 2 ),
  array( 'lhs' => 95, 'rhs' => 3 ),
  array( 'lhs' => 95, 'rhs' => 3 ),
  array( 'lhs' => 95, 'rhs' => 3 ),
  array( 'lhs' => 95, 'rhs' => 3 ),
  array( 'lhs' => 95, 'rhs' => 3 ),
  array( 'lhs' => 95, 'rhs' => 3 ),
  array( 'lhs' => 95, 'rhs' => 1 ),
  array( 'lhs' => 90, 'rhs' => 3 ),
  array( 'lhs' => 90, 'rhs' => 3 ),
  array( 'lhs' => 90, 'rhs' => 4 ),
  array( 'lhs' => 90, 'rhs' => 1 ),
  array( 'lhs' => 90, 'rhs' => 1 ),
    );

    /**
     * The following table contains a mapping of reduce action to method name
     * that handles the reduction.
     * 
     * If a rule is not set, it has no handler.
     */
    static public $yyReduceMap = array(
        0 => 0,
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        64 => 8,
        9 => 9,
        10 => 9,
        11 => 9,
        12 => 9,
        13 => 9,
        15 => 9,
        16 => 9,
        17 => 9,
        27 => 9,
        52 => 9,
        70 => 9,
        78 => 9,
        82 => 9,
        83 => 9,
        14 => 14,
        18 => 18,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
        24 => 24,
        25 => 25,
        26 => 26,
        28 => 28,
        29 => 29,
        30 => 30,
        31 => 31,
        32 => 32,
        33 => 33,
        34 => 34,
        35 => 35,
        36 => 36,
        37 => 37,
        38 => 38,
        39 => 39,
        40 => 40,
        41 => 41,
        42 => 42,
        43 => 43,
        44 => 44,
        46 => 44,
        45 => 45,
        47 => 47,
        48 => 48,
        49 => 49,
        54 => 49,
        50 => 50,
        55 => 50,
        51 => 51,
        53 => 53,
        56 => 56,
        57 => 57,
        61 => 57,
        58 => 58,
        62 => 58,
        59 => 59,
        63 => 59,
        60 => 60,
        65 => 65,
        66 => 65,
        67 => 67,
        68 => 67,
        69 => 69,
        71 => 71,
        72 => 72,
        73 => 72,
        74 => 72,
        76 => 72,
        75 => 75,
        77 => 77,
        79 => 79,
        80 => 80,
        81 => 81,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 79 "lib/Haanga/Compiler/Parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1604 "lib/Haanga/Compiler/Parser.php"
#line 81 "lib/Haanga/Compiler/Parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1607 "lib/Haanga/Compiler/Parser.php"
#line 82 "lib/Haanga/Compiler/Parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1610 "lib/Haanga/Compiler/Parser.php"
#line 85 "lib/Haanga/Compiler/Parser.y"
    function yy_r3(){ if (count($this->yystack[$this->yyidx + 0]->minor)) $this->yystack[$this->yyidx + 0]->minor['line'] = $this->lex->getLine();  $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1613 "lib/Haanga/Compiler/Parser.php"
#line 86 "lib/Haanga/Compiler/Parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor, 'line' => $this->lex->getLine() );     }
#line 1616 "lib/Haanga/Compiler/Parser.php"
#line 87 "lib/Haanga/Compiler/Parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1619 "lib/Haanga/Compiler/Parser.php"
#line 88 "lib/Haanga/Compiler/Parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor, 'line' => $this->lex->getLine() );     }
#line 1622 "lib/Haanga/Compiler/Parser.php"
#line 90 "lib/Haanga/Compiler/Parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1625 "lib/Haanga/Compiler/Parser.php"
#line 91 "lib/Haanga/Compiler/Parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1628 "lib/Haanga/Compiler/Parser.php"
#line 92 "lib/Haanga/Compiler/Parser.y"
    function yy_r9(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1631 "lib/Haanga/Compiler/Parser.php"
#line 97 "lib/Haanga/Compiler/Parser.y"
    function yy_r14(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1634 "lib/Haanga/Compiler/Parser.php"
#line 101 "lib/Haanga/Compiler/Parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'autoescape', 'value' => strtolower(@$this->yystack[$this->yyidx + -5]->minor), 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1637 "lib/Haanga/Compiler/Parser.php"
#line 106 "lib/Haanga/Compiler/Parser.y"
    function yy_r19(){
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array()); 
    }
#line 1642 "lib/Haanga/Compiler/Parser.php"
#line 109 "lib/Haanga/Compiler/Parser.y"
    function yy_r20(){
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array()); 
    }
#line 1647 "lib/Haanga/Compiler/Parser.php"
#line 112 "lib/Haanga/Compiler/Parser.y"
    function yy_r21(){ 
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor); 
    }
#line 1652 "lib/Haanga/Compiler/Parser.php"
#line 115 "lib/Haanga/Compiler/Parser.y"
    function yy_r22(){
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1657 "lib/Haanga/Compiler/Parser.php"
#line 120 "lib/Haanga/Compiler/Parser.y"
    function yy_r23(){
    if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { 
        $this->error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); 
    } 
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array());
    }
#line 1665 "lib/Haanga/Compiler/Parser.php"
#line 126 "lib/Haanga/Compiler/Parser.y"
    function yy_r24(){
    if ('end'.$this->yystack[$this->yyidx + -6]->minor != $this->yystack[$this->yyidx + -1]->minor) { 
        $this->error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); 
    } 
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'list' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1673 "lib/Haanga/Compiler/Parser.php"
#line 134 "lib/Haanga/Compiler/Parser.y"
    function yy_r25(){
    if ('endspacefull' != $this->yystack[$this->yyidx + -1]->minor) {
        $this->error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor);
    } 
    $this->_retvalue = array('operation' => 'spacefull', 'body' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1681 "lib/Haanga/Compiler/Parser.php"
#line 142 "lib/Haanga/Compiler/Parser.y"
    function yy_r26(){
    $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1686 "lib/Haanga/Compiler/Parser.php"
#line 148 "lib/Haanga/Compiler/Parser.y"
    function yy_r28(){
    if (!is_file($this->yystack[$this->yyidx + 0]->minor) || !Haanga_Compiler::getOption('enable_load')) {
        $this->error($this->yystack[$this->yyidx + 0]->minor." is not a valid file"); 
    } 
    require_once $this->yystack[$this->yyidx + 0]->minor;
    }
#line 1694 "lib/Haanga/Compiler/Parser.php"
#line 156 "lib/Haanga/Compiler/Parser.y"
    function yy_r29(){
    /* Try to get the variable */
    $var = $this->compiler->get_context(is_array($this->yystack[$this->yyidx + -1]->minor[0]) ? $this->yystack[$this->yyidx + -1]->minor[0] : array($this->yystack[$this->yyidx + -1]->minor[0]));
    if (is_array($var)) {
        /* let's check if it is an object or array */
        $this->compiler->set_context($this->yystack[$this->yyidx + -3]->minor, current($var));
    }

    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL, 'array' => $this->yystack[$this->yyidx + -1]->minor);
    }
#line 1706 "lib/Haanga/Compiler/Parser.php"
#line 165 "lib/Haanga/Compiler/Parser.y"
    function yy_r30(){
    /* Try to get the variable */
    $var = $this->compiler->get_context(is_array($this->yystack[$this->yyidx + -1]->minor[0]) ? $this->yystack[$this->yyidx + -1]->minor[0] : array($this->yystack[$this->yyidx + -1]->minor[0]));
    if (is_array($var)) {
        /* let's check if it is an object or array */
        $this->compiler->set_context($this->yystack[$this->yyidx + -3]->minor, current($var));
    }
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -5]->minor, 'array' => $this->yystack[$this->yyidx + -1]->minor);
    }
#line 1717 "lib/Haanga/Compiler/Parser.php"
#line 174 "lib/Haanga/Compiler/Parser.y"
    function yy_r31(){ 
    $this->_retvalue = $this->yystack[$this->yyidx + -4]->minor;
    $this->_retvalue['body'] = $this->yystack[$this->yyidx + -3]->minor;
    }
#line 1723 "lib/Haanga/Compiler/Parser.php"
#line 179 "lib/Haanga/Compiler/Parser.y"
    function yy_r32(){ 
    $this->_retvalue = $this->yystack[$this->yyidx + -8]->minor;
    $this->_retvalue['body']  = $this->yystack[$this->yyidx + -7]->minor;
    $this->_retvalue['empty'] = $this->yystack[$this->yyidx + -3]->minor;
    }
#line 1730 "lib/Haanga/Compiler/Parser.php"
#line 185 "lib/Haanga/Compiler/Parser.y"
    function yy_r33(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1733 "lib/Haanga/Compiler/Parser.php"
#line 186 "lib/Haanga/Compiler/Parser.y"
    function yy_r34(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1736 "lib/Haanga/Compiler/Parser.php"
#line 189 "lib/Haanga/Compiler/Parser.y"
    function yy_r35(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1741 "lib/Haanga/Compiler/Parser.php"
#line 193 "lib/Haanga/Compiler/Parser.y"
    function yy_r36(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1746 "lib/Haanga/Compiler/Parser.php"
#line 196 "lib/Haanga/Compiler/Parser.y"
    function yy_r37(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1751 "lib/Haanga/Compiler/Parser.php"
#line 200 "lib/Haanga/Compiler/Parser.y"
    function yy_r38(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1756 "lib/Haanga/Compiler/Parser.php"
#line 205 "lib/Haanga/Compiler/Parser.y"
    function yy_r39(){
    $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '==', 1 => $this->yystack[$this->yyidx + -6]->minor, 2 => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1761 "lib/Haanga/Compiler/Parser.php"
#line 208 "lib/Haanga/Compiler/Parser.y"
    function yy_r40(){
    $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '==', 1 => $this->yystack[$this->yyidx + -10]->minor, 2 => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1766 "lib/Haanga/Compiler/Parser.php"
#line 211 "lib/Haanga/Compiler/Parser.y"
    function yy_r41(){
    $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '!=', 1 => $this->yystack[$this->yyidx + -6]->minor, 2 => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1771 "lib/Haanga/Compiler/Parser.php"
#line 214 "lib/Haanga/Compiler/Parser.y"
    function yy_r42(){
    $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '!=', 1 => $this->yystack[$this->yyidx + -10]->minor, 2 => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1776 "lib/Haanga/Compiler/Parser.php"
#line 219 "lib/Haanga/Compiler/Parser.y"
    function yy_r43(){ 
    $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1781 "lib/Haanga/Compiler/Parser.php"
#line 223 "lib/Haanga/Compiler/Parser.y"
    function yy_r44(){
    $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor); 
    }
#line 1786 "lib/Haanga/Compiler/Parser.php"
#line 227 "lib/Haanga/Compiler/Parser.y"
    function yy_r45(){
    $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1791 "lib/Haanga/Compiler/Parser.php"
#line 236 "lib/Haanga/Compiler/Parser.y"
    function yy_r47(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1794 "lib/Haanga/Compiler/Parser.php"
#line 239 "lib/Haanga/Compiler/Parser.y"
    function yy_r48(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1797 "lib/Haanga/Compiler/Parser.php"
#line 242 "lib/Haanga/Compiler/Parser.y"
    function yy_r49(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1800 "lib/Haanga/Compiler/Parser.php"
#line 243 "lib/Haanga/Compiler/Parser.y"
    function yy_r50(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1803 "lib/Haanga/Compiler/Parser.php"
#line 245 "lib/Haanga/Compiler/Parser.y"
    function yy_r51(){ $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, 'args'=>array($this->yystack[$this->yyidx + 0]->minor));     }
#line 1806 "lib/Haanga/Compiler/Parser.php"
#line 249 "lib/Haanga/Compiler/Parser.y"
    function yy_r53(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1809 "lib/Haanga/Compiler/Parser.php"
#line 255 "lib/Haanga/Compiler/Parser.y"
    function yy_r56(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1812 "lib/Haanga/Compiler/Parser.php"
#line 256 "lib/Haanga/Compiler/Parser.y"
    function yy_r57(){ $this->_retvalue = array('number' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1815 "lib/Haanga/Compiler/Parser.php"
#line 257 "lib/Haanga/Compiler/Parser.y"
    function yy_r58(){ $this->_retvalue = trim(@$this->yystack[$this->yyidx + 0]->minor);     }
#line 1818 "lib/Haanga/Compiler/Parser.php"
#line 258 "lib/Haanga/Compiler/Parser.y"
    function yy_r59(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1821 "lib/Haanga/Compiler/Parser.php"
#line 261 "lib/Haanga/Compiler/Parser.y"
    function yy_r60(){ $this->_retvalue = array('var_filter' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1824 "lib/Haanga/Compiler/Parser.php"
#line 268 "lib/Haanga/Compiler/Parser.y"
    function yy_r65(){  $this->_retvalue = "";     }
#line 1827 "lib/Haanga/Compiler/Parser.php"
#line 270 "lib/Haanga/Compiler/Parser.y"
    function yy_r67(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1830 "lib/Haanga/Compiler/Parser.php"
#line 272 "lib/Haanga/Compiler/Parser.y"
    function yy_r69(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1833 "lib/Haanga/Compiler/Parser.php"
#line 276 "lib/Haanga/Compiler/Parser.y"
    function yy_r71(){ $this->_retvalue = array('op_expr' => 'not', $this->yystack[$this->yyidx + 0]->minor);     }
#line 1836 "lib/Haanga/Compiler/Parser.php"
#line 277 "lib/Haanga/Compiler/Parser.y"
    function yy_r72(){ $this->_retvalue = array('op_expr' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1839 "lib/Haanga/Compiler/Parser.php"
#line 280 "lib/Haanga/Compiler/Parser.y"
    function yy_r75(){ $this->_retvalue = array('op_expr' => trim(@$this->yystack[$this->yyidx + -1]->minor), $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1842 "lib/Haanga/Compiler/Parser.php"
#line 282 "lib/Haanga/Compiler/Parser.y"
    function yy_r77(){ $this->_retvalue = array('op_expr' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1845 "lib/Haanga/Compiler/Parser.php"
#line 286 "lib/Haanga/Compiler/Parser.y"
    function yy_r79(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=array('object' => $this->yystack[$this->yyidx + 0]->minor);    }
#line 1848 "lib/Haanga/Compiler/Parser.php"
#line 287 "lib/Haanga/Compiler/Parser.y"
    function yy_r80(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; } $this->_retvalue[] = ($this->compiler->var_is_object($this->_retvalue)) ? array('object' => $this->yystack[$this->yyidx + 0]->minor) : $this->yystack[$this->yyidx + 0]->minor;    }
#line 1851 "lib/Haanga/Compiler/Parser.php"
#line 288 "lib/Haanga/Compiler/Parser.y"
    function yy_r81(){ if (!is_array($this->yystack[$this->yyidx + -3]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -3]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + -1]->minor;    }
#line 1854 "lib/Haanga/Compiler/Parser.php"

    /**
     * placeholder for the left hand side in a reduce operation.
     * 
     * For a parser with a rule like this:
     * <pre>
     * rule(A) ::= B. { A = 1; }
     * </pre>
     * 
     * The parser will translate to something like:
     * 
     * <code>
     * function yy_r0(){$this->_retvalue = 1;}
     * </code>
     */
    private $_retvalue;

    /**
     * Perform a reduce action and the shift that must immediately
     * follow the reduce.
     * 
     * For a rule such as:
     * 
     * <pre>
     * A ::= B blah C. { dosomething(); }
     * </pre>
     * 
     * This function will first call the action, if any, ("dosomething();" in our
     * example), and then it will pop three states from the stack,
     * one for each entry on the right-hand side of the expression
     * (B, blah, and C in our example rule), and then push the result of the action
     * back on to the stack with the resulting state reduced to (as described in the .out
     * file)
     * @param int Number of the rule by which to reduce
     */
    function yy_reduce($yyruleno)
    {
        //int $yygoto;                     /* The next state */
        //int $yyact;                      /* The next action */
        //mixed $yygotominor;        /* The LHS of the rule reduced */
        //Haanga_yyStackEntry $yymsp;            /* The top of the parser's stack */
        //int $yysize;                     /* Amount to pop the stack */
        $yymsp = $this->yystack[$this->yyidx];
        if (self::$yyTraceFILE && $yyruleno >= 0 
              && $yyruleno < count(self::$yyRuleName)) {
            fprintf(self::$yyTraceFILE, "%sReduce (%d) [%s].\n",
                self::$yyTracePrompt, $yyruleno,
                self::$yyRuleName[$yyruleno]);
        }

        $this->_retvalue = $yy_lefthand_side = null;
        if (array_key_exists($yyruleno, self::$yyReduceMap)) {
            // call the action
            $this->_retvalue = null;
            $this->{'yy_r' . self::$yyReduceMap[$yyruleno]}();
            $yy_lefthand_side = $this->_retvalue;
        }
        $yygoto = self::$yyRuleInfo[$yyruleno]['lhs'];
        $yysize = self::$yyRuleInfo[$yyruleno]['rhs'];
        $this->yyidx -= $yysize;
        for($i = $yysize; $i; $i--) {
            // pop all of the right-hand side parameters
            array_pop($this->yystack);
        }
        $yyact = $this->yy_find_reduce_action($this->yystack[$this->yyidx]->stateno, $yygoto);
        if ($yyact < self::YYNSTATE) {
            /* If we are not debugging and the reduce action popped at least
            ** one element off the stack, then we can push the new element back
            ** onto the stack here, and skip the stack overflow test in yy_shift().
            ** That gives a significant speed improvement. */
            if (!self::$yyTraceFILE && $yysize) {
                $this->yyidx++;
                $x = new Haanga_yyStackEntry;
                $x->stateno = $yyact;
                $x->major = $yygoto;
                $x->minor = $yy_lefthand_side;
                $this->yystack[$this->yyidx] = $x;
            } else {
                $this->yy_shift($yyact, $yygoto, $yy_lefthand_side);
            }
        } elseif ($yyact == self::YYNSTATE + self::YYNRULE + 1) {
            $this->yy_accept();
        }
    }

    /**
     * The following code executes when the parse fails
     * 
     * Code from %parse_fail is inserted here
     */
    function yy_parse_failed()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sFail!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $this->yy_pop_parser_stack();
        }
        /* Here code is inserted which will be executed whenever the
        ** parser fails */
    }

    /**
     * The following code executes when a syntax error first occurs.
     * 
     * %syntax_error code is inserted here
     * @param int The major type of the error token
     * @param mixed The minor type of the error token
     */
    function yy_syntax_error($yymajor, $TOKEN)
    {
#line 70 "lib/Haanga/Compiler/Parser.y"

    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    $this->Error('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
#line 1974 "lib/Haanga/Compiler/Parser.php"
    }

    /**
     * The following is executed when the parser accepts
     * 
     * %parse_accept code is inserted here
     */
    function yy_accept()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sAccept!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $stack = $this->yy_pop_parser_stack();
        }
        /* Here code is inserted which will be executed whenever the
        ** parser accepts */
#line 57 "lib/Haanga/Compiler/Parser.y"

#line 1995 "lib/Haanga/Compiler/Parser.php"
    }

    /**
     * The main parser program.
     * 
     * The first argument is the major token number.  The second is
     * the token value string as scanned from the input.
     *
     * @param int the token number
     * @param mixed the token value
     * @param mixed any extra arguments that should be passed to handlers
     */
    function doParse($yymajor, $yytokenvalue)
    {
//        $yyact;            /* The parser action. */
//        $yyendofinput;     /* True if we are at the end of input */
        $yyerrorhit = 0;   /* True if yymajor has invoked an error */
        
        /* (re)initialize the parser, if necessary */
        if ($this->yyidx === null || $this->yyidx < 0) {
            /* if ($yymajor == 0) return; // not sure why this was here... */
            $this->yyidx = 0;
            $this->yyerrcnt = -1;
            $x = new Haanga_yyStackEntry;
            $x->stateno = 0;
            $x->major = 0;
            $this->yystack = array();
            array_push($this->yystack, $x);
        }
        $yyendofinput = ($yymajor==0);
        
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sInput %s\n",
                self::$yyTracePrompt, self::$yyTokenName[$yymajor]);
        }
        
        do {
            $yyact = $this->yy_find_shift_action($yymajor);
            if ($yymajor < self::YYERRORSYMBOL &&
                  !$this->yy_is_expected_token($yymajor)) {
                // force a syntax error
                $yyact = self::YY_ERROR_ACTION;
            }
            if ($yyact < self::YYNSTATE) {
                $this->yy_shift($yyact, $yymajor, $yytokenvalue);
                $this->yyerrcnt--;
                if ($yyendofinput && $this->yyidx >= 0) {
                    $yymajor = 0;
                } else {
                    $yymajor = self::YYNOCODE;
                }
            } elseif ($yyact < self::YYNSTATE + self::YYNRULE) {
                $this->yy_reduce($yyact - self::YYNSTATE);
            } elseif ($yyact == self::YY_ERROR_ACTION) {
                if (self::$yyTraceFILE) {
                    fprintf(self::$yyTraceFILE, "%sSyntax Error!\n",
                        self::$yyTracePrompt);
                }
                if (self::YYERRORSYMBOL) {
                    /* A syntax error has occurred.
                    ** The response to an error depends upon whether or not the
                    ** grammar defines an error token "ERROR".  
                    **
                    ** This is what we do if the grammar does define ERROR:
                    **
                    **  * Call the %syntax_error function.
                    **
                    **  * Begin popping the stack until we enter a state where
                    **    it is legal to shift the error symbol, then shift
                    **    the error symbol.
                    **
                    **  * Set the error count to three.
                    **
                    **  * Begin accepting and shifting new tokens.  No new error
                    **    processing will occur until three tokens have been
                    **    shifted successfully.
                    **
                    */
                    if ($this->yyerrcnt < 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $yymx = $this->yystack[$this->yyidx]->major;
                    if ($yymx == self::YYERRORSYMBOL || $yyerrorhit ){
                        if (self::$yyTraceFILE) {
                            fprintf(self::$yyTraceFILE, "%sDiscard input token %s\n",
                                self::$yyTracePrompt, self::$yyTokenName[$yymajor]);
                        }
                        $this->yy_destructor($yymajor, $yytokenvalue);
                        $yymajor = self::YYNOCODE;
                    } else {
                        while ($this->yyidx >= 0 &&
                                 $yymx != self::YYERRORSYMBOL &&
        ($yyact = $this->yy_find_shift_action(self::YYERRORSYMBOL)) >= self::YYNSTATE
                              ){
                            $this->yy_pop_parser_stack();
                        }
                        if ($this->yyidx < 0 || $yymajor==0) {
                            $this->yy_destructor($yymajor, $yytokenvalue);
                            $this->yy_parse_failed();
                            $yymajor = self::YYNOCODE;
                        } elseif ($yymx != self::YYERRORSYMBOL) {
                            $u2 = 0;
                            $this->yy_shift($yyact, self::YYERRORSYMBOL, $u2);
                        }
                    }
                    $this->yyerrcnt = 3;
                    $yyerrorhit = 1;
                } else {
                    /* YYERRORSYMBOL is not defined */
                    /* This is what we do if the grammar does not define ERROR:
                    **
                    **  * Report an error message, and throw away the input token.
                    **
                    **  * If the input token is $, then fail the parse.
                    **
                    ** As before, subsequent error messages are suppressed until
                    ** three input tokens have been successfully shifted.
                    */
                    if ($this->yyerrcnt <= 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $this->yyerrcnt = 3;
                    $this->yy_destructor($yymajor, $yytokenvalue);
                    if ($yyendofinput) {
                        $this->yy_parse_failed();
                    }
                    $yymajor = self::YYNOCODE;
                }
            } else {
                $this->yy_accept();
                $yymajor = self::YYNOCODE;
            }            
        } while ($yymajor != self::YYNOCODE && $this->yyidx >= 0);
    }
}