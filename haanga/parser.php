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
    const T_COMMA                        = 25;
    const T_EMPTY                        = 26;
    const T_IF                           = 27;
    const T_ENDIF                        = 28;
    const T_ELSE                         = 29;
    const T_IFCHANGED                    = 30;
    const T_ENDIFCHANGED                 = 31;
    const T_CUSTOM_END                   = 32;
    const T_BLOCK                        = 33;
    const T_END_BLOCK                    = 34;
    const T_FILTER                       = 35;
    const T_END_FILTER                   = 36;
    const T_REGROUP                      = 37;
    const T_BY                           = 38;
    const T_CYCLE                        = 39;
    const T_FIRST_OF                     = 40;
    const T_PIPE                         = 41;
    const T_STRING_SINGLE_INIT           = 42;
    const T_STRING_SINGLE_END            = 43;
    const T_STRING_DOUBLE_INIT           = 44;
    const T_STRING_DOUBLE_END            = 45;
    const T_STRING_CONTENT               = 46;
    const T_LPARENT                      = 47;
    const T_RPARENT                      = 48;
    const T_NUMERIC                      = 49;
    const T_DOT                          = 50;
    const T_ALPHA                        = 51;
    const YY_NO_ACTION = 258;
    const YY_ACCEPT_ACTION = 257;
    const YY_ERROR_ACTION = 256;

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
    const YY_SZ_ACTTAB = 589;
static public $yy_action = array(
 /*     0 */   163,  143,   60,  118,  137,  144,  146,  142,  139,  188,
 /*    10 */   187,  185,   16,    7,  165,  166,  170,   33,  149,   32,
 /*    20 */    62,  124,   61,  168,  111,  110,   34,  113,   17,  124,
 /*    30 */    68,   24,   56,  178,   54,   18,   35,  180,   55,  149,
 /*    40 */    25,   26,   33,  132,   32,   62,   78,   61,   89,  164,
 /*    50 */   171,  148,  149,   17,   59,  122,   24,  135,  151,   54,
 /*    60 */    73,   35,   65,   55,   70,   25,   26,  104,   31,   33,
 /*    70 */    64,   32,   62,   77,   61,  184,   64,  149,  182,   63,
 /*    80 */    17,  121,  126,   24,  124,   68,   54,   56,   35,  124,
 /*    90 */    55,  124,   25,   26,  149,   83,  158,   33,   52,   32,
 /*   100 */    62,  152,   61,   40,  149,  134,  124,  129,   17,  124,
 /*   110 */   124,   24,   31,  140,   54,   36,   35,   68,   55,   56,
 /*   120 */    25,   26,   33,   41,   32,   62,  149,   61,  124,   68,
 /*   130 */   149,   56,  149,   17,  124,  117,   24,  119,  149,   54,
 /*   140 */   136,   35,  141,   55,  156,   25,   26,   82,    4,   33,
 /*   150 */   179,   32,   62,   66,   61,   58,   57,  149,  168,  111,
 /*   160 */    17,   34,  173,   24,  154,  182,   54,   81,   35,  125,
 /*   170 */    55,  186,   25,   26,   33,  124,   32,   62,   68,   61,
 /*   180 */    56,   21,   21,   21,  149,   17,  124,  149,   24,   69,
 /*   190 */    92,   54,   51,   35,   75,   55,  106,   25,   26,  161,
 /*   200 */   177,   33,  169,   32,   62,  155,   61,  108,   53,  149,
 /*   210 */   132,   28,   17,   31,  150,   24,  164,  114,   54,  124,
 /*   220 */    35,   72,   55,  102,   25,   26,   33,  124,   32,   62,
 /*   230 */    68,   61,   56,  175,  130,  159,  149,   17,   80,  149,
 /*   240 */    24,   44,  128,   54,   71,   35,   68,   55,   56,   25,
 /*   250 */    26,   33,  132,   32,   62,  149,   61,  120,  164,  257,
 /*   260 */    43,  149,   17,  153,  174,   24,  124,   74,   54,  178,
 /*   270 */    35,  124,   55,  147,   25,   26,  181,  177,   33,  132,
 /*   280 */    32,   62,   76,   61,   86,  164,  149,  132,   29,   17,
 /*   290 */   133,  145,   24,  164,  160,   54,   98,   35,  162,   55,
 /*   300 */   138,   25,   26,   33,   94,   32,   62,  108,   61,   91,
 /*   310 */   207,   46,  123,  149,   17,   99,  157,   24,  127,    3,
 /*   320 */    54,  131,   35,  101,   55,   42,   25,   26,   93,  168,
 /*   330 */   111,   33,   34,   32,   62,  107,   61,  167,  149,  112,
 /*   340 */    97,   67,   17,   96,  100,   24,   31,  132,   54,   50,
 /*   350 */    35,   38,   55,  164,   25,   26,   33,  103,   32,   62,
 /*   360 */    90,   61,   95,   68,  105,   56,  149,   17,  109,  145,
 /*   370 */    24,  115,  149,   54,   39,   35,   49,   55,   47,   25,
 /*   380 */    26,   48,   12,   33,   37,   32,   62,   45,   61,  116,
 /*   390 */   145,  149,  168,  111,   17,   34,  145,   24,  145,  132,
 /*   400 */    54,  145,   35,  145,   55,  164,   25,   26,  145,   23,
 /*   410 */    20,   19,   19,   22,   22,   21,   21,   21,  149,   23,
 /*   420 */    20,   19,   19,   22,   22,   21,   21,   21,  145,  145,
 /*   430 */   145,  145,  145,  145,   79,  145,  145,  145,   20,   19,
 /*   440 */    19,   22,   22,   21,   21,   21,   19,   19,   22,   22,
 /*   450 */    21,   21,   21,    1,  145,  183,  145,   14,  145,  145,
 /*   460 */   145,  145,  145,  168,  111,    9,   34,  168,  111,   11,
 /*   470 */    34,  145,  145,  145,  145,  168,  111,    2,   34,  168,
 /*   480 */   111,    5,   34,  145,  145,  145,  145,  168,  111,    8,
 /*   490 */    34,  168,  111,   13,   34,  145,  145,  145,  145,  168,
 /*   500 */   111,    6,   34,  168,  111,   10,   34,  145,  145,  145,
 /*   510 */   145,  168,  111,   15,   34,  168,  111,  145,   34,  145,
 /*   520 */   145,  145,  145,  168,  111,  178,   34,  178,  177,  145,
 /*   530 */   145,  145,  145,  145,  145,  132,  178,  132,  132,   27,
 /*   540 */   176,  164,   88,  164,  164,  145,  132,  178,  145,  178,
 /*   550 */   145,   85,  164,  145,  145,  145,  145,  132,  145,  132,
 /*   560 */   177,  145,   84,  164,   87,  164,  145,  145,  145,  145,
 /*   570 */   132,   30,  172,  145,  145,  145,  164,  145,  145,  145,
 /*   580 */   145,  145,  132,  145,  145,  145,  145,  145,  164,
    );
    static public $yy_lookahead = array(
 /*     0 */    56,   55,   23,   59,   60,   61,   62,   63,   64,   65,
 /*    10 */    66,   67,   68,    1,   70,   71,   72,   16,   51,   18,
 /*    20 */    19,   50,   21,   11,   12,   24,   14,   26,   27,   50,
 /*    30 */    42,   30,   44,   58,   33,   47,   35,   49,   37,   51,
 /*    40 */    39,   40,   16,   68,   18,   19,   17,   21,   73,   74,
 /*    50 */    15,   17,   51,   27,   20,   29,   30,   31,   17,   33,
 /*    60 */    17,   35,   23,   37,   25,   39,   40,   68,   25,   16,
 /*    70 */    41,   18,   19,   17,   21,   43,   41,   51,   46,   20,
 /*    80 */    27,   28,   29,   30,   50,   42,   33,   44,   35,   50,
 /*    90 */    37,   50,   39,   40,   51,   17,   17,   16,   38,   18,
 /*   100 */    19,   17,   21,   54,   51,   24,   50,   26,   27,   50,
 /*   110 */    50,   30,   25,   17,   33,   54,   35,   42,   37,   44,
 /*   120 */    39,   40,   16,   54,   18,   19,   51,   21,   50,   42,
 /*   130 */    51,   44,   51,   27,   50,   29,   30,   31,   51,   33,
 /*   140 */    17,   35,   17,   37,   17,   39,   40,   17,    1,   16,
 /*   150 */    51,   18,   19,   17,   21,   19,   20,   51,   11,   12,
 /*   160 */    27,   14,   17,   30,   45,   46,   33,   17,   35,   36,
 /*   170 */    37,   17,   39,   40,   16,   50,   18,   19,   42,   21,
 /*   180 */    44,    8,    9,   10,   51,   27,   50,   51,   30,   20,
 /*   190 */    68,   33,   34,   35,   17,   37,   57,   39,   40,   17,
 /*   200 */    58,   16,   13,   18,   19,   17,   21,   68,   20,   51,
 /*   210 */    68,   69,   27,   25,   17,   30,   74,   32,   33,   50,
 /*   220 */    35,   17,   37,   68,   39,   40,   16,   50,   18,   19,
 /*   230 */    42,   21,   44,   17,   24,   17,   51,   27,   17,   51,
 /*   240 */    30,   54,   58,   33,   17,   35,   42,   37,   44,   39,
 /*   250 */    40,   16,   68,   18,   19,   51,   21,   22,   74,   53,
 /*   260 */    54,   51,   27,   17,   17,   30,   50,   17,   33,   58,
 /*   270 */    35,   50,   37,   17,   39,   40,   17,   58,   16,   68,
 /*   280 */    18,   19,   17,   21,   73,   74,   51,   68,   69,   27,
 /*   290 */    28,   17,   30,   74,   17,   33,   57,   35,   17,   37,
 /*   300 */    17,   39,   40,   16,   68,   18,   19,   68,   21,   68,
 /*   310 */     0,   54,   68,   51,   27,   75,   46,   30,   31,    1,
 /*   320 */    33,   68,   35,   68,   37,   54,   39,   40,   68,   11,
 /*   330 */    12,   16,   14,   18,   19,   68,   21,   58,   51,   24,
 /*   340 */    68,   20,   27,   75,   68,   30,   25,   68,   33,   54,
 /*   350 */    35,   54,   37,   74,   39,   40,   16,   68,   18,   19,
 /*   360 */    68,   21,   68,   42,   68,   44,   51,   27,   68,   76,
 /*   370 */    30,   31,   51,   33,   54,   35,   54,   37,   54,   39,
 /*   380 */    40,   54,    1,   16,   54,   18,   19,   54,   21,   58,
 /*   390 */    76,   51,   11,   12,   27,   14,   76,   30,   76,   68,
 /*   400 */    33,   76,   35,   76,   37,   74,   39,   40,   76,    2,
 /*   410 */     3,    4,    5,    6,    7,    8,    9,   10,   51,    2,
 /*   420 */     3,    4,    5,    6,    7,    8,    9,   10,   76,   76,
 /*   430 */    76,   76,   76,   76,   17,   76,   76,   76,    3,    4,
 /*   440 */     5,    6,    7,    8,    9,   10,    4,    5,    6,    7,
 /*   450 */     8,    9,   10,    1,   76,   48,   76,    1,   76,   76,
 /*   460 */    76,   76,   76,   11,   12,    1,   14,   11,   12,    1,
 /*   470 */    14,   76,   76,   76,   76,   11,   12,    1,   14,   11,
 /*   480 */    12,    1,   14,   76,   76,   76,   76,   11,   12,    1,
 /*   490 */    14,   11,   12,    1,   14,   76,   76,   76,   76,   11,
 /*   500 */    12,    1,   14,   11,   12,    1,   14,   76,   76,   76,
 /*   510 */    76,   11,   12,    1,   14,   11,   12,   76,   14,   76,
 /*   520 */    76,   76,   76,   11,   12,   58,   14,   58,   58,   76,
 /*   530 */    76,   76,   76,   76,   76,   68,   58,   68,   68,   69,
 /*   540 */    73,   74,   73,   74,   74,   76,   68,   58,   76,   58,
 /*   550 */    76,   73,   74,   76,   76,   76,   76,   68,   76,   68,
 /*   560 */    58,   76,   73,   74,   73,   74,   76,   76,   76,   76,
 /*   570 */    68,   69,   58,   76,   76,   76,   74,   76,   76,   76,
 /*   580 */    76,   76,   68,   76,   76,   76,   76,   76,   74,
);
    const YY_SHIFT_USE_DFLT = -34;
    const YY_SHIFT_MAX = 135;
    static public $yy_shift_ofst = array(
 /*     0 */   -34,   53,   26,  106,   81,    1,  235,  210,  262,  287,
 /*    10 */   315,  340,  133,  185,  158,  367,  136,  -12,  -12,  -12,
 /*    20 */   -12,  -12,  -12,  -12,  204,   75,   75,  188,  321,   43,
 /*    30 */    87,   75,   75,   75,  -33,  -33,  488,  318,  456,  452,
 /*    40 */   147,   12,  381,  512,  500,  504,  492,  464,  468,  476,
 /*    50 */   480,   79,  -33,  -33,  -33,  -33,  270,  -33,  -33,  -33,
 /*    60 */   -33,  -33,  -33,  -33,  -33,  -33,  310,  -33,  270,  -33,
 /*    70 */   -33,  -34,  -34,  -34,  -34,  -34,  -34,  -34,  -34,  -34,
 /*    80 */   -34,  -34,  -34,  -34,  407,  417,  435,  442,  442,  173,
 /*    90 */    34,   39,  169,   60,  221,   84,  119,  125,   35,   32,
 /*   100 */    41,   59,   78,  177,  216,  -21,   29,   56,  -29,  -29,
 /*   110 */    96,  189,  256,  250,  246,  247,  259,  265,  283,  281,
 /*   120 */   277,  274,  227,  -29,   99,  145,  130,  123,  127,  150,
 /*   130 */   154,  -29,  -29,  218,  182,  197,
);
    const YY_REDUCE_USE_DFLT = -57;
    const YY_REDUCE_MAX = 83;
    static public $yy_reduce_ofst = array(
 /*     0 */   206,  -56,  -56,  -56,  -56,  -56,  -56,  -56,  -56,  -56,
 /*    10 */   -56,  -56,  -56,  -56,  -56,  -56,  470,  478,  489,  491,
 /*    20 */   469,  467,  -25,  211,  219,  142,  502,  514,  514,  514,
 /*    30 */   514,  279,  331,  184,  239,  139,  -54,  -54,  -54,  -54,
 /*    40 */   -54,  -54,  -54,  -54,  -54,  -54,  -54,  -54,  -54,  -54,
 /*    50 */   -54,   -1,  122,  272,  267,  260,  268,  294,  292,  276,
 /*    60 */   289,  255,  241,  236,  300,  155,  257,  253,  240,  244,
 /*    70 */   296,  324,  322,  330,  333,  295,  327,  297,  271,  320,
 /*    80 */   187,   69,   61,   49,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(16, 18, 19, 21, 27, 28, 29, 30, 33, 35, 37, 39, 40, 51, ),
        /* 2 */ array(16, 18, 19, 21, 27, 29, 30, 31, 33, 35, 37, 39, 40, 51, ),
        /* 3 */ array(16, 18, 19, 21, 27, 29, 30, 31, 33, 35, 37, 39, 40, 51, ),
        /* 4 */ array(16, 18, 19, 21, 24, 26, 27, 30, 33, 35, 37, 39, 40, 51, ),
        /* 5 */ array(16, 18, 19, 21, 24, 26, 27, 30, 33, 35, 37, 39, 40, 51, ),
        /* 6 */ array(16, 18, 19, 21, 22, 27, 30, 33, 35, 37, 39, 40, 51, ),
        /* 7 */ array(16, 18, 19, 21, 24, 27, 30, 33, 35, 37, 39, 40, 51, ),
        /* 8 */ array(16, 18, 19, 21, 27, 28, 30, 33, 35, 37, 39, 40, 51, ),
        /* 9 */ array(16, 18, 19, 21, 27, 30, 31, 33, 35, 37, 39, 40, 51, ),
        /* 10 */ array(16, 18, 19, 21, 24, 27, 30, 33, 35, 37, 39, 40, 51, ),
        /* 11 */ array(16, 18, 19, 21, 27, 30, 31, 33, 35, 37, 39, 40, 51, ),
        /* 12 */ array(16, 18, 19, 21, 27, 30, 33, 35, 36, 37, 39, 40, 51, ),
        /* 13 */ array(16, 18, 19, 21, 27, 30, 32, 33, 35, 37, 39, 40, 51, ),
        /* 14 */ array(16, 18, 19, 21, 27, 30, 33, 34, 35, 37, 39, 40, 51, ),
        /* 15 */ array(16, 18, 19, 21, 27, 30, 33, 35, 37, 39, 40, 51, ),
        /* 16 */ array(17, 19, 20, 42, 44, 50, 51, ),
        /* 17 */ array(42, 44, 47, 49, 51, ),
        /* 18 */ array(42, 44, 47, 49, 51, ),
        /* 19 */ array(42, 44, 47, 49, 51, ),
        /* 20 */ array(42, 44, 47, 49, 51, ),
        /* 21 */ array(42, 44, 47, 49, 51, ),
        /* 22 */ array(42, 44, 47, 49, 51, ),
        /* 23 */ array(42, 44, 47, 49, 51, ),
        /* 24 */ array(17, 42, 44, 51, ),
        /* 25 */ array(42, 44, 51, ),
        /* 26 */ array(42, 44, 51, ),
        /* 27 */ array(17, 20, 25, 42, 44, 51, ),
        /* 28 */ array(20, 25, 42, 44, 51, ),
        /* 29 */ array(17, 25, 42, 44, 51, ),
        /* 30 */ array(25, 42, 44, 51, ),
        /* 31 */ array(42, 44, 51, ),
        /* 32 */ array(42, 44, 51, ),
        /* 33 */ array(42, 44, 51, ),
        /* 34 */ array(51, ),
        /* 35 */ array(51, ),
        /* 36 */ array(1, 11, 12, 14, ),
        /* 37 */ array(1, 11, 12, 14, ),
        /* 38 */ array(1, 11, 12, 14, ),
        /* 39 */ array(1, 11, 12, 14, ),
        /* 40 */ array(1, 11, 12, 14, ),
        /* 41 */ array(1, 11, 12, 14, ),
        /* 42 */ array(1, 11, 12, 14, ),
        /* 43 */ array(1, 11, 12, 14, ),
        /* 44 */ array(1, 11, 12, 14, ),
        /* 45 */ array(1, 11, 12, 14, ),
        /* 46 */ array(1, 11, 12, 14, ),
        /* 47 */ array(1, 11, 12, 14, ),
        /* 48 */ array(1, 11, 12, 14, ),
        /* 49 */ array(1, 11, 12, 14, ),
        /* 50 */ array(1, 11, 12, 14, ),
        /* 51 */ array(17, 51, ),
        /* 52 */ array(51, ),
        /* 53 */ array(51, ),
        /* 54 */ array(51, ),
        /* 55 */ array(51, ),
        /* 56 */ array(46, ),
        /* 57 */ array(51, ),
        /* 58 */ array(51, ),
        /* 59 */ array(51, ),
        /* 60 */ array(51, ),
        /* 61 */ array(51, ),
        /* 62 */ array(51, ),
        /* 63 */ array(51, ),
        /* 64 */ array(51, ),
        /* 65 */ array(51, ),
        /* 66 */ array(0, ),
        /* 67 */ array(51, ),
        /* 68 */ array(46, ),
        /* 69 */ array(51, ),
        /* 70 */ array(51, ),
        /* 71 */ array(),
        /* 72 */ array(),
        /* 73 */ array(),
        /* 74 */ array(),
        /* 75 */ array(),
        /* 76 */ array(),
        /* 77 */ array(),
        /* 78 */ array(),
        /* 79 */ array(),
        /* 80 */ array(),
        /* 81 */ array(),
        /* 82 */ array(),
        /* 83 */ array(),
        /* 84 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 48, ),
        /* 85 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 17, ),
        /* 86 */ array(3, 4, 5, 6, 7, 8, 9, 10, ),
        /* 87 */ array(4, 5, 6, 7, 8, 9, 10, ),
        /* 88 */ array(4, 5, 6, 7, 8, 9, 10, ),
        /* 89 */ array(8, 9, 10, ),
        /* 90 */ array(17, 20, 50, ),
        /* 91 */ array(23, 25, 50, ),
        /* 92 */ array(20, 50, ),
        /* 93 */ array(38, 50, ),
        /* 94 */ array(17, 50, ),
        /* 95 */ array(17, 50, ),
        /* 96 */ array(45, 46, ),
        /* 97 */ array(17, 50, ),
        /* 98 */ array(15, 41, ),
        /* 99 */ array(43, 46, ),
        /* 100 */ array(17, 50, ),
        /* 101 */ array(20, 50, ),
        /* 102 */ array(17, 50, ),
        /* 103 */ array(17, 50, ),
        /* 104 */ array(17, 50, ),
        /* 105 */ array(23, 50, ),
        /* 106 */ array(17, 41, ),
        /* 107 */ array(17, 50, ),
        /* 108 */ array(50, ),
        /* 109 */ array(50, ),
        /* 110 */ array(17, ),
        /* 111 */ array(13, ),
        /* 112 */ array(17, ),
        /* 113 */ array(17, ),
        /* 114 */ array(17, ),
        /* 115 */ array(17, ),
        /* 116 */ array(17, ),
        /* 117 */ array(17, ),
        /* 118 */ array(17, ),
        /* 119 */ array(17, ),
        /* 120 */ array(17, ),
        /* 121 */ array(17, ),
        /* 122 */ array(17, ),
        /* 123 */ array(50, ),
        /* 124 */ array(51, ),
        /* 125 */ array(17, ),
        /* 126 */ array(17, ),
        /* 127 */ array(17, ),
        /* 128 */ array(17, ),
        /* 129 */ array(17, ),
        /* 130 */ array(17, ),
        /* 131 */ array(50, ),
        /* 132 */ array(50, ),
        /* 133 */ array(17, ),
        /* 134 */ array(17, ),
        /* 135 */ array(17, ),
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
);
    static public $yy_default = array(
 /*     0 */   191,  256,  256,  256,  256,  256,  256,  256,  256,  256,
 /*    10 */   256,  256,  256,  256,  256,  256,  256,  256,  256,  256,
 /*    20 */   256,  256,  256,  256,  256,  256,  256,  256,  232,  256,
 /*    30 */   234,  256,  256,  256,  256,  256,  256,  256,  256,  256,
 /*    40 */   256,  256,  256,  189,  256,  256,  256,  256,  256,  256,
 /*    50 */   256,  256,  256,  256,  256,  256,  256,  256,  256,  256,
 /*    60 */   256,  256,  256,  256,  256,  256,  191,  256,  256,  256,
 /*    70 */   256,  191,  191,  191,  191,  191,  191,  191,  191,  191,
 /*    80 */   191,  191,  191,  191,  256,  256,  247,  249,  248,  251,
 /*    90 */   256,  256,  256,  256,  256,  256,  256,  256,  256,  256,
 /*   100 */   256,  256,  256,  256,  256,  256,  256,  256,  236,  235,
 /*   110 */   256,  256,  256,  256,  256,  256,  256,  256,  256,  256,
 /*   120 */   256,  256,  256,  231,  256,  256,  256,  256,  256,  256,
 /*   130 */   256,  233,  240,  256,  256,  256,  225,  198,  197,  202,
 /*   140 */   218,  212,  201,  190,  199,  221,  200,  220,  208,  255,
 /*   150 */   223,  209,  210,  227,  243,  211,  196,  245,  228,  222,
 /*   160 */   213,  217,  224,  192,  241,  214,  215,  238,  193,  194,
 /*   170 */   216,  195,  237,  230,  226,  229,  250,  239,  252,  254,
 /*   180 */   253,  204,  244,  246,  242,  206,  219,  205,  203,
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
    const YYNOCODE = 77;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 189;
    const YYNRULE = 67;
    const YYERRORSYMBOL = 52;
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
  'T_CLOSEFOR',    'T_COMMA',       'T_EMPTY',       'T_IF',        
  'T_ENDIF',       'T_ELSE',        'T_IFCHANGED',   'T_ENDIFCHANGED',
  'T_CUSTOM_END',  'T_BLOCK',       'T_END_BLOCK',   'T_FILTER',    
  'T_END_FILTER',  'T_REGROUP',     'T_BY',          'T_CYCLE',     
  'T_FIRST_OF',    'T_PIPE',        'T_STRING_SINGLE_INIT',  'T_STRING_SINGLE_END',
  'T_STRING_DOUBLE_INIT',  'T_STRING_DOUBLE_END',  'T_STRING_CONTENT',  'T_LPARENT',   
  'T_RPARENT',     'T_NUMERIC',     'T_DOT',         'T_ALPHA',     
  'error',         'start',         'body',          'code',        
  'stmts',         'piped_list',    'var_or_string',  'stmt',        
  'for_stmt',      'ifchanged_stmt',  'block_stmt',    'filter_stmt', 
  'custom_stmt',   'if_stmt',       'fnc_call_stmt',  'alias',       
  'varname',       'list',          'cycle',         'regroup',     
  'first_of',      'expr',          'string',        's_content',   
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
 /*   6 */ "code ::= T_PRINT_OPEN piped_list T_PRINT_CLOSE",
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
 /*  26 */ "stmt ::= regroup",
 /*  27 */ "stmt ::= first_of",
 /*  28 */ "for_stmt ::= T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  29 */ "for_stmt ::= T_FOR varname T_COMMA varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  30 */ "for_stmt ::= T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  31 */ "for_stmt ::= T_FOR varname T_COMMA varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  32 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  33 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  34 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  35 */ "ifchanged_stmt ::= T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  36 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  37 */ "ifchanged_stmt ::= T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  38 */ "custom_stmt ::= varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  39 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  40 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  41 */ "filter_stmt ::= T_FILTER piped_list T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  42 */ "regroup ::= T_REGROUP varname T_BY varname T_AS varname",
 /*  43 */ "cycle ::= T_CYCLE list",
 /*  44 */ "cycle ::= T_CYCLE list T_AS varname",
 /*  45 */ "first_of ::= T_FIRST_OF list",
 /*  46 */ "piped_list ::= piped_list T_PIPE varname",
 /*  47 */ "piped_list ::= varname",
 /*  48 */ "list ::= list var_or_string",
 /*  49 */ "list ::= list T_COMMA var_or_string",
 /*  50 */ "list ::= var_or_string",
 /*  51 */ "var_or_string ::= varname",
 /*  52 */ "var_or_string ::= string",
 /*  53 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  54 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  55 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  56 */ "s_content ::= T_STRING_CONTENT",
 /*  57 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  58 */ "expr ::= expr T_AND expr",
 /*  59 */ "expr ::= expr T_OR expr",
 /*  60 */ "expr ::= expr T_EQ|T_NE expr",
 /*  61 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  62 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  63 */ "expr ::= var_or_string",
 /*  64 */ "expr ::= T_NUMERIC",
 /*  65 */ "varname ::= varname T_DOT T_ALPHA",
 /*  66 */ "varname ::= T_ALPHA",
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
  array( 'lhs' => 53, 'rhs' => 1 ),
  array( 'lhs' => 54, 'rhs' => 2 ),
  array( 'lhs' => 54, 'rhs' => 0 ),
  array( 'lhs' => 55, 'rhs' => 2 ),
  array( 'lhs' => 55, 'rhs' => 1 ),
  array( 'lhs' => 55, 'rhs' => 2 ),
  array( 'lhs' => 55, 'rhs' => 3 ),
  array( 'lhs' => 56, 'rhs' => 3 ),
  array( 'lhs' => 56, 'rhs' => 2 ),
  array( 'lhs' => 56, 'rhs' => 1 ),
  array( 'lhs' => 56, 'rhs' => 1 ),
  array( 'lhs' => 56, 'rhs' => 1 ),
  array( 'lhs' => 56, 'rhs' => 1 ),
  array( 'lhs' => 56, 'rhs' => 1 ),
  array( 'lhs' => 56, 'rhs' => 1 ),
  array( 'lhs' => 56, 'rhs' => 3 ),
  array( 'lhs' => 56, 'rhs' => 1 ),
  array( 'lhs' => 56, 'rhs' => 1 ),
  array( 'lhs' => 66, 'rhs' => 2 ),
  array( 'lhs' => 66, 'rhs' => 4 ),
  array( 'lhs' => 66, 'rhs' => 6 ),
  array( 'lhs' => 66, 'rhs' => 4 ),
  array( 'lhs' => 66, 'rhs' => 3 ),
  array( 'lhs' => 66, 'rhs' => 5 ),
  array( 'lhs' => 67, 'rhs' => 9 ),
  array( 'lhs' => 59, 'rhs' => 1 ),
  array( 'lhs' => 59, 'rhs' => 1 ),
  array( 'lhs' => 59, 'rhs' => 1 ),
  array( 'lhs' => 60, 'rhs' => 9 ),
  array( 'lhs' => 60, 'rhs' => 11 ),
  array( 'lhs' => 60, 'rhs' => 13 ),
  array( 'lhs' => 60, 'rhs' => 15 ),
  array( 'lhs' => 65, 'rhs' => 7 ),
  array( 'lhs' => 65, 'rhs' => 11 ),
  array( 'lhs' => 61, 'rhs' => 6 ),
  array( 'lhs' => 61, 'rhs' => 7 ),
  array( 'lhs' => 61, 'rhs' => 10 ),
  array( 'lhs' => 61, 'rhs' => 11 ),
  array( 'lhs' => 64, 'rhs' => 6 ),
  array( 'lhs' => 62, 'rhs' => 7 ),
  array( 'lhs' => 62, 'rhs' => 8 ),
  array( 'lhs' => 63, 'rhs' => 7 ),
  array( 'lhs' => 71, 'rhs' => 6 ),
  array( 'lhs' => 70, 'rhs' => 2 ),
  array( 'lhs' => 70, 'rhs' => 4 ),
  array( 'lhs' => 72, 'rhs' => 2 ),
  array( 'lhs' => 57, 'rhs' => 3 ),
  array( 'lhs' => 57, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 2 ),
  array( 'lhs' => 69, 'rhs' => 3 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 58, 'rhs' => 1 ),
  array( 'lhs' => 58, 'rhs' => 1 ),
  array( 'lhs' => 74, 'rhs' => 3 ),
  array( 'lhs' => 74, 'rhs' => 3 ),
  array( 'lhs' => 75, 'rhs' => 2 ),
  array( 'lhs' => 75, 'rhs' => 1 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 1 ),
  array( 'lhs' => 73, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
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
        26 => 3,
        27 => 3,
        56 => 3,
        63 => 3,
        64 => 3,
        66 => 3,
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
        45 => 45,
        46 => 46,
        49 => 46,
        47 => 47,
        50 => 47,
        48 => 48,
        51 => 51,
        52 => 52,
        53 => 53,
        54 => 53,
        55 => 55,
        57 => 57,
        58 => 58,
        59 => 58,
        60 => 58,
        61 => 58,
        62 => 58,
        65 => 65,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 63 "parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1343 "parser.php"
#line 65 "parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1346 "parser.php"
#line 66 "parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1349 "parser.php"
#line 69 "parser.y"
    function yy_r3(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1352 "parser.php"
#line 70 "parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1355 "parser.php"
#line 71 "parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1358 "parser.php"
#line 72 "parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1361 "parser.php"
#line 74 "parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1364 "parser.php"
#line 75 "parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1367 "parser.php"
#line 82 "parser.y"
    function yy_r15(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1370 "parser.php"
#line 89 "parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1373 "parser.php"
#line 90 "parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'for' => $this->yystack[$this->yyidx + -1]->minor, 'list' => array());     }
#line 1376 "parser.php"
#line 91 "parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'for' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array(),'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1379 "parser.php"
#line 92 "parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1382 "parser.php"
#line 93 "parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1385 "parser.php"
#line 94 "parser.y"
    function yy_r23(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1388 "parser.php"
#line 97 "parser.y"
    function yy_r24(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1391 "parser.php"
#line 105 "parser.y"
    function yy_r28(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1396 "parser.php"
#line 108 "parser.y"
    function yy_r29(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -9]->minor); 
    }
#line 1401 "parser.php"
#line 111 "parser.y"
    function yy_r30(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1406 "parser.php"
#line 114 "parser.y"
    function yy_r31(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -13]->minor); 
    }
#line 1411 "parser.php"
#line 118 "parser.y"
    function yy_r32(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1414 "parser.php"
#line 119 "parser.y"
    function yy_r33(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1417 "parser.php"
#line 122 "parser.y"
    function yy_r34(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1422 "parser.php"
#line 126 "parser.y"
    function yy_r35(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1427 "parser.php"
#line 129 "parser.y"
    function yy_r36(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1432 "parser.php"
#line 133 "parser.y"
    function yy_r37(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1437 "parser.php"
#line 138 "parser.y"
    function yy_r38(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'filter', 'functions' =>array($this->yystack[$this->yyidx + -5]->minor), 'body' => $this->yystack[$this->yyidx + -3]->minor);    }
#line 1440 "parser.php"
#line 141 "parser.y"
    function yy_r39(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1443 "parser.php"
#line 143 "parser.y"
    function yy_r40(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1446 "parser.php"
#line 146 "parser.y"
    function yy_r41(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1449 "parser.php"
#line 149 "parser.y"
    function yy_r42(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1452 "parser.php"
#line 152 "parser.y"
    function yy_r43(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1455 "parser.php"
#line 153 "parser.y"
    function yy_r44(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1458 "parser.php"
#line 156 "parser.y"
    function yy_r45(){ $this->_retvalue = array('operation' => 'first_of', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1461 "parser.php"
#line 160 "parser.y"
    function yy_r46(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1464 "parser.php"
#line 161 "parser.y"
    function yy_r47(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1467 "parser.php"
#line 164 "parser.y"
    function yy_r48(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1470 "parser.php"
#line 168 "parser.y"
    function yy_r51(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1473 "parser.php"
#line 169 "parser.y"
    function yy_r52(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1476 "parser.php"
#line 171 "parser.y"
    function yy_r53(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1479 "parser.php"
#line 173 "parser.y"
    function yy_r55(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1482 "parser.php"
#line 177 "parser.y"
    function yy_r57(){ $this->_retvalue = array('op' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1485 "parser.php"
#line 178 "parser.y"
    function yy_r58(){ $this->_retvalue = array('op' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1488 "parser.php"
#line 188 "parser.y"
    function yy_r65(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1491 "parser.php"

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
#line 1611 "parser.php"
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

#line 1632 "parser.php"
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