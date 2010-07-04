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
    const T_PLUS                         = 10;
    const T_MINUS                        = 11;
    const T_TIMES                        = 12;
    const T_DIV                          = 13;
    const T_MOD                          = 14;
    const T_HTML                         = 15;
    const T_COMMENT_OPEN                 = 16;
    const T_COMMENT                      = 17;
    const T_PRINT_OPEN                   = 18;
    const T_PRINT_CLOSE                  = 19;
    const T_EXTENDS                      = 20;
    const T_CLOSE_TAG                    = 21;
    const T_INCLUDE                      = 22;
    const T_FOR                          = 23;
    const T_AS                           = 24;
    const T_WITH                         = 25;
    const T_ENDWITH                      = 26;
    const T_IN                           = 27;
    const T_CLOSEFOR                     = 28;
    const T_COMMA                        = 29;
    const T_EMPTY                        = 30;
    const T_IF                           = 31;
    const T_ENDIF                        = 32;
    const T_ELSE                         = 33;
    const T_IFCHANGED                    = 34;
    const T_ENDIFCHANGED                 = 35;
    const T_CUSTOM_END                   = 36;
    const T_BLOCK                        = 37;
    const T_END_BLOCK                    = 38;
    const T_FILTER                       = 39;
    const T_END_FILTER                   = 40;
    const T_REGROUP                      = 41;
    const T_BY                           = 42;
    const T_CYCLE                        = 43;
    const T_FIRST_OF                     = 44;
    const T_PIPE                         = 45;
    const T_COLON                        = 46;
    const T_STRING_SINGLE_INIT           = 47;
    const T_STRING_SINGLE_END            = 48;
    const T_STRING_DOUBLE_INIT           = 49;
    const T_STRING_DOUBLE_END            = 50;
    const T_STRING_CONTENT               = 51;
    const T_LPARENT                      = 52;
    const T_RPARENT                      = 53;
    const T_NUMERIC                      = 54;
    const T_DOT                          = 55;
    const T_ALPHA                        = 56;
    const YY_NO_ACTION = 265;
    const YY_ACCEPT_ACTION = 264;
    const YY_ERROR_ACTION = 263;

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
    const YY_SZ_ACTTAB = 615;
static public $yy_action = array(
 /*     0 */   163,  167,  169,  135,  153,  152,  151,  150,  154,  155,
 /*    10 */   157,  156,   23,  164,  171,  186,  185,   20,   22,   18,
 /*    20 */    18,   18,   18,   18,   18,   19,   19,   17,   17,   17,
 /*    30 */    32,  160,   33,   58,  146,   68,   79,   67,   17,   17,
 /*    40 */    17,   16,  190,  118,   24,  117,  103,   55,  174,   36,
 /*    50 */    96,   59,   83,   26,   25,   61,  177,   63,  116,   28,
 /*    60 */    21,   70,  142,   54,  160,  165,  160,  182,  115,   20,
 /*    70 */    22,   18,   18,   18,   18,   18,   18,   19,   19,   17,
 /*    80 */    17,   17,   13,  162,  166,   31,  115,  169,  161,  115,
 /*    90 */    32,  108,   33,   58,   82,   68,  173,  110,  124,   35,
 /*   100 */   126,   16,   96,   61,   24,   63,  130,   55,  179,   36,
 /*   110 */    40,   59,  160,   26,   25,  112,   32,   96,   33,   58,
 /*   120 */   139,   68,  147,  179,  140,  116,  160,   16,  123,  128,
 /*   130 */    24,  176,  165,   55,   73,   36,   65,   59,  148,   26,
 /*   140 */    25,   62,   56,   43,   95,   61,   31,   63,   32,  115,
 /*   150 */    33,   58,  160,   68,  160,   96,  136,   37,  125,   16,
 /*   160 */    72,  179,   24,  191,   61,   55,   63,   36,  115,   59,
 /*   170 */   115,   26,   25,  160,   32,  115,   33,   58,   57,   68,
 /*   180 */    69,   60,  189,   34,  160,   16,   78,  113,   24,  132,
 /*   190 */    48,   55,  115,   36,  115,   59,   76,   26,   25,   74,
 /*   200 */    32,   37,   33,   58,   61,   68,   63,   31,  264,   45,
 /*   210 */   160,   16,  115,  160,   24,  114,  115,   55,  149,   36,
 /*   220 */    37,   59,  174,   26,   25,   61,   32,   63,   33,   58,
 /*   230 */    77,   68,  116,   30,  160,  105,  160,   16,   49,  165,
 /*   240 */    24,  131,  170,   55,   84,   36,  178,   59,  174,   26,
 /*   250 */    25,  181,   32,  160,   33,   58,  145,   68,  116,   27,
 /*   260 */   192,  116,  160,   16,  122,  165,   24,  141,  165,   55,
 /*   270 */    61,   36,   63,   59,   71,   26,   25,  175,   32,  160,
 /*   280 */    33,   58,  183,   68,  133,   80,  172,  116,  160,   16,
 /*   290 */   115,   66,   24,  159,  165,   55,   81,   36,  101,   59,
 /*   300 */   174,   26,   25,  180,   32,  115,   33,   58,   46,   68,
 /*   310 */   116,   29,  120,  116,  160,   16,  137,  165,   24,  119,
 /*   320 */   165,   55,  115,   36,  168,   59,   99,   26,   25,  116,
 /*   330 */    32,  154,   33,   58,  211,   68,  165,   64,   75,  134,
 /*   340 */   160,   16,   31,   94,   24,   52,  121,   55,   38,   36,
 /*   350 */   115,   59,  144,   26,   25,  129,   32,   97,   33,   58,
 /*   360 */    61,   68,   63,  102,  111,  109,  160,   16,   44,  160,
 /*   370 */    24,  104,  115,   55,   92,   36,   98,   59,   93,   26,
 /*   380 */    25,   42,   32,   41,   33,   58,  115,   68,  143,  106,
 /*   390 */   138,  158,  160,   16,   50,  184,   24,   39,  187,   55,
 /*   400 */    53,   36,   51,   59,   47,   26,   25,  188,   32,  154,
 /*   410 */    33,   58,   90,   68,  100,  107,  154,  154,  160,   16,
 /*   420 */   154,  154,   24,  154,  154,   55,  154,   36,  127,   59,
 /*   430 */   154,   26,   25,  154,   32,  154,   33,   58,  154,   68,
 /*   440 */   154,  154,  154,  130,  160,   16,  154,  154,   24,  154,
 /*   450 */     2,   55,  154,   36,   96,   59,  154,   26,   25,   89,
 /*   460 */   179,  140,  154,  154,  173,  110,  154,   35,  154,  154,
 /*   470 */   160,  154,  154,  154,   22,   18,   18,   18,   18,   18,
 /*   480 */    18,   19,   19,   17,   17,   17,   18,   18,   18,   18,
 /*   490 */    18,   18,   19,   19,   17,   17,   17,  130,  154,  154,
 /*   500 */   130,  154,  154,  154,  154,  154,  154,  154,   96,  154,
 /*   510 */     5,   96,  154,   85,  179,  140,   88,  179,  140,  154,
 /*   520 */   130,  154,  154,  130,  173,  110,  154,   35,  154,    3,
 /*   530 */   154,   96,  154,    4,   96,  154,   87,  179,  140,   91,
 /*   540 */   179,  140,  130,  173,  110,  154,   35,  173,  110,    6,
 /*   550 */    35,  154,  154,   96,  154,    9,  154,  154,   86,  179,
 /*   560 */   140,   10,  154,  173,  110,   12,   35,  154,  154,  173,
 /*   570 */   110,    1,   35,  154,  154,  173,  110,   14,   35,  173,
 /*   580 */   110,   11,   35,  154,  154,  173,  110,    8,   35,  154,
 /*   590 */   154,  173,  110,    7,   35,  173,  110,   15,   35,  154,
 /*   600 */   154,  173,  110,  154,   35,  154,  154,  173,  110,  154,
 /*   610 */    35,  173,  110,  154,   35,
    );
    static public $yy_lookahead = array(
 /*     0 */    61,   50,   51,   64,   65,   66,   67,   68,   69,   70,
 /*    10 */    71,   72,   73,   60,   75,   76,   77,    2,    3,    4,
 /*    20 */     5,    6,    7,    8,    9,   10,   11,   12,   13,   14,
 /*    30 */    20,   56,   22,   23,   21,   25,   21,   24,   12,   13,
 /*    40 */    14,   31,   21,   33,   34,   35,   73,   37,   63,   39,
 /*    50 */    73,   41,   21,   43,   44,   47,   79,   49,   73,   74,
 /*    60 */    52,   27,   54,   29,   56,   80,   56,   21,   55,    2,
 /*    70 */     3,    4,    5,    6,    7,    8,    9,   10,   11,   12,
 /*    80 */    13,   14,    1,   21,   48,   29,   55,   51,   56,   55,
 /*    90 */    20,   62,   22,   23,   21,   25,   15,   16,   28,   18,
 /*   100 */    30,   31,   73,   47,   34,   49,   62,   37,   79,   39,
 /*   110 */    59,   41,   56,   43,   44,   63,   20,   73,   22,   23,
 /*   120 */    53,   25,   78,   79,   80,   73,   56,   31,   32,   33,
 /*   130 */    34,   19,   80,   37,   21,   39,   42,   41,   21,   43,
 /*   140 */    44,   24,   27,   59,   62,   47,   29,   49,   20,   55,
 /*   150 */    22,   23,   56,   25,   56,   73,   28,   45,   30,   31,
 /*   160 */    21,   79,   34,   21,   47,   37,   49,   39,   55,   41,
 /*   170 */    55,   43,   44,   56,   20,   55,   22,   23,   21,   25,
 /*   180 */    23,   24,   21,   46,   56,   31,   21,   33,   34,   35,
 /*   190 */    59,   37,   55,   39,   55,   41,   21,   43,   44,   21,
 /*   200 */    20,   45,   22,   23,   47,   25,   49,   29,   58,   59,
 /*   210 */    56,   31,   55,   56,   34,   35,   55,   37,   21,   39,
 /*   220 */    45,   41,   63,   43,   44,   47,   20,   49,   22,   23,
 /*   230 */    21,   25,   73,   74,   56,   73,   56,   31,   59,   80,
 /*   240 */    34,   35,   21,   37,   21,   39,   21,   41,   63,   43,
 /*   250 */    44,   63,   20,   56,   22,   23,   21,   25,   73,   74,
 /*   260 */    21,   73,   56,   31,   32,   80,   34,   21,   80,   37,
 /*   270 */    47,   39,   49,   41,   24,   43,   44,   63,   20,   56,
 /*   280 */    22,   23,   21,   25,   26,   21,   17,   73,   56,   31,
 /*   290 */    55,   24,   34,   21,   80,   37,   21,   39,   81,   41,
 /*   300 */    63,   43,   44,   63,   20,   55,   22,   23,   59,   25,
 /*   310 */    73,   74,   28,   73,   56,   31,   21,   80,   34,   63,
 /*   320 */    80,   37,   55,   39,   51,   41,   73,   43,   44,   73,
 /*   330 */    20,   82,   22,   23,    0,   25,   80,   24,   21,   73,
 /*   340 */    56,   31,   29,   73,   34,   59,   36,   37,   59,   39,
 /*   350 */    55,   41,   21,   43,   44,   73,   20,   81,   22,   23,
 /*   360 */    47,   25,   49,   73,   28,   73,   56,   31,   59,   56,
 /*   370 */    34,   73,   55,   37,   73,   39,   73,   41,   73,   43,
 /*   380 */    44,   59,   20,   59,   22,   23,   55,   25,   21,   73,
 /*   390 */    21,   21,   56,   31,   59,   21,   34,   59,   21,   37,
 /*   400 */    38,   39,   59,   41,   59,   43,   44,   21,   20,   82,
 /*   410 */    22,   23,   73,   25,   73,   73,   82,   82,   56,   31,
 /*   420 */    82,   82,   34,   82,   82,   37,   82,   39,   40,   41,
 /*   430 */    82,   43,   44,   82,   20,   82,   22,   23,   82,   25,
 /*   440 */    82,   82,   82,   62,   56,   31,   82,   82,   34,   82,
 /*   450 */     1,   37,   82,   39,   73,   41,   82,   43,   44,   78,
 /*   460 */    79,   80,   82,   82,   15,   16,   82,   18,   82,   82,
 /*   470 */    56,   82,   82,   82,    3,    4,    5,    6,    7,    8,
 /*   480 */     9,   10,   11,   12,   13,   14,    4,    5,    6,    7,
 /*   490 */     8,    9,   10,   11,   12,   13,   14,   62,   82,   82,
 /*   500 */    62,   82,   82,   82,   82,   82,   82,   82,   73,   82,
 /*   510 */     1,   73,   82,   78,   79,   80,   78,   79,   80,   82,
 /*   520 */    62,   82,   82,   62,   15,   16,   82,   18,   82,    1,
 /*   530 */    82,   73,   82,    1,   73,   82,   78,   79,   80,   78,
 /*   540 */    79,   80,   62,   15,   16,   82,   18,   15,   16,    1,
 /*   550 */    18,   82,   82,   73,   82,    1,   82,   82,   78,   79,
 /*   560 */    80,    1,   82,   15,   16,    1,   18,   82,   82,   15,
 /*   570 */    16,    1,   18,   82,   82,   15,   16,    1,   18,   15,
 /*   580 */    16,    1,   18,   82,   82,   15,   16,    1,   18,   82,
 /*   590 */    82,   15,   16,    1,   18,   15,   16,    1,   18,   82,
 /*   600 */    82,   15,   16,   82,   18,   82,   82,   15,   16,   82,
 /*   610 */    18,   15,   16,   82,   18,
);
    const YY_SHIFT_USE_DFLT = -50;
    const YY_SHIFT_MAX = 136;
    static public $yy_shift_ofst = array(
 /*     0 */   -50,   70,   10,  128,   96,  154,  336,  232,  284,  310,
 /*    10 */   206,  362,  388,  258,  180,  414,    8,    8,    8,    8,
 /*    20 */     8,    8,    8,  157,  223,   98,   98,  117,  313,  178,
 /*    30 */    56,   98,   98,   98,   98,  -25,  -25,  -25,  532,  548,
 /*    40 */   528,  564,  509,  560,  570,  596,  576,  580,  449,  592,
 /*    50 */   586,   81,  554,  197,  -25,  -25,  -25,  334,  -25,  -25,
 /*    60 */   -25,  273,  -25,  273,  -25,  -25,  -25,  -25,  -25,  -25,
 /*    70 */   -25,  -25,  -50,  -50,  -50,  -50,  -50,  -50,  -50,  -50,
 /*    80 */   -50,  -50,  -50,  -50,  -50,   15,   67,  471,  482,  482,
 /*    90 */    13,   26,   34,   94,  331,  112,  137,   36,  235,  295,
 /*   100 */   317,  -49,  267,  161,  139,  115,  250,  113,  175,   31,
 /*   110 */   269,  261,   62,   73,   21,   32,  120,  142,  264,  370,
 /*   120 */   369,  367,  386,  377,  374,  165,  209,   46,  275,  120,
 /*   130 */   156,  239,  225,  221,  120,  272,  246,
);
    const YY_REDUCE_USE_DFLT = -62;
    const YY_REDUCE_MAX = 84;
    static public $yy_reduce_ofst = array(
 /*     0 */   150,  -61,  -61,  -61,  -61,  -61,  -61,  -61,  -61,  -61,
 /*    10 */   -61,  -61,  -61,  -61,  -61,  -61,  435,   44,  381,  461,
 /*    20 */   458,  480,  438,  185,  237,  159,  -15,  188,  188,  188,
 /*    30 */   188,  214,   52,  256,  240,   82,   29,  -23,  -47,  -47,
 /*    40 */   -47,  -47,  -47,  -47,  -47,  -47,  -47,  -47,  -47,  -47,
 /*    50 */   -47,  -47,  -47,  -27,  162,  298,  292,  286,  301,  305,
 /*    60 */   303,  276,  253,  217,  266,  290,  282,  270,  316,  339,
 /*    70 */   341,  342,  345,  343,  322,  309,  324,  338,  335,  289,
 /*    80 */   249,  179,   84,   51,  131,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(20, 22, 23, 25, 28, 30, 31, 34, 37, 39, 41, 43, 44, 56, ),
        /* 2 */ array(20, 22, 23, 25, 31, 33, 34, 35, 37, 39, 41, 43, 44, 56, ),
        /* 3 */ array(20, 22, 23, 25, 28, 30, 31, 34, 37, 39, 41, 43, 44, 56, ),
        /* 4 */ array(20, 22, 23, 25, 31, 32, 33, 34, 37, 39, 41, 43, 44, 56, ),
        /* 5 */ array(20, 22, 23, 25, 31, 33, 34, 35, 37, 39, 41, 43, 44, 56, ),
        /* 6 */ array(20, 22, 23, 25, 28, 31, 34, 37, 39, 41, 43, 44, 56, ),
        /* 7 */ array(20, 22, 23, 25, 31, 32, 34, 37, 39, 41, 43, 44, 56, ),
        /* 8 */ array(20, 22, 23, 25, 28, 31, 34, 37, 39, 41, 43, 44, 56, ),
        /* 9 */ array(20, 22, 23, 25, 31, 34, 36, 37, 39, 41, 43, 44, 56, ),
        /* 10 */ array(20, 22, 23, 25, 31, 34, 35, 37, 39, 41, 43, 44, 56, ),
        /* 11 */ array(20, 22, 23, 25, 31, 34, 37, 38, 39, 41, 43, 44, 56, ),
        /* 12 */ array(20, 22, 23, 25, 31, 34, 37, 39, 40, 41, 43, 44, 56, ),
        /* 13 */ array(20, 22, 23, 25, 26, 31, 34, 37, 39, 41, 43, 44, 56, ),
        /* 14 */ array(20, 22, 23, 25, 31, 34, 35, 37, 39, 41, 43, 44, 56, ),
        /* 15 */ array(20, 22, 23, 25, 31, 34, 37, 39, 41, 43, 44, 56, ),
        /* 16 */ array(47, 49, 52, 54, 56, ),
        /* 17 */ array(47, 49, 52, 54, 56, ),
        /* 18 */ array(47, 49, 52, 54, 56, ),
        /* 19 */ array(47, 49, 52, 54, 56, ),
        /* 20 */ array(47, 49, 52, 54, 56, ),
        /* 21 */ array(47, 49, 52, 54, 56, ),
        /* 22 */ array(47, 49, 52, 54, 56, ),
        /* 23 */ array(21, 23, 24, 47, 49, 55, 56, ),
        /* 24 */ array(21, 47, 49, 56, ),
        /* 25 */ array(47, 49, 56, ),
        /* 26 */ array(47, 49, 56, ),
        /* 27 */ array(21, 24, 29, 47, 49, 56, ),
        /* 28 */ array(24, 29, 47, 49, 56, ),
        /* 29 */ array(21, 29, 47, 49, 56, ),
        /* 30 */ array(29, 47, 49, 56, ),
        /* 31 */ array(47, 49, 56, ),
        /* 32 */ array(47, 49, 56, ),
        /* 33 */ array(47, 49, 56, ),
        /* 34 */ array(47, 49, 56, ),
        /* 35 */ array(56, ),
        /* 36 */ array(56, ),
        /* 37 */ array(56, ),
        /* 38 */ array(1, 15, 16, 18, ),
        /* 39 */ array(1, 15, 16, 18, ),
        /* 40 */ array(1, 15, 16, 18, ),
        /* 41 */ array(1, 15, 16, 18, ),
        /* 42 */ array(1, 15, 16, 18, ),
        /* 43 */ array(1, 15, 16, 18, ),
        /* 44 */ array(1, 15, 16, 18, ),
        /* 45 */ array(1, 15, 16, 18, ),
        /* 46 */ array(1, 15, 16, 18, ),
        /* 47 */ array(1, 15, 16, 18, ),
        /* 48 */ array(1, 15, 16, 18, ),
        /* 49 */ array(1, 15, 16, 18, ),
        /* 50 */ array(1, 15, 16, 18, ),
        /* 51 */ array(1, 15, 16, 18, ),
        /* 52 */ array(1, 15, 16, 18, ),
        /* 53 */ array(21, 56, ),
        /* 54 */ array(56, ),
        /* 55 */ array(56, ),
        /* 56 */ array(56, ),
        /* 57 */ array(0, ),
        /* 58 */ array(56, ),
        /* 59 */ array(56, ),
        /* 60 */ array(56, ),
        /* 61 */ array(51, ),
        /* 62 */ array(56, ),
        /* 63 */ array(51, ),
        /* 64 */ array(56, ),
        /* 65 */ array(56, ),
        /* 66 */ array(56, ),
        /* 67 */ array(56, ),
        /* 68 */ array(56, ),
        /* 69 */ array(56, ),
        /* 70 */ array(56, ),
        /* 71 */ array(56, ),
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
        /* 84 */ array(),
        /* 85 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 21, ),
        /* 86 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 53, ),
        /* 87 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, ),
        /* 88 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, ),
        /* 89 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, ),
        /* 90 */ array(21, 24, 55, ),
        /* 91 */ array(12, 13, 14, ),
        /* 92 */ array(27, 29, 55, ),
        /* 93 */ array(42, 55, ),
        /* 94 */ array(21, 55, ),
        /* 95 */ array(19, 45, ),
        /* 96 */ array(46, 55, ),
        /* 97 */ array(48, 51, ),
        /* 98 */ array(21, 55, ),
        /* 99 */ array(21, 55, ),
        /* 100 */ array(21, 55, ),
        /* 101 */ array(50, 51, ),
        /* 102 */ array(24, 55, ),
        /* 103 */ array(21, 55, ),
        /* 104 */ array(21, 55, ),
        /* 105 */ array(27, 55, ),
        /* 106 */ array(24, 55, ),
        /* 107 */ array(21, 55, ),
        /* 108 */ array(21, 45, ),
        /* 109 */ array(21, 55, ),
        /* 110 */ array(17, ),
        /* 111 */ array(21, ),
        /* 112 */ array(21, ),
        /* 113 */ array(21, ),
        /* 114 */ array(21, ),
        /* 115 */ array(56, ),
        /* 116 */ array(55, ),
        /* 117 */ array(21, ),
        /* 118 */ array(21, ),
        /* 119 */ array(21, ),
        /* 120 */ array(21, ),
        /* 121 */ array(21, ),
        /* 122 */ array(21, ),
        /* 123 */ array(21, ),
        /* 124 */ array(21, ),
        /* 125 */ array(21, ),
        /* 126 */ array(21, ),
        /* 127 */ array(21, ),
        /* 128 */ array(21, ),
        /* 129 */ array(55, ),
        /* 130 */ array(45, ),
        /* 131 */ array(21, ),
        /* 132 */ array(21, ),
        /* 133 */ array(21, ),
        /* 134 */ array(55, ),
        /* 135 */ array(21, ),
        /* 136 */ array(21, ),
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
        /* 192 */ array(),
);
    static public $yy_default = array(
 /*     0 */   195,  263,  263,  263,  263,  263,  263,  263,  263,  263,
 /*    10 */   263,  263,  263,  263,  263,  263,  263,  263,  263,  263,
 /*    20 */   263,  263,  263,  263,  263,  263,  263,  263,  236,  263,
 /*    30 */   238,  263,  263,  263,  263,  263,  263,  263,  263,  263,
 /*    40 */   263,  263,  263,  263,  263,  193,  263,  263,  263,  263,
 /*    50 */   263,  263,  263,  263,  263,  263,  263,  195,  263,  263,
 /*    60 */   263,  263,  263,  263,  263,  263,  263,  263,  263,  263,
 /*    70 */   263,  263,  195,  195,  195,  195,  195,  195,  195,  195,
 /*    80 */   195,  195,  195,  195,  195,  263,  263,  252,  253,  255,
 /*    90 */   263,  254,  263,  263,  263,  263,  242,  263,  263,  263,
 /*   100 */   263,  263,  263,  263,  263,  263,  263,  263,  263,  263,
 /*   110 */   263,  263,  263,  263,  263,  263,  246,  263,  263,  263,
 /*   120 */   263,  263,  263,  263,  263,  263,  263,  263,  263,  235,
 /*   130 */   257,  263,  263,  263,  237,  263,  263,  216,  224,  258,
 /*   140 */   259,  222,  260,  231,  213,  214,  212,  256,  215,  232,
 /*   150 */   205,  204,  203,  202,  206,  207,  210,  209,  208,  201,
 /*   160 */   262,  261,  200,  196,  194,  247,  248,  249,  251,  250,
 /*   170 */   217,  218,  198,  197,  245,  244,  199,  239,  228,  240,
 /*   180 */   241,  243,  234,  223,  221,  220,  219,  225,  226,  233,
 /*   190 */   229,  227,  230,
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
    const YYNOCODE = 83;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 193;
    const YYNRULE = 70;
    const YYERRORSYMBOL = 57;
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
  'T_LT',          'T_LE',          'T_PLUS',        'T_MINUS',     
  'T_TIMES',       'T_DIV',         'T_MOD',         'T_HTML',      
  'T_COMMENT_OPEN',  'T_COMMENT',     'T_PRINT_OPEN',  'T_PRINT_CLOSE',
  'T_EXTENDS',     'T_CLOSE_TAG',   'T_INCLUDE',     'T_FOR',       
  'T_AS',          'T_WITH',        'T_ENDWITH',     'T_IN',        
  'T_CLOSEFOR',    'T_COMMA',       'T_EMPTY',       'T_IF',        
  'T_ENDIF',       'T_ELSE',        'T_IFCHANGED',   'T_ENDIFCHANGED',
  'T_CUSTOM_END',  'T_BLOCK',       'T_END_BLOCK',   'T_FILTER',    
  'T_END_FILTER',  'T_REGROUP',     'T_BY',          'T_CYCLE',     
  'T_FIRST_OF',    'T_PIPE',        'T_COLON',       'T_STRING_SINGLE_INIT',
  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',  'T_STRING_DOUBLE_END',  'T_STRING_CONTENT',
  'T_LPARENT',     'T_RPARENT',     'T_NUMERIC',     'T_DOT',       
  'T_ALPHA',       'error',         'start',         'body',        
  'code',          'stmts',         'piped_list',    'var_or_string',
  'stmt',          'for_stmt',      'ifchanged_stmt',  'block_stmt',  
  'filter_stmt',   'custom_stmt',   'if_stmt',       'fnc_call_stmt',
  'alias',         'varname',       'list',          'cycle',       
  'regroup',       'first_of',      'expr',          'varname_args',
  'string',        's_content',   
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
 /*  46 */ "piped_list ::= piped_list T_PIPE varname_args",
 /*  47 */ "piped_list ::= varname_args",
 /*  48 */ "varname_args ::= varname T_COLON var_or_string",
 /*  49 */ "varname_args ::= varname",
 /*  50 */ "list ::= list var_or_string",
 /*  51 */ "list ::= list T_COMMA var_or_string",
 /*  52 */ "list ::= var_or_string",
 /*  53 */ "var_or_string ::= varname",
 /*  54 */ "var_or_string ::= string",
 /*  55 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  56 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  57 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  58 */ "s_content ::= T_STRING_CONTENT",
 /*  59 */ "expr ::= expr T_AND expr",
 /*  60 */ "expr ::= expr T_OR expr",
 /*  61 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  62 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE expr",
 /*  63 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  64 */ "expr ::= piped_list",
 /*  65 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  66 */ "expr ::= string",
 /*  67 */ "expr ::= T_NUMERIC",
 /*  68 */ "varname ::= varname T_DOT T_ALPHA",
 /*  69 */ "varname ::= T_ALPHA",
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
  array( 'lhs' => 58, 'rhs' => 1 ),
  array( 'lhs' => 59, 'rhs' => 2 ),
  array( 'lhs' => 59, 'rhs' => 0 ),
  array( 'lhs' => 60, 'rhs' => 2 ),
  array( 'lhs' => 60, 'rhs' => 1 ),
  array( 'lhs' => 60, 'rhs' => 2 ),
  array( 'lhs' => 60, 'rhs' => 3 ),
  array( 'lhs' => 61, 'rhs' => 3 ),
  array( 'lhs' => 61, 'rhs' => 2 ),
  array( 'lhs' => 61, 'rhs' => 1 ),
  array( 'lhs' => 61, 'rhs' => 1 ),
  array( 'lhs' => 61, 'rhs' => 1 ),
  array( 'lhs' => 61, 'rhs' => 1 ),
  array( 'lhs' => 61, 'rhs' => 1 ),
  array( 'lhs' => 61, 'rhs' => 1 ),
  array( 'lhs' => 61, 'rhs' => 3 ),
  array( 'lhs' => 61, 'rhs' => 1 ),
  array( 'lhs' => 61, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 2 ),
  array( 'lhs' => 71, 'rhs' => 4 ),
  array( 'lhs' => 71, 'rhs' => 6 ),
  array( 'lhs' => 71, 'rhs' => 4 ),
  array( 'lhs' => 71, 'rhs' => 3 ),
  array( 'lhs' => 71, 'rhs' => 5 ),
  array( 'lhs' => 72, 'rhs' => 9 ),
  array( 'lhs' => 64, 'rhs' => 1 ),
  array( 'lhs' => 64, 'rhs' => 1 ),
  array( 'lhs' => 64, 'rhs' => 1 ),
  array( 'lhs' => 65, 'rhs' => 9 ),
  array( 'lhs' => 65, 'rhs' => 11 ),
  array( 'lhs' => 65, 'rhs' => 13 ),
  array( 'lhs' => 65, 'rhs' => 15 ),
  array( 'lhs' => 70, 'rhs' => 7 ),
  array( 'lhs' => 70, 'rhs' => 11 ),
  array( 'lhs' => 66, 'rhs' => 6 ),
  array( 'lhs' => 66, 'rhs' => 7 ),
  array( 'lhs' => 66, 'rhs' => 10 ),
  array( 'lhs' => 66, 'rhs' => 11 ),
  array( 'lhs' => 69, 'rhs' => 6 ),
  array( 'lhs' => 67, 'rhs' => 7 ),
  array( 'lhs' => 67, 'rhs' => 8 ),
  array( 'lhs' => 68, 'rhs' => 7 ),
  array( 'lhs' => 76, 'rhs' => 6 ),
  array( 'lhs' => 75, 'rhs' => 2 ),
  array( 'lhs' => 75, 'rhs' => 4 ),
  array( 'lhs' => 77, 'rhs' => 2 ),
  array( 'lhs' => 62, 'rhs' => 3 ),
  array( 'lhs' => 62, 'rhs' => 1 ),
  array( 'lhs' => 79, 'rhs' => 3 ),
  array( 'lhs' => 79, 'rhs' => 1 ),
  array( 'lhs' => 74, 'rhs' => 2 ),
  array( 'lhs' => 74, 'rhs' => 3 ),
  array( 'lhs' => 74, 'rhs' => 1 ),
  array( 'lhs' => 63, 'rhs' => 1 ),
  array( 'lhs' => 63, 'rhs' => 1 ),
  array( 'lhs' => 80, 'rhs' => 3 ),
  array( 'lhs' => 80, 'rhs' => 3 ),
  array( 'lhs' => 81, 'rhs' => 2 ),
  array( 'lhs' => 81, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 3 ),
  array( 'lhs' => 78, 'rhs' => 3 ),
  array( 'lhs' => 78, 'rhs' => 3 ),
  array( 'lhs' => 78, 'rhs' => 3 ),
  array( 'lhs' => 78, 'rhs' => 3 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 3 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 1 ),
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
        49 => 3,
        58 => 3,
        67 => 3,
        69 => 3,
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
        51 => 46,
        47 => 47,
        52 => 47,
        48 => 48,
        50 => 50,
        53 => 53,
        54 => 54,
        66 => 54,
        55 => 55,
        56 => 55,
        57 => 57,
        59 => 59,
        60 => 59,
        61 => 59,
        62 => 59,
        63 => 59,
        64 => 64,
        65 => 65,
        68 => 68,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 64 "parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1370 "parser.php"
#line 66 "parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1373 "parser.php"
#line 67 "parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1376 "parser.php"
#line 70 "parser.y"
    function yy_r3(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1379 "parser.php"
#line 71 "parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1382 "parser.php"
#line 72 "parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1385 "parser.php"
#line 73 "parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1388 "parser.php"
#line 75 "parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1391 "parser.php"
#line 76 "parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1394 "parser.php"
#line 83 "parser.y"
    function yy_r15(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1397 "parser.php"
#line 90 "parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1400 "parser.php"
#line 91 "parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'for' => $this->yystack[$this->yyidx + -1]->minor, 'list' => array());     }
#line 1403 "parser.php"
#line 92 "parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'for' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array(),'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1406 "parser.php"
#line 93 "parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1409 "parser.php"
#line 94 "parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1412 "parser.php"
#line 95 "parser.y"
    function yy_r23(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1415 "parser.php"
#line 98 "parser.y"
    function yy_r24(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1418 "parser.php"
#line 106 "parser.y"
    function yy_r28(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1423 "parser.php"
#line 109 "parser.y"
    function yy_r29(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -9]->minor); 
    }
#line 1428 "parser.php"
#line 112 "parser.y"
    function yy_r30(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1433 "parser.php"
#line 115 "parser.y"
    function yy_r31(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -13]->minor); 
    }
#line 1438 "parser.php"
#line 119 "parser.y"
    function yy_r32(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1441 "parser.php"
#line 120 "parser.y"
    function yy_r33(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1444 "parser.php"
#line 123 "parser.y"
    function yy_r34(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1449 "parser.php"
#line 127 "parser.y"
    function yy_r35(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1454 "parser.php"
#line 130 "parser.y"
    function yy_r36(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1459 "parser.php"
#line 134 "parser.y"
    function yy_r37(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1464 "parser.php"
#line 139 "parser.y"
    function yy_r38(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'filter', 'functions' =>array($this->yystack[$this->yyidx + -5]->minor), 'body' => $this->yystack[$this->yyidx + -3]->minor);    }
#line 1467 "parser.php"
#line 142 "parser.y"
    function yy_r39(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1470 "parser.php"
#line 144 "parser.y"
    function yy_r40(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1473 "parser.php"
#line 147 "parser.y"
    function yy_r41(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1476 "parser.php"
#line 150 "parser.y"
    function yy_r42(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1479 "parser.php"
#line 153 "parser.y"
    function yy_r43(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1482 "parser.php"
#line 154 "parser.y"
    function yy_r44(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1485 "parser.php"
#line 157 "parser.y"
    function yy_r45(){ $this->_retvalue = array('operation' => 'first_of', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1488 "parser.php"
#line 161 "parser.y"
    function yy_r46(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1491 "parser.php"
#line 162 "parser.y"
    function yy_r47(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1494 "parser.php"
#line 164 "parser.y"
    function yy_r48(){ $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, 'args'=>array($this->yystack[$this->yyidx + 0]->minor));     }
#line 1497 "parser.php"
#line 168 "parser.y"
    function yy_r50(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1500 "parser.php"
#line 172 "parser.y"
    function yy_r53(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1503 "parser.php"
#line 173 "parser.y"
    function yy_r54(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1506 "parser.php"
#line 175 "parser.y"
    function yy_r55(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1509 "parser.php"
#line 177 "parser.y"
    function yy_r57(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1512 "parser.php"
#line 181 "parser.y"
    function yy_r59(){ $this->_retvalue = array('op' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1515 "parser.php"
#line 186 "parser.y"
    function yy_r64(){$this->_retvalue = array('var_filter' => $this->yystack[$this->yyidx + 0]->minor);    }
#line 1518 "parser.php"
#line 187 "parser.y"
    function yy_r65(){ $this->_retvalue = array('op' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1521 "parser.php"
#line 194 "parser.y"
    function yy_r68(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1524 "parser.php"

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
#line 55 "parser.y"

    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    throw new Exception('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
#line 1644 "parser.php"
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

#line 1665 "parser.php"
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