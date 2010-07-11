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
    const T_FOR                          = 28;
    const T_AS                           = 29;
    const T_WITH                         = 30;
    const T_ENDWITH                      = 31;
    const T_CLOSEFOR                     = 32;
    const T_COMMA                        = 33;
    const T_EMPTY                        = 34;
    const T_IF                           = 35;
    const T_ENDIF                        = 36;
    const T_ELSE                         = 37;
    const T_IFCHANGED                    = 38;
    const T_ENDIFCHANGED                 = 39;
    const T_CUSTOM_END                   = 40;
    const T_BLOCK                        = 41;
    const T_END_BLOCK                    = 42;
    const T_FILTER                       = 43;
    const T_END_FILTER                   = 44;
    const T_REGROUP                      = 45;
    const T_BY                           = 46;
    const T_CYCLE                        = 47;
    const T_FIRST_OF                     = 48;
    const T_PIPE                         = 49;
    const T_COLON                        = 50;
    const T_STRING_SINGLE_INIT           = 51;
    const T_STRING_SINGLE_END            = 52;
    const T_STRING_DOUBLE_INIT           = 53;
    const T_STRING_DOUBLE_END            = 54;
    const T_STRING_CONTENT               = 55;
    const T_LPARENT                      = 56;
    const T_RPARENT                      = 57;
    const T_NUMERIC                      = 58;
    const T_DOT                          = 59;
    const T_ALPHA                        = 60;
    const T_BRACKETS_OPEN                = 61;
    const T_BRACKETS_CLOSE               = 62;
    const YY_NO_ACTION = 277;
    const YY_ACCEPT_ACTION = 276;
    const YY_ERROR_ACTION = 275;

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
    const YY_SZ_ACTTAB = 695;
static public $yy_action = array(
 /*     0 */    35,   36,   33,  114,   21,   21,   21,   71,  180,   73,
 /*    10 */   125,  131,   34,  128,   17,  104,   35,   25,   33,  114,
 /*    20 */    63,  183,   38,   71,   67,   73,   27,   26,  276,   41,
 /*    30 */    17,  142,  143,   25,  118,  118,   63,   39,   38,  149,
 /*    40 */    67,   45,   27,   26,   68,   35,   58,   33,  114,   20,
 /*    50 */    46,  164,   71,  149,   73,  149,  137,  146,  135,   17,
 /*    60 */   145,   35,   25,   33,  114,   63,   54,   38,   71,   67,
 /*    70 */    73,   27,   26,   49,    8,   17,  129,  119,   25,  121,
 /*    80 */   132,   63,   78,   38,  149,   67,  116,   27,   26,  181,
 /*    90 */   141,  104,   37,  166,   72,   70,   93,  178,  202,  176,
 /*   100 */   149,  152,  145,   22,   18,   23,   23,   23,   23,   23,
 /*   110 */    23,   23,   19,   19,   21,   21,   21,   57,   69,  125,
 /*   120 */    80,   34,   32,   88,  201,  149,   22,   18,   23,   23,
 /*   130 */    23,   23,   23,   23,   23,   19,   19,   21,   21,   21,
 /*   140 */    68,   61,   58,  125,  125,   34,   34,   39,   35,  149,
 /*   150 */    33,  114,   53,   74,  125,   71,   34,   73,   44,   62,
 /*   160 */    65,    5,   17,  175,  139,   25,  134,  155,   63,   68,
 /*   170 */    38,   58,   67,  116,   27,   26,  181,  141,  149,   37,
 /*   180 */   166,  192,   68,  148,   58,   83,   42,  149,   51,  187,
 /*   190 */   125,  149,   34,  169,  150,  159,   32,   47,  123,  171,
 /*   200 */   191,  188,  189,  194,  195,  199,  198,   24,  167,  184,
 /*   210 */   185,  182,  186,  161,   68,   66,   58,   35,  193,   33,
 /*   220 */   114,  158,  116,  149,   71,  174,   73,  149,   64,  166,
 /*   230 */    77,   17,   32,   75,   25,  116,   31,   63,   56,   38,
 /*   240 */   165,   67,  166,   27,   26,  125,   35,   34,   33,  114,
 /*   250 */    68,   86,   58,   71,  200,   73,  149,  127,  153,  149,
 /*   260 */    17,   76,   68,   25,   58,  132,   63,  125,   38,   34,
 /*   270 */    67,  149,   27,   26,   16,   32,  104,   35,   52,   33,
 /*   280 */   114,   91,  178,  202,   71,  149,   73,  120,  168,  181,
 /*   290 */   141,   17,   37,   68,   25,   58,   10,   63,  125,   38,
 /*   300 */    34,   67,  149,   27,   26,  125,   35,   34,   33,  114,
 /*   310 */    82,  181,  141,   71,   37,   73,  149,   39,   60,   87,
 /*   320 */    17,  154,  172,   25,  138,  125,   63,   34,   38,  174,
 /*   330 */    67,  163,   27,   26,  156,   35,  111,   33,  114,  116,
 /*   340 */    29,  122,   71,  174,   73,  149,  166,   85,  125,   17,
 /*   350 */    34,  196,   25,  116,   28,   63,  125,   38,   34,   67,
 /*   360 */   166,   27,   26,   35,  110,   33,  114,  173,  160,  177,
 /*   370 */    71,  125,   73,   34,  149,  104,  197,   17,   59,  147,
 /*   380 */    25,  178,  124,   63,   79,   38,  174,   67,  162,   27,
 /*   390 */    26,   81,   35,   40,   33,  114,  116,   30,  108,   71,
 /*   400 */   101,   73,  149,  166,  222,  125,   17,   34,  125,   25,
 /*   410 */    34,   14,   63,   96,   38,  136,   67,  113,   27,   26,
 /*   420 */   106,   35,   95,   33,  114,  117,  181,  141,   71,   37,
 /*   430 */    73,  149,  144,   55,   15,   17,  104,   35,   25,   33,
 /*   440 */   114,   63,  178,   38,   71,   67,   73,   27,   26,  181,
 /*   450 */   141,   17,   37,  100,   25,  133,  130,   63,  157,   38,
 /*   460 */   149,   67,  109,   27,   26,   35,  116,   33,  114,  107,
 /*   470 */    94,  179,   71,  166,   73,   84,  149,   43,   50,   17,
 /*   480 */   140,  116,   25,  132,  151,   63,  126,   38,  166,   67,
 /*   490 */   170,   27,   26,   48,  104,  125,  116,   34,  102,   92,
 /*   500 */   178,  202,  103,  166,  149,   99,   98,  115,   18,   23,
 /*   510 */    23,   23,   23,   23,   23,   23,   19,   19,   21,   21,
 /*   520 */    21,   97,  112,  162,  132,  162,  162,  162,  162,  162,
 /*   530 */    35,  162,   33,  114,  162,  104,  162,   71,  162,   73,
 /*   540 */    89,  178,  202,  162,   17,  162,  162,   25,  132,  162,
 /*   550 */    63,  162,   38,  162,   67,  162,   27,   26,  162,  104,
 /*   560 */   162,  162,  162,  162,  105,  178,  202,  162,  162,  149,
 /*   570 */   162,  162,  162,  162,   23,   23,   23,   23,   23,   23,
 /*   580 */    23,   19,   19,   21,   21,   21,  132,  162,  162,  132,
 /*   590 */   162,  162,  162,  162,  162,  162,  162,  104,  162,   13,
 /*   600 */   104,  162,  190,  178,  202,   90,  178,  202,    4,  162,
 /*   610 */   162,  162,  162,  162,  181,  141,    6,   37,  162,  162,
 /*   620 */   162,  162,  162,  181,  141,    9,   37,  162,  162,  162,
 /*   630 */   162,  181,  141,    7,   37,  162,  162,  162,  162,  162,
 /*   640 */   181,  141,    2,   37,  162,  162,  162,  162,  181,  141,
 /*   650 */    11,   37,  162,  162,  162,  162,  162,  181,  141,    3,
 /*   660 */    37,  162,  162,  162,  162,  181,  141,    1,   37,  162,
 /*   670 */   162,  162,  162,  162,  181,  141,   12,   37,  162,  162,
 /*   680 */   162,  162,  181,  141,  162,   37,  162,  162,  162,  162,
 /*   690 */   162,  181,  141,  162,   37,
    );
    static public $yy_lookahead = array(
 /*     0 */    21,   50,   23,   24,   13,   14,   15,   28,   20,   30,
 /*    10 */    59,   32,   61,   34,   35,   79,   21,   38,   23,   24,
 /*    20 */    41,   85,   43,   28,   45,   30,   47,   48,   64,   65,
 /*    30 */    35,   36,   37,   38,   25,   26,   41,   49,   43,   60,
 /*    40 */    45,   65,   47,   48,   51,   21,   53,   23,   24,   56,
 /*    50 */    65,   58,   28,   60,   30,   60,   32,   52,   34,   35,
 /*    60 */    55,   21,   38,   23,   24,   41,   65,   43,   28,   45,
 /*    70 */    30,   47,   48,   65,    1,   35,   69,   37,   38,   39,
 /*    80 */    68,   41,   22,   43,   60,   45,   79,   47,   48,   16,
 /*    90 */    17,   79,   19,   86,   10,   10,   84,   85,   86,   22,
 /*   100 */    60,   54,   55,    2,    3,    4,    5,    6,    7,    8,
 /*   110 */     9,   10,   11,   12,   13,   14,   15,   33,   29,   59,
 /*   120 */    22,   61,   33,   22,   22,   60,    2,    3,    4,    5,
 /*   130 */     6,    7,    8,    9,   10,   11,   12,   13,   14,   15,
 /*   140 */    51,   46,   53,   59,   59,   61,   61,   49,   21,   60,
 /*   150 */    23,   24,   65,   22,   59,   28,   61,   30,   65,   28,
 /*   160 */    29,    1,   35,   69,   37,   38,   39,   22,   41,   51,
 /*   170 */    43,   53,   45,   79,   47,   48,   16,   17,   60,   19,
 /*   180 */    86,   57,   51,   22,   53,   22,   65,   60,   65,   22,
 /*   190 */    59,   60,   61,   60,   22,   67,   33,   65,   70,   71,
 /*   200 */    72,   73,   74,   75,   76,   77,   78,   79,   22,   81,
 /*   210 */    82,   83,   69,   66,   51,   29,   53,   21,   18,   23,
 /*   220 */    24,   22,   79,   60,   28,   69,   30,   60,   29,   86,
 /*   230 */    22,   35,   33,   22,   38,   79,   80,   41,   42,   43,
 /*   240 */    22,   45,   86,   47,   48,   59,   21,   61,   23,   24,
 /*   250 */    51,   22,   53,   28,   22,   30,   60,   32,   22,   60,
 /*   260 */    35,   22,   51,   38,   53,   68,   41,   59,   43,   61,
 /*   270 */    45,   60,   47,   48,    1,   33,   79,   21,   65,   23,
 /*   280 */    24,   84,   85,   86,   28,   60,   30,   31,   22,   16,
 /*   290 */    17,   35,   19,   51,   38,   53,    1,   41,   59,   43,
 /*   300 */    61,   45,   60,   47,   48,   59,   21,   61,   23,   24,
 /*   310 */    22,   16,   17,   28,   19,   30,   60,   49,   29,   22,
 /*   320 */    35,   22,   22,   38,   39,   59,   41,   61,   43,   69,
 /*   330 */    45,   22,   47,   48,   22,   21,   87,   23,   24,   79,
 /*   340 */    80,   27,   28,   69,   30,   60,   86,   22,   59,   35,
 /*   350 */    61,   22,   38,   79,   80,   41,   59,   43,   61,   45,
 /*   360 */    86,   47,   48,   21,   68,   23,   24,   22,   22,   22,
 /*   370 */    28,   59,   30,   61,   60,   79,   22,   35,   29,   55,
 /*   380 */    38,   85,   40,   41,   22,   43,   69,   45,   22,   47,
 /*   390 */    48,   22,   21,   65,   23,   24,   79,   80,   79,   28,
 /*   400 */    79,   30,   60,   86,    0,   59,   35,   61,   59,   38,
 /*   410 */    61,    1,   41,   79,   43,   44,   45,   79,   47,   48,
 /*   420 */    79,   21,   79,   23,   24,   68,   16,   17,   28,   19,
 /*   430 */    30,   60,   32,   65,    1,   35,   79,   21,   38,   23,
 /*   440 */    24,   41,   85,   43,   28,   45,   30,   47,   48,   16,
 /*   450 */    17,   35,   19,   79,   38,   39,   69,   41,   22,   43,
 /*   460 */    60,   45,   79,   47,   48,   21,   79,   23,   24,   79,
 /*   470 */    79,   69,   28,   86,   30,   22,   60,   65,   65,   35,
 /*   480 */    36,   79,   38,   68,   62,   41,   69,   43,   86,   45,
 /*   490 */    22,   47,   48,   65,   79,   59,   79,   61,   79,   84,
 /*   500 */    85,   86,   79,   86,   60,   79,   79,   87,    3,    4,
 /*   510 */     5,    6,    7,    8,    9,   10,   11,   12,   13,   14,
 /*   520 */    15,   79,   79,   88,   68,   88,   88,   88,   88,   88,
 /*   530 */    21,   88,   23,   24,   88,   79,   88,   28,   88,   30,
 /*   540 */    84,   85,   86,   88,   35,   88,   88,   38,   68,   88,
 /*   550 */    41,   88,   43,   88,   45,   88,   47,   48,   88,   79,
 /*   560 */    88,   88,   88,   88,   84,   85,   86,   88,   88,   60,
 /*   570 */    88,   88,   88,   88,    4,    5,    6,    7,    8,    9,
 /*   580 */    10,   11,   12,   13,   14,   15,   68,   88,   88,   68,
 /*   590 */    88,   88,   88,   88,   88,   88,   88,   79,   88,    1,
 /*   600 */    79,   88,   84,   85,   86,   84,   85,   86,    1,   88,
 /*   610 */    88,   88,   88,   88,   16,   17,    1,   19,   88,   88,
 /*   620 */    88,   88,   88,   16,   17,    1,   19,   88,   88,   88,
 /*   630 */    88,   16,   17,    1,   19,   88,   88,   88,   88,   88,
 /*   640 */    16,   17,    1,   19,   88,   88,   88,   88,   16,   17,
 /*   650 */     1,   19,   88,   88,   88,   88,   88,   16,   17,    1,
 /*   660 */    19,   88,   88,   88,   88,   16,   17,    1,   19,   88,
 /*   670 */    88,   88,   88,   88,   16,   17,    1,   19,   88,   88,
 /*   680 */    88,   88,   16,   17,   88,   19,   88,   88,   88,   88,
 /*   690 */    88,   16,   17,   88,   19,
);
    const YY_SHIFT_USE_DFLT = -50;
    const YY_SHIFT_MAX = 144;
    static public $yy_shift_ofst = array(
 /*     0 */   -50,  127,   24,   40,  -21,   -5,  371,  400,  416,  444,
 /*    10 */   314,  225,  256,  196,  342,  285,  509,   -7,   -7,   -7,
 /*    20 */    -7,   -7,   -7,   -7,  131,  211,  118,  118,  199,  163,
 /*    30 */    89,  242,  118,  118,  118,  118,  118,   65,   65,   65,
 /*    40 */   598,  273,  433,  641,  658,  632,  160,  624,  666,  615,
 /*    50 */   675,  295,   73,  649,  607,  410,  167,   65,  324,   65,
 /*    60 */    65,   65,   65,   65,   65,   65,   65,   65,  324,   65,
 /*    70 */    65,   65,   65,   65,  404,  -50,  -50,  -50,  -50,  -50,
 /*    80 */   -50,  -50,  -50,  -50,  -50,  -50,  -50,  -50,  -50,  101,
 /*    90 */   124,  505,  570,  570,   84,  186,  312,   95,  346,  436,
 /*   100 */   289,   85,  297,  266,  -49,   -9,   60,  208,  239,  349,
 /*   110 */    98,   47,  246,  246,    9,    5,  246,  -12,  369,  362,
 /*   120 */   345,  347,   77,  172,  145,  133,  366,  468,  453,  102,
 /*   130 */   422,  161,  268,  354,  218,  229,  299,  300,  309,  288,
 /*   140 */   236,  200,  232,  325,  329,
);
    const YY_REDUCE_USE_DFLT = -65;
    const YY_REDUCE_MAX = 88;
    static public $yy_reduce_ofst = array(
 /*     0 */   -36,  128,  128,  128,  128,  128,  128,  128,  128,  128,
 /*    10 */   128,  128,  128,  128,  128,  128,  128,  456,  415,  480,
 /*    20 */   521,  518,  197,   12,  274,  260,  156,  317,  143,  143,
 /*    30 */   143,  143,   94,    7,  387,  417,  402,  357,  296,  -64,
 /*    40 */   147,  147,  147,  147,  147,  147,  147,  147,  147,  147,
 /*    50 */   147,  147,  147,  147,  147,  147,  334,  321,  249,  319,
 /*    60 */   338,  374,  343,  341,  427,  426,  423,  442,  420,  443,
 /*    70 */   419,  391,  390,  383,  368,  428,  413,  412,  328,  213,
 /*    80 */     8,  123,  121,   93,   87,  132,  -24,    1,  -15,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(21, 23, 24, 28, 30, 35, 37, 38, 39, 41, 43, 45, 47, 48, 60, ),
        /* 2 */ array(21, 23, 24, 28, 30, 32, 34, 35, 38, 41, 43, 45, 47, 48, 60, ),
        /* 3 */ array(21, 23, 24, 28, 30, 35, 37, 38, 39, 41, 43, 45, 47, 48, 60, ),
        /* 4 */ array(21, 23, 24, 28, 30, 32, 34, 35, 38, 41, 43, 45, 47, 48, 60, ),
        /* 5 */ array(21, 23, 24, 28, 30, 35, 36, 37, 38, 41, 43, 45, 47, 48, 60, ),
        /* 6 */ array(21, 23, 24, 28, 30, 35, 38, 41, 43, 44, 45, 47, 48, 60, ),
        /* 7 */ array(21, 23, 24, 28, 30, 32, 35, 38, 41, 43, 45, 47, 48, 60, ),
        /* 8 */ array(21, 23, 24, 28, 30, 35, 38, 39, 41, 43, 45, 47, 48, 60, ),
        /* 9 */ array(21, 23, 24, 28, 30, 35, 36, 38, 41, 43, 45, 47, 48, 60, ),
        /* 10 */ array(21, 23, 24, 27, 28, 30, 35, 38, 41, 43, 45, 47, 48, 60, ),
        /* 11 */ array(21, 23, 24, 28, 30, 32, 35, 38, 41, 43, 45, 47, 48, 60, ),
        /* 12 */ array(21, 23, 24, 28, 30, 31, 35, 38, 41, 43, 45, 47, 48, 60, ),
        /* 13 */ array(21, 23, 24, 28, 30, 35, 38, 41, 42, 43, 45, 47, 48, 60, ),
        /* 14 */ array(21, 23, 24, 28, 30, 35, 38, 40, 41, 43, 45, 47, 48, 60, ),
        /* 15 */ array(21, 23, 24, 28, 30, 35, 38, 39, 41, 43, 45, 47, 48, 60, ),
        /* 16 */ array(21, 23, 24, 28, 30, 35, 38, 41, 43, 45, 47, 48, 60, ),
        /* 17 */ array(51, 53, 56, 58, 60, ),
        /* 18 */ array(51, 53, 56, 58, 60, ),
        /* 19 */ array(51, 53, 56, 58, 60, ),
        /* 20 */ array(51, 53, 56, 58, 60, ),
        /* 21 */ array(51, 53, 56, 58, 60, ),
        /* 22 */ array(51, 53, 56, 58, 60, ),
        /* 23 */ array(51, 53, 56, 58, 60, ),
        /* 24 */ array(22, 28, 29, 51, 53, 59, 60, 61, ),
        /* 25 */ array(22, 51, 53, 60, ),
        /* 26 */ array(51, 53, 60, ),
        /* 27 */ array(51, 53, 60, ),
        /* 28 */ array(22, 29, 33, 51, 53, 60, ),
        /* 29 */ array(22, 33, 51, 53, 60, ),
        /* 30 */ array(29, 33, 51, 53, 60, ),
        /* 31 */ array(33, 51, 53, 60, ),
        /* 32 */ array(51, 53, 60, ),
        /* 33 */ array(51, 53, 60, ),
        /* 34 */ array(51, 53, 60, ),
        /* 35 */ array(51, 53, 60, ),
        /* 36 */ array(51, 53, 60, ),
        /* 37 */ array(60, ),
        /* 38 */ array(60, ),
        /* 39 */ array(60, ),
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
        /* 51 */ array(1, 16, 17, 19, ),
        /* 52 */ array(1, 16, 17, 19, ),
        /* 53 */ array(1, 16, 17, 19, ),
        /* 54 */ array(1, 16, 17, 19, ),
        /* 55 */ array(1, 16, 17, 19, ),
        /* 56 */ array(22, 60, ),
        /* 57 */ array(60, ),
        /* 58 */ array(55, ),
        /* 59 */ array(60, ),
        /* 60 */ array(60, ),
        /* 61 */ array(60, ),
        /* 62 */ array(60, ),
        /* 63 */ array(60, ),
        /* 64 */ array(60, ),
        /* 65 */ array(60, ),
        /* 66 */ array(60, ),
        /* 67 */ array(60, ),
        /* 68 */ array(55, ),
        /* 69 */ array(60, ),
        /* 70 */ array(60, ),
        /* 71 */ array(60, ),
        /* 72 */ array(60, ),
        /* 73 */ array(60, ),
        /* 74 */ array(0, ),
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
        /* 85 */ array(),
        /* 86 */ array(),
        /* 87 */ array(),
        /* 88 */ array(),
        /* 89 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 22, ),
        /* 90 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 57, ),
        /* 91 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 92 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 93 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 94 */ array(10, 33, 59, 61, ),
        /* 95 */ array(22, 29, 59, 61, ),
        /* 96 */ array(22, 59, 61, ),
        /* 97 */ array(46, 59, 61, ),
        /* 98 */ array(22, 59, 61, ),
        /* 99 */ array(22, 59, 61, ),
        /* 100 */ array(29, 59, 61, ),
        /* 101 */ array(10, 59, 61, ),
        /* 102 */ array(22, 59, 61, ),
        /* 103 */ array(22, 59, 61, ),
        /* 104 */ array(50, 59, 61, ),
        /* 105 */ array(13, 14, 15, ),
        /* 106 */ array(22, 59, 61, ),
        /* 107 */ array(22, 59, 61, ),
        /* 108 */ array(22, 59, 61, ),
        /* 109 */ array(29, 59, 61, ),
        /* 110 */ array(22, 49, ),
        /* 111 */ array(54, 55, ),
        /* 112 */ array(59, 61, ),
        /* 113 */ array(59, 61, ),
        /* 114 */ array(25, 26, ),
        /* 115 */ array(52, 55, ),
        /* 116 */ array(59, 61, ),
        /* 117 */ array(20, 49, ),
        /* 118 */ array(22, ),
        /* 119 */ array(22, ),
        /* 120 */ array(22, ),
        /* 121 */ array(22, ),
        /* 122 */ array(22, ),
        /* 123 */ array(22, ),
        /* 124 */ array(22, ),
        /* 125 */ array(60, ),
        /* 126 */ array(22, ),
        /* 127 */ array(22, ),
        /* 128 */ array(22, ),
        /* 129 */ array(22, ),
        /* 130 */ array(62, ),
        /* 131 */ array(22, ),
        /* 132 */ array(49, ),
        /* 133 */ array(22, ),
        /* 134 */ array(22, ),
        /* 135 */ array(22, ),
        /* 136 */ array(22, ),
        /* 137 */ array(22, ),
        /* 138 */ array(22, ),
        /* 139 */ array(22, ),
        /* 140 */ array(22, ),
        /* 141 */ array(18, ),
        /* 142 */ array(22, ),
        /* 143 */ array(22, ),
        /* 144 */ array(22, ),
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
);
    static public $yy_default = array(
 /*     0 */   205,  275,  275,  275,  275,  275,  275,  275,  275,  275,
 /*    10 */   275,  275,  275,  275,  275,  275,  275,  275,  275,  275,
 /*    20 */   275,  275,  275,  275,  275,  275,  275,  275,  275,  275,
 /*    30 */   247,  249,  275,  275,  275,  275,  275,  275,  275,  275,
 /*    40 */   275,  203,  275,  275,  275,  275,  275,  275,  275,  275,
 /*    50 */   275,  275,  275,  275,  275,  275,  275,  275,  275,  275,
 /*    60 */   275,  275,  275,  275,  275,  275,  275,  275,  275,  275,
 /*    70 */   275,  275,  275,  275,  205,  205,  205,  205,  205,  205,
 /*    80 */   205,  205,  205,  205,  205,  205,  205,  205,  205,  275,
 /*    90 */   275,  263,  264,  266,  275,  275,  275,  275,  275,  275,
 /*   100 */   275,  275,  275,  275,  253,  265,  275,  275,  275,  275,
 /*   110 */   275,  275,  248,  246,  275,  275,  257,  275,  275,  275,
 /*   120 */   275,  275,  275,  275,  275,  275,  275,  275,  275,  275,
 /*   130 */   275,  275,  268,  275,  275,  275,  275,  275,  275,  275,
 /*   140 */   275,  275,  275,  275,  275,  261,  259,  262,  233,  274,
 /*   150 */   211,  273,  260,  237,  245,  242,  244,  225,  226,  206,
 /*   160 */   227,  204,  210,  240,  271,  238,  258,  223,  224,  272,
 /*   170 */   235,  212,  232,  228,  256,  255,  221,  239,  251,  252,
 /*   180 */   209,  207,  231,  250,  229,  230,  254,  243,  214,  215,
 /*   190 */   267,  213,  269,  208,  216,  217,  234,  241,  220,  219,
 /*   200 */   236,  218,  270,
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
    const YYNOCODE = 89;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 203;
    const YYNRULE = 72;
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
  'T_FOR',         'T_AS',          'T_WITH',        'T_ENDWITH',   
  'T_CLOSEFOR',    'T_COMMA',       'T_EMPTY',       'T_IF',        
  'T_ENDIF',       'T_ELSE',        'T_IFCHANGED',   'T_ENDIFCHANGED',
  'T_CUSTOM_END',  'T_BLOCK',       'T_END_BLOCK',   'T_FILTER',    
  'T_END_FILTER',  'T_REGROUP',     'T_BY',          'T_CYCLE',     
  'T_FIRST_OF',    'T_PIPE',        'T_COLON',       'T_STRING_SINGLE_INIT',
  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',  'T_STRING_DOUBLE_END',  'T_STRING_CONTENT',
  'T_LPARENT',     'T_RPARENT',     'T_NUMERIC',     'T_DOT',       
  'T_ALPHA',       'T_BRACKETS_OPEN',  'T_BRACKETS_CLOSE',  'error',       
  'start',         'body',          'code',          'stmts',       
  'piped_list',    'var_or_string',  'stmt',          'for_stmt',    
  'ifchanged_stmt',  'block_stmt',    'filter_stmt',   'custom_stmt', 
  'if_stmt',       'fnc_call_stmt',  'alias',         'varname',     
  'list',          'cycle',         'regroup',       'first_of',    
  'expr',          'varname_args',  'string',        's_content',   
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
 /*  18 */ "stmts ::= T_AUTOESCAPE T_OFF|T_ON T_CLOSE_TAG body T_OPEN_TAG T_END_AUTOESCAPE T_CLOSE_TAG",
 /*  19 */ "fnc_call_stmt ::= varname T_CLOSE_TAG",
 /*  20 */ "fnc_call_stmt ::= varname T_FOR varname T_CLOSE_TAG",
 /*  21 */ "fnc_call_stmt ::= varname T_FOR varname T_AS varname T_CLOSE_TAG",
 /*  22 */ "fnc_call_stmt ::= varname T_AS varname T_CLOSE_TAG",
 /*  23 */ "fnc_call_stmt ::= varname list T_CLOSE_TAG",
 /*  24 */ "fnc_call_stmt ::= varname list T_AS varname T_CLOSE_TAG",
 /*  25 */ "alias ::= T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_ENDWITH T_CLOSE_TAG",
 /*  26 */ "stmt ::= cycle",
 /*  27 */ "stmt ::= regroup",
 /*  28 */ "stmt ::= first_of",
 /*  29 */ "for_stmt ::= T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  30 */ "for_stmt ::= T_FOR varname T_COMMA varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  31 */ "for_stmt ::= T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  32 */ "for_stmt ::= T_FOR varname T_COMMA varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  33 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  34 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  35 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  36 */ "ifchanged_stmt ::= T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  37 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  38 */ "ifchanged_stmt ::= T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  39 */ "custom_stmt ::= varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  40 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  41 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  42 */ "filter_stmt ::= T_FILTER piped_list T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  43 */ "regroup ::= T_REGROUP varname T_BY varname T_AS varname",
 /*  44 */ "cycle ::= T_CYCLE list",
 /*  45 */ "cycle ::= T_CYCLE list T_AS varname",
 /*  46 */ "first_of ::= T_FIRST_OF list",
 /*  47 */ "piped_list ::= piped_list T_PIPE varname_args",
 /*  48 */ "piped_list ::= varname_args",
 /*  49 */ "varname_args ::= varname T_COLON var_or_string",
 /*  50 */ "varname_args ::= varname",
 /*  51 */ "list ::= list var_or_string",
 /*  52 */ "list ::= list T_COMMA var_or_string",
 /*  53 */ "list ::= var_or_string",
 /*  54 */ "var_or_string ::= varname",
 /*  55 */ "var_or_string ::= string",
 /*  56 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  57 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  58 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  59 */ "s_content ::= T_STRING_CONTENT",
 /*  60 */ "expr ::= expr T_AND expr",
 /*  61 */ "expr ::= expr T_OR expr",
 /*  62 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  63 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN expr",
 /*  64 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  65 */ "expr ::= piped_list",
 /*  66 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  67 */ "expr ::= string",
 /*  68 */ "expr ::= T_NUMERIC",
 /*  69 */ "varname ::= varname T_DOT T_ALPHA",
 /*  70 */ "varname ::= varname T_BRACKETS_OPEN var_or_string T_BRACKETS_CLOSE",
 /*  71 */ "varname ::= T_ALPHA",
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
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 7 ),
  array( 'lhs' => 77, 'rhs' => 2 ),
  array( 'lhs' => 77, 'rhs' => 4 ),
  array( 'lhs' => 77, 'rhs' => 6 ),
  array( 'lhs' => 77, 'rhs' => 4 ),
  array( 'lhs' => 77, 'rhs' => 3 ),
  array( 'lhs' => 77, 'rhs' => 5 ),
  array( 'lhs' => 78, 'rhs' => 9 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 9 ),
  array( 'lhs' => 71, 'rhs' => 11 ),
  array( 'lhs' => 71, 'rhs' => 13 ),
  array( 'lhs' => 71, 'rhs' => 15 ),
  array( 'lhs' => 76, 'rhs' => 7 ),
  array( 'lhs' => 76, 'rhs' => 11 ),
  array( 'lhs' => 72, 'rhs' => 6 ),
  array( 'lhs' => 72, 'rhs' => 7 ),
  array( 'lhs' => 72, 'rhs' => 10 ),
  array( 'lhs' => 72, 'rhs' => 11 ),
  array( 'lhs' => 75, 'rhs' => 6 ),
  array( 'lhs' => 73, 'rhs' => 7 ),
  array( 'lhs' => 73, 'rhs' => 8 ),
  array( 'lhs' => 74, 'rhs' => 7 ),
  array( 'lhs' => 82, 'rhs' => 6 ),
  array( 'lhs' => 81, 'rhs' => 2 ),
  array( 'lhs' => 81, 'rhs' => 4 ),
  array( 'lhs' => 83, 'rhs' => 2 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 1 ),
  array( 'lhs' => 80, 'rhs' => 2 ),
  array( 'lhs' => 80, 'rhs' => 3 ),
  array( 'lhs' => 80, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 87, 'rhs' => 2 ),
  array( 'lhs' => 87, 'rhs' => 1 ),
  array( 'lhs' => 84, 'rhs' => 3 ),
  array( 'lhs' => 84, 'rhs' => 3 ),
  array( 'lhs' => 84, 'rhs' => 3 ),
  array( 'lhs' => 84, 'rhs' => 3 ),
  array( 'lhs' => 84, 'rhs' => 3 ),
  array( 'lhs' => 84, 'rhs' => 1 ),
  array( 'lhs' => 84, 'rhs' => 3 ),
  array( 'lhs' => 84, 'rhs' => 1 ),
  array( 'lhs' => 84, 'rhs' => 1 ),
  array( 'lhs' => 79, 'rhs' => 3 ),
  array( 'lhs' => 79, 'rhs' => 4 ),
  array( 'lhs' => 79, 'rhs' => 1 ),
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
        26 => 3,
        27 => 3,
        28 => 3,
        50 => 3,
        59 => 3,
        68 => 3,
        71 => 3,
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
        25 => 25,
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
        47 => 47,
        52 => 47,
        48 => 48,
        53 => 48,
        49 => 49,
        51 => 51,
        54 => 54,
        55 => 55,
        67 => 55,
        56 => 56,
        57 => 56,
        58 => 58,
        60 => 60,
        61 => 60,
        62 => 60,
        64 => 60,
        63 => 63,
        65 => 65,
        66 => 66,
        69 => 69,
        70 => 70,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 65 "parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1411 "parser.php"
#line 67 "parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1414 "parser.php"
#line 68 "parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1417 "parser.php"
#line 71 "parser.y"
    function yy_r3(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1420 "parser.php"
#line 72 "parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1423 "parser.php"
#line 73 "parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1426 "parser.php"
#line 74 "parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1429 "parser.php"
#line 76 "parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1432 "parser.php"
#line 77 "parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1435 "parser.php"
#line 84 "parser.y"
    function yy_r15(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1438 "parser.php"
#line 87 "parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'autoescape', 'value' => @$this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1441 "parser.php"
#line 92 "parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1444 "parser.php"
#line 93 "parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'for' => $this->yystack[$this->yyidx + -1]->minor, 'list' => array());     }
#line 1447 "parser.php"
#line 94 "parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'for' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array(),'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1450 "parser.php"
#line 95 "parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1453 "parser.php"
#line 96 "parser.y"
    function yy_r23(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1456 "parser.php"
#line 97 "parser.y"
    function yy_r24(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1459 "parser.php"
#line 100 "parser.y"
    function yy_r25(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1462 "parser.php"
#line 108 "parser.y"
    function yy_r29(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1467 "parser.php"
#line 111 "parser.y"
    function yy_r30(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -9]->minor); 
    }
#line 1472 "parser.php"
#line 114 "parser.y"
    function yy_r31(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1477 "parser.php"
#line 117 "parser.y"
    function yy_r32(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -13]->minor); 
    }
#line 1482 "parser.php"
#line 121 "parser.y"
    function yy_r33(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1485 "parser.php"
#line 122 "parser.y"
    function yy_r34(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1488 "parser.php"
#line 125 "parser.y"
    function yy_r35(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1493 "parser.php"
#line 129 "parser.y"
    function yy_r36(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1498 "parser.php"
#line 132 "parser.y"
    function yy_r37(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1503 "parser.php"
#line 136 "parser.y"
    function yy_r38(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1508 "parser.php"
#line 141 "parser.y"
    function yy_r39(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'filter', 'functions' =>array($this->yystack[$this->yyidx + -5]->minor), 'body' => $this->yystack[$this->yyidx + -3]->minor);    }
#line 1511 "parser.php"
#line 144 "parser.y"
    function yy_r40(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1514 "parser.php"
#line 146 "parser.y"
    function yy_r41(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1517 "parser.php"
#line 149 "parser.y"
    function yy_r42(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1520 "parser.php"
#line 152 "parser.y"
    function yy_r43(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1523 "parser.php"
#line 155 "parser.y"
    function yy_r44(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1526 "parser.php"
#line 156 "parser.y"
    function yy_r45(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1529 "parser.php"
#line 159 "parser.y"
    function yy_r46(){ $this->_retvalue = array('operation' => 'first_of', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1532 "parser.php"
#line 163 "parser.y"
    function yy_r47(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1535 "parser.php"
#line 164 "parser.y"
    function yy_r48(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1538 "parser.php"
#line 166 "parser.y"
    function yy_r49(){ $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, 'args'=>array($this->yystack[$this->yyidx + 0]->minor));     }
#line 1541 "parser.php"
#line 170 "parser.y"
    function yy_r51(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1544 "parser.php"
#line 174 "parser.y"
    function yy_r54(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1547 "parser.php"
#line 175 "parser.y"
    function yy_r55(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1550 "parser.php"
#line 177 "parser.y"
    function yy_r56(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1553 "parser.php"
#line 179 "parser.y"
    function yy_r58(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1556 "parser.php"
#line 183 "parser.y"
    function yy_r60(){ $this->_retvalue = array('op' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1559 "parser.php"
#line 186 "parser.y"
    function yy_r63(){ $this->_retvalue = array('op' => trim(@$this->yystack[$this->yyidx + -1]->minor), $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1562 "parser.php"
#line 188 "parser.y"
    function yy_r65(){$this->_retvalue = array('var_filter' => $this->yystack[$this->yyidx + 0]->minor);    }
#line 1565 "parser.php"
#line 189 "parser.y"
    function yy_r66(){ $this->_retvalue = array('op' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1568 "parser.php"
#line 196 "parser.y"
    function yy_r69(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1571 "parser.php"
#line 197 "parser.y"
    function yy_r70(){ if (!is_array($this->yystack[$this->yyidx + -3]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -3]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + -1]->minor;    }
#line 1574 "parser.php"

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
#line 1694 "parser.php"
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

#line 1715 "parser.php"
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