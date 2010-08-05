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
    const T_COMMA                        = 36;
    const T_CLOSEFOR                     = 37;
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
    const T_INTL                         = 57;
    const T_RPARENT                      = 58;
    const T_STRING_SINGLE_INIT           = 59;
    const T_STRING_SINGLE_END            = 60;
    const T_STRING_DOUBLE_INIT           = 61;
    const T_STRING_DOUBLE_END            = 62;
    const T_STRING_CONTENT               = 63;
    const T_LPARENT                      = 64;
    const T_OBJ                          = 65;
    const T_ALPHA                        = 66;
    const T_DOT                          = 67;
    const T_BRACKETS_OPEN                = 68;
    const T_BRACKETS_CLOSE               = 69;
    const YY_NO_ACTION = 311;
    const YY_ACCEPT_ACTION = 310;
    const YY_ERROR_ACTION = 309;

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
    const YY_SZ_ACTTAB = 913;
static public $yy_action = array(
 /*     0 */    39,  121,   35,  116,   21,   21,   21,   31,  225,  149,
 /*    10 */   225,   76,  111,   67,   69,  111,  164,   37,   25,  186,
 /*    20 */   124,   32,  201,   29,  127,   30,  152,   46,  143,   36,
 /*    30 */    44,   39,   40,   35,  116,   12,  145,  145,   31,   71,
 /*    40 */   149,   77,   76,   78,   67,   69,  218,  147,  141,   25,
 /*    50 */   180,  131,   32,   43,   29,   81,   30,  227,   46,   75,
 /*    60 */    45,   44,   39,   40,   35,  116,  208,  112,   34,   31,
 /*    70 */   171,  149,   95,   76,   91,   67,   69,  225,  155,  225,
 /*    80 */    25,  162,  156,   32,  158,   29,  103,   30,  112,   46,
 /*    90 */   117,  171,   44,   39,   40,   35,  116,  173,  206,  136,
 /*   100 */    31,  111,  149,  185,   76,   45,   67,   69,  186,  125,
 /*   110 */   115,   25,  196,  133,   32,  218,   29,   52,   30,  134,
 /*   120 */    46,  111,  178,   44,   39,   40,   35,  116,  186,  229,
 /*   130 */   227,   31,   45,  149,  203,   76,   45,   67,   69,  174,
 /*   140 */   112,   33,   25,  171,  159,   32,  160,   29,  205,   30,
 /*   150 */   152,   46,  143,   36,   44,   39,   40,   35,  116,  118,
 /*   160 */   213,  119,   31,  211,  149,  176,   76,   45,   67,   69,
 /*   170 */   111,  197,  111,   25,  144,  153,   32,  186,   29,  186,
 /*   180 */    30,  112,   46,  204,  171,   44,   39,   40,   35,  116,
 /*   190 */   207,  211,  226,   31,   85,  149,  221,   76,  214,   67,
 /*   200 */    69,  212,  169,  225,   25,  225,  187,   32,   90,   29,
 /*   210 */   172,   30,  129,   46,  310,   59,   44,   39,   40,   35,
 /*   220 */   116,  209,  212,  166,   31,  168,  149,  228,   76,   92,
 /*   230 */    67,   69,   71,  137,   77,   25,   78,  181,   32,  157,
 /*   240 */    29,  218,   30,  112,   46,  199,  171,   44,   39,   40,
 /*   250 */    35,  116,   93,   83,   65,   31,  120,  149,  122,   76,
 /*   260 */    84,   67,   69,  105,  193,  225,   25,  225,  188,   32,
 /*   270 */    48,   29,  126,   30,  112,   46,   58,  171,   44,   39,
 /*   280 */    40,   35,  116,   66,  183,   50,   31,  175,  149,  114,
 /*   290 */    76,  150,   67,   69,   71,  151,   77,   25,   78,   45,
 /*   300 */    32,  138,   29,  218,   30,  112,   46,  104,  171,   44,
 /*   310 */    39,   40,   35,  116,    3,  108,  191,   31,  102,  149,
 /*   320 */   110,   76,  107,   67,   69,  106,  198,  109,   25,  180,
 /*   330 */   131,   32,   43,   29,   41,   30,  112,   46,   55,  171,
 /*   340 */    44,   39,   40,   35,  116,   51,   47,  140,   31,  177,
 /*   350 */   149,   57,   76,   86,   67,   69,   89,  216,   63,   25,
 /*   360 */    70,  182,   32,  225,   29,  225,   30,   54,   46,  210,
 /*   370 */    49,   44,   39,   40,   35,  116,   61,   56,   82,   31,
 /*   380 */    53,  149,  148,   76,  179,   67,   69,   60,   64,  152,
 /*   390 */    25,  143,   36,   32,   62,   29,  176,   30,  217,   46,
 /*   400 */   176,  218,   44,   39,   40,   35,  116,    5,  176,  176,
 /*   410 */    31,  176,  149,  176,   76,  176,   67,   69,  176,  176,
 /*   420 */   176,   25,  180,  131,   32,   43,   29,   42,   30,  176,
 /*   430 */    46,  123,  176,   44,   39,   40,   35,  116,    9,  176,
 /*   440 */   176,   31,  176,  149,  176,   76,  176,   67,   69,  176,
 /*   450 */   154,  176,   25,  180,  131,   32,   43,   29,  176,   30,
 /*   460 */   176,   46,  176,  176,   44,   39,   40,   35,  116,  176,
 /*   470 */   176,  176,   31,  176,  149,  176,   76,  176,   67,   69,
 /*   480 */   176,  176,  152,   25,  143,   36,   32,  146,   29,  176,
 /*   490 */    30,  176,   46,  176,  176,   44,   39,   40,   35,  116,
 /*   500 */    10,  176,  176,   31,  176,  149,  176,   76,  176,   67,
 /*   510 */    69,  176,  176,  176,   25,  180,  131,   32,   43,   29,
 /*   520 */   176,   30,  176,   46,  176,  176,   44,  132,   40,   39,
 /*   530 */   176,   35,  116,  176,  176,  176,   31,  176,  149,  176,
 /*   540 */    76,  176,   67,   69,  176,  176,  176,   25,  139,  176,
 /*   550 */    32,  176,   29,  176,   30,  225,   46,  225,  176,   44,
 /*   560 */   176,   40,   24,   26,   22,   22,   22,   22,   22,   22,
 /*   570 */    22,   23,   23,   21,   21,   21,   39,  168,   35,  116,
 /*   580 */    17,  176,   79,   31,   71,  149,   77,   76,   78,   67,
 /*   590 */    69,   20,  176,  218,   25,  180,  131,   32,   43,   29,
 /*   600 */   176,   30,  176,   46,  176,  176,   44,  176,   40,   24,
 /*   610 */    26,   22,   22,   22,   22,   22,   22,   22,   23,   23,
 /*   620 */    21,   21,   21,   26,   22,   22,   22,   22,   22,   22,
 /*   630 */    22,   23,   23,   21,   21,   21,   22,   22,   22,   22,
 /*   640 */    22,   22,   22,   23,   23,   21,   21,   21,  161,  176,
 /*   650 */   176,  128,  224,  223,  219,  220,  222,  189,  190,  192,
 /*   660 */   202,    6,  200,  184,   94,  167,  225,   73,  225,  225,
 /*   670 */    74,  225,  176,  176,   38,   88,  180,  131,   87,   43,
 /*   680 */   176,  225,  176,  225,  225,  176,  225,  176,  175,   38,
 /*   690 */   176,  175,  176,  176,  176,   71,  176,   77,   71,   78,
 /*   700 */    77,  176,   78,  175,  218,  176,  175,  218,  176,  142,
 /*   710 */    71,  176,   77,   71,   78,   77,  176,   78,  142,  218,
 /*   720 */   111,  176,  218,  170,   16,   97,  165,  186,  176,  111,
 /*   730 */   142,  176,  170,  176,  163,  165,  186,  176,  142,  180,
 /*   740 */   131,  111,   43,  176,  170,  176,  100,  165,  186,  111,
 /*   750 */   142,  176,  170,  176,  113,  165,  186,  176,  176,  142,
 /*   760 */   176,  111,  176,  176,  170,  176,   99,  165,  186,  176,
 /*   770 */   111,  142,  176,  170,  176,  101,  165,  186,  176,  142,
 /*   780 */   176,  176,  111,  176,  176,  170,  176,   98,  165,  186,
 /*   790 */   111,  142,  176,  170,  176,  176,   28,  186,  176,  142,
 /*   800 */   176,  142,  111,  176,  176,  170,  176,    1,   27,  186,
 /*   810 */   111,   11,  111,  170,  176,  170,  135,  186,  130,  186,
 /*   820 */     2,  176,  180,  131,   15,   43,  180,  131,    8,   43,
 /*   830 */   195,  176,   19,  176,   96,  180,  131,    7,   43,  180,
 /*   840 */   131,   18,   43,  180,  131,   72,   43,  180,  131,   13,
 /*   850 */    43,  194,  180,  131,   14,   43,  180,  131,  176,   43,
 /*   860 */    80,  176,   68,  176,  180,  131,  215,   43,  176,  180,
 /*   870 */   131,    4,   43,  152,  176,  143,   36,  152,  176,  143,
 /*   880 */    36,  152,  176,  143,   36,  176,  180,  131,  176,   43,
 /*   890 */   176,  176,  176,  176,  152,  176,  143,   36,  152,  176,
 /*   900 */   143,   36,  176,  152,  176,  143,   36,  176,  176,  152,
 /*   910 */   176,  143,   36,
    );
    static public $yy_lookahead = array(
 /*     0 */    21,   75,   23,   24,   13,   14,   15,   28,   28,   30,
 /*    10 */    30,   32,   86,   34,   35,   86,   73,   56,   39,   93,
 /*    20 */    41,   42,   93,   44,   45,   46,   65,   48,   67,   68,
 /*    30 */    51,   21,   53,   23,   24,    1,   25,   26,   28,   57,
 /*    40 */    30,   59,   32,   61,   34,   35,   66,   37,   38,   39,
 /*    50 */    16,   17,   42,   19,   44,   22,   46,   76,   48,   54,
 /*    60 */    55,   51,   21,   53,   23,   24,   22,   86,   87,   28,
 /*    70 */    89,   30,   22,   32,   22,   34,   35,   28,   76,   30,
 /*    80 */    39,   22,   41,   42,   43,   44,   86,   46,   86,   48,
 /*    90 */    75,   89,   51,   21,   53,   23,   24,   20,   22,   50,
 /*   100 */    28,   86,   30,   22,   32,   55,   34,   35,   93,   50,
 /*   110 */    75,   39,   22,   41,   42,   66,   44,   72,   46,   47,
 /*   120 */    48,   86,   18,   51,   21,   53,   23,   24,   93,   22,
 /*   130 */    76,   28,   55,   30,   22,   32,   55,   34,   35,   22,
 /*   140 */    86,   87,   39,   89,   41,   42,   43,   44,   22,   46,
 /*   150 */    65,   48,   67,   68,   51,   21,   53,   23,   24,   75,
 /*   160 */    60,   75,   28,   63,   30,   66,   32,   55,   34,   35,
 /*   170 */    86,   76,   86,   39,   40,   41,   42,   93,   44,   93,
 /*   180 */    46,   86,   48,   89,   89,   51,   21,   53,   23,   24,
 /*   190 */    62,   63,   22,   28,   22,   30,   22,   32,   60,   34,
 /*   200 */    35,   63,   22,   28,   39,   30,   22,   42,   22,   44,
 /*   210 */    66,   46,   47,   48,   71,   72,   51,   21,   53,   23,
 /*   220 */    24,   62,   63,   22,   28,   50,   30,   22,   32,   22,
 /*   230 */    34,   35,   57,   76,   59,   39,   61,   22,   42,   43,
 /*   240 */    44,   66,   46,   86,   48,   22,   89,   51,   21,   53,
 /*   250 */    23,   24,   22,   22,   72,   28,   94,   30,   94,   32,
 /*   260 */    22,   34,   35,   86,   76,   28,   39,   30,   22,   42,
 /*   270 */    72,   44,   45,   46,   86,   48,   72,   89,   51,   21,
 /*   280 */    53,   23,   24,   72,   22,   72,   28,   50,   30,   86,
 /*   290 */    32,   33,   34,   35,   57,   76,   59,   39,   61,   55,
 /*   300 */    42,   89,   44,   66,   46,   86,   48,   86,   89,   51,
 /*   310 */    21,   53,   23,   24,    1,   86,   22,   28,   86,   30,
 /*   320 */    86,   32,   86,   34,   35,   86,   76,   86,   39,   16,
 /*   330 */    17,   42,   19,   44,   10,   46,   86,   48,   49,   89,
 /*   340 */    51,   21,   53,   23,   24,   72,   72,   27,   28,   22,
 /*   350 */    30,   72,   32,   22,   34,   35,   22,   22,   72,   39,
 /*   360 */    36,   22,   42,   28,   44,   30,   46,   72,   48,   22,
 /*   370 */    72,   51,   21,   53,   23,   24,   72,   72,   22,   28,
 /*   380 */    72,   30,   31,   32,   58,   34,   35,   72,   72,   65,
 /*   390 */    39,   67,   68,   42,   72,   44,   95,   46,   69,   48,
 /*   400 */    95,   66,   51,   21,   53,   23,   24,    1,   95,   95,
 /*   410 */    28,   95,   30,   95,   32,   95,   34,   35,   95,   95,
 /*   420 */    95,   39,   16,   17,   42,   19,   44,   10,   46,   95,
 /*   430 */    48,   49,   95,   51,   21,   53,   23,   24,    1,   95,
 /*   440 */    95,   28,   95,   30,   95,   32,   95,   34,   35,   95,
 /*   450 */    37,   95,   39,   16,   17,   42,   19,   44,   95,   46,
 /*   460 */    95,   48,   95,   95,   51,   21,   53,   23,   24,   95,
 /*   470 */    95,   95,   28,   95,   30,   95,   32,   95,   34,   35,
 /*   480 */    95,   95,   65,   39,   67,   68,   42,   43,   44,   95,
 /*   490 */    46,   95,   48,   95,   95,   51,   21,   53,   23,   24,
 /*   500 */     1,   95,   95,   28,   95,   30,   95,   32,   95,   34,
 /*   510 */    35,   95,   95,   95,   39,   16,   17,   42,   19,   44,
 /*   520 */    95,   46,   95,   48,   95,   95,   51,   52,   53,   21,
 /*   530 */    95,   23,   24,   95,   95,   95,   28,   95,   30,   95,
 /*   540 */    32,   95,   34,   35,   95,   95,   95,   39,   40,   95,
 /*   550 */    42,   95,   44,   95,   46,   28,   48,   30,   95,   51,
 /*   560 */    95,   53,    2,    3,    4,    5,    6,    7,    8,    9,
 /*   570 */    10,   11,   12,   13,   14,   15,   21,   50,   23,   24,
 /*   580 */     1,   95,   22,   28,   57,   30,   59,   32,   61,   34,
 /*   590 */    35,   64,   95,   66,   39,   16,   17,   42,   19,   44,
 /*   600 */    95,   46,   95,   48,   95,   95,   51,   95,   53,    2,
 /*   610 */     3,    4,    5,    6,    7,    8,    9,   10,   11,   12,
 /*   620 */    13,   14,   15,    3,    4,    5,    6,    7,    8,    9,
 /*   630 */    10,   11,   12,   13,   14,   15,    4,    5,    6,    7,
 /*   640 */     8,    9,   10,   11,   12,   13,   14,   15,   74,   95,
 /*   650 */    95,   77,   78,   79,   80,   81,   82,   83,   84,   85,
 /*   660 */    22,    1,   88,   22,   90,   58,   28,   29,   30,   28,
 /*   670 */    29,   30,   95,   95,   36,   22,   16,   17,   22,   19,
 /*   680 */    95,   28,   95,   30,   28,   95,   30,   95,   50,   36,
 /*   690 */    95,   50,   95,   95,   95,   57,   95,   59,   57,   61,
 /*   700 */    59,   95,   61,   50,   66,   95,   50,   66,   95,   75,
 /*   710 */    57,   95,   59,   57,   61,   59,   95,   61,   75,   66,
 /*   720 */    86,   95,   66,   89,    1,   91,   92,   93,   95,   86,
 /*   730 */    75,   95,   89,   95,   91,   92,   93,   95,   75,   16,
 /*   740 */    17,   86,   19,   95,   89,   95,   91,   92,   93,   86,
 /*   750 */    75,   95,   89,   95,   91,   92,   93,   95,   95,   75,
 /*   760 */    95,   86,   95,   95,   89,   95,   91,   92,   93,   95,
 /*   770 */    86,   75,   95,   89,   95,   91,   92,   93,   95,   75,
 /*   780 */    95,   95,   86,   95,   95,   89,   95,   91,   92,   93,
 /*   790 */    86,   75,   95,   89,   95,   95,   92,   93,   95,   75,
 /*   800 */    95,   75,   86,   95,   95,   89,   95,    1,   92,   93,
 /*   810 */    86,    1,   86,   89,   95,   89,   92,   93,   92,   93,
 /*   820 */     1,   95,   16,   17,    1,   19,   16,   17,    1,   19,
 /*   830 */    22,   95,    1,   95,   22,   16,   17,    1,   19,   16,
 /*   840 */    17,    1,   19,   16,   17,   29,   19,   16,   17,    1,
 /*   850 */    19,   22,   16,   17,    1,   19,   16,   17,   95,   19,
 /*   860 */    22,   95,   29,   95,   16,   17,   22,   19,   95,   16,
 /*   870 */    17,    1,   19,   65,   95,   67,   68,   65,   95,   67,
 /*   880 */    68,   65,   95,   67,   68,   95,   16,   17,   95,   19,
 /*   890 */    95,   95,   95,   95,   65,   95,   67,   68,   65,   95,
 /*   900 */    67,   68,   95,   65,   95,   67,   68,   95,   95,   65,
 /*   910 */    95,   67,   68,
);
    const YY_SHIFT_USE_DFLT = -40;
    const YY_SHIFT_MAX = 160;
    static public $yy_shift_ofst = array(
 /*     0 */   -40,  134,  103,  -21,   41,   72,   10,  475,  508,  196,
 /*    10 */   227,  165,  289,  382,  320,  351,  444,  258,  413,  555,
 /*    20 */   527,  527,  527,  527,  527,  527,  527,  175,  175,  175,
 /*    30 */   175,  641,  656,  638,  653,  237,  237,  237,  237,  237,
 /*    40 */   -20,  -20,  -20,  -20,  -20,  -20,   49,  313,   34,  499,
 /*    50 */   823,  810,  579,  723,  660,  335,  406,  827,  836,  831,
 /*    60 */   848,  840,  870,  437,  819,  806,  853,  -18,  -20,  -20,
 /*    70 */   -20,  -18,  -20,  -20,  -20,  -20,  -20,  100,  128,  -40,
 /*    80 */   -40,  -40,  -40,  -40,  -40,  -40,  -40,  -40,  -40,  -40,
 /*    90 */   -40,  -40,  -40,  -40,  -40,  -40,  -40,  607,  560,  620,
 /*   100 */   632,  632,  324,  844,  833,  816,  838,  829,  417,  808,
 /*   110 */   812,  -39,   85,   -9,   85,   50,   11,   77,    5,   81,
 /*   120 */   159,  112,  138,   59,  230,  201,  170,  205,  215,   44,
 /*   130 */    52,  104,  107,  231,  347,  334,  331,  329,  326,  294,
 /*   140 */   262,  238,  244,  144,  246,  356,  327,  339,   90,   33,
 /*   150 */   223,  180,   99,  186,  184,  126,  172,  174,  117,  207,
 /*   160 */    76,
);
    const YY_REDUCE_USE_DFLT = -75;
    const YY_REDUCE_MAX = 96;
    static public $yy_reduce_ofst = array(
 /*     0 */   143,  574,  574,  574,  574,  574,  574,  574,  574,  574,
 /*    10 */   574,  574,  574,  574,  574,  574,  574,  574,  574,  574,
 /*    20 */   634,  643,  655,  663,  675,  696,  684,  724,  726,  704,
 /*    30 */   716,   54,  -19,   95,   95,    2,  157,  188,  250,  219,
 /*    40 */    84,  -74,   86,   15,   35,  -71,  239,  -57,  -57,  -57,
 /*    50 */   -57,  -57,  -57,  -57,  -57,    0,  -57,  -57,  -57,  -57,
 /*    60 */   -57,  -57,  -57,  -57,  -57,  -57,  -57,   94,  203,  232,
 /*    70 */   229,  212,  234,  241,  236,  221,  177,  164,  162,  182,
 /*    80 */   198,  213,  211,  273,  304,  308,  315,  316,  322,  305,
 /*    90 */   279,  274,  286,  298,  295,  204,   45,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 40, 41, 42, 44, 46, 48, 51, 53, ),
        /* 2 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 41, 42, 43, 44, 46, 48, 51, 53, ),
        /* 3 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 41, 42, 44, 45, 46, 48, 51, 53, ),
        /* 4 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 41, 42, 43, 44, 46, 48, 51, 53, ),
        /* 5 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 41, 42, 44, 46, 47, 48, 51, 53, ),
        /* 6 */ array(21, 23, 24, 28, 30, 32, 34, 35, 37, 38, 39, 42, 44, 46, 48, 51, 53, ),
        /* 7 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 42, 44, 46, 48, 51, 52, 53, ),
        /* 8 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 40, 42, 44, 46, 48, 51, 53, ),
        /* 9 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 42, 43, 44, 46, 48, 51, 53, ),
        /* 10 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 42, 44, 45, 46, 48, 51, 53, ),
        /* 11 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 42, 44, 46, 47, 48, 51, 53, ),
        /* 12 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 42, 44, 46, 48, 49, 51, 53, ),
        /* 13 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 42, 44, 46, 48, 49, 51, 53, ),
        /* 14 */ array(21, 23, 24, 27, 28, 30, 32, 34, 35, 39, 42, 44, 46, 48, 51, 53, ),
        /* 15 */ array(21, 23, 24, 28, 30, 31, 32, 34, 35, 39, 42, 44, 46, 48, 51, 53, ),
        /* 16 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 42, 43, 44, 46, 48, 51, 53, ),
        /* 17 */ array(21, 23, 24, 28, 30, 32, 33, 34, 35, 39, 42, 44, 46, 48, 51, 53, ),
        /* 18 */ array(21, 23, 24, 28, 30, 32, 34, 35, 37, 39, 42, 44, 46, 48, 51, 53, ),
        /* 19 */ array(21, 23, 24, 28, 30, 32, 34, 35, 39, 42, 44, 46, 48, 51, 53, ),
        /* 20 */ array(28, 30, 50, 57, 59, 61, 64, 66, ),
        /* 21 */ array(28, 30, 50, 57, 59, 61, 64, 66, ),
        /* 22 */ array(28, 30, 50, 57, 59, 61, 64, 66, ),
        /* 23 */ array(28, 30, 50, 57, 59, 61, 64, 66, ),
        /* 24 */ array(28, 30, 50, 57, 59, 61, 64, 66, ),
        /* 25 */ array(28, 30, 50, 57, 59, 61, 64, 66, ),
        /* 26 */ array(28, 30, 50, 57, 59, 61, 64, 66, ),
        /* 27 */ array(28, 30, 50, 57, 59, 61, 66, ),
        /* 28 */ array(28, 30, 50, 57, 59, 61, 66, ),
        /* 29 */ array(28, 30, 50, 57, 59, 61, 66, ),
        /* 30 */ array(28, 30, 50, 57, 59, 61, 66, ),
        /* 31 */ array(22, 28, 29, 30, 50, 57, 59, 61, 66, ),
        /* 32 */ array(22, 28, 30, 50, 57, 59, 61, 66, ),
        /* 33 */ array(22, 28, 29, 30, 36, 50, 57, 59, 61, 66, ),
        /* 34 */ array(22, 28, 30, 36, 50, 57, 59, 61, 66, ),
        /* 35 */ array(28, 30, 50, 57, 59, 61, 66, ),
        /* 36 */ array(28, 30, 50, 57, 59, 61, 66, ),
        /* 37 */ array(28, 30, 50, 57, 59, 61, 66, ),
        /* 38 */ array(28, 30, 50, 57, 59, 61, 66, ),
        /* 39 */ array(28, 30, 50, 57, 59, 61, 66, ),
        /* 40 */ array(28, 30, 66, ),
        /* 41 */ array(28, 30, 66, ),
        /* 42 */ array(28, 30, 66, ),
        /* 43 */ array(28, 30, 66, ),
        /* 44 */ array(28, 30, 66, ),
        /* 45 */ array(28, 30, 66, ),
        /* 46 */ array(28, 30, 50, 66, ),
        /* 47 */ array(1, 16, 17, 19, ),
        /* 48 */ array(1, 16, 17, 19, ),
        /* 49 */ array(1, 16, 17, 19, ),
        /* 50 */ array(1, 16, 17, 19, ),
        /* 51 */ array(1, 16, 17, 19, ),
        /* 52 */ array(1, 16, 17, 19, ),
        /* 53 */ array(1, 16, 17, 19, ),
        /* 54 */ array(1, 16, 17, 19, ),
        /* 55 */ array(22, 28, 30, 66, ),
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
        /* 67 */ array(57, 59, 61, ),
        /* 68 */ array(28, 30, 66, ),
        /* 69 */ array(28, 30, 66, ),
        /* 70 */ array(28, 30, 66, ),
        /* 71 */ array(57, 59, 61, ),
        /* 72 */ array(28, 30, 66, ),
        /* 73 */ array(28, 30, 66, ),
        /* 74 */ array(28, 30, 66, ),
        /* 75 */ array(28, 30, 66, ),
        /* 76 */ array(28, 30, 66, ),
        /* 77 */ array(60, 63, ),
        /* 78 */ array(62, 63, ),
        /* 79 */ array(),
        /* 80 */ array(),
        /* 81 */ array(),
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
        /* 97 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 58, ),
        /* 98 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 22, ),
        /* 99 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 100 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 101 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 102 */ array(10, 36, 65, 67, 68, ),
        /* 103 */ array(22, 65, 67, 68, ),
        /* 104 */ array(29, 65, 67, 68, ),
        /* 105 */ array(29, 65, 67, 68, ),
        /* 106 */ array(22, 65, 67, 68, ),
        /* 107 */ array(22, 65, 67, 68, ),
        /* 108 */ array(10, 65, 67, 68, ),
        /* 109 */ array(22, 65, 67, 68, ),
        /* 110 */ array(22, 65, 67, 68, ),
        /* 111 */ array(56, 65, 67, 68, ),
        /* 112 */ array(65, 67, 68, ),
        /* 113 */ array(13, 14, 15, ),
        /* 114 */ array(65, 67, 68, ),
        /* 115 */ array(22, 55, ),
        /* 116 */ array(25, 26, ),
        /* 117 */ array(20, 55, ),
        /* 118 */ array(54, 55, ),
        /* 119 */ array(22, 55, ),
        /* 120 */ array(62, 63, ),
        /* 121 */ array(22, 55, ),
        /* 122 */ array(60, 63, ),
        /* 123 */ array(22, 50, ),
        /* 124 */ array(22, ),
        /* 125 */ array(22, ),
        /* 126 */ array(22, ),
        /* 127 */ array(22, ),
        /* 128 */ array(22, ),
        /* 129 */ array(22, ),
        /* 130 */ array(22, ),
        /* 131 */ array(18, ),
        /* 132 */ array(22, ),
        /* 133 */ array(22, ),
        /* 134 */ array(22, ),
        /* 135 */ array(22, ),
        /* 136 */ array(22, ),
        /* 137 */ array(69, ),
        /* 138 */ array(58, ),
        /* 139 */ array(22, ),
        /* 140 */ array(22, ),
        /* 141 */ array(22, ),
        /* 142 */ array(55, ),
        /* 143 */ array(66, ),
        /* 144 */ array(22, ),
        /* 145 */ array(22, ),
        /* 146 */ array(22, ),
        /* 147 */ array(22, ),
        /* 148 */ array(22, ),
        /* 149 */ array(22, ),
        /* 150 */ array(22, ),
        /* 151 */ array(22, ),
        /* 152 */ array(66, ),
        /* 153 */ array(22, ),
        /* 154 */ array(22, ),
        /* 155 */ array(22, ),
        /* 156 */ array(22, ),
        /* 157 */ array(22, ),
        /* 158 */ array(22, ),
        /* 159 */ array(22, ),
        /* 160 */ array(22, ),
        /* 161 */ array(),
        /* 162 */ array(),
        /* 163 */ array(),
        /* 164 */ array(),
        /* 165 */ array(),
        /* 166 */ array(),
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
);
    static public $yy_default = array(
 /*     0 */   232,  309,  309,  309,  309,  309,  309,  309,  309,  309,
 /*    10 */   309,  309,  309,  309,  309,  309,  309,  309,  309,  309,
 /*    20 */   309,  309,  309,  309,  309,  309,  309,  309,  309,  309,
 /*    30 */   309,  309,  309,  309,  309,  309,  309,  309,  309,  309,
 /*    40 */   309,  309,  309,  309,  309,  309,  309,  309,  309,  309,
 /*    50 */   309,  309,  309,  309,  309,  309,  309,  309,  309,  230,
 /*    60 */   309,  309,  309,  309,  309,  309,  309,  309,  309,  309,
 /*    70 */   309,  309,  309,  309,  309,  309,  309,  309,  309,  232,
 /*    80 */   232,  232,  232,  232,  232,  232,  232,  232,  232,  232,
 /*    90 */   232,  232,  232,  232,  232,  232,  232,  309,  309,  297,
 /*   100 */   300,  298,  309,  309,  309,  309,  309,  309,  309,  309,
 /*   110 */   309,  280,  284,  299,  276,  309,  309,  309,  309,  309,
 /*   120 */   309,  309,  309,  309,  309,  309,  309,  309,  309,  309,
 /*   130 */   309,  309,  309,  309,  309,  309,  309,  309,  309,  309,
 /*   140 */   309,  309,  287,  309,  309,  309,  309,  309,  309,  309,
 /*   150 */   309,  309,  309,  309,  309,  309,  309,  309,  309,  309,
 /*   160 */   309,  233,  273,  301,  231,  303,  274,  302,  288,  237,
 /*   170 */   289,  286,  305,  236,  264,  285,  304,  266,  235,  290,
 /*   180 */   234,  238,  259,  248,  249,  258,  278,  260,  261,  245,
 /*   190 */   246,  262,  247,  279,  250,  252,  253,  281,  282,  254,
 /*   200 */   255,  277,  251,  257,  256,  244,  263,  292,  270,  294,
 /*   210 */   269,  296,  295,  291,  293,  272,  271,  306,  307,  241,
 /*   220 */   242,  265,  243,  240,  239,  308,  268,  283,  267,  275,
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
    const YYNOCODE = 96;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 230;
    const YYNRULE = 79;
    const YYERRORSYMBOL = 70;
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
  'T_COMMA',       'T_CLOSEFOR',    'T_EMPTY',       'T_IF',        
  'T_ENDIF',       'T_ELSE',        'T_IFCHANGED',   'T_ENDIFCHANGED',
  'T_IFEQUAL',     'T_END_IFEQUAL',  'T_IFNOTEQUAL',  'T_END_IFNOTEQUAL',
  'T_BLOCK',       'T_END_BLOCK',   'T_NUMERIC',     'T_FILTER',    
  'T_END_FILTER',  'T_REGROUP',     'T_BY',          'T_PIPE',      
  'T_COLON',       'T_INTL',        'T_RPARENT',     'T_STRING_SINGLE_INIT',
  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',  'T_STRING_DOUBLE_END',  'T_STRING_CONTENT',
  'T_LPARENT',     'T_OBJ',         'T_ALPHA',       'T_DOT',       
  'T_BRACKETS_OPEN',  'T_BRACKETS_CLOSE',  'error',         'start',       
  'body',          'code',          'stmts',         'filtered_var',
  'var_or_string',  'stmt',          'for_stmt',      'ifchanged_stmt',
  'block_stmt',    'filter_stmt',   'if_stmt',       'custom_tag',  
  'alias',         'ifequal',       'varname',       'var_list',    
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
 /*  21 */ "custom_tag ::= T_CUSTOM_TAG var_list T_CLOSE_TAG",
 /*  22 */ "custom_tag ::= T_CUSTOM_TAG var_list T_AS varname T_CLOSE_TAG",
 /*  23 */ "custom_tag ::= T_CUSTOM_BLOCK T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  24 */ "alias ::= T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_ENDWITH T_CLOSE_TAG",
 /*  25 */ "stmt ::= regroup",
 /*  26 */ "stmt ::= T_LOAD string",
 /*  27 */ "for_def ::= T_FOR varname T_IN filtered_var T_CLOSE_TAG",
 /*  28 */ "for_def ::= T_FOR varname T_COMMA varname T_IN filtered_var T_CLOSE_TAG",
 /*  29 */ "for_stmt ::= for_def body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  30 */ "for_stmt ::= for_def body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
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
 /*  60 */ "string ::= T_INTL string T_RPARENT",
 /*  61 */ "string ::= T_STRING_SINGLE_INIT T_STRING_SINGLE_END",
 /*  62 */ "string ::= T_STRING_DOUBLE_INIT T_STRING_DOUBLE_END",
 /*  63 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  64 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  65 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  66 */ "s_content ::= T_STRING_CONTENT",
 /*  67 */ "expr ::= expr T_AND expr",
 /*  68 */ "expr ::= expr T_OR expr",
 /*  69 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  70 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN expr",
 /*  71 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  72 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  73 */ "expr ::= fvar_or_string",
 /*  74 */ "varname ::= varname T_OBJ T_ALPHA",
 /*  75 */ "varname ::= varname T_DOT T_ALPHA",
 /*  76 */ "varname ::= varname T_BRACKETS_OPEN var_or_string T_BRACKETS_CLOSE",
 /*  77 */ "varname ::= T_ALPHA",
 /*  78 */ "varname ::= T_CUSTOM_TAG|T_CUSTOM_BLOCK",
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
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 2 ),
  array( 'lhs' => 72, 'rhs' => 0 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 1 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 74, 'rhs' => 3 ),
  array( 'lhs' => 74, 'rhs' => 2 ),
  array( 'lhs' => 74, 'rhs' => 1 ),
  array( 'lhs' => 74, 'rhs' => 1 ),
  array( 'lhs' => 74, 'rhs' => 1 ),
  array( 'lhs' => 74, 'rhs' => 1 ),
  array( 'lhs' => 74, 'rhs' => 1 ),
  array( 'lhs' => 74, 'rhs' => 3 ),
  array( 'lhs' => 74, 'rhs' => 1 ),
  array( 'lhs' => 74, 'rhs' => 1 ),
  array( 'lhs' => 74, 'rhs' => 1 ),
  array( 'lhs' => 74, 'rhs' => 7 ),
  array( 'lhs' => 83, 'rhs' => 2 ),
  array( 'lhs' => 83, 'rhs' => 4 ),
  array( 'lhs' => 83, 'rhs' => 3 ),
  array( 'lhs' => 83, 'rhs' => 5 ),
  array( 'lhs' => 83, 'rhs' => 6 ),
  array( 'lhs' => 84, 'rhs' => 9 ),
  array( 'lhs' => 77, 'rhs' => 1 ),
  array( 'lhs' => 77, 'rhs' => 2 ),
  array( 'lhs' => 90, 'rhs' => 5 ),
  array( 'lhs' => 90, 'rhs' => 7 ),
  array( 'lhs' => 78, 'rhs' => 5 ),
  array( 'lhs' => 78, 'rhs' => 9 ),
  array( 'lhs' => 82, 'rhs' => 7 ),
  array( 'lhs' => 82, 'rhs' => 11 ),
  array( 'lhs' => 79, 'rhs' => 6 ),
  array( 'lhs' => 79, 'rhs' => 7 ),
  array( 'lhs' => 79, 'rhs' => 10 ),
  array( 'lhs' => 79, 'rhs' => 11 ),
  array( 'lhs' => 85, 'rhs' => 8 ),
  array( 'lhs' => 85, 'rhs' => 12 ),
  array( 'lhs' => 85, 'rhs' => 8 ),
  array( 'lhs' => 85, 'rhs' => 12 ),
  array( 'lhs' => 80, 'rhs' => 7 ),
  array( 'lhs' => 80, 'rhs' => 8 ),
  array( 'lhs' => 80, 'rhs' => 7 ),
  array( 'lhs' => 80, 'rhs' => 8 ),
  array( 'lhs' => 81, 'rhs' => 7 ),
  array( 'lhs' => 88, 'rhs' => 6 ),
  array( 'lhs' => 75, 'rhs' => 3 ),
  array( 'lhs' => 75, 'rhs' => 1 ),
  array( 'lhs' => 93, 'rhs' => 3 ),
  array( 'lhs' => 93, 'rhs' => 1 ),
  array( 'lhs' => 87, 'rhs' => 2 ),
  array( 'lhs' => 87, 'rhs' => 3 ),
  array( 'lhs' => 87, 'rhs' => 1 ),
  array( 'lhs' => 76, 'rhs' => 1 ),
  array( 'lhs' => 76, 'rhs' => 1 ),
  array( 'lhs' => 76, 'rhs' => 1 ),
  array( 'lhs' => 92, 'rhs' => 1 ),
  array( 'lhs' => 92, 'rhs' => 1 ),
  array( 'lhs' => 92, 'rhs' => 1 ),
  array( 'lhs' => 89, 'rhs' => 3 ),
  array( 'lhs' => 89, 'rhs' => 2 ),
  array( 'lhs' => 89, 'rhs' => 2 ),
  array( 'lhs' => 89, 'rhs' => 3 ),
  array( 'lhs' => 89, 'rhs' => 3 ),
  array( 'lhs' => 94, 'rhs' => 2 ),
  array( 'lhs' => 94, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 3 ),
  array( 'lhs' => 91, 'rhs' => 3 ),
  array( 'lhs' => 91, 'rhs' => 3 ),
  array( 'lhs' => 91, 'rhs' => 3 ),
  array( 'lhs' => 91, 'rhs' => 3 ),
  array( 'lhs' => 91, 'rhs' => 3 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 4 ),
  array( 'lhs' => 86, 'rhs' => 1 ),
  array( 'lhs' => 86, 'rhs' => 1 ),
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
        66 => 3,
        73 => 3,
        77 => 3,
        78 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        60 => 8,
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
        61 => 61,
        62 => 61,
        63 => 63,
        64 => 63,
        65 => 65,
        67 => 67,
        68 => 67,
        69 => 67,
        71 => 67,
        70 => 70,
        72 => 72,
        74 => 74,
        75 => 75,
        76 => 76,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 65 "lib/Haanga/Compiler/Parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1517 "lib/Haanga/Compiler/Parser.php"
#line 67 "lib/Haanga/Compiler/Parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1520 "lib/Haanga/Compiler/Parser.php"
#line 68 "lib/Haanga/Compiler/Parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1523 "lib/Haanga/Compiler/Parser.php"
#line 71 "lib/Haanga/Compiler/Parser.y"
    function yy_r3(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1526 "lib/Haanga/Compiler/Parser.php"
#line 72 "lib/Haanga/Compiler/Parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1529 "lib/Haanga/Compiler/Parser.php"
#line 73 "lib/Haanga/Compiler/Parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1532 "lib/Haanga/Compiler/Parser.php"
#line 74 "lib/Haanga/Compiler/Parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1535 "lib/Haanga/Compiler/Parser.php"
#line 76 "lib/Haanga/Compiler/Parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1538 "lib/Haanga/Compiler/Parser.php"
#line 77 "lib/Haanga/Compiler/Parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1541 "lib/Haanga/Compiler/Parser.php"
#line 83 "lib/Haanga/Compiler/Parser.y"
    function yy_r14(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1544 "lib/Haanga/Compiler/Parser.php"
#line 87 "lib/Haanga/Compiler/Parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'autoescape', 'value' => strtolower(@$this->yystack[$this->yyidx + -5]->minor), 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1547 "lib/Haanga/Compiler/Parser.php"
#line 92 "lib/Haanga/Compiler/Parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1550 "lib/Haanga/Compiler/Parser.php"
#line 93 "lib/Haanga/Compiler/Parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1553 "lib/Haanga/Compiler/Parser.php"
#line 94 "lib/Haanga/Compiler/Parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1556 "lib/Haanga/Compiler/Parser.php"
#line 95 "lib/Haanga/Compiler/Parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1559 "lib/Haanga/Compiler/Parser.php"
#line 97 "lib/Haanga/Compiler/Parser.y"
    function yy_r23(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array());    }
#line 1562 "lib/Haanga/Compiler/Parser.php"
#line 100 "lib/Haanga/Compiler/Parser.y"
    function yy_r24(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1565 "lib/Haanga/Compiler/Parser.php"
#line 104 "lib/Haanga/Compiler/Parser.y"
    function yy_r26(){
    if (!is_file($this->yystack[$this->yyidx + 0]->minor)) {
        throw new Haanga_Compiler_Exception($this->yystack[$this->yyidx + 0]->minor." is not a valid file"); 
    } 
    require_once $this->yystack[$this->yyidx + 0]->minor;
    }
#line 1573 "lib/Haanga/Compiler/Parser.php"
#line 112 "lib/Haanga/Compiler/Parser.y"
    function yy_r27(){
    $this->compiler->set_context($this->yystack[$this->yyidx + -3]->minor, array());
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL, 'array' => $this->yystack[$this->yyidx + -1]->minor);
    }
#line 1579 "lib/Haanga/Compiler/Parser.php"
#line 117 "lib/Haanga/Compiler/Parser.y"
    function yy_r28(){
    $this->compiler->set_context($this->yystack[$this->yyidx + -3]->minor, array());
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -5]->minor, 'array' => $this->yystack[$this->yyidx + -1]->minor);
    }
#line 1585 "lib/Haanga/Compiler/Parser.php"
#line 123 "lib/Haanga/Compiler/Parser.y"
    function yy_r29(){ 
    $this->_retvalue = $this->yystack[$this->yyidx + -4]->minor;
    $this->_retvalue['body'] = $this->yystack[$this->yyidx + -3]->minor;
    }
#line 1591 "lib/Haanga/Compiler/Parser.php"
#line 128 "lib/Haanga/Compiler/Parser.y"
    function yy_r30(){ 
    $this->_retvalue = $this->yystack[$this->yyidx + -8]->minor;
    $this->_retvalue['body']  = $this->yystack[$this->yyidx + -7]->minor;
    $this->_retvalue['empty'] = $this->yystack[$this->yyidx + -3]->minor;
    }
#line 1598 "lib/Haanga/Compiler/Parser.php"
#line 134 "lib/Haanga/Compiler/Parser.y"
    function yy_r31(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1601 "lib/Haanga/Compiler/Parser.php"
#line 135 "lib/Haanga/Compiler/Parser.y"
    function yy_r32(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1604 "lib/Haanga/Compiler/Parser.php"
#line 138 "lib/Haanga/Compiler/Parser.y"
    function yy_r33(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1609 "lib/Haanga/Compiler/Parser.php"
#line 142 "lib/Haanga/Compiler/Parser.y"
    function yy_r34(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1614 "lib/Haanga/Compiler/Parser.php"
#line 145 "lib/Haanga/Compiler/Parser.y"
    function yy_r35(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1619 "lib/Haanga/Compiler/Parser.php"
#line 149 "lib/Haanga/Compiler/Parser.y"
    function yy_r36(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1624 "lib/Haanga/Compiler/Parser.php"
#line 154 "lib/Haanga/Compiler/Parser.y"
    function yy_r37(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '==', 1 => $this->yystack[$this->yyidx + -6]->minor, 2 => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1627 "lib/Haanga/Compiler/Parser.php"
#line 155 "lib/Haanga/Compiler/Parser.y"
    function yy_r38(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '==', 1 => $this->yystack[$this->yyidx + -10]->minor, 2 => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1630 "lib/Haanga/Compiler/Parser.php"
#line 156 "lib/Haanga/Compiler/Parser.y"
    function yy_r39(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '!=', 1 => $this->yystack[$this->yyidx + -6]->minor, 2 => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1633 "lib/Haanga/Compiler/Parser.php"
#line 157 "lib/Haanga/Compiler/Parser.y"
    function yy_r40(){  $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '!=', 1 => $this->yystack[$this->yyidx + -10]->minor, 2 => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1636 "lib/Haanga/Compiler/Parser.php"
#line 161 "lib/Haanga/Compiler/Parser.y"
    function yy_r41(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1639 "lib/Haanga/Compiler/Parser.php"
#line 163 "lib/Haanga/Compiler/Parser.y"
    function yy_r42(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1642 "lib/Haanga/Compiler/Parser.php"
#line 170 "lib/Haanga/Compiler/Parser.y"
    function yy_r45(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1645 "lib/Haanga/Compiler/Parser.php"
#line 173 "lib/Haanga/Compiler/Parser.y"
    function yy_r46(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1648 "lib/Haanga/Compiler/Parser.php"
#line 176 "lib/Haanga/Compiler/Parser.y"
    function yy_r47(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1651 "lib/Haanga/Compiler/Parser.php"
#line 177 "lib/Haanga/Compiler/Parser.y"
    function yy_r48(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1654 "lib/Haanga/Compiler/Parser.php"
#line 179 "lib/Haanga/Compiler/Parser.y"
    function yy_r49(){ $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, 'args'=>array($this->yystack[$this->yyidx + 0]->minor));     }
#line 1657 "lib/Haanga/Compiler/Parser.php"
#line 183 "lib/Haanga/Compiler/Parser.y"
    function yy_r51(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1660 "lib/Haanga/Compiler/Parser.php"
#line 189 "lib/Haanga/Compiler/Parser.y"
    function yy_r54(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1663 "lib/Haanga/Compiler/Parser.php"
#line 190 "lib/Haanga/Compiler/Parser.y"
    function yy_r55(){ $this->_retvalue = array('number' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1666 "lib/Haanga/Compiler/Parser.php"
#line 191 "lib/Haanga/Compiler/Parser.y"
    function yy_r56(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1669 "lib/Haanga/Compiler/Parser.php"
#line 193 "lib/Haanga/Compiler/Parser.y"
    function yy_r57(){ $this->_retvalue = array('var_filter' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1672 "lib/Haanga/Compiler/Parser.php"
#line 199 "lib/Haanga/Compiler/Parser.y"
    function yy_r61(){  $this->_retvalue = "";     }
#line 1675 "lib/Haanga/Compiler/Parser.php"
#line 201 "lib/Haanga/Compiler/Parser.y"
    function yy_r63(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1678 "lib/Haanga/Compiler/Parser.php"
#line 203 "lib/Haanga/Compiler/Parser.y"
    function yy_r65(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1681 "lib/Haanga/Compiler/Parser.php"
#line 207 "lib/Haanga/Compiler/Parser.y"
    function yy_r67(){ $this->_retvalue = array('op_expr' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1684 "lib/Haanga/Compiler/Parser.php"
#line 210 "lib/Haanga/Compiler/Parser.y"
    function yy_r70(){ $this->_retvalue = array('op_expr' => trim(@$this->yystack[$this->yyidx + -1]->minor), $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1687 "lib/Haanga/Compiler/Parser.php"
#line 212 "lib/Haanga/Compiler/Parser.y"
    function yy_r72(){ $this->_retvalue = array('op_expr' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1690 "lib/Haanga/Compiler/Parser.php"
#line 216 "lib/Haanga/Compiler/Parser.y"
    function yy_r74(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=array('object' => $this->yystack[$this->yyidx + 0]->minor);    }
#line 1693 "lib/Haanga/Compiler/Parser.php"
#line 217 "lib/Haanga/Compiler/Parser.y"
    function yy_r75(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; } $this->_retvalue[] = ($this->compiler->var_is_object($this->_retvalue)) ? array('object' => $this->yystack[$this->yyidx + 0]->minor) : $this->yystack[$this->yyidx + 0]->minor;    }
#line 1696 "lib/Haanga/Compiler/Parser.php"
#line 218 "lib/Haanga/Compiler/Parser.y"
    function yy_r76(){ if (!is_array($this->yystack[$this->yyidx + -3]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -3]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + -1]->minor;    }
#line 1699 "lib/Haanga/Compiler/Parser.php"

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
#line 56 "lib/Haanga/Compiler/Parser.y"

    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    throw new Exception('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
#line 1819 "lib/Haanga/Compiler/Parser.php"
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

#line 1840 "lib/Haanga/Compiler/Parser.php"
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