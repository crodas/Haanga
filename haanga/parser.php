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
#line 2 "parser.y"

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
#line 136 "parser.php"

// declare_class is output here
#line 39 "parser.y"
 class Parser #line 141 "parser.php"
{
/* First off, code is included which follows the "include_class" declaration
** in the input file. */
#line 40 "parser.y"


#line 149 "parser.php"

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
    const T_PLUS                         =  6;
    const T_MINUS                        =  7;
    const T_TIMES                        =  8;
    const T_DIV                          =  9;
    const T_MOD                          = 10;
    const T_HTML                         = 11;
    const T_COMMENT_OPEN                 = 12;
    const T_COMMENT                      = 13;
    const T_PRINT_OPEN                   = 14;
    const T_PRINT_CLOSE                  = 15;
    const T_EXTENDS                      = 16;
    const T_CLOSE_TAG                    = 17;
    const T_INCLUDE                      = 18;
    const T_FOR                          = 19;
    const T_AS                           = 20;
    const T_WITH                         = 21;
    const T_ENDWITH                      = 22;
    const T_IN                           = 23;
    const T_CLOSEFOR                     = 24;
    const T_EMPTY                        = 25;
    const T_IF                           = 26;
    const T_ENDIF                        = 27;
    const T_ELSE                         = 28;
    const T_IFCHANGED                    = 29;
    const T_ENDIFCHANGED                 = 30;
    const T_CUSTOM_END                   = 31;
    const T_BLOCK                        = 32;
    const T_END_BLOCK                    = 33;
    const T_FILTER                       = 34;
    const T_END_FILTER                   = 35;
    const T_CYCLE                        = 36;
    const T_PIPE                         = 37;
    const T_COMMA                        = 38;
    const T_STRING_SINGLE_INIT           = 39;
    const T_STRING_SINGLE_END            = 40;
    const T_STRING_DOUBLE_INIT           = 41;
    const T_STRING_DOUBLE_END            = 42;
    const T_STRING_CONTENT               = 43;
    const T_LPARENT                      = 44;
    const T_RPARENT                      = 45;
    const T_NUMERIC                      = 46;
    const T_DOT                          = 47;
    const T_ALPHA                        = 48;
    const YY_NO_ACTION = 227;
    const YY_ACCEPT_ACTION = 226;
    const YY_ERROR_ACTION = 225;

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
    const YY_SZ_ACTTAB = 469;
static public $yy_action = array(
 /*     0 */   137,   14,   40,  104,  120,  134,  163,  155,  154,  152,
 /*    10 */   162,  161,   31,  150,   28,   53,   34,   50,  118,  116,
 /*    20 */    99,  100,   20,   68,   58,   22,   55,  140,   56,   16,
 /*    30 */    23,  113,   24,  119,   18,   18,   18,   31,   38,   28,
 /*    40 */    53,   13,   50,   29,  119,  106,  114,   20,  102,  108,
 /*    50 */    22,  147,   91,   56,   48,   23,   46,   24,   71,  107,
 /*    60 */   125,   31,  124,   28,   53,  116,   50,  106,  146,  119,
 /*    70 */    61,   20,  131,   97,   22,   95,   49,   56,   25,   23,
 /*    80 */   107,   24,  125,   32,  133,   35,   31,   54,   28,   53,
 /*    90 */    36,   50,   58,  119,   55,   65,   20,  132,   98,   22,
 /*   100 */   112,  119,   56,  107,   23,   37,   24,  226,   42,   39,
 /*   110 */    31,  107,   28,   53,  107,   50,  103,  128,  119,   31,
 /*   120 */    20,   28,   53,   22,   50,  107,   56,  107,   23,   20,
 /*   130 */    24,   58,   22,   55,   70,   56,   64,   23,   93,   24,
 /*   140 */   119,  157,  119,   31,  135,   28,   53,  107,   50,  106,
 /*   150 */   139,  119,   31,   20,   28,   53,   22,   50,   92,   56,
 /*   160 */   101,   23,   20,   24,  125,   22,  107,   62,   56,   63,
 /*   170 */    23,  107,   24,  143,  129,  119,   31,  149,   28,   53,
 /*   180 */   148,   50,   67,  121,  119,  126,   20,  106,  114,   22,
 /*   190 */    96,  153,   56,  158,   23,  144,   24,  106,  114,  107,
 /*   200 */    73,   31,  125,   28,   53,  119,   50,  142,  119,  117,
 /*   210 */    76,   20,  125,    5,   22,  110,  122,   56,  136,   23,
 /*   220 */   159,   24,   69,  147,   91,   31,   48,   28,   53,  119,
 /*   230 */    50,  106,  114,  119,  160,   20,  106,  146,   22,   43,
 /*   240 */    87,   56,   45,   23,   74,   24,  125,   27,  107,   90,
 /*   250 */    31,  125,   28,   53,   12,   50,   94,  119,   86,  182,
 /*   260 */    20,  111,   80,   22,  147,   91,   56,   48,   23,  151,
 /*   270 */    24,   17,   19,   15,   15,   21,   21,   18,   18,   18,
 /*   280 */   106,  141,  119,   84,   89,   17,   19,   15,   15,   21,
 /*   290 */    21,   18,   18,   18,   88,  125,  106,  145,  106,  146,
 /*   300 */    60,  127,   31,   81,   28,   53,    2,   50,   79,   26,
 /*   310 */    83,  125,   20,  125,  138,   22,  147,   91,   56,   48,
 /*   320 */    23,   85,   24,   44,   19,   15,   15,   21,   21,   18,
 /*   330 */    18,   18,   66,   77,  119,   15,   15,   21,   21,   18,
 /*   340 */    18,   18,   52,  115,   57,   51,  130,   78,    6,   59,
 /*   350 */   106,  109,   33,   30,   58,   82,   55,   47,  147,   91,
 /*   360 */    41,   48,  134,  119,   58,  125,   55,   30,   58,   10,
 /*   370 */    55,  134,  107,  119,  134,   30,   58,  119,   55,  147,
 /*   380 */    91,    7,   48,  134,  134,  119,  134,    3,  134,  134,
 /*   390 */   134,  147,   91,    9,   48,  134,  134,  147,   91,    4,
 /*   400 */    48,  134,  134,  147,   91,    8,   48,  134,  134,  147,
 /*   410 */    91,   11,   48,  106,  114,  147,   91,  134,   48,  106,
 /*   420 */   114,  147,   91,  134,   48,  134,   75,  134,  125,  134,
 /*   430 */   106,  114,  123,  134,  125,  134,    1,  106,  156,  134,
 /*   440 */   134,  134,  134,   72,  134,  125,  147,   91,  134,   48,
 /*   450 */   134,  134,  125,  106,  105,  134,  134,  134,  134,  134,
 /*   460 */   134,  134,  134,  134,  134,  134,  134,  134,  125,
    );
    static public $yy_lookahead = array(
 /*     0 */    53,   54,   51,   56,   57,   58,   59,   60,   61,   62,
 /*    10 */    63,   64,   16,   66,   18,   19,   51,   21,   42,   43,
 /*    20 */    24,   25,   26,   17,   39,   29,   41,   15,   32,   44,
 /*    30 */    34,   46,   36,   48,    8,    9,   10,   16,   51,   18,
 /*    40 */    19,    1,   21,   37,   48,   54,   55,   26,   27,   28,
 /*    50 */    29,   11,   12,   32,   14,   34,   23,   36,   67,   47,
 /*    60 */    69,   16,   40,   18,   19,   43,   21,   54,   55,   48,
 /*    70 */    17,   26,   17,   28,   29,   30,   20,   32,   65,   34,
 /*    80 */    47,   36,   69,   51,   17,   51,   16,   20,   18,   19,
 /*    90 */    51,   21,   39,   48,   41,   17,   26,   17,   28,   29,
 /*   100 */    30,   48,   32,   47,   34,   51,   36,   50,   51,   51,
 /*   110 */    16,   47,   18,   19,   47,   21,   22,   17,   48,   16,
 /*   120 */    26,   18,   19,   29,   21,   47,   32,   47,   34,   26,
 /*   130 */    36,   39,   29,   41,   17,   32,   17,   34,   35,   36,
 /*   140 */    48,   17,   48,   16,   48,   18,   19,   47,   21,   54,
 /*   150 */    55,   48,   16,   26,   18,   19,   29,   21,   31,   32,
 /*   160 */    24,   34,   26,   36,   69,   29,   47,   17,   32,   17,
 /*   170 */    34,   47,   36,   17,   17,   48,   16,   13,   18,   19,
 /*   180 */    17,   21,   17,   17,   48,   17,   26,   54,   55,   29,
 /*   190 */    30,   17,   32,   17,   34,   17,   36,   54,   55,   47,
 /*   200 */    67,   16,   69,   18,   19,   48,   21,   17,   48,   17,
 /*   210 */    67,   26,   69,    1,   29,   30,   17,   32,   17,   34,
 /*   220 */    17,   36,   17,   11,   12,   16,   14,   18,   19,   48,
 /*   230 */    21,   54,   55,   48,   17,   26,   54,   55,   29,   51,
 /*   240 */    54,   32,   33,   34,   67,   36,   69,   65,   47,   54,
 /*   250 */    16,   69,   18,   19,    1,   21,   54,   48,   54,    0,
 /*   260 */    26,   27,   54,   29,   11,   12,   32,   14,   34,   17,
 /*   270 */    36,    2,    3,    4,    5,    6,    7,    8,    9,   10,
 /*   280 */    54,   55,   48,   54,   54,    2,    3,    4,    5,    6,
 /*   290 */     7,    8,    9,   10,   68,   69,   54,   55,   54,   55,
 /*   300 */    17,   52,   16,   70,   18,   19,    1,   21,   54,   65,
 /*   310 */    54,   69,   26,   69,   45,   29,   11,   12,   32,   14,
 /*   320 */    34,   54,   36,   51,    3,    4,    5,    6,    7,    8,
 /*   330 */     9,   10,   17,   54,   48,    4,    5,    6,    7,    8,
 /*   340 */     9,   10,   17,   43,   19,   20,   17,   54,    1,   20,
 /*   350 */    54,   55,   51,   38,   39,   70,   41,   20,   11,   12,
 /*   360 */    51,   14,   71,   48,   39,   69,   41,   38,   39,    1,
 /*   370 */    41,   71,   47,   48,   71,   38,   39,   48,   41,   11,
 /*   380 */    12,    1,   14,   71,   71,   48,   71,    1,   71,   71,
 /*   390 */    71,   11,   12,    1,   14,   71,   71,   11,   12,    1,
 /*   400 */    14,   71,   71,   11,   12,    1,   14,   71,   71,   11,
 /*   410 */    12,    1,   14,   54,   55,   11,   12,   71,   14,   54,
 /*   420 */    55,   11,   12,   71,   14,   71,   67,   71,   69,   71,
 /*   430 */    54,   55,   67,   71,   69,   71,    1,   54,   55,   71,
 /*   440 */    71,   71,   71,   67,   71,   69,   11,   12,   71,   14,
 /*   450 */    71,   71,   69,   54,   55,   71,   71,   71,   71,   71,
 /*   460 */    71,   71,   71,   71,   71,   71,   71,   71,   69,
);
    const YY_SHIFT_USE_DFLT = -25;
    const YY_SHIFT_MAX = 112;
    static public $yy_shift_ofst = array(
 /*     0 */   -25,   -4,   21,   70,   45,  160,  185,  209,  234,  136,
 /*    10 */   103,   94,  127,  286,  325,  -15,  -15,  -15,  -15,  -15,
 /*    20 */   -15,  -15,   53,   92,   92,  329,  337,  315,   92,   92,
 /*    30 */    92,   92,  398,  386,  347,  410,  435,  392,  404,  380,
 /*    40 */   368,  212,   40,  253,  305,  157,  181,  181,  181,  181,
 /*    50 */   181,  181,  259,  181,  181,  300,  181,  181,  300,  181,
 /*    60 */   -25,  -25,  -25,  -25,  -25,  -25,  -25,  -25,  -25,  -25,
 /*    70 */   -25,  283,  269,  321,  331,  331,   26,   67,  152,  124,
 /*    80 */    33,   22,  -24,   80,  100,  201,   56,  119,    6,   78,
 /*    90 */    12,  164,  192,  199,   64,  203,  174,  150,  117,  156,
 /*   100 */   165,  178,  163,  252,  166,  168,   64,   96,  205,  176,
 /*   110 */    55,  190,  217,
);
    const YY_REDUCE_USE_DFLT = -54;
    const YY_REDUCE_MAX = 70;
    static public $yy_reduce_ofst = array(
 /*     0 */    57,  -53,  -53,  -53,  -53,  -53,  -53,  -53,  -53,  -53,
 /*    10 */   -53,  -53,  -53,  -53,   13,  359,  376,  133,  365,  177,
 /*    20 */    -9,  143,  182,  226,  244,  242,  242,  242,  296,   95,
 /*    30 */   383,  399,  249,  249,  249,  249,  249,  249,  249,  249,
 /*    40 */   249,  249,  249,  249,  249,  254,  230,  202,  195,  186,
 /*    50 */   204,  229,  188,  208,  256,  285,  293,  279,  233,  267,
 /*    60 */   272,  301,  309,   58,   34,   39,   32,   54,  -49,  -13,
 /*    70 */   -35,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(16, 18, 19, 21, 24, 25, 26, 29, 32, 34, 36, 48, ),
        /* 2 */ array(16, 18, 19, 21, 26, 27, 28, 29, 32, 34, 36, 48, ),
        /* 3 */ array(16, 18, 19, 21, 26, 28, 29, 30, 32, 34, 36, 48, ),
        /* 4 */ array(16, 18, 19, 21, 26, 28, 29, 30, 32, 34, 36, 48, ),
        /* 5 */ array(16, 18, 19, 21, 26, 29, 30, 32, 34, 36, 48, ),
        /* 6 */ array(16, 18, 19, 21, 26, 29, 30, 32, 34, 36, 48, ),
        /* 7 */ array(16, 18, 19, 21, 26, 29, 32, 33, 34, 36, 48, ),
        /* 8 */ array(16, 18, 19, 21, 26, 27, 29, 32, 34, 36, 48, ),
        /* 9 */ array(16, 18, 19, 21, 24, 26, 29, 32, 34, 36, 48, ),
        /* 10 */ array(16, 18, 19, 21, 26, 29, 32, 34, 35, 36, 48, ),
        /* 11 */ array(16, 18, 19, 21, 22, 26, 29, 32, 34, 36, 48, ),
        /* 12 */ array(16, 18, 19, 21, 26, 29, 31, 32, 34, 36, 48, ),
        /* 13 */ array(16, 18, 19, 21, 26, 29, 32, 34, 36, 48, ),
        /* 14 */ array(17, 19, 20, 39, 41, 47, 48, ),
        /* 15 */ array(39, 41, 44, 46, 48, ),
        /* 16 */ array(39, 41, 44, 46, 48, ),
        /* 17 */ array(39, 41, 44, 46, 48, ),
        /* 18 */ array(39, 41, 44, 46, 48, ),
        /* 19 */ array(39, 41, 44, 46, 48, ),
        /* 20 */ array(39, 41, 44, 46, 48, ),
        /* 21 */ array(39, 41, 44, 46, 48, ),
        /* 22 */ array(17, 39, 41, 48, ),
        /* 23 */ array(39, 41, 48, ),
        /* 24 */ array(39, 41, 48, ),
        /* 25 */ array(17, 20, 38, 39, 41, 48, ),
        /* 26 */ array(20, 38, 39, 41, 48, ),
        /* 27 */ array(17, 38, 39, 41, 48, ),
        /* 28 */ array(39, 41, 48, ),
        /* 29 */ array(39, 41, 48, ),
        /* 30 */ array(39, 41, 48, ),
        /* 31 */ array(39, 41, 48, ),
        /* 32 */ array(1, 11, 12, 14, ),
        /* 33 */ array(1, 11, 12, 14, ),
        /* 34 */ array(1, 11, 12, 14, ),
        /* 35 */ array(1, 11, 12, 14, ),
        /* 36 */ array(1, 11, 12, 14, ),
        /* 37 */ array(1, 11, 12, 14, ),
        /* 38 */ array(1, 11, 12, 14, ),
        /* 39 */ array(1, 11, 12, 14, ),
        /* 40 */ array(1, 11, 12, 14, ),
        /* 41 */ array(1, 11, 12, 14, ),
        /* 42 */ array(1, 11, 12, 14, ),
        /* 43 */ array(1, 11, 12, 14, ),
        /* 44 */ array(1, 11, 12, 14, ),
        /* 45 */ array(17, 48, ),
        /* 46 */ array(48, ),
        /* 47 */ array(48, ),
        /* 48 */ array(48, ),
        /* 49 */ array(48, ),
        /* 50 */ array(48, ),
        /* 51 */ array(48, ),
        /* 52 */ array(0, ),
        /* 53 */ array(48, ),
        /* 54 */ array(48, ),
        /* 55 */ array(43, ),
        /* 56 */ array(48, ),
        /* 57 */ array(48, ),
        /* 58 */ array(43, ),
        /* 59 */ array(48, ),
        /* 60 */ array(),
        /* 61 */ array(),
        /* 62 */ array(),
        /* 63 */ array(),
        /* 64 */ array(),
        /* 65 */ array(),
        /* 66 */ array(),
        /* 67 */ array(),
        /* 68 */ array(),
        /* 69 */ array(),
        /* 70 */ array(),
        /* 71 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 17, ),
        /* 72 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 45, ),
        /* 73 */ array(3, 4, 5, 6, 7, 8, 9, 10, ),
        /* 74 */ array(4, 5, 6, 7, 8, 9, 10, ),
        /* 75 */ array(4, 5, 6, 7, 8, 9, 10, ),
        /* 76 */ array(8, 9, 10, ),
        /* 77 */ array(17, 20, 47, ),
        /* 78 */ array(17, 47, ),
        /* 79 */ array(17, 47, ),
        /* 80 */ array(23, 47, ),
        /* 81 */ array(40, 43, ),
        /* 82 */ array(42, 43, ),
        /* 83 */ array(17, 47, ),
        /* 84 */ array(17, 47, ),
        /* 85 */ array(17, 47, ),
        /* 86 */ array(20, 47, ),
        /* 87 */ array(17, 47, ),
        /* 88 */ array(17, 37, ),
        /* 89 */ array(17, 47, ),
        /* 90 */ array(15, 47, ),
        /* 91 */ array(13, ),
        /* 92 */ array(17, ),
        /* 93 */ array(17, ),
        /* 94 */ array(47, ),
        /* 95 */ array(17, ),
        /* 96 */ array(17, ),
        /* 97 */ array(17, ),
        /* 98 */ array(17, ),
        /* 99 */ array(17, ),
        /* 100 */ array(17, ),
        /* 101 */ array(17, ),
        /* 102 */ array(17, ),
        /* 103 */ array(17, ),
        /* 104 */ array(17, ),
        /* 105 */ array(17, ),
        /* 106 */ array(47, ),
        /* 107 */ array(48, ),
        /* 108 */ array(17, ),
        /* 109 */ array(17, ),
        /* 110 */ array(17, ),
        /* 111 */ array(17, ),
        /* 112 */ array(17, ),
        /* 113 */ array(),
        /* 114 */ array(),
        /* 115 */ array(),
        /* 116 */ array(),
        /* 117 */ array(),
        /* 118 */ array(),
        /* 119 */ array(),
        /* 120 */ array(),
        /* 121 */ array(),
        /* 122 */ array(),
        /* 123 */ array(),
        /* 124 */ array(),
        /* 125 */ array(),
        /* 126 */ array(),
        /* 127 */ array(),
        /* 128 */ array(),
        /* 129 */ array(),
        /* 130 */ array(),
        /* 131 */ array(),
        /* 132 */ array(),
        /* 133 */ array(),
        /* 134 */ array(),
        /* 135 */ array(),
        /* 136 */ array(),
        /* 137 */ array(),
        /* 138 */ array(),
        /* 139 */ array(),
        /* 140 */ array(),
        /* 141 */ array(),
        /* 142 */ array(),
        /* 143 */ array(),
        /* 144 */ array(),
        /* 145 */ array(),
        /* 146 */ array(),
        /* 147 */ array(),
        /* 148 */ array(),
        /* 149 */ array(),
        /* 150 */ array(),
        /* 151 */ array(),
        /* 152 */ array(),
        /* 153 */ array(),
        /* 154 */ array(),
        /* 155 */ array(),
        /* 156 */ array(),
        /* 157 */ array(),
        /* 158 */ array(),
        /* 159 */ array(),
        /* 160 */ array(),
        /* 161 */ array(),
        /* 162 */ array(),
        /* 163 */ array(),
);
    static public $yy_default = array(
 /*     0 */   166,  225,  225,  225,  225,  225,  225,  225,  225,  225,
 /*    10 */   225,  225,  225,  225,  225,  225,  225,  225,  225,  225,
 /*    20 */   225,  225,  225,  225,  225,  225,  202,  225,  225,  225,
 /*    30 */   225,  225,  225,  225,  225,  225,  225,  225,  225,  225,
 /*    40 */   225,  225,  164,  225,  225,  225,  225,  225,  225,  225,
 /*    50 */   225,  225,  166,  225,  225,  225,  225,  225,  225,  225,
 /*    60 */   166,  166,  166,  166,  166,  166,  166,  166,  166,  166,
 /*    70 */   166,  225,  225,  216,  217,  218,  220,  225,  225,  225,
 /*    80 */   225,  225,  225,  225,  225,  225,  225,  225,  225,  225,
 /*    90 */   225,  225,  225,  225,  203,  225,  225,  225,  225,  225,
 /*   100 */   225,  225,  225,  225,  225,  225,  209,  225,  225,  225,
 /*   110 */   225,  225,  225,  222,  221,  214,  213,  198,  212,  224,
 /*   120 */   173,  172,  201,  219,  211,  210,  171,  165,  185,  199,
 /*   130 */   186,  196,  184,  183,  174,  223,  187,  167,  215,  204,
 /*   140 */   170,  205,  193,  190,  191,  206,  208,  168,  192,  169,
 /*   150 */   189,  188,  178,  197,  177,  176,  207,  200,  179,  195,
 /*   160 */   194,  181,  180,  175,
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
    const YYNOCODE = 72;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 164;
    const YYNRULE = 61;
    const YYERRORSYMBOL = 49;
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
  'T_EQ',          'T_NE',          'T_PLUS',        'T_MINUS',     
  'T_TIMES',       'T_DIV',         'T_MOD',         'T_HTML',      
  'T_COMMENT_OPEN',  'T_COMMENT',     'T_PRINT_OPEN',  'T_PRINT_CLOSE',
  'T_EXTENDS',     'T_CLOSE_TAG',   'T_INCLUDE',     'T_FOR',       
  'T_AS',          'T_WITH',        'T_ENDWITH',     'T_IN',        
  'T_CLOSEFOR',    'T_EMPTY',       'T_IF',          'T_ENDIF',     
  'T_ELSE',        'T_IFCHANGED',   'T_ENDIFCHANGED',  'T_CUSTOM_END',
  'T_BLOCK',       'T_END_BLOCK',   'T_FILTER',      'T_END_FILTER',
  'T_CYCLE',       'T_PIPE',        'T_COMMA',       'T_STRING_SINGLE_INIT',
  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',  'T_STRING_DOUBLE_END',  'T_STRING_CONTENT',
  'T_LPARENT',     'T_RPARENT',     'T_NUMERIC',     'T_DOT',       
  'T_ALPHA',       'error',         'start',         'body',        
  'code',          'stmts',         'varname',       'var_or_string',
  'stmt',          'for_stmt',      'ifchanged_stmt',  'block_stmt',  
  'filter_stmt',   'custom_stmt',   'if_stmt',       'fnc_call_stmt',
  'alias',         'list',          'cycle',         'expr',        
  'piped_list',    'string',        's_content',   
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
 /*   6 */ "code ::= T_PRINT_OPEN varname T_PRINT_CLOSE",
 /*   7 */ "stmts ::= T_EXTENDS var_or_string T_CLOSE_TAG",
 /*   8 */ "stmts ::= stmt T_CLOSE_TAG",
 /*   9 */ "stmts ::= for_stmt",
 /*  10 */ "stmts ::= ifchanged_stmt",
 /*  11 */ "stmts ::= block_stmt",
 /*  12 */ "stmts ::= filter_stmt",
 /*  13 */ "stmts ::= custom_stmt",
 /*  14 */ "stmts ::= if_stmt",
 /*  15 */ "stmts ::= T_INCLUDE var_or_string T_CLOSE_TAG",
 /*  16 */ "stmts ::= fnc_call_stmt",
 /*  17 */ "stmts ::= alias",
 /*  18 */ "fnc_call_stmt ::= varname T_CLOSE_TAG",
 /*  19 */ "fnc_call_stmt ::= varname T_FOR varname T_CLOSE_TAG",
 /*  20 */ "fnc_call_stmt ::= varname T_FOR varname T_AS varname T_CLOSE_TAG",
 /*  21 */ "fnc_call_stmt ::= varname T_AS varname T_CLOSE_TAG",
 /*  22 */ "fnc_call_stmt ::= varname list T_CLOSE_TAG",
 /*  23 */ "fnc_call_stmt ::= varname list T_AS varname T_CLOSE_TAG",
 /*  24 */ "alias ::= T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_ENDWITH T_CLOSE_TAG",
 /*  25 */ "stmt ::= cycle",
 /*  26 */ "for_stmt ::= T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  27 */ "for_stmt ::= T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  28 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  29 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  30 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  31 */ "ifchanged_stmt ::= T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  32 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  33 */ "ifchanged_stmt ::= T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  34 */ "custom_stmt ::= varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  35 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  36 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  37 */ "filter_stmt ::= T_FILTER piped_list T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  38 */ "cycle ::= T_CYCLE list",
 /*  39 */ "cycle ::= T_CYCLE list T_AS varname",
 /*  40 */ "piped_list ::= piped_list T_PIPE var_or_string",
 /*  41 */ "piped_list ::= var_or_string",
 /*  42 */ "list ::= list var_or_string",
 /*  43 */ "list ::= list T_COMMA var_or_string",
 /*  44 */ "list ::= var_or_string",
 /*  45 */ "var_or_string ::= varname",
 /*  46 */ "var_or_string ::= string",
 /*  47 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  48 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  49 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  50 */ "s_content ::= T_STRING_CONTENT",
 /*  51 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  52 */ "expr ::= expr T_AND expr",
 /*  53 */ "expr ::= expr T_OR expr",
 /*  54 */ "expr ::= expr T_EQ|T_NE expr",
 /*  55 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  56 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  57 */ "expr ::= var_or_string",
 /*  58 */ "expr ::= T_NUMERIC",
 /*  59 */ "varname ::= varname T_DOT T_ALPHA",
 /*  60 */ "varname ::= T_ALPHA",
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
  array( 'lhs' => 50, 'rhs' => 1 ),
  array( 'lhs' => 51, 'rhs' => 2 ),
  array( 'lhs' => 51, 'rhs' => 0 ),
  array( 'lhs' => 52, 'rhs' => 2 ),
  array( 'lhs' => 52, 'rhs' => 1 ),
  array( 'lhs' => 52, 'rhs' => 2 ),
  array( 'lhs' => 52, 'rhs' => 3 ),
  array( 'lhs' => 53, 'rhs' => 3 ),
  array( 'lhs' => 53, 'rhs' => 2 ),
  array( 'lhs' => 53, 'rhs' => 1 ),
  array( 'lhs' => 53, 'rhs' => 1 ),
  array( 'lhs' => 53, 'rhs' => 1 ),
  array( 'lhs' => 53, 'rhs' => 1 ),
  array( 'lhs' => 53, 'rhs' => 1 ),
  array( 'lhs' => 53, 'rhs' => 1 ),
  array( 'lhs' => 53, 'rhs' => 3 ),
  array( 'lhs' => 53, 'rhs' => 1 ),
  array( 'lhs' => 53, 'rhs' => 1 ),
  array( 'lhs' => 63, 'rhs' => 2 ),
  array( 'lhs' => 63, 'rhs' => 4 ),
  array( 'lhs' => 63, 'rhs' => 6 ),
  array( 'lhs' => 63, 'rhs' => 4 ),
  array( 'lhs' => 63, 'rhs' => 3 ),
  array( 'lhs' => 63, 'rhs' => 5 ),
  array( 'lhs' => 64, 'rhs' => 9 ),
  array( 'lhs' => 56, 'rhs' => 1 ),
  array( 'lhs' => 57, 'rhs' => 9 ),
  array( 'lhs' => 57, 'rhs' => 13 ),
  array( 'lhs' => 62, 'rhs' => 7 ),
  array( 'lhs' => 62, 'rhs' => 11 ),
  array( 'lhs' => 58, 'rhs' => 6 ),
  array( 'lhs' => 58, 'rhs' => 7 ),
  array( 'lhs' => 58, 'rhs' => 10 ),
  array( 'lhs' => 58, 'rhs' => 11 ),
  array( 'lhs' => 61, 'rhs' => 6 ),
  array( 'lhs' => 59, 'rhs' => 7 ),
  array( 'lhs' => 59, 'rhs' => 8 ),
  array( 'lhs' => 60, 'rhs' => 7 ),
  array( 'lhs' => 66, 'rhs' => 2 ),
  array( 'lhs' => 66, 'rhs' => 4 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 65, 'rhs' => 2 ),
  array( 'lhs' => 65, 'rhs' => 3 ),
  array( 'lhs' => 65, 'rhs' => 1 ),
  array( 'lhs' => 55, 'rhs' => 1 ),
  array( 'lhs' => 55, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 3 ),
  array( 'lhs' => 69, 'rhs' => 3 ),
  array( 'lhs' => 70, 'rhs' => 2 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 3 ),
  array( 'lhs' => 54, 'rhs' => 1 ),
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
        14 => 3,
        16 => 3,
        17 => 3,
        25 => 3,
        50 => 3,
        57 => 3,
        58 => 3,
        60 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        15 => 15,
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
        43 => 40,
        41 => 41,
        44 => 41,
        42 => 42,
        45 => 45,
        46 => 46,
        47 => 47,
        48 => 47,
        49 => 49,
        51 => 51,
        52 => 52,
        53 => 52,
        54 => 52,
        55 => 52,
        56 => 52,
        59 => 59,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 63 "parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1267 "parser.php"
#line 65 "parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1270 "parser.php"
#line 66 "parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1273 "parser.php"
#line 69 "parser.y"
    function yy_r3(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1276 "parser.php"
#line 70 "parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1279 "parser.php"
#line 71 "parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1282 "parser.php"
#line 72 "parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1285 "parser.php"
#line 74 "parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1288 "parser.php"
#line 75 "parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1291 "parser.php"
#line 82 "parser.y"
    function yy_r15(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1294 "parser.php"
#line 89 "parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1297 "parser.php"
#line 90 "parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'for' => $this->yystack[$this->yyidx + -1]->minor, 'list' => array());     }
#line 1300 "parser.php"
#line 91 "parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'for' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array(),'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1303 "parser.php"
#line 92 "parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1306 "parser.php"
#line 93 "parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1309 "parser.php"
#line 94 "parser.y"
    function yy_r23(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1312 "parser.php"
#line 97 "parser.y"
    function yy_r24(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1315 "parser.php"
#line 103 "parser.y"
    function yy_r26(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1320 "parser.php"
#line 106 "parser.y"
    function yy_r27(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1325 "parser.php"
#line 110 "parser.y"
    function yy_r28(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1328 "parser.php"
#line 111 "parser.y"
    function yy_r29(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1331 "parser.php"
#line 114 "parser.y"
    function yy_r30(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1336 "parser.php"
#line 118 "parser.y"
    function yy_r31(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1341 "parser.php"
#line 121 "parser.y"
    function yy_r32(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1346 "parser.php"
#line 125 "parser.y"
    function yy_r33(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1351 "parser.php"
#line 130 "parser.y"
    function yy_r34(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'filter', 'functions' => array(array('var'=>$this->yystack[$this->yyidx + -5]->minor)), 'body' => $this->yystack[$this->yyidx + -3]->minor);    }
#line 1354 "parser.php"
#line 133 "parser.y"
    function yy_r35(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1357 "parser.php"
#line 135 "parser.y"
    function yy_r36(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1360 "parser.php"
#line 138 "parser.y"
    function yy_r37(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1363 "parser.php"
#line 142 "parser.y"
    function yy_r38(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1366 "parser.php"
#line 143 "parser.y"
    function yy_r39(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1369 "parser.php"
#line 146 "parser.y"
    function yy_r40(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1372 "parser.php"
#line 147 "parser.y"
    function yy_r41(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1375 "parser.php"
#line 150 "parser.y"
    function yy_r42(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1378 "parser.php"
#line 154 "parser.y"
    function yy_r45(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1381 "parser.php"
#line 155 "parser.y"
    function yy_r46(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1384 "parser.php"
#line 157 "parser.y"
    function yy_r47(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1387 "parser.php"
#line 159 "parser.y"
    function yy_r49(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1390 "parser.php"
#line 163 "parser.y"
    function yy_r51(){ $this->_retvalue = array('op' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1393 "parser.php"
#line 164 "parser.y"
    function yy_r52(){ $this->_retvalue = array('op' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1396 "parser.php"
#line 174 "parser.y"
    function yy_r59(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1399 "parser.php"

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
#line 54 "parser.y"

    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    throw new Exception('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
#line 1519 "parser.php"
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
#line 44 "parser.y"

#line 1540 "parser.php"
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