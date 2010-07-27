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
#line 2 "Compiler/Parser.y"

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
#line 136 "Compiler/Parser.php"

// declare_class is output here
#line 39 "Compiler/Parser.y"
 class Haanga_Compiler_Parser #line 141 "Compiler/Parser.php"
{
/* First off, code is included which follows the "include_class" declaration
** in the input file. */
#line 40 "Compiler/Parser.y"


#line 149 "Compiler/Parser.php"

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
    const T_AND                          =  2;
    const T_OR                           =  3;
    const T_EQ                           =  4;
    const T_NE                           =  5;
    const T_GT                           =  6;
    const T_GE                           =  7;
    const T_LT                           =  8;
    const T_LE                           =  9;
    const T_IN                           = 10;
    const T_PLUS                         = 11;
    const T_MINUS                        = 12;
    const T_TIMES                        = 13;
    const T_DIV                          = 14;
    const T_MOD                          = 15;
    const T_HTML                         = 16;
    const T_COMMENT_OPEN                 = 17;
    const T_COMMENT                      = 18;
    const T_PRINT_OPEN                   = 19;
    const T_PRINT_CLOSE                  = 20;
    const T_EXTENDS                      = 21;
    const T_CLOSE_TAG                    = 22;
    const T_INCLUDE                      = 23;
    const T_AUTOESCAPE                   = 24;
    const T_OFF                          = 25;
    const T_ON                           = 26;
    const T_END_AUTOESCAPE               = 27;
    const T_CUSTOM_TAG                   = 28;
    const T_AS                           = 29;
    const T_CUSTOM_BLOCK                 = 30;
    const T_CUSTOM_END                   = 31;
    const T_WITH                         = 32;
    const T_ENDWITH                      = 33;
    const T_LOAD                         = 34;
    const T_FOR                          = 35;
    const T_CLOSEFOR                     = 36;
    const T_COMMA                        = 37;
    const T_EMPTY                        = 38;
    const T_IF                           = 39;
    const T_ENDIF                        = 40;
    const T_ELSE                         = 41;
    const T_IFCHANGED                    = 42;
    const T_ENDIFCHANGED                 = 43;
    const T_IFEQUAL                      = 44;
    const T_END_IFEQUAL                  = 45;
    const T_IFNOTEQUAL                   = 46;
    const T_END_IFNOTEQUAL               = 47;
    const T_BLOCK                        = 48;
    const T_END_BLOCK                    = 49;
    const T_NUMERIC                      = 50;
    const T_FILTER                       = 51;
    const T_END_FILTER                   = 52;
    const T_REGROUP                      = 53;
    const T_BY                           = 54;
    const T_PIPE                         = 55;
    const T_COLON                        = 56;
    const T_STRING_SINGLE_INIT           = 57;
    const T_STRING_SINGLE_END            = 58;
    const T_STRING_DOUBLE_INIT           = 59;
    const T_STRING_DOUBLE_END            = 60;
    const T_STRING_CONTENT               = 61;
    const T_LPARENT                      = 62;
    const T_RPARENT                      = 63;
    const T_DOT                          = 64;
    const T_ALPHA                        = 65;
    const T_BRACKETS_OPEN                = 66;
    const T_BRACKETS_CLOSE               = 67;
    const YY_NO_ACTION = 313;
    const YY_ACCEPT_ACTION = 312;
    const YY_ERROR_ACTION = 311;

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
    const YY_SZ_ACTTAB = 953;
static public $yy_action = array(
 /*     0 */    37,    8,   38,  120,  209,   65,  196,   33,  196,  141,
 /*    10 */   196,   77,  196,   81,   71,  173,  216,  129,   25,   43,
 /*    20 */   138,   34,  196,   32,  196,   31,  130,   54,  180,  214,
 /*    30 */    44,   37,   46,   38,  120,   80,  168,   79,   33,   98,
 /*    40 */   141,  203,   77,  198,   81,   71,  175,  198,  215,   25,
 /*    50 */    47,  161,   34,  157,   32,  211,   31,  192,   54,  198,
 /*    60 */   231,   44,   37,   46,   38,  120,    9,  126,   36,   33,
 /*    70 */   232,  141,   47,   77,  134,   81,   71,  153,   42,  151,
 /*    80 */    25,  216,  129,   34,   43,   32,  127,   31,  192,   54,
 /*    90 */    72,   47,   44,   37,   46,   38,  120,  108,  126,   35,
 /*   100 */    33,  232,  141,  217,   77,   74,   81,   71,  187,   45,
 /*   110 */    67,   25,  223,  158,   34,  191,   32,  160,   31,   80,
 /*   120 */    54,   79,   64,   44,   37,   46,   38,  120,   20,   97,
 /*   130 */   182,   33,  133,  141,   40,   77,   55,   81,   71,  143,
 /*   140 */    86,  155,   25,  216,  129,   34,   43,   32,  100,   31,
 /*   150 */   133,   54,   40,   63,   44,   37,   46,   38,  120,  312,
 /*   160 */    57,   73,   33,  133,  141,   40,   77,   47,   81,   71,
 /*   170 */   210,   39,  133,   25,   40,  159,   34,  156,   32,  133,
 /*   180 */    31,   40,   54,  147,  147,   44,   37,   46,   38,  120,
 /*   190 */   133,  225,   40,   33,  190,  141,  133,   77,   40,   81,
 /*   200 */    71,   28,   28,   28,   25,  139,  165,   34,   78,   32,
 /*   210 */   233,   31,  133,   54,   40,   70,   44,   37,   46,   38,
 /*   220 */   120,   93,  176,  218,   33,   84,  141,  133,   77,   40,
 /*   230 */    81,   71,   94,  126,  220,   25,  232,   90,   34,  154,
 /*   240 */    32,   89,   31,  133,   54,   40,   48,   44,   37,   46,
 /*   250 */    38,  120,    7,  221,  191,   33,   83,  141,   47,   77,
 /*   260 */   212,   81,   71,  133,  230,   40,   25,  216,  129,   34,
 /*   270 */    43,   32,  181,   31,  136,   54,  213,  228,   44,   37,
 /*   280 */    46,   38,  120,    4,  200,  190,   33,   96,  141,   47,
 /*   290 */    77,  178,   81,   71,  167,  149,   99,   25,  216,  129,
 /*   300 */    34,   43,   32,  172,   31,  126,   54,   87,  232,   44,
 /*   310 */   135,   46,   37,   13,   38,  120,  108,   82,  146,   33,
 /*   320 */   107,  141,  219,   77,   69,   81,   71,  116,  216,  129,
 /*   330 */    25,   43,  110,   34,  226,   32,  185,   31,  188,   54,
 /*   340 */   118,  109,   44,   37,   46,   38,  120,  196,  126,  196,
 /*   350 */    33,  232,  141,  227,   77,  114,   81,   71,  119,  113,
 /*   360 */   111,   25,  112,  117,   34,  163,   32,   61,   31,  132,
 /*   370 */    54,   56,   51,   44,   37,   46,   38,  120,   11,  121,
 /*   380 */   224,   33,  207,  141,  198,   77,  189,   81,   71,  144,
 /*   390 */   131,   50,   25,  216,  129,   34,   43,   32,   68,   31,
 /*   400 */   126,   54,   95,  232,   44,   37,   46,   38,  120,   18,
 /*   410 */    60,  199,   33,   53,  141,  197,   77,  142,   81,   71,
 /*   420 */    88,  193,   58,   25,  216,  129,   34,   43,   32,  101,
 /*   430 */    31,  126,   54,   66,  232,   44,   37,   46,   38,  120,
 /*   440 */    10,   62,   52,   33,  169,  141,  222,   77,   59,   81,
 /*   450 */    71,  171,  171,  171,   25,  216,  129,   34,   43,   32,
 /*   460 */   171,   31,  124,   54,  123,  171,   44,   37,   46,   38,
 /*   470 */   120,  171,  171,  108,   33,  171,  141,  171,   77,  217,
 /*   480 */    81,   71,  171,  171,  171,   25,  166,  171,   34,  171,
 /*   490 */    32,  171,   31,  125,   54,  171,  171,   44,   37,   46,
 /*   500 */    38,  120,   12,  171,  108,   33,  171,  141,  140,   77,
 /*   510 */   217,   81,   71,  171,  171,  171,   25,  216,  129,   34,
 /*   520 */    43,   32,  171,   31,  122,   54,  171,  171,   44,   37,
 /*   530 */    46,   38,  120,   16,  171,  108,   33,  171,  141,  171,
 /*   540 */    77,  217,   81,   71,  171,  171,  171,   25,  216,  129,
 /*   550 */    34,   43,   32,  162,   31,  128,   54,  171,  171,   44,
 /*   560 */    37,   46,   38,  120,   19,  171,  108,   33,  171,  141,
 /*   570 */   171,   77,  217,   81,   71,  148,  152,  171,   25,  216,
 /*   580 */   129,   34,   43,   32,  171,   31,  126,   54,  171,  232,
 /*   590 */    44,   37,   46,   38,  120,    1,  171,  171,   33,  171,
 /*   600 */   141,  171,   77,  171,   81,   71,  171,  171,  171,   25,
 /*   610 */   216,  129,   34,   43,   32,  171,   31,  171,   54,   49,
 /*   620 */   171,   44,   37,   46,   38,  120,   17,  171,  171,   33,
 /*   630 */   171,  141,  171,   77,  171,   81,   71,  171,  171,  171,
 /*   640 */    25,  216,  129,   34,   43,   32,  171,   31,  171,   54,
 /*   650 */   171,  171,   44,  171,   46,   22,   23,   27,   27,   27,
 /*   660 */    27,   27,   27,   27,   24,   24,   28,   28,   28,   22,
 /*   670 */    23,   27,   27,   27,   27,   27,   27,   27,   24,   24,
 /*   680 */    28,   28,   28,  171,  171,  171,  171,  171,  171,   85,
 /*   690 */   171,  171,  171,   23,   27,   27,   27,   27,   27,   27,
 /*   700 */    27,   24,   24,   28,   28,   28,  171,  171,  171,  171,
 /*   710 */   171,  171,  171,  171,  171,  171,  171,  171,  171,  171,
 /*   720 */   171,   27,   27,   27,   27,   27,   27,   27,   24,   24,
 /*   730 */    28,   28,   28,  174,  171,  171,  150,  201,  202,  206,
 /*   740 */   205,  204,  195,  194,  186,  183,    6,  208,  184,  171,
 /*   750 */   171,  196,   75,  196,  196,   76,  196,  171,  171,   91,
 /*   760 */    41,  216,  129,  171,   43,  196,  171,  196,  171,  171,
 /*   770 */   196,  171,  196,  229,   41,  171,  229,  171,   92,  171,
 /*   780 */    80,  171,   79,   80,  196,   79,  196,  229,  198,  171,
 /*   790 */   171,  198,  180,  171,   80,  171,   79,  171,  171,   80,
 /*   800 */   137,   79,  198,  196,   26,  196,  229,  198,  171,  171,
 /*   810 */   171,  108,  137,   80,  170,   79,   29,  217,  171,  171,
 /*   820 */   171,  198,  137,  108,  171,  229,  170,  106,  177,  217,
 /*   830 */   137,  171,   80,  108,   79,  171,  170,  104,  177,  217,
 /*   840 */   198,  108,  171,  171,  170,  179,  177,  217,  171,  171,
 /*   850 */   137,  171,  171,  171,  171,  171,  171,  137,  171,  171,
 /*   860 */   171,  108,  171,  171,  170,  103,  177,  217,  108,  171,
 /*   870 */   137,  170,  102,  177,  217,  171,  171,  137,  171,  171,
 /*   880 */   171,  108,  171,    3,  170,  105,  177,  217,  108,  137,
 /*   890 */   171,  170,  115,  177,  217,  171,  137,  171,  216,  129,
 /*   900 */   108,   43,  171,  170,  137,  145,  217,  108,    2,  171,
 /*   910 */   170,  171,  164,  217,    5,  108,  171,  171,  170,  171,
 /*   920 */    30,  217,   21,  216,  129,  171,   43,  171,   15,  216,
 /*   930 */   129,  171,   43,  171,   14,  171,  171,  216,  129,  171,
 /*   940 */    43,  171,  171,  216,  129,  171,   43,  171,  171,  216,
 /*   950 */   129,  171,   43,
    );
    static public $yy_lookahead = array(
 /*     0 */    21,    1,   23,   24,   22,   70,   28,   28,   30,   30,
 /*    10 */    28,   32,   30,   34,   35,   20,   16,   17,   39,   19,
 /*    20 */    41,   42,   28,   44,   30,   46,   47,   48,   50,   22,
 /*    30 */    51,   21,   53,   23,   24,   57,   71,   59,   28,   22,
 /*    40 */    30,   22,   32,   65,   34,   35,   22,   65,   22,   39,
 /*    50 */    55,   41,   42,   43,   44,   22,   46,   74,   48,   65,
 /*    60 */    22,   51,   21,   53,   23,   24,    1,   84,   85,   28,
 /*    70 */    87,   30,   55,   32,   50,   34,   35,   36,   10,   38,
 /*    80 */    39,   16,   17,   42,   19,   44,   73,   46,   74,   48,
 /*    90 */    54,   55,   51,   21,   53,   23,   24,   84,   84,   85,
 /*   100 */    28,   87,   30,   90,   32,   37,   34,   35,   22,   10,
 /*   110 */    70,   39,   58,   41,   42,   61,   44,   45,   46,   57,
 /*   120 */    48,   59,   70,   51,   21,   53,   23,   24,    1,   22,
 /*   130 */    22,   28,   64,   30,   66,   32,   70,   34,   35,   36,
 /*   140 */    22,   38,   39,   16,   17,   42,   19,   44,   22,   46,
 /*   150 */    64,   48,   66,   70,   51,   21,   53,   23,   24,   69,
 /*   160 */    70,   29,   28,   64,   30,   66,   32,   55,   34,   35,
 /*   170 */    22,   56,   64,   39,   66,   41,   42,   43,   44,   64,
 /*   180 */    46,   66,   48,   25,   26,   51,   21,   53,   23,   24,
 /*   190 */    64,   58,   66,   28,   61,   30,   64,   32,   66,   34,
 /*   200 */    35,   13,   14,   15,   39,   40,   41,   42,   29,   44,
 /*   210 */    18,   46,   64,   48,   66,   70,   51,   21,   53,   23,
 /*   220 */    24,   22,   22,   74,   28,   22,   30,   64,   32,   66,
 /*   230 */    34,   35,   22,   84,   22,   39,   87,   22,   42,   43,
 /*   240 */    44,   22,   46,   64,   48,   66,   70,   51,   21,   53,
 /*   250 */    23,   24,    1,   60,   61,   28,   22,   30,   55,   32,
 /*   260 */    22,   34,   35,   64,   22,   66,   39,   16,   17,   42,
 /*   270 */    19,   44,   22,   46,   47,   48,   65,   22,   51,   21,
 /*   280 */    53,   23,   24,    1,   60,   61,   28,   22,   30,   55,
 /*   290 */    32,   22,   34,   35,   22,   74,   22,   39,   16,   17,
 /*   300 */    42,   19,   44,   22,   46,   84,   48,   22,   87,   51,
 /*   310 */    52,   53,   21,    1,   23,   24,   84,   22,   27,   28,
 /*   320 */    84,   30,   90,   32,   70,   34,   35,   84,   16,   17,
 /*   330 */    39,   19,   84,   42,   87,   44,   22,   46,   74,   48,
 /*   340 */    84,   84,   51,   21,   53,   23,   24,   28,   84,   30,
 /*   350 */    28,   87,   30,   22,   32,   84,   34,   35,   91,   84,
 /*   360 */    84,   39,   84,   84,   42,   43,   44,   70,   46,   50,
 /*   370 */    48,   70,   70,   51,   21,   53,   23,   24,    1,   91,
 /*   380 */    22,   28,   22,   30,   65,   32,   22,   34,   35,   36,
 /*   390 */    74,   70,   39,   16,   17,   42,   19,   44,   70,   46,
 /*   400 */    84,   48,   22,   87,   51,   21,   53,   23,   24,    1,
 /*   410 */    70,   67,   28,   70,   30,   22,   32,   33,   34,   35,
 /*   420 */    22,   74,   70,   39,   16,   17,   42,   19,   44,   22,
 /*   430 */    46,   84,   48,   70,   87,   51,   21,   53,   23,   24,
 /*   440 */     1,   70,   70,   28,   22,   30,   22,   32,   70,   34,
 /*   450 */    35,   92,   92,   92,   39,   16,   17,   42,   19,   44,
 /*   460 */    92,   46,   73,   48,   49,   92,   51,   21,   53,   23,
 /*   470 */    24,   92,   92,   84,   28,   92,   30,   92,   32,   90,
 /*   480 */    34,   35,   92,   92,   92,   39,   40,   92,   42,   92,
 /*   490 */    44,   92,   46,   73,   48,   92,   92,   51,   21,   53,
 /*   500 */    23,   24,    1,   92,   84,   28,   92,   30,   31,   32,
 /*   510 */    90,   34,   35,   92,   92,   92,   39,   16,   17,   42,
 /*   520 */    19,   44,   92,   46,   73,   48,   92,   92,   51,   21,
 /*   530 */    53,   23,   24,    1,   92,   84,   28,   92,   30,   92,
 /*   540 */    32,   90,   34,   35,   92,   92,   92,   39,   16,   17,
 /*   550 */    42,   19,   44,   45,   46,   73,   48,   92,   92,   51,
 /*   560 */    21,   53,   23,   24,    1,   92,   84,   28,   92,   30,
 /*   570 */    92,   32,   90,   34,   35,   36,   74,   92,   39,   16,
 /*   580 */    17,   42,   19,   44,   92,   46,   84,   48,   92,   87,
 /*   590 */    51,   21,   53,   23,   24,    1,   92,   92,   28,   92,
 /*   600 */    30,   92,   32,   92,   34,   35,   92,   92,   92,   39,
 /*   610 */    16,   17,   42,   19,   44,   92,   46,   92,   48,   49,
 /*   620 */    92,   51,   21,   53,   23,   24,    1,   92,   92,   28,
 /*   630 */    92,   30,   92,   32,   92,   34,   35,   92,   92,   92,
 /*   640 */    39,   16,   17,   42,   19,   44,   92,   46,   92,   48,
 /*   650 */    92,   92,   51,   92,   53,    2,    3,    4,    5,    6,
 /*   660 */     7,    8,    9,   10,   11,   12,   13,   14,   15,    2,
 /*   670 */     3,    4,    5,    6,    7,    8,    9,   10,   11,   12,
 /*   680 */    13,   14,   15,   92,   92,   92,   92,   92,   92,   22,
 /*   690 */    92,   92,   92,    3,    4,    5,    6,    7,    8,    9,
 /*   700 */    10,   11,   12,   13,   14,   15,   92,   92,   92,   92,
 /*   710 */    92,   92,   92,   92,   92,   92,   63,   92,   92,   92,
 /*   720 */    92,    4,    5,    6,    7,    8,    9,   10,   11,   12,
 /*   730 */    13,   14,   15,   72,   92,   92,   75,   76,   77,   78,
 /*   740 */    79,   80,   81,   82,   83,   22,    1,   86,   22,   92,
 /*   750 */    92,   28,   29,   30,   28,   29,   30,   92,   92,   22,
 /*   760 */    37,   16,   17,   92,   19,   28,   92,   30,   92,   92,
 /*   770 */    28,   92,   30,   50,   37,   92,   50,   92,   22,   92,
 /*   780 */    57,   92,   59,   57,   28,   59,   30,   50,   65,   92,
 /*   790 */    92,   65,   50,   92,   57,   92,   59,   92,   92,   57,
 /*   800 */    73,   59,   65,   28,   62,   30,   50,   65,   92,   92,
 /*   810 */    92,   84,   73,   57,   87,   59,   89,   90,   92,   92,
 /*   820 */    92,   65,   73,   84,   92,   50,   87,   88,   89,   90,
 /*   830 */    73,   92,   57,   84,   59,   92,   87,   88,   89,   90,
 /*   840 */    65,   84,   92,   92,   87,   88,   89,   90,   92,   92,
 /*   850 */    73,   92,   92,   92,   92,   92,   92,   73,   92,   92,
 /*   860 */    92,   84,   92,   92,   87,   88,   89,   90,   84,   92,
 /*   870 */    73,   87,   88,   89,   90,   92,   92,   73,   92,   92,
 /*   880 */    92,   84,   92,    1,   87,   88,   89,   90,   84,   73,
 /*   890 */    92,   87,   88,   89,   90,   92,   73,   92,   16,   17,
 /*   900 */    84,   19,   92,   87,   73,   89,   90,   84,    1,   92,
 /*   910 */    87,   92,   89,   90,    1,   84,   92,   92,   87,   92,
 /*   920 */    89,   90,    1,   16,   17,   92,   19,   92,    1,   16,
 /*   930 */    17,   92,   19,   92,    1,   92,   92,   16,   17,   92,
 /*   940 */    19,   92,   92,   16,   17,   92,   19,   92,   92,   16,
 /*   950 */    17,   92,   19,
);
    const YY_SHIFT_USE_DFLT = -23;
    const YY_SHIFT_MAX = 166;
    static public $yy_shift_ofst = array(
 /*     0 */   -23,  134,  165,  103,   72,  -21,   41,   10,  353,  258,
 /*    10 */   539,  384,  477,  446,  196,  227,  291,  508,  415,  570,
 /*    20 */   322,  601,  742,  742,  742,  742,  742,  742,  742,  -22,
 /*    30 */   -22,  -22,  -22,  726,  756,  723,  737,  775,  775,  775,
 /*    40 */   775,  775,   -6,   -6,   -6,   -6,   -6,   -6,  501,  -18,
 /*    50 */   408,  312,  907,  439,  319,  127,  913,  921,  933,  745,
 /*    60 */   625,  563,  594,  882,  927,  532,   65,    0,  251,  282,
 /*    70 */   377,   -6,   -6,   -6,   -6,   -6,   -6,   -6,   -6,  193,
 /*    80 */    54,   62,  -23,  -23,  -23,  -23,  -23,  -23,  -23,  -23,
 /*    90 */   -23,  -23,  -23,  -23,  -23,  -23,  -23,  -23,  -23,  -23,
 /*   100 */   -23,  -23,  667,  653,  690,  717,  717,   68,  115,  179,
 /*   110 */   132,   86,   99,  108,  126,  188,  148,  199,  163,  224,
 /*   120 */   158,  133,   -5,   24,  234,  203,  163,   36,   17,  192,
 /*   130 */   238,    7,  219,  211,  269,   26,   33,  112,  107,  331,
 /*   140 */   364,  380,  360,  358,  424,  398,  314,  407,  422,  344,
 /*   150 */   393,  118,   19,  272,  281,  274,   38,  200,  215,  265,
 /*   160 */   250,  295,  212,  242,  210,  285,  255,
);
    const YY_REDUCE_USE_DFLT = -66;
    const YY_REDUCE_MAX = 101;
    static public $yy_reduce_ofst = array(
 /*     0 */    90,  661,  661,  661,  661,  661,  661,  661,  661,  661,
 /*    10 */   661,  661,  661,  661,  661,  661,  661,  661,  661,  661,
 /*    20 */   661,  661,  749,  797,  804,  784,  777,  739,  757,  816,
 /*    30 */   823,  727,  831,   14,  -17,  264,  264,  316,  502,  149,
 /*    40 */   221,  347,  482,  451,  389,  420,   13,  232,  -35,  243,
 /*    50 */   -35,  -35,  -35,  -35,  279,  -35,  -35,  -35,  -35,  -35,
 /*    60 */   -35,  -35,  -35,  -35,  -35,  -35,  -35,  -35,  -35,  -35,
 /*    70 */   -35,  236,  248,  256,  278,  276,  275,  257,  271,  267,
 /*    80 */   288,  247,  352,  363,  378,  372,  343,  302,  301,  321,
 /*    90 */   340,  328,  371,  297,  254,  176,   66,   52,   83,   40,
 /*   100 */   145,  -65,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 41, 42, 43, 44, 46, 48, 51, 53, ),
        /* 2 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 40, 41, 42, 44, 46, 48, 51, 53, ),
        /* 3 */ array(21, 23, 24, 28, 30, 32, 34, 35, 36, 38, 39, 42, 44, 46, 48, 51, 53, ),
        /* 4 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 41, 42, 44, 45, 46, 48, 51, 53, ),
        /* 5 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 41, 42, 44, 46, 47, 48, 51, 53, ),
        /* 6 */ array(21, 23, 24, 28, 30, 32, 34, 35, 36, 38, 39, 42, 44, 46, 48, 51, 53, ),
        /* 7 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 41, 42, 43, 44, 46, 48, 51, 53, ),
        /* 8 */ array(21, 23, 24, 28, 30, 32, 34, 35, 36, 39, 42, 44, 46, 48, 51, 53, ),
        /* 9 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 42, 44, 46, 48, 51, 52, 53, ),
        /* 10 */ array(21, 23, 24, 28, 30, 32, 34, 35, 36, 39, 42, 44, 46, 48, 51, 53, ),
        /* 11 */ array(21, 23, 24, 28, 30, 32, 33, 34, 35, 39, 42, 44, 46, 48, 51, 53, ),
        /* 12 */ array(21, 23, 24, 28, 30, 31, 32, 34, 35, 39, 42, 44, 46, 48, 51, 53, ),
        /* 13 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 40, 42, 44, 46, 48, 51, 53, ),
        /* 14 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 42, 43, 44, 46, 48, 51, 53, ),
        /* 15 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 42, 44, 46, 47, 48, 51, 53, ),
        /* 16 */ array(21, 23, 24, 27, 28, 30, 32, 34, 35, 39, 42, 44, 46, 48, 51, 53, ),
        /* 17 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 42, 44, 45, 46, 48, 51, 53, ),
        /* 18 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 42, 44, 46, 48, 49, 51, 53, ),
        /* 19 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 42, 44, 46, 48, 49, 51, 53, ),
        /* 20 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 42, 43, 44, 46, 48, 51, 53, ),
        /* 21 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 42, 44, 46, 48, 51, 53, ),
        /* 22 */ array(28, 30, 50, 57, 59, 62, 65, ),
        /* 23 */ array(28, 30, 50, 57, 59, 62, 65, ),
        /* 24 */ array(28, 30, 50, 57, 59, 62, 65, ),
        /* 25 */ array(28, 30, 50, 57, 59, 62, 65, ),
        /* 26 */ array(28, 30, 50, 57, 59, 62, 65, ),
        /* 27 */ array(28, 30, 50, 57, 59, 62, 65, ),
        /* 28 */ array(28, 30, 50, 57, 59, 62, 65, ),
        /* 29 */ array(28, 30, 50, 57, 59, 65, ),
        /* 30 */ array(28, 30, 50, 57, 59, 65, ),
        /* 31 */ array(28, 30, 50, 57, 59, 65, ),
        /* 32 */ array(28, 30, 50, 57, 59, 65, ),
        /* 33 */ array(22, 28, 29, 30, 50, 57, 59, 65, ),
        /* 34 */ array(22, 28, 30, 50, 57, 59, 65, ),
        /* 35 */ array(22, 28, 29, 30, 37, 50, 57, 59, 65, ),
        /* 36 */ array(22, 28, 30, 37, 50, 57, 59, 65, ),
        /* 37 */ array(28, 30, 50, 57, 59, 65, ),
        /* 38 */ array(28, 30, 50, 57, 59, 65, ),
        /* 39 */ array(28, 30, 50, 57, 59, 65, ),
        /* 40 */ array(28, 30, 50, 57, 59, 65, ),
        /* 41 */ array(28, 30, 50, 57, 59, 65, ),
        /* 42 */ array(28, 30, 65, ),
        /* 43 */ array(28, 30, 65, ),
        /* 44 */ array(28, 30, 65, ),
        /* 45 */ array(28, 30, 65, ),
        /* 46 */ array(28, 30, 65, ),
        /* 47 */ array(28, 30, 65, ),
        /* 48 */ array(1, 16, 17, 19, ),
        /* 49 */ array(22, 28, 30, 65, ),
        /* 50 */ array(1, 16, 17, 19, ),
        /* 51 */ array(1, 16, 17, 19, ),
        /* 52 */ array(1, 16, 17, 19, ),
        /* 53 */ array(1, 16, 17, 19, ),
        /* 54 */ array(28, 30, 50, 65, ),
        /* 55 */ array(1, 16, 17, 19, ),
        /* 56 */ array(1, 16, 17, 19, ),
        /* 57 */ array(1, 16, 17, 19, ),
        /* 58 */ array(1, 16, 17, 19, ),
        /* 59 */ array(1, 16, 17, 19, ),
        /* 60 */ array(1, 16, 17, 19, ),
        /* 61 */ array(1, 16, 17, 19, ),
        /* 62 */ array(1, 16, 17, 19, ),
        /* 63 */ array(1, 16, 17, 19, ),
        /* 64 */ array(1, 16, 17, 19, ),
        /* 65 */ array(1, 16, 17, 19, ),
        /* 66 */ array(1, 16, 17, 19, ),
        /* 67 */ array(1, 16, 17, 19, ),
        /* 68 */ array(1, 16, 17, 19, ),
        /* 69 */ array(1, 16, 17, 19, ),
        /* 70 */ array(1, 16, 17, 19, ),
        /* 71 */ array(28, 30, 65, ),
        /* 72 */ array(28, 30, 65, ),
        /* 73 */ array(28, 30, 65, ),
        /* 74 */ array(28, 30, 65, ),
        /* 75 */ array(28, 30, 65, ),
        /* 76 */ array(28, 30, 65, ),
        /* 77 */ array(28, 30, 65, ),
        /* 78 */ array(28, 30, 65, ),
        /* 79 */ array(60, 61, ),
        /* 80 */ array(58, 61, ),
        /* 81 */ array(57, 59, ),
        /* 82 */ array(),
        /* 83 */ array(),
        /* 84 */ array(),
        /* 85 */ array(),
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
        /* 102 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 22, ),
        /* 103 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 63, ),
        /* 104 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 105 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 106 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 107 */ array(10, 37, 64, 66, ),
        /* 108 */ array(56, 64, 66, ),
        /* 109 */ array(29, 64, 66, ),
        /* 110 */ array(29, 64, 66, ),
        /* 111 */ array(22, 64, 66, ),
        /* 112 */ array(10, 64, 66, ),
        /* 113 */ array(22, 64, 66, ),
        /* 114 */ array(22, 64, 66, ),
        /* 115 */ array(13, 14, 15, ),
        /* 116 */ array(22, 64, 66, ),
        /* 117 */ array(22, 64, 66, ),
        /* 118 */ array(64, 66, ),
        /* 119 */ array(60, 61, ),
        /* 120 */ array(25, 26, ),
        /* 121 */ array(58, 61, ),
        /* 122 */ array(20, 55, ),
        /* 123 */ array(22, 50, ),
        /* 124 */ array(22, 55, ),
        /* 125 */ array(22, 55, ),
        /* 126 */ array(64, 66, ),
        /* 127 */ array(54, 55, ),
        /* 128 */ array(22, 55, ),
        /* 129 */ array(18, ),
        /* 130 */ array(22, ),
        /* 131 */ array(22, ),
        /* 132 */ array(22, ),
        /* 133 */ array(65, ),
        /* 134 */ array(22, ),
        /* 135 */ array(22, ),
        /* 136 */ array(22, ),
        /* 137 */ array(55, ),
        /* 138 */ array(22, ),
        /* 139 */ array(22, ),
        /* 140 */ array(22, ),
        /* 141 */ array(22, ),
        /* 142 */ array(22, ),
        /* 143 */ array(22, ),
        /* 144 */ array(22, ),
        /* 145 */ array(22, ),
        /* 146 */ array(22, ),
        /* 147 */ array(22, ),
        /* 148 */ array(22, ),
        /* 149 */ array(67, ),
        /* 150 */ array(22, ),
        /* 151 */ array(22, ),
        /* 152 */ array(22, ),
        /* 153 */ array(22, ),
        /* 154 */ array(22, ),
        /* 155 */ array(22, ),
        /* 156 */ array(22, ),
        /* 157 */ array(22, ),
        /* 158 */ array(22, ),
        /* 159 */ array(22, ),
        /* 160 */ array(22, ),
        /* 161 */ array(22, ),
        /* 162 */ array(22, ),
        /* 163 */ array(22, ),
        /* 164 */ array(22, ),
        /* 165 */ array(22, ),
        /* 166 */ array(22, ),
        /* 167 */ array(),
        /* 168 */ array(),
        /* 169 */ array(),
        /* 170 */ array(),
        /* 171 */ array(),
        /* 172 */ array(),
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
);
    static public $yy_default = array(
 /*     0 */   236,  311,  311,  311,  311,  311,  311,  311,  311,  311,
 /*    10 */   311,  311,  311,  311,  311,  311,  311,  311,  311,  311,
 /*    20 */   311,  311,  311,  311,  311,  311,  311,  311,  311,  311,
 /*    30 */   311,  311,  311,  311,  311,  311,  311,  311,  311,  311,
 /*    40 */   311,  311,  311,  311,  311,  311,  311,  311,  311,  311,
 /*    50 */   311,  311,  311,  311,  311,  311,  311,  234,  311,  311,
 /*    60 */   311,  311,  311,  311,  311,  311,  311,  311,  311,  311,
 /*    70 */   311,  311,  311,  311,  311,  311,  311,  311,  311,  311,
 /*    80 */   311,  311,  236,  236,  236,  236,  236,  236,  236,  236,
 /*    90 */   236,  236,  236,  236,  236,  236,  236,  236,  236,  236,
 /*   100 */   236,  236,  311,  311,  300,  301,  303,  311,  284,  311,
 /*   110 */   311,  311,  311,  311,  311,  302,  311,  311,  280,  311,
 /*   120 */   311,  311,  311,  311,  311,  311,  288,  311,  311,  311,
 /*   130 */   311,  311,  311,  311,  311,  311,  311,  291,  311,  311,
 /*   140 */   311,  311,  311,  311,  311,  311,  311,  311,  311,  311,
 /*   150 */   311,  311,  311,  311,  311,  311,  311,  311,  311,  311,
 /*   160 */   311,  311,  311,  311,  311,  311,  311,  262,  235,  264,
 /*   170 */   293,  305,  270,  240,  237,  277,  268,  306,  278,  304,
 /*   180 */   292,  271,  254,  255,  253,  252,  251,  256,  285,  257,
 /*   190 */   298,  299,  287,  286,  250,  249,  310,  242,  309,  308,
 /*   200 */   297,  243,  244,  248,  247,  246,  245,  258,  259,  275,
 /*   210 */   276,  274,  273,  307,  241,  279,  238,  282,  283,  281,
 /*   220 */   272,  295,  263,  294,  261,  296,  260,  265,  266,  289,
 /*   230 */   269,  267,  290,  239,
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
    const YYNOCODE = 93;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 234;
    const YYNRULE = 77;
    const YYERRORSYMBOL = 68;
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
  '$',             'T_OPEN_TAG',    'T_AND',         'T_OR',        
  'T_EQ',          'T_NE',          'T_GT',          'T_GE',        
  'T_LT',          'T_LE',          'T_IN',          'T_PLUS',      
  'T_MINUS',       'T_TIMES',       'T_DIV',         'T_MOD',       
  'T_HTML',        'T_COMMENT_OPEN',  'T_COMMENT',     'T_PRINT_OPEN',
  'T_PRINT_CLOSE',  'T_EXTENDS',     'T_CLOSE_TAG',   'T_INCLUDE',   
  'T_AUTOESCAPE',  'T_OFF',         'T_ON',          'T_END_AUTOESCAPE',
  'T_CUSTOM_TAG',  'T_AS',          'T_CUSTOM_BLOCK',  'T_CUSTOM_END',
  'T_WITH',        'T_ENDWITH',     'T_LOAD',        'T_FOR',       
  'T_CLOSEFOR',    'T_COMMA',       'T_EMPTY',       'T_IF',        
  'T_ENDIF',       'T_ELSE',        'T_IFCHANGED',   'T_ENDIFCHANGED',
  'T_IFEQUAL',     'T_END_IFEQUAL',  'T_IFNOTEQUAL',  'T_END_IFNOTEQUAL',
  'T_BLOCK',       'T_END_BLOCK',   'T_NUMERIC',     'T_FILTER',    
  'T_END_FILTER',  'T_REGROUP',     'T_BY',          'T_PIPE',      
  'T_COLON',       'T_STRING_SINGLE_INIT',  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',
  'T_STRING_DOUBLE_END',  'T_STRING_CONTENT',  'T_LPARENT',     'T_RPARENT',   
  'T_DOT',         'T_ALPHA',       'T_BRACKETS_OPEN',  'T_BRACKETS_CLOSE',
  'error',         'start',         'body',          'code',        
  'stmts',         'filtered_var',  'var_or_string',  'stmt',        
  'for_stmt',      'ifchanged_stmt',  'block_stmt',    'filter_stmt', 
  'if_stmt',       'custom_tag',    'alias',         'ifequal',     
  'varname',       'var_list',      'regroup',       'string',      
  'expr',          'fvar_or_string',  'varname_args',  's_content',   
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
 /*  21 */ "custom_tag ::= T_CUSTOM_TAG var_list T_CLOSE_TAG",
 /*  22 */ "custom_tag ::= T_CUSTOM_TAG var_list T_AS varname T_CLOSE_TAG",
 /*  23 */ "custom_tag ::= T_CUSTOM_BLOCK T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  24 */ "alias ::= T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_ENDWITH T_CLOSE_TAG",
 /*  25 */ "stmt ::= regroup",
 /*  26 */ "stmt ::= T_LOAD string",
 /*  27 */ "for_stmt ::= T_FOR varname T_IN filtered_var T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  28 */ "for_stmt ::= T_FOR varname T_COMMA varname T_IN filtered_var T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  29 */ "for_stmt ::= T_FOR varname T_IN filtered_var T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  30 */ "for_stmt ::= T_FOR varname T_COMMA varname T_IN filtered_var T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  31 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  32 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  33 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  34 */ "ifchanged_stmt ::= T_IFCHANGED var_list T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  35 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  36 */ "ifchanged_stmt ::= T_IFCHANGED var_list T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  37 */ "ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_END_IFEQUAL T_CLOSE_TAG",
 /*  38 */ "ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_END_IFEQUAL T_CLOSE_TAG",
 /*  39 */ "ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_END_IFNOTEQUAL T_CLOSE_TAG",
 /*  40 */ "ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_END_IFNOTEQUAL T_CLOSE_TAG",
 /*  41 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  42 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  43 */ "block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  44 */ "block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_NUMERIC T_CLOSE_TAG",
 /*  45 */ "filter_stmt ::= T_FILTER filtered_var T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  46 */ "regroup ::= T_REGROUP filtered_var T_BY varname T_AS varname",
 /*  47 */ "filtered_var ::= filtered_var T_PIPE varname_args",
 /*  48 */ "filtered_var ::= varname_args",
 /*  49 */ "varname_args ::= varname T_COLON var_or_string",
 /*  50 */ "varname_args ::= varname",
 /*  51 */ "var_list ::= var_list var_or_string",
 /*  52 */ "var_list ::= var_list T_COMMA var_or_string",
 /*  53 */ "var_list ::= var_or_string",
 /*  54 */ "var_or_string ::= varname",
 /*  55 */ "var_or_string ::= T_NUMERIC",
 /*  56 */ "var_or_string ::= string",
 /*  57 */ "fvar_or_string ::= filtered_var",
 /*  58 */ "fvar_or_string ::= T_NUMERIC",
 /*  59 */ "fvar_or_string ::= string",
 /*  60 */ "string ::= T_STRING_SINGLE_INIT T_STRING_SINGLE_END",
 /*  61 */ "string ::= T_STRING_DOUBLE_INIT T_STRING_DOUBLE_END",
 /*  62 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  63 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  64 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  65 */ "s_content ::= T_STRING_CONTENT",
 /*  66 */ "expr ::= expr T_AND expr",
 /*  67 */ "expr ::= expr T_OR expr",
 /*  68 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  69 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN expr",
 /*  70 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  71 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  72 */ "expr ::= fvar_or_string",
 /*  73 */ "varname ::= varname T_DOT T_ALPHA",
 /*  74 */ "varname ::= varname T_BRACKETS_OPEN var_or_string T_BRACKETS_CLOSE",
 /*  75 */ "varname ::= T_ALPHA",
 /*  76 */ "varname ::= T_CUSTOM_TAG|T_CUSTOM_BLOCK",
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
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 2 ),
  array( 'lhs' => 70, 'rhs' => 0 ),
  array( 'lhs' => 71, 'rhs' => 2 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 2 ),
  array( 'lhs' => 71, 'rhs' => 3 ),
  array( 'lhs' => 72, 'rhs' => 3 ),
  array( 'lhs' => 72, 'rhs' => 2 ),
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 3 ),
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 7 ),
  array( 'lhs' => 81, 'rhs' => 2 ),
  array( 'lhs' => 81, 'rhs' => 4 ),
  array( 'lhs' => 81, 'rhs' => 3 ),
  array( 'lhs' => 81, 'rhs' => 5 ),
  array( 'lhs' => 81, 'rhs' => 6 ),
  array( 'lhs' => 82, 'rhs' => 9 ),
  array( 'lhs' => 75, 'rhs' => 1 ),
  array( 'lhs' => 75, 'rhs' => 2 ),
  array( 'lhs' => 76, 'rhs' => 9 ),
  array( 'lhs' => 76, 'rhs' => 11 ),
  array( 'lhs' => 76, 'rhs' => 13 ),
  array( 'lhs' => 76, 'rhs' => 15 ),
  array( 'lhs' => 80, 'rhs' => 7 ),
  array( 'lhs' => 80, 'rhs' => 11 ),
  array( 'lhs' => 77, 'rhs' => 6 ),
  array( 'lhs' => 77, 'rhs' => 7 ),
  array( 'lhs' => 77, 'rhs' => 10 ),
  array( 'lhs' => 77, 'rhs' => 11 ),
  array( 'lhs' => 83, 'rhs' => 8 ),
  array( 'lhs' => 83, 'rhs' => 12 ),
  array( 'lhs' => 83, 'rhs' => 8 ),
  array( 'lhs' => 83, 'rhs' => 12 ),
  array( 'lhs' => 78, 'rhs' => 7 ),
  array( 'lhs' => 78, 'rhs' => 8 ),
  array( 'lhs' => 78, 'rhs' => 7 ),
  array( 'lhs' => 78, 'rhs' => 8 ),
  array( 'lhs' => 79, 'rhs' => 7 ),
  array( 'lhs' => 86, 'rhs' => 6 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 1 ),
  array( 'lhs' => 90, 'rhs' => 3 ),
  array( 'lhs' => 90, 'rhs' => 1 ),
  array( 'lhs' => 85, 'rhs' => 2 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 1 ),
  array( 'lhs' => 74, 'rhs' => 1 ),
  array( 'lhs' => 74, 'rhs' => 1 ),
  array( 'lhs' => 74, 'rhs' => 1 ),
  array( 'lhs' => 89, 'rhs' => 1 ),
  array( 'lhs' => 89, 'rhs' => 1 ),
  array( 'lhs' => 89, 'rhs' => 1 ),
  array( 'lhs' => 87, 'rhs' => 2 ),
  array( 'lhs' => 87, 'rhs' => 2 ),
  array( 'lhs' => 87, 'rhs' => 3 ),
  array( 'lhs' => 87, 'rhs' => 3 ),
  array( 'lhs' => 91, 'rhs' => 2 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 88, 'rhs' => 3 ),
  array( 'lhs' => 88, 'rhs' => 3 ),
  array( 'lhs' => 88, 'rhs' => 3 ),
  array( 'lhs' => 88, 'rhs' => 3 ),
  array( 'lhs' => 88, 'rhs' => 3 ),
  array( 'lhs' => 88, 'rhs' => 3 ),
  array( 'lhs' => 88, 'rhs' => 1 ),
  array( 'lhs' => 84, 'rhs' => 3 ),
  array( 'lhs' => 84, 'rhs' => 4 ),
  array( 'lhs' => 84, 'rhs' => 1 ),
  array( 'lhs' => 84, 'rhs' => 1 ),
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
        9 => 3,
        10 => 3,
        11 => 3,
        12 => 3,
        13 => 3,
        15 => 3,
        16 => 3,
        17 => 3,
        25 => 3,
        50 => 3,
        65 => 3,
        72 => 3,
        75 => 3,
        76 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        14 => 14,
        18 => 18,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
        24 => 24,
        26 => 26,
        27 => 27,
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
        43 => 41,
        42 => 42,
        44 => 42,
        45 => 45,
        46 => 46,
        47 => 47,
        52 => 47,
        48 => 48,
        53 => 48,
        49 => 49,
        51 => 51,
        54 => 54,
        55 => 55,
        58 => 55,
        56 => 56,
        59 => 56,
        57 => 57,
        60 => 60,
        61 => 60,
        62 => 62,
        63 => 62,
        64 => 64,
        66 => 66,
        67 => 66,
        68 => 66,
        70 => 66,
        69 => 69,
        71 => 71,
        73 => 73,
        74 => 74,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 65 "Compiler/Parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1522 "Compiler/Parser.php"
#line 67 "Compiler/Parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1525 "Compiler/Parser.php"
#line 68 "Compiler/Parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1528 "Compiler/Parser.php"
#line 71 "Compiler/Parser.y"
    function yy_r3(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1531 "Compiler/Parser.php"
#line 72 "Compiler/Parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1534 "Compiler/Parser.php"
#line 73 "Compiler/Parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1537 "Compiler/Parser.php"
#line 74 "Compiler/Parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1540 "Compiler/Parser.php"
#line 76 "Compiler/Parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1543 "Compiler/Parser.php"
#line 77 "Compiler/Parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1546 "Compiler/Parser.php"
#line 83 "Compiler/Parser.y"
    function yy_r14(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1549 "Compiler/Parser.php"
#line 87 "Compiler/Parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'autoescape', 'value' => strtolower(@$this->yystack[$this->yyidx + -5]->minor), 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1552 "Compiler/Parser.php"
#line 92 "Compiler/Parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1555 "Compiler/Parser.php"
#line 93 "Compiler/Parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1558 "Compiler/Parser.php"
#line 94 "Compiler/Parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1561 "Compiler/Parser.php"
#line 95 "Compiler/Parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1564 "Compiler/Parser.php"
#line 97 "Compiler/Parser.y"
    function yy_r23(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array());    }
#line 1567 "Compiler/Parser.php"
#line 100 "Compiler/Parser.y"
    function yy_r24(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1570 "Compiler/Parser.php"
#line 104 "Compiler/Parser.y"
    function yy_r26(){
    if (!is_file($this->yystack[$this->yyidx + 0]->minor)) {
        throw new Haanga_Compiler_Exception($this->yystack[$this->yyidx + 0]->minor." is not a valid file"); 
    } 
    require_once $this->yystack[$this->yyidx + 0]->minor;
    }
#line 1578 "Compiler/Parser.php"
#line 112 "Compiler/Parser.y"
    function yy_r27(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL); 
    }
#line 1583 "Compiler/Parser.php"
#line 115 "Compiler/Parser.y"
    function yy_r28(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -9]->minor); 
    }
#line 1588 "Compiler/Parser.php"
#line 118 "Compiler/Parser.y"
    function yy_r29(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL); 
    }
#line 1593 "Compiler/Parser.php"
#line 121 "Compiler/Parser.y"
    function yy_r30(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -13]->minor); 
    }
#line 1598 "Compiler/Parser.php"
#line 125 "Compiler/Parser.y"
    function yy_r31(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1601 "Compiler/Parser.php"
#line 126 "Compiler/Parser.y"
    function yy_r32(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1604 "Compiler/Parser.php"
#line 129 "Compiler/Parser.y"
    function yy_r33(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1609 "Compiler/Parser.php"
#line 133 "Compiler/Parser.y"
    function yy_r34(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1614 "Compiler/Parser.php"
#line 136 "Compiler/Parser.y"
    function yy_r35(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1619 "Compiler/Parser.php"
#line 140 "Compiler/Parser.y"
    function yy_r36(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1624 "Compiler/Parser.php"
#line 145 "Compiler/Parser.y"
    function yy_r37(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '==', 1 => $this->yystack[$this->yyidx + -6]->minor, 2 => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1627 "Compiler/Parser.php"
#line 146 "Compiler/Parser.y"
    function yy_r38(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '==', 1 => $this->yystack[$this->yyidx + -10]->minor, 2 => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1630 "Compiler/Parser.php"
#line 147 "Compiler/Parser.y"
    function yy_r39(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '!=', 1 => $this->yystack[$this->yyidx + -6]->minor, 2 => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1633 "Compiler/Parser.php"
#line 148 "Compiler/Parser.y"
    function yy_r40(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '!=', 1 => $this->yystack[$this->yyidx + -10]->minor, 2 => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1636 "Compiler/Parser.php"
#line 152 "Compiler/Parser.y"
    function yy_r41(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1639 "Compiler/Parser.php"
#line 154 "Compiler/Parser.y"
    function yy_r42(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1642 "Compiler/Parser.php"
#line 161 "Compiler/Parser.y"
    function yy_r45(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1645 "Compiler/Parser.php"
#line 164 "Compiler/Parser.y"
    function yy_r46(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1648 "Compiler/Parser.php"
#line 167 "Compiler/Parser.y"
    function yy_r47(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1651 "Compiler/Parser.php"
#line 168 "Compiler/Parser.y"
    function yy_r48(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1654 "Compiler/Parser.php"
#line 170 "Compiler/Parser.y"
    function yy_r49(){ $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, 'args'=>array($this->yystack[$this->yyidx + 0]->minor));     }
#line 1657 "Compiler/Parser.php"
#line 174 "Compiler/Parser.y"
    function yy_r51(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1660 "Compiler/Parser.php"
#line 180 "Compiler/Parser.y"
    function yy_r54(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1663 "Compiler/Parser.php"
#line 181 "Compiler/Parser.y"
    function yy_r55(){ $this->_retvalue = array('number' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1666 "Compiler/Parser.php"
#line 182 "Compiler/Parser.y"
    function yy_r56(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1669 "Compiler/Parser.php"
#line 184 "Compiler/Parser.y"
    function yy_r57(){ $this->_retvalue = array('var_filter' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1672 "Compiler/Parser.php"
#line 189 "Compiler/Parser.y"
    function yy_r60(){  $this->_retvalue = "";     }
#line 1675 "Compiler/Parser.php"
#line 191 "Compiler/Parser.y"
    function yy_r62(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1678 "Compiler/Parser.php"
#line 193 "Compiler/Parser.y"
    function yy_r64(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1681 "Compiler/Parser.php"
#line 197 "Compiler/Parser.y"
    function yy_r66(){ $this->_retvalue = array('op_expr' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1684 "Compiler/Parser.php"
#line 200 "Compiler/Parser.y"
    function yy_r69(){ $this->_retvalue = array('op_expr' => trim(@$this->yystack[$this->yyidx + -1]->minor), $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1687 "Compiler/Parser.php"
#line 202 "Compiler/Parser.y"
    function yy_r71(){ $this->_retvalue = array('op_expr' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1690 "Compiler/Parser.php"
#line 206 "Compiler/Parser.y"
    function yy_r73(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1693 "Compiler/Parser.php"
#line 207 "Compiler/Parser.y"
    function yy_r74(){ if (!is_array($this->yystack[$this->yyidx + -3]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -3]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + -1]->minor;    }
#line 1696 "Compiler/Parser.php"

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
#line 56 "Compiler/Parser.y"

    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    throw new Exception('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
#line 1816 "Compiler/Parser.php"
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
#line 44 "Compiler/Parser.y"

#line 1837 "Compiler/Parser.php"
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