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
#line 136 "lib/Haanga/Compiler/Parser.php"

// declare_class is output here
#line 39 "lib/Haanga/Compiler/Parser.y"
 class Haanga_Compiler_Parser #line 141 "lib/Haanga/Compiler/Parser.php"
{
/* First off, code is included which follows the "include_class" declaration
** in the input file. */
#line 40 "lib/Haanga/Compiler/Parser.y"


#line 149 "lib/Haanga/Compiler/Parser.php"

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
    const T_BUFFER                       = 33;
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
    const T_INTL                         = 59;
    const T_RPARENT                      = 60;
    const T_STRING_SINGLE_INIT           = 61;
    const T_STRING_SINGLE_END            = 62;
    const T_STRING_DOUBLE_INIT           = 63;
    const T_STRING_DOUBLE_END            = 64;
    const T_STRING_CONTENT               = 65;
    const T_LPARENT                      = 66;
    const T_OBJ                          = 67;
    const T_ALPHA                        = 68;
    const T_DOT                          = 69;
    const T_BRACKETS_OPEN                = 70;
    const T_BRACKETS_CLOSE               = 71;
    const YY_NO_ACTION = 322;
    const YY_ACCEPT_ACTION = 321;
    const YY_ERROR_ACTION = 320;

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
    const YY_SZ_ACTTAB = 963;
static public $yy_action = array(
 /*     0 */    38,  170,   41,  125,    1,  192,  177,   33,  177,  150,
 /*    10 */   200,   79,   73,  215,   71,   75,  230,  159,  158,   28,
 /*    20 */   171,  142,   34,   43,   30,   49,   32,  198,   67,  189,
 /*    30 */   206,   42,   38,   46,   41,  125,   80,   47,   82,   33,
 /*    40 */    81,  150,  219,   79,   73,  180,   71,   75,  177,   89,
 /*    50 */   177,   28,  216,  145,   34,  186,   30,   83,   32,  149,
 /*    60 */    67,   78,   47,   42,   38,   46,   41,  125,  199,  215,
 /*    70 */   177,   33,  177,  150,  112,   79,   73,   90,   71,   75,
 /*    80 */   177,  235,  177,   28,  147,  133,   34,  180,   30,  143,
 /*    90 */    32,   47,   67,  220,  187,   42,   38,   46,   41,  125,
 /*   100 */    80,   86,   82,   33,   81,  150,  214,   79,   73,  180,
 /*   110 */    71,   75,   21,   21,   21,   28,  157,  156,   34,  180,
 /*   120 */    30,  185,   32,  213,   67,  321,   58,   42,   38,   46,
 /*   130 */    41,  125,  221,  206,  177,   33,  177,  150,  197,   79,
 /*   140 */    73,  169,   71,   75,  138,  138,   87,   28,  204,  163,
 /*   150 */    34,  154,   30,  181,   32,  201,   67,  139,  205,   42,
 /*   160 */    38,   46,   41,  125,  190,  119,   35,   33,  228,  150,
 /*   170 */    88,   79,   73,  180,   71,   75,   80,  202,   82,   28,
 /*   180 */    81,  165,   34,  136,   30,  203,   32,  201,   67,   94,
 /*   190 */    92,   42,   38,   46,   41,  125,    7,  119,   36,   33,
 /*   200 */   228,  150,  152,   79,   73,  196,   71,   75,  210,  224,
 /*   210 */    37,   28,  171,  142,   34,   43,   30,  178,   32,  164,
 /*   220 */    67,  137,   39,   42,   38,   46,   41,  125,  191,  217,
 /*   230 */   225,   33,  207,  150,   91,   79,   73,   99,   71,   75,
 /*   240 */   194,   95,   47,   28,  101,    4,   34,  168,   30,  175,
 /*   250 */    32,  164,   67,  137,   39,   42,   38,   46,   41,  125,
 /*   260 */    13,  171,  142,   33,   43,  150,   47,   79,   73,  237,
 /*   270 */    71,   75,  227,   47,  183,   28,  171,  142,   34,   43,
 /*   280 */    30,  135,   32,  141,   67,  195,   57,   42,   38,   46,
 /*   290 */    41,  125,    8,  119,  229,   33,  228,  150,  166,   79,
 /*   300 */    73,  117,   71,   75,   56,  232,   52,   28,  171,  142,
 /*   310 */    34,   43,   30,  120,   32,  119,   67,   66,  228,   42,
 /*   320 */    38,   46,   41,  125,   55,  130,   63,   33,   53,  150,
 /*   330 */   109,   79,   73,  160,   71,   75,  112,   60,  164,   28,
 /*   340 */   137,   39,   34,  208,   30,  116,   32,  153,   67,  123,
 /*   350 */    54,   42,   38,   46,   41,  125,  122,  119,  108,   33,
 /*   360 */   228,  150,  114,   79,   73,  110,   71,   75,  111,  115,
 /*   370 */   118,   28,  113,    2,   34,  155,   30,  131,   32,  211,
 /*   380 */    67,   59,   51,   42,   38,   46,   41,  125,    6,  171,
 /*   390 */   142,   33,   43,  150,   65,   79,   73,  180,   71,   75,
 /*   400 */    48,  231,   61,   28,  171,  142,   34,   43,   30,   64,
 /*   410 */    32,  119,   67,  124,  228,   42,   38,   46,   41,  125,
 /*   420 */    20,   50,  144,   33,   62,  150,   69,   79,   73,  180,
 /*   430 */    71,   75,  180,  209,  180,   28,  171,  142,   34,   43,
 /*   440 */    30,  180,   32,  119,   67,  180,  228,   42,   38,   46,
 /*   450 */    41,  125,   10,  180,  180,   33,  180,  150,  180,   79,
 /*   460 */    73,  180,   71,   75,  180,  180,  180,   28,  171,  142,
 /*   470 */    34,   43,   30,  180,   32,  162,   67,   68,  180,   42,
 /*   480 */    38,   46,   41,  125,   16,  119,  180,   33,  228,  150,
 /*   490 */   180,   79,   73,  180,   71,   75,  180,  161,  129,   28,
 /*   500 */   171,  142,   34,   43,   30,  180,   32,  180,   67,  112,
 /*   510 */   180,   42,   38,   46,   41,  125,  208,  128,  180,   33,
 /*   520 */   180,  150,  180,   79,   73,  180,   71,   75,  112,  180,
 /*   530 */   180,   28,  151,   14,   34,  208,   30,  180,   32,  180,
 /*   540 */    67,  180,  180,   42,   38,   46,   41,  125,    5,  171,
 /*   550 */   142,   33,   43,  150,  180,   79,   73,  180,   71,   75,
 /*   560 */   180,  180,  180,   28,  171,  142,   34,   43,   30,  180,
 /*   570 */    32,  180,   67,  127,  180,   42,  140,   46,   38,   17,
 /*   580 */    41,  125,  180,  180,  112,   33,  180,  150,  180,   79,
 /*   590 */    73,  208,   71,   75,  180,  171,  142,   28,   43,    9,
 /*   600 */    34,  180,   30,  180,   32,  148,   67,  180,  180,   42,
 /*   610 */    38,   46,   41,  125,   18,  171,  142,   33,   43,  150,
 /*   620 */   180,   79,   73,    3,   71,   75,  180,   70,  180,   28,
 /*   630 */   171,  142,   34,   43,   30,  180,   32,  180,   67,  171,
 /*   640 */   142,   42,   43,   46,   15,   25,   26,   22,   22,   22,
 /*   650 */    22,   22,   22,   22,   27,   27,   21,   21,   21,  180,
 /*   660 */   171,  142,  180,   43,  164,   93,  137,   39,  180,   25,
 /*   670 */    26,   22,   22,   22,   22,   22,   22,   22,   27,   27,
 /*   680 */    21,   21,   21,   25,   26,   22,   22,   22,   22,   22,
 /*   690 */    22,   22,   27,   27,   21,   21,   21,   26,   22,   22,
 /*   700 */    22,   22,   22,   22,   22,   27,   27,   21,   21,   21,
 /*   710 */    22,   22,   22,   22,   22,   22,   22,   27,   27,   21,
 /*   720 */    21,   21,  180,   24,  176,  180,  172,  134,  182,  188,
 /*   730 */   193,  173,  238,  226,  223,  222,  233,  180,  212,  180,
 /*   740 */    85,  180,  177,   76,  177,  126,  180,  180,  180,  180,
 /*   750 */   177,   40,  177,  146,  236,  180,  112,  180,  180,  180,
 /*   760 */   177,   74,  177,  208,  112,  220,  180,  184,  180,  106,
 /*   770 */   179,  208,   80,  189,   82,  180,   81,  180,  180,  180,
 /*   780 */    80,  180,   82,  220,   81,   84,  180,   23,  180,  180,
 /*   790 */    80,  177,   82,  177,   81,  146,  180,   97,  180,  180,
 /*   800 */    40,  180,  180,  177,  180,  177,  112,  180,  180,  184,
 /*   810 */   180,  103,  179,  208,  220,   11,  180,  180,  180,  180,
 /*   820 */   180,   80,  180,   82,  180,   81,  220,  180,  180,  146,
 /*   830 */   180,  171,  142,   80,   43,   82,  180,   81,  146,  180,
 /*   840 */   112,   45,  180,  184,   12,  107,  179,  208,  146,  112,
 /*   850 */   180,  180,  184,  180,  174,  179,  208,  180,  146,  112,
 /*   860 */   171,  142,  184,   43,  104,  179,  208,  146,   77,  112,
 /*   870 */   234,  180,  184,  180,  105,  179,  208,  146,  112,  180,
 /*   880 */   180,  184,  180,  102,  179,  208,  180,  146,  112,   98,
 /*   890 */    44,  184,  146,  121,  179,  208,  218,  164,  112,  137,
 /*   900 */    39,  184,  180,  112,  132,  208,  184,  100,  146,   31,
 /*   910 */   208,  180,  180,  146,  164,   96,  137,   39,   72,  112,
 /*   920 */   180,  180,  184,  180,  112,   29,  208,  184,   19,  180,
 /*   930 */   167,  208,  180,  164,  180,  137,   39,  180,  180,  180,
 /*   940 */   164,  180,  137,   39,  171,  142,  164,   43,  137,   39,
 /*   950 */   180,  164,  180,  137,   39,  164,  180,  137,   39,  164,
 /*   960 */   180,  137,   39,
    );
    static public $yy_lookahead = array(
 /*     0 */    22,   21,   24,   25,    1,   23,   29,   29,   31,   31,
 /*    10 */    62,   33,   34,   65,   36,   37,   23,   39,   40,   41,
 /*    20 */    17,   18,   44,   20,   46,   74,   48,   62,   50,   52,
 /*    30 */    65,   53,   22,   55,   24,   25,   59,   57,   61,   29,
 /*    40 */    63,   31,   23,   33,   34,   68,   36,   37,   29,   23,
 /*    50 */    31,   41,   60,   43,   44,   23,   46,   23,   48,   49,
 /*    60 */    50,   56,   57,   53,   22,   55,   24,   25,   64,   65,
 /*    70 */    29,   29,   31,   31,   88,   33,   34,   23,   36,   37,
 /*    80 */    29,   95,   31,   41,   52,   43,   44,   68,   46,   47,
 /*    90 */    48,   57,   50,   52,   23,   53,   22,   55,   24,   25,
 /*   100 */    59,   23,   61,   29,   63,   31,   23,   33,   34,   68,
 /*   110 */    36,   37,   14,   15,   16,   41,   42,   43,   44,   68,
 /*   120 */    46,   68,   48,   23,   50,   73,   74,   53,   22,   55,
 /*   130 */    24,   25,   64,   65,   29,   29,   31,   31,   23,   33,
 /*   140 */    34,   71,   36,   37,   26,   27,   23,   41,   23,   43,
 /*   150 */    44,   45,   46,   23,   48,   78,   50,   52,   23,   53,
 /*   160 */    22,   55,   24,   25,   23,   88,   89,   29,   91,   31,
 /*   170 */    23,   33,   34,   68,   36,   37,   59,   23,   61,   41,
 /*   180 */    63,   43,   44,   45,   46,   23,   48,   78,   50,   23,
 /*   190 */    23,   53,   22,   55,   24,   25,    1,   88,   89,   29,
 /*   200 */    91,   31,   32,   33,   34,   23,   36,   37,   23,   23,
 /*   210 */    58,   41,   17,   18,   44,   20,   46,   19,   48,   67,
 /*   220 */    50,   69,   70,   53,   22,   55,   24,   25,   68,   23,
 /*   230 */    23,   29,   23,   31,   23,   33,   34,   23,   36,   37,
 /*   240 */    23,   23,   57,   41,   23,    1,   44,   45,   46,   75,
 /*   250 */    48,   67,   50,   69,   70,   53,   22,   55,   24,   25,
 /*   260 */     1,   17,   18,   29,   20,   31,   57,   33,   34,   23,
 /*   270 */    36,   37,   23,   57,   23,   41,   17,   18,   44,   20,
 /*   280 */    46,   47,   48,   78,   50,   23,   74,   53,   22,   55,
 /*   290 */    24,   25,    1,   88,   23,   29,   91,   31,   32,   33,
 /*   300 */    34,   88,   36,   37,   74,   78,   74,   41,   17,   18,
 /*   310 */    44,   20,   46,   88,   48,   88,   50,   74,   91,   53,
 /*   320 */    22,   55,   24,   25,   74,   77,   74,   29,   74,   31,
 /*   330 */    88,   33,   34,   35,   36,   37,   88,   74,   67,   41,
 /*   340 */    69,   70,   44,   95,   46,   88,   48,   78,   50,   96,
 /*   350 */    74,   53,   22,   55,   24,   25,   96,   88,   88,   29,
 /*   360 */    91,   31,   88,   33,   34,   88,   36,   37,   88,   88,
 /*   370 */    88,   41,   88,    1,   44,   45,   46,   91,   48,   91,
 /*   380 */    50,   74,   74,   53,   22,   55,   24,   25,    1,   17,
 /*   390 */    18,   29,   20,   31,   74,   33,   34,   97,   36,   37,
 /*   400 */    74,   78,   74,   41,   17,   18,   44,   20,   46,   74,
 /*   410 */    48,   88,   50,   51,   91,   53,   22,   55,   24,   25,
 /*   420 */     1,   74,   28,   29,   74,   31,   74,   33,   34,   97,
 /*   430 */    36,   37,   97,   78,   97,   41,   17,   18,   44,   20,
 /*   440 */    46,   97,   48,   88,   50,   97,   91,   53,   22,   55,
 /*   450 */    24,   25,    1,   97,   97,   29,   97,   31,   97,   33,
 /*   460 */    34,   97,   36,   37,   97,   97,   97,   41,   17,   18,
 /*   470 */    44,   20,   46,   97,   48,   78,   50,   51,   97,   53,
 /*   480 */    22,   55,   24,   25,    1,   88,   97,   29,   91,   31,
 /*   490 */    97,   33,   34,   97,   36,   37,   97,   39,   77,   41,
 /*   500 */    17,   18,   44,   20,   46,   97,   48,   97,   50,   88,
 /*   510 */    97,   53,   22,   55,   24,   25,   95,   77,   97,   29,
 /*   520 */    97,   31,   97,   33,   34,   97,   36,   37,   88,   97,
 /*   530 */    97,   41,   42,    1,   44,   95,   46,   97,   48,   97,
 /*   540 */    50,   97,   97,   53,   22,   55,   24,   25,    1,   17,
 /*   550 */    18,   29,   20,   31,   97,   33,   34,   97,   36,   37,
 /*   560 */    97,   97,   97,   41,   17,   18,   44,   20,   46,   97,
 /*   570 */    48,   97,   50,   77,   97,   53,   54,   55,   22,    1,
 /*   580 */    24,   25,   97,   97,   88,   29,   97,   31,   97,   33,
 /*   590 */    34,   95,   36,   37,   97,   17,   18,   41,   20,    1,
 /*   600 */    44,   97,   46,   97,   48,   49,   50,   97,   97,   53,
 /*   610 */    22,   55,   24,   25,    1,   17,   18,   29,   20,   31,
 /*   620 */    97,   33,   34,    1,   36,   37,   97,   30,   97,   41,
 /*   630 */    17,   18,   44,   20,   46,   97,   48,   97,   50,   17,
 /*   640 */    18,   53,   20,   55,    1,    3,    4,    5,    6,    7,
 /*   650 */     8,    9,   10,   11,   12,   13,   14,   15,   16,   97,
 /*   660 */    17,   18,   97,   20,   67,   23,   69,   70,   97,    3,
 /*   670 */     4,    5,    6,    7,    8,    9,   10,   11,   12,   13,
 /*   680 */    14,   15,   16,    3,    4,    5,    6,    7,    8,    9,
 /*   690 */    10,   11,   12,   13,   14,   15,   16,    4,    5,    6,
 /*   700 */     7,    8,    9,   10,   11,   12,   13,   14,   15,   16,
 /*   710 */     5,    6,    7,    8,    9,   10,   11,   12,   13,   14,
 /*   720 */    15,   16,   97,    2,   76,   97,   60,   79,   80,   81,
 /*   730 */    82,   83,   84,   85,   86,   87,   23,   97,   90,   97,
 /*   740 */    92,   97,   29,   30,   31,   77,   97,   97,   97,   97,
 /*   750 */    29,   38,   31,   77,   23,   97,   88,   97,   97,   97,
 /*   760 */    29,   30,   31,   95,   88,   52,   97,   91,   97,   93,
 /*   770 */    94,   95,   59,   52,   61,   97,   63,   97,   97,   97,
 /*   780 */    59,   68,   61,   52,   63,   23,   97,   66,   97,   68,
 /*   790 */    59,   29,   61,   31,   63,   77,   97,   23,   97,   68,
 /*   800 */    38,   97,   97,   29,   97,   31,   88,   97,   97,   91,
 /*   810 */    97,   93,   94,   95,   52,    1,   97,   97,   97,   97,
 /*   820 */    97,   59,   97,   61,   97,   63,   52,   97,   97,   77,
 /*   830 */    68,   17,   18,   59,   20,   61,   97,   63,   77,   97,
 /*   840 */    88,   11,   68,   91,    1,   93,   94,   95,   77,   88,
 /*   850 */    97,   97,   91,   97,   93,   94,   95,   97,   77,   88,
 /*   860 */    17,   18,   91,   20,   93,   94,   95,   77,   38,   88,
 /*   870 */    23,   97,   91,   97,   93,   94,   95,   77,   88,   97,
 /*   880 */    97,   91,   97,   93,   94,   95,   97,   77,   88,   23,
 /*   890 */    11,   91,   77,   93,   94,   95,   23,   67,   88,   69,
 /*   900 */    70,   91,   97,   88,   94,   95,   91,   23,   77,   94,
 /*   910 */    95,   97,   97,   77,   67,   23,   69,   70,   30,   88,
 /*   920 */    97,   97,   91,   97,   88,   94,   95,   91,    1,   97,
 /*   930 */    94,   95,   97,   67,   97,   69,   70,   97,   97,   97,
 /*   940 */    67,   97,   69,   70,   17,   18,   67,   20,   69,   70,
 /*   950 */    97,   67,   97,   69,   70,   67,   97,   69,   70,   67,
 /*   960 */    97,   69,   70,
);
    const YY_SHIFT_USE_DFLT = -53;
    const YY_SHIFT_MAX = 168;
    static public $yy_shift_ofst = array(
 /*     0 */   -53,  138,   42,   10,  106,   74,  -22,  170,  234,  266,
 /*    10 */   298,  202,  556,  490,  458,  426,  394,  362,  330,  522,
 /*    20 */   588,  721,  721,  721,  721,  721,  721,  721,  721,  -23,
 /*    30 */   -23,  -23,  -23,  731,  774,  713,  762,   41,   41,   41,
 /*    40 */    41,   41,   51,   51,   51,   51,   51,   51,  814,  598,
 /*    50 */   291,  244,    3,  372,  547,  532,  387,  451,  419,  578,
 /*    60 */   259,  195,  613,  622,  843,  643,  927,  105,   19,  483,
 /*    70 */    51,  117,   51,   51,   51,   51,   51,   51,   51,   51,
 /*    80 */   117,    4,  -52,  -53,  -53,  -53,  -53,  -53,  -53,  -53,
 /*    90 */   -53,  -53,  -53,  -53,  -53,  -53,  -53,  -53,  -53,  -53,
 /*   100 */   -53,  -53,  642,  666,  680,  693,  705,  705,  830,  892,
 /*   110 */   888,  884,  152,  597,  847,  879,  271,  873,  866,  184,
 /*   120 */   184,   98,   68,  -35,   32,  118,  209,  185,  -20,    5,
 /*   130 */    34,   -8,   26,   54,  -18,   -7,   71,  160,  214,  211,
 /*   140 */   207,  186,  198,  206,  217,  218,  216,  251,  249,  246,
 /*   150 */   221,  262,  182,   70,  125,  130,  123,  115,   78,   83,
 /*   160 */   100,  135,  141,  167,   53,  166,  162,  147,  154,
);
    const YY_REDUCE_USE_DFLT = -50;
    const YY_REDUCE_MAX = 101;
    static public $yy_reduce_ofst = array(
 /*     0 */    52,  648,  648,  648,  648,  648,  648,  648,  648,  648,
 /*    10 */   648,  648,  648,  648,  648,  648,  648,  648,  648,  648,
 /*    20 */   648,  761,  752,  718,  771,  781,  676,  800,  790,  836,
 /*    30 */   831,  810,  815,   77,  109,  323,  323,  355,  397,  269,
 /*    40 */   227,  205,  248,  440,  668,  496,  421,  -14,  174,  174,
 /*    50 */   174,  174,  174,  174,  174,  174,  174,  174,  174,  174,
 /*    60 */   174,  174,  174,  174,  174,  174,  174,  242,  213,  174,
 /*    70 */   225,  288,  280,  277,  274,  270,  257,  281,  284,  282,
 /*    80 */   286,  260,  253,  243,  232,  230,  250,  263,  254,  252,
 /*    90 */   347,  307,  326,  276,  350,  335,  320,  308,  328,  352,
 /*   100 */   212,  -49,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 43, 44, 45, 46, 48, 50, 53, 55, ),
        /* 2 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 43, 44, 46, 47, 48, 50, 53, 55, ),
        /* 3 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 43, 44, 46, 48, 49, 50, 53, 55, ),
        /* 4 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 43, 44, 45, 46, 48, 50, 53, 55, ),
        /* 5 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 42, 43, 44, 46, 48, 50, 53, 55, ),
        /* 6 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 39, 40, 41, 44, 46, 48, 50, 53, 55, ),
        /* 7 */ array(22, 24, 25, 29, 31, 32, 33, 34, 36, 37, 41, 44, 46, 48, 50, 53, 55, ),
        /* 8 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 47, 48, 50, 53, 55, ),
        /* 9 */ array(22, 24, 25, 29, 31, 32, 33, 34, 36, 37, 41, 44, 46, 48, 50, 53, 55, ),
        /* 10 */ array(22, 24, 25, 29, 31, 33, 34, 35, 36, 37, 41, 44, 46, 48, 50, 53, 55, ),
        /* 11 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 45, 46, 48, 50, 53, 55, ),
        /* 12 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 49, 50, 53, 55, ),
        /* 13 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 42, 44, 46, 48, 50, 53, 55, ),
        /* 14 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 39, 41, 44, 46, 48, 50, 53, 55, ),
        /* 15 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 50, 51, 53, 55, ),
        /* 16 */ array(22, 24, 25, 28, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 50, 53, 55, ),
        /* 17 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 50, 51, 53, 55, ),
        /* 18 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 45, 46, 48, 50, 53, 55, ),
        /* 19 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 50, 53, 54, 55, ),
        /* 20 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 50, 53, 55, ),
        /* 21 */ array(2, 29, 31, 52, 59, 61, 63, 66, 68, ),
        /* 22 */ array(2, 29, 31, 52, 59, 61, 63, 66, 68, ),
        /* 23 */ array(2, 29, 31, 52, 59, 61, 63, 66, 68, ),
        /* 24 */ array(2, 29, 31, 52, 59, 61, 63, 66, 68, ),
        /* 25 */ array(2, 29, 31, 52, 59, 61, 63, 66, 68, ),
        /* 26 */ array(2, 29, 31, 52, 59, 61, 63, 66, 68, ),
        /* 27 */ array(2, 29, 31, 52, 59, 61, 63, 66, 68, ),
        /* 28 */ array(2, 29, 31, 52, 59, 61, 63, 66, 68, ),
        /* 29 */ array(29, 31, 52, 59, 61, 63, 68, ),
        /* 30 */ array(29, 31, 52, 59, 61, 63, 68, ),
        /* 31 */ array(29, 31, 52, 59, 61, 63, 68, ),
        /* 32 */ array(29, 31, 52, 59, 61, 63, 68, ),
        /* 33 */ array(23, 29, 30, 31, 52, 59, 61, 63, 68, ),
        /* 34 */ array(23, 29, 31, 52, 59, 61, 63, 68, ),
        /* 35 */ array(23, 29, 30, 31, 38, 52, 59, 61, 63, 68, ),
        /* 36 */ array(23, 29, 31, 38, 52, 59, 61, 63, 68, ),
        /* 37 */ array(29, 31, 52, 59, 61, 63, 68, ),
        /* 38 */ array(29, 31, 52, 59, 61, 63, 68, ),
        /* 39 */ array(29, 31, 52, 59, 61, 63, 68, ),
        /* 40 */ array(29, 31, 52, 59, 61, 63, 68, ),
        /* 41 */ array(29, 31, 52, 59, 61, 63, 68, ),
        /* 42 */ array(29, 31, 68, ),
        /* 43 */ array(29, 31, 68, ),
        /* 44 */ array(29, 31, 68, ),
        /* 45 */ array(29, 31, 68, ),
        /* 46 */ array(29, 31, 68, ),
        /* 47 */ array(29, 31, 68, ),
        /* 48 */ array(1, 17, 18, 20, ),
        /* 49 */ array(1, 17, 18, 20, ),
        /* 50 */ array(1, 17, 18, 20, ),
        /* 51 */ array(1, 17, 18, 20, ),
        /* 52 */ array(1, 17, 18, 20, ),
        /* 53 */ array(1, 17, 18, 20, ),
        /* 54 */ array(1, 17, 18, 20, ),
        /* 55 */ array(1, 17, 18, 20, ),
        /* 56 */ array(1, 17, 18, 20, ),
        /* 57 */ array(1, 17, 18, 20, ),
        /* 58 */ array(1, 17, 18, 20, ),
        /* 59 */ array(1, 17, 18, 20, ),
        /* 60 */ array(1, 17, 18, 20, ),
        /* 61 */ array(1, 17, 18, 20, ),
        /* 62 */ array(1, 17, 18, 20, ),
        /* 63 */ array(1, 17, 18, 20, ),
        /* 64 */ array(1, 17, 18, 20, ),
        /* 65 */ array(1, 17, 18, 20, ),
        /* 66 */ array(1, 17, 18, 20, ),
        /* 67 */ array(29, 31, 52, 68, ),
        /* 68 */ array(23, 29, 31, 68, ),
        /* 69 */ array(1, 17, 18, 20, ),
        /* 70 */ array(29, 31, 68, ),
        /* 71 */ array(59, 61, 63, ),
        /* 72 */ array(29, 31, 68, ),
        /* 73 */ array(29, 31, 68, ),
        /* 74 */ array(29, 31, 68, ),
        /* 75 */ array(29, 31, 68, ),
        /* 76 */ array(29, 31, 68, ),
        /* 77 */ array(29, 31, 68, ),
        /* 78 */ array(29, 31, 68, ),
        /* 79 */ array(29, 31, 68, ),
        /* 80 */ array(59, 61, 63, ),
        /* 81 */ array(64, 65, ),
        /* 82 */ array(62, 65, ),
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
        /* 102 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 23, ),
        /* 103 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 60, ),
        /* 104 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 105 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 106 */ array(5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 107 */ array(5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 108 */ array(11, 38, 67, 69, 70, ),
        /* 109 */ array(23, 67, 69, 70, ),
        /* 110 */ array(30, 67, 69, 70, ),
        /* 111 */ array(23, 67, 69, 70, ),
        /* 112 */ array(58, 67, 69, 70, ),
        /* 113 */ array(30, 67, 69, 70, ),
        /* 114 */ array(23, 67, 69, 70, ),
        /* 115 */ array(11, 67, 69, 70, ),
        /* 116 */ array(23, 67, 69, 70, ),
        /* 117 */ array(23, 67, 69, 70, ),
        /* 118 */ array(23, 67, 69, 70, ),
        /* 119 */ array(67, 69, 70, ),
        /* 120 */ array(67, 69, 70, ),
        /* 121 */ array(14, 15, 16, ),
        /* 122 */ array(64, 65, ),
        /* 123 */ array(62, 65, ),
        /* 124 */ array(23, 52, ),
        /* 125 */ array(26, 27, ),
        /* 126 */ array(23, 57, ),
        /* 127 */ array(23, 57, ),
        /* 128 */ array(21, 57, ),
        /* 129 */ array(56, 57, ),
        /* 130 */ array(23, 57, ),
        /* 131 */ array(60, ),
        /* 132 */ array(23, ),
        /* 133 */ array(23, ),
        /* 134 */ array(23, ),
        /* 135 */ array(23, ),
        /* 136 */ array(23, ),
        /* 137 */ array(68, ),
        /* 138 */ array(23, ),
        /* 139 */ array(23, ),
        /* 140 */ array(23, ),
        /* 141 */ array(23, ),
        /* 142 */ array(19, ),
        /* 143 */ array(23, ),
        /* 144 */ array(23, ),
        /* 145 */ array(23, ),
        /* 146 */ array(57, ),
        /* 147 */ array(23, ),
        /* 148 */ array(23, ),
        /* 149 */ array(23, ),
        /* 150 */ array(23, ),
        /* 151 */ array(23, ),
        /* 152 */ array(23, ),
        /* 153 */ array(71, ),
        /* 154 */ array(23, ),
        /* 155 */ array(23, ),
        /* 156 */ array(23, ),
        /* 157 */ array(23, ),
        /* 158 */ array(23, ),
        /* 159 */ array(23, ),
        /* 160 */ array(23, ),
        /* 161 */ array(23, ),
        /* 162 */ array(23, ),
        /* 163 */ array(23, ),
        /* 164 */ array(68, ),
        /* 165 */ array(23, ),
        /* 166 */ array(23, ),
        /* 167 */ array(23, ),
        /* 168 */ array(23, ),
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
        /* 234 */ array(),
        /* 235 */ array(),
        /* 236 */ array(),
        /* 237 */ array(),
        /* 238 */ array(),
);
    static public $yy_default = array(
 /*     0 */   241,  320,  320,  320,  320,  320,  320,  320,  320,  320,
 /*    10 */   320,  320,  320,  320,  320,  320,  320,  320,  320,  320,
 /*    20 */   320,  320,  320,  320,  320,  320,  320,  320,  320,  320,
 /*    30 */   320,  320,  320,  320,  320,  320,  320,  320,  320,  320,
 /*    40 */   320,  320,  320,  320,  320,  320,  320,  320,  320,  320,
 /*    50 */   320,  320,  320,  320,  320,  320,  320,  320,  239,  320,
 /*    60 */   320,  320,  320,  320,  320,  320,  320,  320,  320,  320,
 /*    70 */   320,  320,  320,  320,  320,  320,  320,  320,  320,  320,
 /*    80 */   320,  320,  320,  241,  241,  241,  241,  241,  241,  241,
 /*    90 */   241,  241,  241,  241,  241,  241,  241,  241,  241,  241,
 /*   100 */   241,  241,  320,  320,  307,  308,  309,  311,  320,  320,
 /*   110 */   320,  320,  290,  320,  320,  320,  320,  320,  320,  294,
 /*   120 */   286,  310,  320,  320,  320,  320,  320,  320,  320,  320,
 /*   130 */   320,  320,  320,  320,  320,  320,  320,  320,  320,  320,
 /*   140 */   320,  320,  320,  320,  320,  320,  297,  320,  320,  320,
 /*   150 */   320,  320,  320,  320,  320,  320,  320,  320,  320,  320,
 /*   160 */   320,  320,  320,  320,  320,  320,  320,  320,  320,  317,
 /*   170 */   245,  243,  313,  251,  312,  240,  242,  319,  244,  314,
 /*   180 */   318,  276,  248,  284,  299,  315,  283,  274,  249,  298,
 /*   190 */   246,  316,  247,  250,  257,  272,  263,  271,  303,  302,
 /*   200 */   301,  293,  275,  262,  273,  270,  305,  268,  288,  289,
 /*   210 */   267,  266,  265,  264,  269,  306,  300,  277,  282,  281,
 /*   220 */   295,  304,  256,  255,  253,  285,  254,  280,  296,  261,
 /*   230 */   278,  291,  292,  260,  259,  287,  258,  279,  252,
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
    const YYNOCODE = 98;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 239;
    const YYNRULE = 81;
    const YYERRORSYMBOL = 72;
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
  'T_CUSTOM_END',  'T_BUFFER',      'T_WITH',        'T_ENDWITH',   
  'T_LOAD',        'T_FOR',         'T_COMMA',       'T_CLOSEFOR',  
  'T_EMPTY',       'T_IF',          'T_ENDIF',       'T_ELSE',      
  'T_IFCHANGED',   'T_ENDIFCHANGED',  'T_IFEQUAL',     'T_END_IFEQUAL',
  'T_IFNOTEQUAL',  'T_END_IFNOTEQUAL',  'T_BLOCK',       'T_END_BLOCK', 
  'T_NUMERIC',     'T_FILTER',      'T_END_FILTER',  'T_REGROUP',   
  'T_BY',          'T_PIPE',        'T_COLON',       'T_INTL',      
  'T_RPARENT',     'T_STRING_SINGLE_INIT',  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',
  'T_STRING_DOUBLE_END',  'T_STRING_CONTENT',  'T_LPARENT',     'T_OBJ',       
  'T_ALPHA',       'T_DOT',         'T_BRACKETS_OPEN',  'T_BRACKETS_CLOSE',
  'error',         'start',         'body',          'code',        
  'stmts',         'filtered_var',  'var_or_string',  'stmt',        
  'for_stmt',      'ifchanged_stmt',  'block_stmt',    'filter_stmt', 
  'if_stmt',       'custom_tag',    'alias',         'ifequal',     
  'varname',       'var_list',      'regroup',       'string',      
  'for_def',       'expr',          'fvar_or_string',  'varname_args',
  's_content',   
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
 /*  24 */ "custom_tag ::= T_BUFFER varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  25 */ "alias ::= T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_ENDWITH T_CLOSE_TAG",
 /*  26 */ "stmt ::= regroup",
 /*  27 */ "stmt ::= T_LOAD string",
 /*  28 */ "for_def ::= T_FOR varname T_IN filtered_var T_CLOSE_TAG",
 /*  29 */ "for_def ::= T_FOR varname T_COMMA varname T_IN filtered_var T_CLOSE_TAG",
 /*  30 */ "for_stmt ::= for_def body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  31 */ "for_stmt ::= for_def body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  32 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  33 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  34 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  35 */ "ifchanged_stmt ::= T_IFCHANGED var_list T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  36 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  37 */ "ifchanged_stmt ::= T_IFCHANGED var_list T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  38 */ "ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_END_IFEQUAL T_CLOSE_TAG",
 /*  39 */ "ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_END_IFEQUAL T_CLOSE_TAG",
 /*  40 */ "ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_END_IFNOTEQUAL T_CLOSE_TAG",
 /*  41 */ "ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_END_IFNOTEQUAL T_CLOSE_TAG",
 /*  42 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  43 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  44 */ "block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  45 */ "block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_NUMERIC T_CLOSE_TAG",
 /*  46 */ "filter_stmt ::= T_FILTER filtered_var T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  47 */ "regroup ::= T_REGROUP filtered_var T_BY varname T_AS varname",
 /*  48 */ "filtered_var ::= filtered_var T_PIPE varname_args",
 /*  49 */ "filtered_var ::= varname_args",
 /*  50 */ "varname_args ::= varname T_COLON var_or_string",
 /*  51 */ "varname_args ::= varname",
 /*  52 */ "var_list ::= var_list var_or_string",
 /*  53 */ "var_list ::= var_list T_COMMA var_or_string",
 /*  54 */ "var_list ::= var_or_string",
 /*  55 */ "var_or_string ::= varname",
 /*  56 */ "var_or_string ::= T_NUMERIC",
 /*  57 */ "var_or_string ::= string",
 /*  58 */ "fvar_or_string ::= filtered_var",
 /*  59 */ "fvar_or_string ::= T_NUMERIC",
 /*  60 */ "fvar_or_string ::= string",
 /*  61 */ "string ::= T_INTL string T_RPARENT",
 /*  62 */ "string ::= T_STRING_SINGLE_INIT T_STRING_SINGLE_END",
 /*  63 */ "string ::= T_STRING_DOUBLE_INIT T_STRING_DOUBLE_END",
 /*  64 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  65 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  66 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  67 */ "s_content ::= T_STRING_CONTENT",
 /*  68 */ "expr ::= T_NOT expr",
 /*  69 */ "expr ::= expr T_AND expr",
 /*  70 */ "expr ::= expr T_OR expr",
 /*  71 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  72 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN expr",
 /*  73 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  74 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  75 */ "expr ::= fvar_or_string",
 /*  76 */ "varname ::= varname T_OBJ T_ALPHA",
 /*  77 */ "varname ::= varname T_DOT T_ALPHA",
 /*  78 */ "varname ::= varname T_BRACKETS_OPEN var_or_string T_BRACKETS_CLOSE",
 /*  79 */ "varname ::= T_ALPHA",
 /*  80 */ "varname ::= T_CUSTOM_TAG|T_CUSTOM_BLOCK",
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
  array( 'lhs' => 73, 'rhs' => 1 ),
  array( 'lhs' => 74, 'rhs' => 2 ),
  array( 'lhs' => 74, 'rhs' => 0 ),
  array( 'lhs' => 75, 'rhs' => 2 ),
  array( 'lhs' => 75, 'rhs' => 1 ),
  array( 'lhs' => 75, 'rhs' => 2 ),
  array( 'lhs' => 75, 'rhs' => 3 ),
  array( 'lhs' => 76, 'rhs' => 3 ),
  array( 'lhs' => 76, 'rhs' => 2 ),
  array( 'lhs' => 76, 'rhs' => 1 ),
  array( 'lhs' => 76, 'rhs' => 1 ),
  array( 'lhs' => 76, 'rhs' => 1 ),
  array( 'lhs' => 76, 'rhs' => 1 ),
  array( 'lhs' => 76, 'rhs' => 1 ),
  array( 'lhs' => 76, 'rhs' => 3 ),
  array( 'lhs' => 76, 'rhs' => 1 ),
  array( 'lhs' => 76, 'rhs' => 1 ),
  array( 'lhs' => 76, 'rhs' => 1 ),
  array( 'lhs' => 76, 'rhs' => 7 ),
  array( 'lhs' => 85, 'rhs' => 2 ),
  array( 'lhs' => 85, 'rhs' => 4 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 5 ),
  array( 'lhs' => 85, 'rhs' => 6 ),
  array( 'lhs' => 85, 'rhs' => 7 ),
  array( 'lhs' => 86, 'rhs' => 9 ),
  array( 'lhs' => 79, 'rhs' => 1 ),
  array( 'lhs' => 79, 'rhs' => 2 ),
  array( 'lhs' => 92, 'rhs' => 5 ),
  array( 'lhs' => 92, 'rhs' => 7 ),
  array( 'lhs' => 80, 'rhs' => 5 ),
  array( 'lhs' => 80, 'rhs' => 9 ),
  array( 'lhs' => 84, 'rhs' => 7 ),
  array( 'lhs' => 84, 'rhs' => 11 ),
  array( 'lhs' => 81, 'rhs' => 6 ),
  array( 'lhs' => 81, 'rhs' => 7 ),
  array( 'lhs' => 81, 'rhs' => 10 ),
  array( 'lhs' => 81, 'rhs' => 11 ),
  array( 'lhs' => 87, 'rhs' => 8 ),
  array( 'lhs' => 87, 'rhs' => 12 ),
  array( 'lhs' => 87, 'rhs' => 8 ),
  array( 'lhs' => 87, 'rhs' => 12 ),
  array( 'lhs' => 82, 'rhs' => 7 ),
  array( 'lhs' => 82, 'rhs' => 8 ),
  array( 'lhs' => 82, 'rhs' => 7 ),
  array( 'lhs' => 82, 'rhs' => 8 ),
  array( 'lhs' => 83, 'rhs' => 7 ),
  array( 'lhs' => 90, 'rhs' => 6 ),
  array( 'lhs' => 77, 'rhs' => 3 ),
  array( 'lhs' => 77, 'rhs' => 1 ),
  array( 'lhs' => 95, 'rhs' => 3 ),
  array( 'lhs' => 95, 'rhs' => 1 ),
  array( 'lhs' => 89, 'rhs' => 2 ),
  array( 'lhs' => 89, 'rhs' => 3 ),
  array( 'lhs' => 89, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
  array( 'lhs' => 94, 'rhs' => 1 ),
  array( 'lhs' => 94, 'rhs' => 1 ),
  array( 'lhs' => 94, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 3 ),
  array( 'lhs' => 91, 'rhs' => 2 ),
  array( 'lhs' => 91, 'rhs' => 2 ),
  array( 'lhs' => 91, 'rhs' => 3 ),
  array( 'lhs' => 91, 'rhs' => 3 ),
  array( 'lhs' => 96, 'rhs' => 2 ),
  array( 'lhs' => 96, 'rhs' => 1 ),
  array( 'lhs' => 93, 'rhs' => 2 ),
  array( 'lhs' => 93, 'rhs' => 3 ),
  array( 'lhs' => 93, 'rhs' => 3 ),
  array( 'lhs' => 93, 'rhs' => 3 ),
  array( 'lhs' => 93, 'rhs' => 3 ),
  array( 'lhs' => 93, 'rhs' => 3 ),
  array( 'lhs' => 93, 'rhs' => 3 ),
  array( 'lhs' => 93, 'rhs' => 1 ),
  array( 'lhs' => 88, 'rhs' => 3 ),
  array( 'lhs' => 88, 'rhs' => 3 ),
  array( 'lhs' => 88, 'rhs' => 4 ),
  array( 'lhs' => 88, 'rhs' => 1 ),
  array( 'lhs' => 88, 'rhs' => 1 ),
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
        26 => 3,
        51 => 3,
        67 => 3,
        75 => 3,
        79 => 3,
        80 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        61 => 8,
        14 => 14,
        18 => 18,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
        24 => 24,
        25 => 25,
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
        42 => 42,
        44 => 42,
        43 => 43,
        45 => 43,
        46 => 46,
        47 => 47,
        48 => 48,
        53 => 48,
        49 => 49,
        54 => 49,
        50 => 50,
        52 => 52,
        55 => 55,
        56 => 56,
        59 => 56,
        57 => 57,
        60 => 57,
        58 => 58,
        62 => 62,
        63 => 62,
        64 => 64,
        65 => 64,
        66 => 66,
        68 => 68,
        69 => 69,
        70 => 69,
        71 => 69,
        73 => 69,
        72 => 72,
        74 => 74,
        76 => 76,
        77 => 77,
        78 => 78,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 66 "lib/Haanga/Compiler/Parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1547 "lib/Haanga/Compiler/Parser.php"
#line 68 "lib/Haanga/Compiler/Parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1550 "lib/Haanga/Compiler/Parser.php"
#line 69 "lib/Haanga/Compiler/Parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1553 "lib/Haanga/Compiler/Parser.php"
#line 72 "lib/Haanga/Compiler/Parser.y"
    function yy_r3(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1556 "lib/Haanga/Compiler/Parser.php"
#line 73 "lib/Haanga/Compiler/Parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1559 "lib/Haanga/Compiler/Parser.php"
#line 74 "lib/Haanga/Compiler/Parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1562 "lib/Haanga/Compiler/Parser.php"
#line 75 "lib/Haanga/Compiler/Parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1565 "lib/Haanga/Compiler/Parser.php"
#line 77 "lib/Haanga/Compiler/Parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1568 "lib/Haanga/Compiler/Parser.php"
#line 78 "lib/Haanga/Compiler/Parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1571 "lib/Haanga/Compiler/Parser.php"
#line 84 "lib/Haanga/Compiler/Parser.y"
    function yy_r14(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1574 "lib/Haanga/Compiler/Parser.php"
#line 88 "lib/Haanga/Compiler/Parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'autoescape', 'value' => strtolower(@$this->yystack[$this->yyidx + -5]->minor), 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1577 "lib/Haanga/Compiler/Parser.php"
#line 93 "lib/Haanga/Compiler/Parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1580 "lib/Haanga/Compiler/Parser.php"
#line 94 "lib/Haanga/Compiler/Parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1583 "lib/Haanga/Compiler/Parser.php"
#line 95 "lib/Haanga/Compiler/Parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1586 "lib/Haanga/Compiler/Parser.php"
#line 96 "lib/Haanga/Compiler/Parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1589 "lib/Haanga/Compiler/Parser.php"
#line 98 "lib/Haanga/Compiler/Parser.y"
    function yy_r23(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array());    }
#line 1592 "lib/Haanga/Compiler/Parser.php"
#line 99 "lib/Haanga/Compiler/Parser.y"
    function yy_r24(){ if ('endbuffer' != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'buffer', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);    }
#line 1595 "lib/Haanga/Compiler/Parser.php"
#line 102 "lib/Haanga/Compiler/Parser.y"
    function yy_r25(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1598 "lib/Haanga/Compiler/Parser.php"
#line 106 "lib/Haanga/Compiler/Parser.y"
    function yy_r27(){
    if (!is_file($this->yystack[$this->yyidx + 0]->minor)) {
        throw new Haanga_Compiler_Exception($this->yystack[$this->yyidx + 0]->minor." is not a valid file"); 
    } 
    require_once $this->yystack[$this->yyidx + 0]->minor;
    }
#line 1606 "lib/Haanga/Compiler/Parser.php"
#line 114 "lib/Haanga/Compiler/Parser.y"
    function yy_r28(){
    $this->compiler->set_context($this->yystack[$this->yyidx + -3]->minor, array());
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL, 'array' => $this->yystack[$this->yyidx + -1]->minor);
    }
#line 1612 "lib/Haanga/Compiler/Parser.php"
#line 119 "lib/Haanga/Compiler/Parser.y"
    function yy_r29(){
    $this->compiler->set_context($this->yystack[$this->yyidx + -3]->minor, array());
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -5]->minor, 'array' => $this->yystack[$this->yyidx + -1]->minor);
    }
#line 1618 "lib/Haanga/Compiler/Parser.php"
#line 125 "lib/Haanga/Compiler/Parser.y"
    function yy_r30(){ 
    $this->_retvalue = $this->yystack[$this->yyidx + -4]->minor;
    $this->_retvalue['body'] = $this->yystack[$this->yyidx + -3]->minor;
    }
#line 1624 "lib/Haanga/Compiler/Parser.php"
#line 130 "lib/Haanga/Compiler/Parser.y"
    function yy_r31(){ 
    $this->_retvalue = $this->yystack[$this->yyidx + -8]->minor;
    $this->_retvalue['body']  = $this->yystack[$this->yyidx + -7]->minor;
    $this->_retvalue['empty'] = $this->yystack[$this->yyidx + -3]->minor;
    }
#line 1631 "lib/Haanga/Compiler/Parser.php"
#line 136 "lib/Haanga/Compiler/Parser.y"
    function yy_r32(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1634 "lib/Haanga/Compiler/Parser.php"
#line 137 "lib/Haanga/Compiler/Parser.y"
    function yy_r33(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1637 "lib/Haanga/Compiler/Parser.php"
#line 140 "lib/Haanga/Compiler/Parser.y"
    function yy_r34(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1642 "lib/Haanga/Compiler/Parser.php"
#line 144 "lib/Haanga/Compiler/Parser.y"
    function yy_r35(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1647 "lib/Haanga/Compiler/Parser.php"
#line 147 "lib/Haanga/Compiler/Parser.y"
    function yy_r36(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1652 "lib/Haanga/Compiler/Parser.php"
#line 151 "lib/Haanga/Compiler/Parser.y"
    function yy_r37(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1657 "lib/Haanga/Compiler/Parser.php"
#line 156 "lib/Haanga/Compiler/Parser.y"
    function yy_r38(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '==', 1 => $this->yystack[$this->yyidx + -6]->minor, 2 => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1660 "lib/Haanga/Compiler/Parser.php"
#line 157 "lib/Haanga/Compiler/Parser.y"
    function yy_r39(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '==', 1 => $this->yystack[$this->yyidx + -10]->minor, 2 => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1663 "lib/Haanga/Compiler/Parser.php"
#line 158 "lib/Haanga/Compiler/Parser.y"
    function yy_r40(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '!=', 1 => $this->yystack[$this->yyidx + -6]->minor, 2 => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1666 "lib/Haanga/Compiler/Parser.php"
#line 159 "lib/Haanga/Compiler/Parser.y"
    function yy_r41(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '!=', 1 => $this->yystack[$this->yyidx + -10]->minor, 2 => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1669 "lib/Haanga/Compiler/Parser.php"
#line 163 "lib/Haanga/Compiler/Parser.y"
    function yy_r42(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1672 "lib/Haanga/Compiler/Parser.php"
#line 165 "lib/Haanga/Compiler/Parser.y"
    function yy_r43(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1675 "lib/Haanga/Compiler/Parser.php"
#line 172 "lib/Haanga/Compiler/Parser.y"
    function yy_r46(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1678 "lib/Haanga/Compiler/Parser.php"
#line 175 "lib/Haanga/Compiler/Parser.y"
    function yy_r47(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1681 "lib/Haanga/Compiler/Parser.php"
#line 178 "lib/Haanga/Compiler/Parser.y"
    function yy_r48(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1684 "lib/Haanga/Compiler/Parser.php"
#line 179 "lib/Haanga/Compiler/Parser.y"
    function yy_r49(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1687 "lib/Haanga/Compiler/Parser.php"
#line 181 "lib/Haanga/Compiler/Parser.y"
    function yy_r50(){ $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, 'args'=>array($this->yystack[$this->yyidx + 0]->minor));     }
#line 1690 "lib/Haanga/Compiler/Parser.php"
#line 185 "lib/Haanga/Compiler/Parser.y"
    function yy_r52(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1693 "lib/Haanga/Compiler/Parser.php"
#line 191 "lib/Haanga/Compiler/Parser.y"
    function yy_r55(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1696 "lib/Haanga/Compiler/Parser.php"
#line 192 "lib/Haanga/Compiler/Parser.y"
    function yy_r56(){ $this->_retvalue = array('number' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1699 "lib/Haanga/Compiler/Parser.php"
#line 193 "lib/Haanga/Compiler/Parser.y"
    function yy_r57(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1702 "lib/Haanga/Compiler/Parser.php"
#line 195 "lib/Haanga/Compiler/Parser.y"
    function yy_r58(){ $this->_retvalue = array('var_filter' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1705 "lib/Haanga/Compiler/Parser.php"
#line 201 "lib/Haanga/Compiler/Parser.y"
    function yy_r62(){  $this->_retvalue = "";     }
#line 1708 "lib/Haanga/Compiler/Parser.php"
#line 203 "lib/Haanga/Compiler/Parser.y"
    function yy_r64(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1711 "lib/Haanga/Compiler/Parser.php"
#line 205 "lib/Haanga/Compiler/Parser.y"
    function yy_r66(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1714 "lib/Haanga/Compiler/Parser.php"
#line 209 "lib/Haanga/Compiler/Parser.y"
    function yy_r68(){ $this->_retvalue = array('op_expr' => 'not', $this->yystack[$this->yyidx + 0]->minor);     }
#line 1717 "lib/Haanga/Compiler/Parser.php"
#line 210 "lib/Haanga/Compiler/Parser.y"
    function yy_r69(){ $this->_retvalue = array('op_expr' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1720 "lib/Haanga/Compiler/Parser.php"
#line 213 "lib/Haanga/Compiler/Parser.y"
    function yy_r72(){ $this->_retvalue = array('op_expr' => trim(@$this->yystack[$this->yyidx + -1]->minor), $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1723 "lib/Haanga/Compiler/Parser.php"
#line 215 "lib/Haanga/Compiler/Parser.y"
    function yy_r74(){ $this->_retvalue = array('op_expr' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1726 "lib/Haanga/Compiler/Parser.php"
#line 219 "lib/Haanga/Compiler/Parser.y"
    function yy_r76(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=array('object' => $this->yystack[$this->yyidx + 0]->minor);    }
#line 1729 "lib/Haanga/Compiler/Parser.php"
#line 220 "lib/Haanga/Compiler/Parser.y"
    function yy_r77(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; } $this->_retvalue[] = ($this->compiler->var_is_object($this->_retvalue)) ? array('object' => $this->yystack[$this->yyidx + 0]->minor) : $this->yystack[$this->yyidx + 0]->minor;    }
#line 1732 "lib/Haanga/Compiler/Parser.php"
#line 221 "lib/Haanga/Compiler/Parser.y"
    function yy_r78(){ if (!is_array($this->yystack[$this->yyidx + -3]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -3]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + -1]->minor;    }
#line 1735 "lib/Haanga/Compiler/Parser.php"

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
#line 57 "lib/Haanga/Compiler/Parser.y"

    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    throw new Exception('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
#line 1855 "lib/Haanga/Compiler/Parser.php"
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
#line 44 "lib/Haanga/Compiler/Parser.y"

#line 1876 "lib/Haanga/Compiler/Parser.php"
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