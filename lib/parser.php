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
    const T_FOR                          = 34;
    const T_CLOSEFOR                     = 35;
    const T_COMMA                        = 36;
    const T_EMPTY                        = 37;
    const T_IF                           = 38;
    const T_ENDIF                        = 39;
    const T_ELSE                         = 40;
    const T_IFCHANGED                    = 41;
    const T_ENDIFCHANGED                 = 42;
    const T_BLOCK                        = 43;
    const T_END_BLOCK                    = 44;
    const T_FILTER                       = 45;
    const T_END_FILTER                   = 46;
    const T_REGROUP                      = 47;
    const T_BY                           = 48;
    const T_PIPE                         = 49;
    const T_COLON                        = 50;
    const T_NUMERIC                      = 51;
    const T_STRING_SINGLE_INIT           = 52;
    const T_STRING_SINGLE_END            = 53;
    const T_STRING_DOUBLE_INIT           = 54;
    const T_STRING_DOUBLE_END            = 55;
    const T_STRING_CONTENT               = 56;
    const T_LPARENT                      = 57;
    const T_RPARENT                      = 58;
    const T_DOT                          = 59;
    const T_ALPHA                        = 60;
    const T_BRACKETS_OPEN                = 61;
    const T_BRACKETS_CLOSE               = 62;
    const YY_NO_ACTION = 260;
    const YY_ACCEPT_ACTION = 259;
    const YY_ERROR_ACTION = 258;

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
    const YY_SZ_ACTTAB = 634;
static public $yy_action = array(
 /*     0 */    21,   22,   17,   17,   17,   17,   17,   17,   17,   20,
 /*    10 */    20,   19,   19,   19,   21,   22,   17,   17,   17,   17,
 /*    20 */    17,   17,   17,   20,   20,   19,   19,   19,   30,   31,
 /*    30 */    28,  103,  259,   47,   70,   24,  190,  124,  122,   59,
 /*    40 */    32,   61,   19,   19,   19,   23,  138,  116,   25,  129,
 /*    50 */    56,  105,   34,  187,   36,  167,  142,   30,  166,   28,
 /*    60 */   103,   92,  104,   27,   24,  177,  124,  163,   59,   52,
 /*    70 */    61,  149,   12,  149,   23,   38,  130,   25,  111,   56,
 /*    80 */   183,   34,   30,   36,   28,  103,   71,  176,  109,   24,
 /*    90 */    35,  124,  122,   59,   32,   61,   58,    4,   73,   23,
 /*   100 */   127,  126,   25,  156,   56,  174,   34,   30,   36,   28,
 /*   110 */   103,   46,  176,  109,   24,   35,  124,  122,   59,   32,
 /*   120 */    61,  119,    3,  123,   23,   38,  122,   25,   32,   56,
 /*   130 */   185,   34,   30,   36,   28,  103,   81,  176,  109,   24,
 /*   140 */    35,  124,  122,   59,   32,   61,  133,    2,  135,   23,
 /*   150 */   137,   76,   25,   37,   56,  181,   34,   30,   36,   28,
 /*   160 */   103,  180,  176,  109,   24,   35,  124,  122,   59,   32,
 /*   170 */    61,  118,  140,  122,   23,   32,   14,   25,   38,   56,
 /*   180 */   104,   34,  108,   36,   69,  163,   30,   54,   28,  103,
 /*   190 */    80,  176,  109,   24,   35,  124,   67,   59,  148,   61,
 /*   200 */   132,    6,  122,   23,   32,   92,   25,   68,   56,  179,
 /*   210 */    34,   30,   36,   28,  103,  154,  176,  109,   24,   35,
 /*   220 */   124,  158,   59,   38,   61,  164,  166,  122,   23,   32,
 /*   230 */    77,   25,  110,   56,  102,   34,   30,   36,   28,  103,
 /*   240 */   157,  178,  125,   24,   92,  124,  159,   59,  177,   61,
 /*   250 */   104,   15,   38,   23,  189,  163,   25,   75,   56,   72,
 /*   260 */    34,   30,   36,   28,  103,  145,  176,  109,   24,   35,
 /*   270 */   124,  131,   59,  191,   61,  173,  115,  115,   23,  172,
 /*   280 */    98,   25,  121,   56,  175,   34,   30,   36,   28,  103,
 /*   290 */    92,  104,  170,   24,  177,  124,  163,   59,  149,   61,
 /*   300 */   149,    8,   62,   23,   57,   38,   25,  134,   56,  139,
 /*   310 */    34,   30,   36,   28,  103,  171,  176,  109,   24,   35,
 /*   320 */   124,  168,   59,   74,   61,  120,    7,   95,   23,  136,
 /*   330 */   156,   25,  122,   56,   32,   34,   30,   36,   28,  103,
 /*   340 */   106,  176,  109,   24,   35,  124,   90,   59,  112,   61,
 /*   350 */    92,  161,   94,   23,  177,   88,   25,   89,   56,   87,
 /*   360 */    34,   99,   36,   41,   22,   17,   17,   17,   17,   17,
 /*   370 */    17,   17,   20,   20,   19,   19,   19,  165,   30,  100,
 /*   380 */    28,  103,   96,  182,   93,   24,   91,  124,   42,   59,
 /*   390 */   153,   61,  104,    9,  107,   23,   55,  163,   25,   43,
 /*   400 */    56,   51,   34,   30,   36,   28,  103,   40,  176,  109,
 /*   410 */    24,   35,  124,   39,   59,   49,   61,   44,   78,   45,
 /*   420 */    23,  128,  153,   25,  149,   56,  149,   34,   50,   36,
 /*   430 */    17,   17,   17,   17,   17,   17,   17,   20,   20,   19,
 /*   440 */    19,   19,   30,   48,   28,  103,   53,  162,   66,   24,
 /*   450 */    65,  124,  153,   59,  153,   61,  156,   79,  153,   23,
 /*   460 */   153,  153,   25,  149,   56,  149,   34,  153,   36,  160,
 /*   470 */   153,   29,  114,  147,  146,  150,  151,  155,  153,  152,
 /*   480 */   153,  153,  188,  153,  153,  184,  162,   66,  153,   65,
 /*   490 */   153,  149,   63,  149,   13,  156,  169,  187,  149,   29,
 /*   500 */   149,  153,  149,   64,  149,  153,  104,   26,  153,  176,
 /*   510 */   109,  163,   35,  153,  162,   66,  149,   65,  149,  101,
 /*   520 */     1,  141,   66,  156,   65,  162,   66,   18,   65,   92,
 /*   530 */   156,  153,  153,  177,  156,  176,  109,  117,   35,  162,
 /*   540 */    66,  153,   65,  117,  153,  153,  153,   92,  156,  153,
 /*   550 */    84,  177,  144,   92,  117,  153,   86,  177,  144,  153,
 /*   560 */   117,  153,   10,  153,   92,  153,  153,   97,  177,  144,
 /*   570 */    92,  117,  153,   83,  177,  144,   16,  176,  109,  153,
 /*   580 */    35,   92,   33,  117,   82,  177,  144,  153,  153,  153,
 /*   590 */   117,  176,  109,   92,   35,    5,   85,  177,  144,   11,
 /*   600 */    92,  153,  153,  143,  177,  144,  153,  113,   60,  186,
 /*   610 */   176,  109,  153,   35,  176,  109,  104,   35,  104,  153,
 /*   620 */   153,  163,  153,  163,  153,  153,  153,  153,  153,  153,
 /*   630 */   153,  122,  153,   32,
    );
    static public $yy_lookahead = array(
 /*     0 */     2,    3,    4,    5,    6,    7,    8,    9,   10,   11,
 /*    10 */    12,   13,   14,   15,    2,    3,    4,    5,    6,    7,
 /*    20 */     8,    9,   10,   11,   12,   13,   14,   15,   21,   50,
 /*    30 */    23,   24,   64,   65,   22,   28,   22,   30,   59,   32,
 /*    40 */    61,   34,   13,   14,   15,   38,   20,   40,   41,   42,
 /*    50 */    43,   68,   45,   69,   47,   53,   58,   21,   56,   23,
 /*    60 */    24,   78,   78,   79,   28,   82,   30,   83,   32,   65,
 /*    70 */    34,   28,    1,   30,   38,   49,   40,   41,   42,   43,
 /*    80 */    22,   45,   21,   47,   23,   24,   22,   16,   17,   28,
 /*    90 */    19,   30,   59,   32,   61,   34,   29,    1,   22,   38,
 /*   100 */    39,   40,   41,   60,   43,   22,   45,   21,   47,   23,
 /*   110 */    24,   65,   16,   17,   28,   19,   30,   59,   32,   61,
 /*   120 */    34,   35,    1,   37,   38,   49,   59,   41,   61,   43,
 /*   130 */    22,   45,   21,   47,   23,   24,   22,   16,   17,   28,
 /*   140 */    19,   30,   59,   32,   61,   34,   35,    1,   37,   38,
 /*   150 */    22,   22,   41,   10,   43,   22,   45,   21,   47,   23,
 /*   160 */    24,   22,   16,   17,   28,   19,   30,   59,   32,   61,
 /*   170 */    34,   69,   22,   59,   38,   61,    1,   41,   49,   43,
 /*   180 */    78,   45,   46,   47,   22,   83,   21,   65,   23,   24,
 /*   190 */    22,   16,   17,   28,   19,   30,   22,   32,   22,   34,
 /*   200 */    35,    1,   59,   38,   61,   78,   41,   22,   43,   82,
 /*   210 */    45,   21,   47,   23,   24,   22,   16,   17,   28,   19,
 /*   220 */    30,   60,   32,   49,   34,   55,   56,   59,   38,   61,
 /*   230 */    22,   41,   42,   43,   68,   45,   21,   47,   23,   24,
 /*   240 */    62,   69,   27,   28,   78,   30,   22,   32,   82,   34,
 /*   250 */    78,    1,   49,   38,   22,   83,   41,   22,   43,   22,
 /*   260 */    45,   21,   47,   23,   24,   22,   16,   17,   28,   19,
 /*   270 */    30,   31,   32,   18,   34,   22,   25,   26,   38,   22,
 /*   280 */    68,   41,   69,   43,   22,   45,   21,   47,   23,   24,
 /*   290 */    78,   78,   22,   28,   82,   30,   83,   32,   28,   34,
 /*   300 */    30,    1,   29,   38,   48,   49,   41,   42,   43,   22,
 /*   310 */    45,   21,   47,   23,   24,   22,   16,   17,   28,   19,
 /*   320 */    30,   22,   32,   22,   34,   35,    1,   78,   38,   22,
 /*   330 */    60,   41,   59,   43,   61,   45,   21,   47,   23,   24,
 /*   340 */    68,   16,   17,   28,   19,   30,   78,   32,   33,   34,
 /*   350 */    78,   66,   78,   38,   82,   78,   41,   78,   43,   78,
 /*   360 */    45,   78,   47,   65,    3,    4,    5,    6,    7,    8,
 /*   370 */     9,   10,   11,   12,   13,   14,   15,   56,   21,   84,
 /*   380 */    23,   24,   78,   69,   78,   28,   78,   30,   65,   32,
 /*   390 */    85,   34,   78,    1,   84,   38,   65,   83,   41,   65,
 /*   400 */    43,   44,   45,   21,   47,   23,   24,   65,   16,   17,
 /*   410 */    28,   19,   30,   65,   32,   65,   34,   65,   22,   65,
 /*   420 */    38,   39,   85,   41,   28,   43,   30,   45,   65,   47,
 /*   430 */     4,    5,    6,    7,    8,    9,   10,   11,   12,   13,
 /*   440 */    14,   15,   21,   65,   23,   24,   65,   51,   52,   28,
 /*   450 */    54,   30,   85,   32,   85,   34,   60,   22,   85,   38,
 /*   460 */    85,   85,   41,   28,   43,   30,   45,   85,   47,   67,
 /*   470 */    85,   36,   70,   71,   72,   73,   74,   75,   76,   77,
 /*   480 */    85,   85,   80,   85,   85,   22,   51,   52,   85,   54,
 /*   490 */    85,   28,   29,   30,    1,   60,   22,   69,   28,   36,
 /*   500 */    30,   85,   28,   29,   30,   85,   78,   79,   85,   16,
 /*   510 */    17,   83,   19,   85,   51,   52,   28,   54,   30,   68,
 /*   520 */     1,   51,   52,   60,   54,   51,   52,   57,   54,   78,
 /*   530 */    60,   85,   85,   82,   60,   16,   17,   68,   19,   51,
 /*   540 */    52,   85,   54,   68,   85,   85,   85,   78,   60,   85,
 /*   550 */    81,   82,   83,   78,   68,   85,   81,   82,   83,   85,
 /*   560 */    68,   85,    1,   85,   78,   85,   85,   81,   82,   83,
 /*   570 */    78,   68,   85,   81,   82,   83,    1,   16,   17,   85,
 /*   580 */    19,   78,   10,   68,   81,   82,   83,   85,   85,   85,
 /*   590 */    68,   16,   17,   78,   19,    1,   81,   82,   83,    1,
 /*   600 */    78,   85,   85,   81,   82,   83,   85,   69,   36,   69,
 /*   610 */    16,   17,   85,   19,   16,   17,   78,   19,   78,   85,
 /*   620 */    85,   83,   85,   83,   85,   85,   85,   85,   85,   85,
 /*   630 */    85,   59,   85,   61,
);
    const YY_SHIFT_USE_DFLT = -22;
    const YY_SHIFT_MAX = 135;
    static public $yy_shift_ofst = array(
 /*     0 */   -22,  111,   86,   61,   36,    7,  315,  382,  240,  136,
 /*    10 */   190,  265,  290,  357,  215,  165,  421,  470,  470,  470,
 /*    20 */   470,  470,  470,  470,  474,  396,  463,  435,  488,  488,
 /*    30 */   488,  488,  488,   43,   43,   43,   43,   43,   43,  300,
 /*    40 */   250,  519,   71,  325,  594,  561,  493,  575,  598,  392,
 /*    50 */   121,  270,  200,  175,   96,  146,   43,   43,   43,   43,
 /*    60 */    43,   43,   43,   43,   43,  321,  321,  -22,  -22,  -22,
 /*    70 */   -22,  -22,  -22,  -22,  -22,  -22,  -22,  -22,  -22,  -22,
 /*    80 */   -22,  -22,   12,   -2,  361,  426,  426,  572,  273,  168,
 /*    90 */   143,   83,  -21,  108,  114,   67,   58,   29,  129,   33,
 /*   100 */   170,  256,   26,  251,   33,  174,   76,    2,  262,  255,
 /*   110 */   293,  287,  232,  193,  176,  162,  208,  203,  178,  150,
 /*   120 */   307,  224,  161,  185,  235,  299,  237,  243,  253,  257,
 /*   130 */   301,   14,  139,  133,  128,   64,
);
    const YY_REDUCE_USE_DFLT = -33;
    const YY_REDUCE_MAX = 81;
    static public $yy_reduce_ofst = array(
 /*     0 */   -32,  402,  402,  402,  402,  402,  402,  402,  402,  402,
 /*    10 */   402,  402,  402,  402,  402,  402,  402,  475,  492,  522,
 /*    20 */   486,  469,  515,  503,  428,  -16,  314,  314,  538,  540,
 /*    30 */   213,  172,  102,  -17,  212,  166,  451,  272,  127,  285,
 /*    40 */   285,  285,  285,  285,  285,  285,  285,  285,  285,  285,
 /*    50 */   285,  308,  285,  285,  285,  285,  279,  277,  274,  249,
 /*    60 */   268,  281,  283,  304,  306,  295,  310,  298,  323,  381,
 /*    70 */   363,  342,  334,  331,  378,  348,  350,  354,  352,  122,
 /*    80 */    46,    4,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(21, 23, 24, 28, 30, 32, 34, 35, 37, 38, 41, 43, 45, 47, ),
        /* 2 */ array(21, 23, 24, 28, 30, 32, 34, 35, 37, 38, 41, 43, 45, 47, ),
        /* 3 */ array(21, 23, 24, 28, 30, 32, 34, 38, 39, 40, 41, 43, 45, 47, ),
        /* 4 */ array(21, 23, 24, 28, 30, 32, 34, 38, 40, 41, 42, 43, 45, 47, ),
        /* 5 */ array(21, 23, 24, 28, 30, 32, 34, 38, 40, 41, 42, 43, 45, 47, ),
        /* 6 */ array(21, 23, 24, 28, 30, 32, 33, 34, 38, 41, 43, 45, 47, ),
        /* 7 */ array(21, 23, 24, 28, 30, 32, 34, 38, 39, 41, 43, 45, 47, ),
        /* 8 */ array(21, 23, 24, 28, 30, 31, 32, 34, 38, 41, 43, 45, 47, ),
        /* 9 */ array(21, 23, 24, 28, 30, 32, 34, 38, 41, 43, 45, 46, 47, ),
        /* 10 */ array(21, 23, 24, 28, 30, 32, 34, 38, 41, 42, 43, 45, 47, ),
        /* 11 */ array(21, 23, 24, 28, 30, 32, 34, 38, 41, 42, 43, 45, 47, ),
        /* 12 */ array(21, 23, 24, 28, 30, 32, 34, 35, 38, 41, 43, 45, 47, ),
        /* 13 */ array(21, 23, 24, 28, 30, 32, 34, 38, 41, 43, 44, 45, 47, ),
        /* 14 */ array(21, 23, 24, 27, 28, 30, 32, 34, 38, 41, 43, 45, 47, ),
        /* 15 */ array(21, 23, 24, 28, 30, 32, 34, 35, 38, 41, 43, 45, 47, ),
        /* 16 */ array(21, 23, 24, 28, 30, 32, 34, 38, 41, 43, 45, 47, ),
        /* 17 */ array(28, 30, 51, 52, 54, 57, 60, ),
        /* 18 */ array(28, 30, 51, 52, 54, 57, 60, ),
        /* 19 */ array(28, 30, 51, 52, 54, 57, 60, ),
        /* 20 */ array(28, 30, 51, 52, 54, 57, 60, ),
        /* 21 */ array(28, 30, 51, 52, 54, 57, 60, ),
        /* 22 */ array(28, 30, 51, 52, 54, 57, 60, ),
        /* 23 */ array(28, 30, 51, 52, 54, 57, 60, ),
        /* 24 */ array(22, 28, 29, 30, 51, 52, 54, 60, ),
        /* 25 */ array(22, 28, 30, 51, 52, 54, 60, ),
        /* 26 */ array(22, 28, 29, 30, 36, 51, 52, 54, 60, ),
        /* 27 */ array(22, 28, 30, 36, 51, 52, 54, 60, ),
        /* 28 */ array(28, 30, 51, 52, 54, 60, ),
        /* 29 */ array(28, 30, 51, 52, 54, 60, ),
        /* 30 */ array(28, 30, 51, 52, 54, 60, ),
        /* 31 */ array(28, 30, 51, 52, 54, 60, ),
        /* 32 */ array(28, 30, 51, 52, 54, 60, ),
        /* 33 */ array(28, 30, 60, ),
        /* 34 */ array(28, 30, 60, ),
        /* 35 */ array(28, 30, 60, ),
        /* 36 */ array(28, 30, 60, ),
        /* 37 */ array(28, 30, 60, ),
        /* 38 */ array(28, 30, 60, ),
        /* 39 */ array(1, 16, 17, 19, ),
        /* 40 */ array(1, 16, 17, 19, ),
        /* 41 */ array(1, 16, 17, 19, ),
        /* 42 */ array(1, 16, 17, 19, ),
        /* 43 */ array(1, 16, 17, 19, ),
        /* 44 */ array(1, 16, 17, 19, ),
        /* 45 */ array(1, 16, 17, 19, ),
        /* 46 */ array(1, 16, 17, 19, ),
        /* 47 */ array(1, 16, 17, 19, ),
        /* 48 */ array(1, 16, 17, 19, ),
        /* 49 */ array(1, 16, 17, 19, ),
        /* 50 */ array(1, 16, 17, 19, ),
        /* 51 */ array(22, 28, 30, 60, ),
        /* 52 */ array(1, 16, 17, 19, ),
        /* 53 */ array(1, 16, 17, 19, ),
        /* 54 */ array(1, 16, 17, 19, ),
        /* 55 */ array(1, 16, 17, 19, ),
        /* 56 */ array(28, 30, 60, ),
        /* 57 */ array(28, 30, 60, ),
        /* 58 */ array(28, 30, 60, ),
        /* 59 */ array(28, 30, 60, ),
        /* 60 */ array(28, 30, 60, ),
        /* 61 */ array(28, 30, 60, ),
        /* 62 */ array(28, 30, 60, ),
        /* 63 */ array(28, 30, 60, ),
        /* 64 */ array(28, 30, 60, ),
        /* 65 */ array(56, ),
        /* 66 */ array(56, ),
        /* 67 */ array(),
        /* 68 */ array(),
        /* 69 */ array(),
        /* 70 */ array(),
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
        /* 82 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 22, ),
        /* 83 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 58, ),
        /* 84 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 85 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 86 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 87 */ array(10, 36, 59, 61, ),
        /* 88 */ array(29, 59, 61, ),
        /* 89 */ array(22, 59, 61, ),
        /* 90 */ array(10, 59, 61, ),
        /* 91 */ array(22, 59, 61, ),
        /* 92 */ array(50, 59, 61, ),
        /* 93 */ array(22, 59, 61, ),
        /* 94 */ array(22, 59, 61, ),
        /* 95 */ array(29, 59, 61, ),
        /* 96 */ array(22, 59, 61, ),
        /* 97 */ array(13, 14, 15, ),
        /* 98 */ array(22, 49, ),
        /* 99 */ array(59, 61, ),
        /* 100 */ array(55, 56, ),
        /* 101 */ array(48, 49, ),
        /* 102 */ array(20, 49, ),
        /* 103 */ array(25, 26, ),
        /* 104 */ array(59, 61, ),
        /* 105 */ array(22, 49, ),
        /* 106 */ array(22, 49, ),
        /* 107 */ array(53, 56, ),
        /* 108 */ array(22, ),
        /* 109 */ array(18, ),
        /* 110 */ array(22, ),
        /* 111 */ array(22, ),
        /* 112 */ array(22, ),
        /* 113 */ array(22, ),
        /* 114 */ array(22, ),
        /* 115 */ array(22, ),
        /* 116 */ array(22, ),
        /* 117 */ array(49, ),
        /* 118 */ array(62, ),
        /* 119 */ array(22, ),
        /* 120 */ array(22, ),
        /* 121 */ array(22, ),
        /* 122 */ array(60, ),
        /* 123 */ array(22, ),
        /* 124 */ array(22, ),
        /* 125 */ array(22, ),
        /* 126 */ array(22, ),
        /* 127 */ array(22, ),
        /* 128 */ array(22, ),
        /* 129 */ array(22, ),
        /* 130 */ array(22, ),
        /* 131 */ array(22, ),
        /* 132 */ array(22, ),
        /* 133 */ array(22, ),
        /* 134 */ array(22, ),
        /* 135 */ array(22, ),
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
        /* 189 */ array(),
        /* 190 */ array(),
        /* 191 */ array(),
);
    static public $yy_default = array(
 /*     0 */   194,  258,  258,  258,  258,  258,  258,  258,  258,  258,
 /*    10 */   258,  258,  258,  258,  258,  258,  258,  258,  258,  258,
 /*    20 */   258,  258,  258,  258,  258,  258,  258,  258,  258,  258,
 /*    30 */   258,  258,  258,  258,  258,  258,  258,  258,  258,  258,
 /*    40 */   258,  258,  258,  258,  258,  258,  258,  192,  258,  258,
 /*    50 */   258,  258,  258,  258,  258,  258,  258,  258,  258,  258,
 /*    60 */   258,  258,  258,  258,  258,  258,  258,  194,  194,  194,
 /*    70 */   194,  194,  194,  194,  194,  194,  194,  194,  194,  194,
 /*    80 */   194,  194,  258,  258,  245,  246,  248,  258,  258,  258,
 /*    90 */   258,  258,  234,  258,  258,  258,  258,  247,  258,  230,
 /*   100 */   258,  258,  258,  258,  238,  258,  258,  258,  258,  258,
 /*   110 */   258,  258,  258,  258,  258,  258,  258,  250,  258,  258,
 /*   120 */   258,  258,  258,  258,  258,  258,  258,  258,  258,  258,
 /*   130 */   258,  258,  258,  258,  258,  258,  220,  226,  198,  224,
 /*   140 */   218,  253,  251,  249,  252,  221,  202,  201,  200,  257,
 /*   150 */   203,  204,  208,  207,  206,  205,  256,  255,  254,  199,
 /*   160 */   195,  193,  239,  240,  242,  244,  243,  241,  209,  210,
 /*   170 */   227,  225,  223,  222,  228,  229,  196,  232,  233,  231,
 /*   180 */   219,  217,  235,  213,  212,  211,  236,  237,  216,  215,
 /*   190 */   214,  197,
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
    const YYNOCODE = 86;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 192;
    const YYNRULE = 66;
    const YYERRORSYMBOL = 63;
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
  'T_WITH',        'T_ENDWITH',     'T_FOR',         'T_CLOSEFOR',  
  'T_COMMA',       'T_EMPTY',       'T_IF',          'T_ENDIF',     
  'T_ELSE',        'T_IFCHANGED',   'T_ENDIFCHANGED',  'T_BLOCK',     
  'T_END_BLOCK',   'T_FILTER',      'T_END_FILTER',  'T_REGROUP',   
  'T_BY',          'T_PIPE',        'T_COLON',       'T_NUMERIC',   
  'T_STRING_SINGLE_INIT',  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',  'T_STRING_DOUBLE_END',
  'T_STRING_CONTENT',  'T_LPARENT',     'T_RPARENT',     'T_DOT',       
  'T_ALPHA',       'T_BRACKETS_OPEN',  'T_BRACKETS_CLOSE',  'error',       
  'start',         'body',          'code',          'stmts',       
  'filtered_var',  'var_or_string',  'stmt',          'for_stmt',    
  'ifchanged_stmt',  'block_stmt',    'filter_stmt',   'if_stmt',     
  'custom_tag',    'alias',         'varname',       'var_list',    
  'regroup',       'expr',          'varname_args',  'string',      
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
 /*  17 */ "stmts ::= T_AUTOESCAPE T_OFF|T_ON T_CLOSE_TAG body T_OPEN_TAG T_END_AUTOESCAPE T_CLOSE_TAG",
 /*  18 */ "custom_tag ::= T_CUSTOM_TAG T_CLOSE_TAG",
 /*  19 */ "custom_tag ::= T_CUSTOM_TAG T_AS varname T_CLOSE_TAG",
 /*  20 */ "custom_tag ::= T_CUSTOM_TAG var_list T_CLOSE_TAG",
 /*  21 */ "custom_tag ::= T_CUSTOM_TAG var_list T_AS varname T_CLOSE_TAG",
 /*  22 */ "custom_tag ::= T_CUSTOM_BLOCK T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  23 */ "alias ::= T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_ENDWITH T_CLOSE_TAG",
 /*  24 */ "stmt ::= regroup",
 /*  25 */ "for_stmt ::= T_FOR varname T_IN filtered_var T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  26 */ "for_stmt ::= T_FOR varname T_COMMA varname T_IN filtered_var T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  27 */ "for_stmt ::= T_FOR varname T_IN filtered_var T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  28 */ "for_stmt ::= T_FOR varname T_COMMA varname T_IN filtered_var T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  29 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  30 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  31 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  32 */ "ifchanged_stmt ::= T_IFCHANGED var_list T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  33 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  34 */ "ifchanged_stmt ::= T_IFCHANGED var_list T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  35 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  36 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  37 */ "filter_stmt ::= T_FILTER filtered_var T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  38 */ "regroup ::= T_REGROUP filtered_var T_BY varname T_AS varname",
 /*  39 */ "filtered_var ::= filtered_var T_PIPE varname_args",
 /*  40 */ "filtered_var ::= varname_args",
 /*  41 */ "varname_args ::= varname T_COLON var_or_string",
 /*  42 */ "varname_args ::= varname",
 /*  43 */ "var_list ::= var_list var_or_string",
 /*  44 */ "var_list ::= var_list T_COMMA var_or_string",
 /*  45 */ "var_list ::= var_or_string",
 /*  46 */ "var_or_string ::= varname",
 /*  47 */ "var_or_string ::= T_NUMERIC",
 /*  48 */ "var_or_string ::= string",
 /*  49 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  50 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  51 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  52 */ "s_content ::= T_STRING_CONTENT",
 /*  53 */ "expr ::= expr T_AND expr",
 /*  54 */ "expr ::= expr T_OR expr",
 /*  55 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  56 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN expr",
 /*  57 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  58 */ "expr ::= filtered_var",
 /*  59 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  60 */ "expr ::= string",
 /*  61 */ "expr ::= T_NUMERIC",
 /*  62 */ "varname ::= varname T_DOT T_ALPHA",
 /*  63 */ "varname ::= varname T_BRACKETS_OPEN var_or_string T_BRACKETS_CLOSE",
 /*  64 */ "varname ::= T_ALPHA",
 /*  65 */ "varname ::= T_CUSTOM_TAG|T_CUSTOM_BLOCK",
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
  array( 'lhs' => 64, 'rhs' => 1 ),
  array( 'lhs' => 65, 'rhs' => 2 ),
  array( 'lhs' => 65, 'rhs' => 0 ),
  array( 'lhs' => 66, 'rhs' => 2 ),
  array( 'lhs' => 66, 'rhs' => 1 ),
  array( 'lhs' => 66, 'rhs' => 2 ),
  array( 'lhs' => 66, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 2 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 7 ),
  array( 'lhs' => 76, 'rhs' => 2 ),
  array( 'lhs' => 76, 'rhs' => 4 ),
  array( 'lhs' => 76, 'rhs' => 3 ),
  array( 'lhs' => 76, 'rhs' => 5 ),
  array( 'lhs' => 76, 'rhs' => 6 ),
  array( 'lhs' => 77, 'rhs' => 9 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 9 ),
  array( 'lhs' => 71, 'rhs' => 11 ),
  array( 'lhs' => 71, 'rhs' => 13 ),
  array( 'lhs' => 71, 'rhs' => 15 ),
  array( 'lhs' => 75, 'rhs' => 7 ),
  array( 'lhs' => 75, 'rhs' => 11 ),
  array( 'lhs' => 72, 'rhs' => 6 ),
  array( 'lhs' => 72, 'rhs' => 7 ),
  array( 'lhs' => 72, 'rhs' => 10 ),
  array( 'lhs' => 72, 'rhs' => 11 ),
  array( 'lhs' => 73, 'rhs' => 7 ),
  array( 'lhs' => 73, 'rhs' => 8 ),
  array( 'lhs' => 74, 'rhs' => 7 ),
  array( 'lhs' => 80, 'rhs' => 6 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 82, 'rhs' => 3 ),
  array( 'lhs' => 82, 'rhs' => 1 ),
  array( 'lhs' => 79, 'rhs' => 2 ),
  array( 'lhs' => 79, 'rhs' => 3 ),
  array( 'lhs' => 79, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 83, 'rhs' => 3 ),
  array( 'lhs' => 83, 'rhs' => 3 ),
  array( 'lhs' => 84, 'rhs' => 2 ),
  array( 'lhs' => 84, 'rhs' => 1 ),
  array( 'lhs' => 81, 'rhs' => 3 ),
  array( 'lhs' => 81, 'rhs' => 3 ),
  array( 'lhs' => 81, 'rhs' => 3 ),
  array( 'lhs' => 81, 'rhs' => 3 ),
  array( 'lhs' => 81, 'rhs' => 3 ),
  array( 'lhs' => 81, 'rhs' => 1 ),
  array( 'lhs' => 81, 'rhs' => 3 ),
  array( 'lhs' => 81, 'rhs' => 1 ),
  array( 'lhs' => 81, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 3 ),
  array( 'lhs' => 78, 'rhs' => 4 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
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
        24 => 3,
        42 => 3,
        52 => 3,
        64 => 3,
        65 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        14 => 14,
        17 => 17,
        18 => 18,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
        25 => 25,
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
        44 => 39,
        40 => 40,
        45 => 40,
        41 => 41,
        43 => 43,
        46 => 46,
        47 => 47,
        61 => 47,
        48 => 48,
        60 => 48,
        49 => 49,
        50 => 49,
        51 => 51,
        53 => 53,
        54 => 53,
        55 => 53,
        57 => 53,
        56 => 56,
        58 => 58,
        59 => 59,
        62 => 62,
        63 => 63,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 65 "parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1368 "parser.php"
#line 67 "parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1371 "parser.php"
#line 68 "parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1374 "parser.php"
#line 71 "parser.y"
    function yy_r3(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1377 "parser.php"
#line 72 "parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1380 "parser.php"
#line 73 "parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1383 "parser.php"
#line 74 "parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1386 "parser.php"
#line 76 "parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1389 "parser.php"
#line 77 "parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1392 "parser.php"
#line 83 "parser.y"
    function yy_r14(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1395 "parser.php"
#line 86 "parser.y"
    function yy_r17(){ $this->_retvalue = array('operation' => 'autoescape', 'value' => strtolower(@$this->yystack[$this->yyidx + -5]->minor), 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1398 "parser.php"
#line 91 "parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1401 "parser.php"
#line 92 "parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1404 "parser.php"
#line 93 "parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1407 "parser.php"
#line 94 "parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1410 "parser.php"
#line 96 "parser.y"
    function yy_r22(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array());    }
#line 1413 "parser.php"
#line 99 "parser.y"
    function yy_r23(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1416 "parser.php"
#line 105 "parser.y"
    function yy_r25(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL); 
    }
#line 1421 "parser.php"
#line 108 "parser.y"
    function yy_r26(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -9]->minor); 
    }
#line 1426 "parser.php"
#line 111 "parser.y"
    function yy_r27(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL); 
    }
#line 1431 "parser.php"
#line 114 "parser.y"
    function yy_r28(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -13]->minor); 
    }
#line 1436 "parser.php"
#line 118 "parser.y"
    function yy_r29(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1439 "parser.php"
#line 119 "parser.y"
    function yy_r30(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1442 "parser.php"
#line 122 "parser.y"
    function yy_r31(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1447 "parser.php"
#line 126 "parser.y"
    function yy_r32(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1452 "parser.php"
#line 129 "parser.y"
    function yy_r33(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1457 "parser.php"
#line 133 "parser.y"
    function yy_r34(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1462 "parser.php"
#line 139 "parser.y"
    function yy_r35(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1465 "parser.php"
#line 141 "parser.y"
    function yy_r36(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1468 "parser.php"
#line 144 "parser.y"
    function yy_r37(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1471 "parser.php"
#line 147 "parser.y"
    function yy_r38(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1474 "parser.php"
#line 150 "parser.y"
    function yy_r39(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1477 "parser.php"
#line 151 "parser.y"
    function yy_r40(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1480 "parser.php"
#line 153 "parser.y"
    function yy_r41(){ $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, 'args'=>array($this->yystack[$this->yyidx + 0]->minor));     }
#line 1483 "parser.php"
#line 157 "parser.y"
    function yy_r43(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1486 "parser.php"
#line 163 "parser.y"
    function yy_r46(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1489 "parser.php"
#line 164 "parser.y"
    function yy_r47(){ $this->_retvalue = array('number' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1492 "parser.php"
#line 165 "parser.y"
    function yy_r48(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1495 "parser.php"
#line 167 "parser.y"
    function yy_r49(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1498 "parser.php"
#line 169 "parser.y"
    function yy_r51(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1501 "parser.php"
#line 173 "parser.y"
    function yy_r53(){ $this->_retvalue = array('op_expr' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1504 "parser.php"
#line 176 "parser.y"
    function yy_r56(){ $this->_retvalue = array('op_expr' => trim(@$this->yystack[$this->yyidx + -1]->minor), $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1507 "parser.php"
#line 178 "parser.y"
    function yy_r58(){$this->_retvalue = array('var_filter' => $this->yystack[$this->yyidx + 0]->minor);    }
#line 1510 "parser.php"
#line 179 "parser.y"
    function yy_r59(){ $this->_retvalue = array('op_expr' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1513 "parser.php"
#line 185 "parser.y"
    function yy_r62(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1516 "parser.php"
#line 186 "parser.y"
    function yy_r63(){ if (!is_array($this->yystack[$this->yyidx + -3]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -3]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + -1]->minor;    }
#line 1519 "parser.php"

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
#line 56 "parser.y"

    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    throw new Exception('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
#line 1639 "parser.php"
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

#line 1660 "parser.php"
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