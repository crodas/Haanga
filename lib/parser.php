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
    const T_FOR                          = 29;
    const T_AS                           = 30;
    const T_CUSTOM_BLOCK                 = 31;
    const T_CUSTOM_END                   = 32;
    const T_WITH                         = 33;
    const T_ENDWITH                      = 34;
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
    const YY_NO_ACTION = 268;
    const YY_ACCEPT_ACTION = 267;
    const YY_ERROR_ACTION = 266;

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
    const YY_SZ_ACTTAB = 654;
static public $yy_action = array(
 /*     0 */    22,   21,   23,   23,   23,   23,   23,   23,   23,   17,
 /*    10 */    17,   20,   20,   20,   22,   21,   23,   23,   23,   23,
 /*    20 */    23,   23,   23,   17,   17,   20,   20,   20,   32,  112,
 /*    30 */    30,  108,   81,  174,   73,   24,   64,   33,  121,  100,
 /*    40 */    58,   56,   84,  183,  150,   19,  134,  135,   25,  133,
 /*    50 */    62,   31,   34,   43,   36,  156,  155,   32,  141,   30,
 /*    60 */   108,  195,  158,   61,   24,   64,  173,  121,   70,   58,
 /*    70 */   133,  125,   31,  122,   19,  111,   26,   25,   77,   62,
 /*    80 */   152,   34,   32,   36,   30,  108,  133,  196,   31,   24,
 /*    90 */    64,   76,  121,  188,   58,   38,  188,  159,  133,   19,
 /*   100 */    31,  131,   25,  132,   62,   14,   34,   32,   36,   30,
 /*   110 */   108,  267,   52,  188,   24,   64,  188,  121,   38,   58,
 /*   120 */   186,  115,  140,   35,   19,  181,  119,   25,  136,   62,
 /*   130 */   168,   34,   32,   36,   30,  108,   59,   38,   82,   24,
 /*   140 */    64,  173,  121,  164,   58,  181,  117,  170,  127,   19,
 /*   150 */   111,   27,   25,  197,   62,  152,   34,   32,   36,   30,
 /*   160 */   108,  184,  141,  137,   24,   64,  146,  121,   32,   58,
 /*   170 */    30,  108,   75,   63,   19,   24,   64,   25,  121,   62,
 /*   180 */    58,   34,   38,   36,  133,   19,   31,  160,   25,  154,
 /*   190 */    62,   50,   34,   32,   36,   30,  108,  169,   29,   38,
 /*   200 */    24,   64,  133,  121,   31,   58,  111,  133,  100,   31,
 /*   210 */    19,  152,  179,   25,  120,   62,   12,   34,   32,   36,
 /*   220 */    30,  108,  153,  139,  139,   24,   64,  104,  121,  193,
 /*   230 */    58,  186,  115,   71,   35,   19,  175,  100,   25,   42,
 /*   240 */    62,  183,   34,  113,   36,   78,   80,   32,  112,   30,
 /*   250 */   108,  176,  147,   72,   24,   64,  166,  121,  100,   58,
 /*   260 */   124,   86,  183,  150,   19,   83,  133,   25,   31,   62,
 /*   270 */   133,   34,   31,   36,  145,   21,   23,   23,   23,   23,
 /*   280 */    23,   23,   23,   17,   17,   20,   20,   20,  133,   32,
 /*   290 */    31,   30,  108,   20,   20,   20,   24,   64,  110,  121,
 /*   300 */    79,   58,  133,  138,   31,  177,   19,   38,  100,   25,
 /*   310 */   180,   62,  183,   34,   32,   36,   30,  108,  109,   57,
 /*   320 */   185,   24,   64,  107,  121,  123,   58,  190,  100,  194,
 /*   330 */   187,   19,  183,  100,   25,  162,   62,  183,   34,   32,
 /*   340 */    36,   30,  108,  118,   37,   91,   24,   64,  133,  121,
 /*   350 */    31,   58,  111,  130,   90,   93,   19,  152,  155,   25,
 /*   360 */   102,   62,   95,   34,   32,   36,   30,  108,  101,  126,
 /*   370 */    97,   24,   64,  172,  121,   98,   58,   89,  111,   94,
 /*   380 */    53,   19,  111,  152,   25,  128,   62,  152,   34,   32,
 /*   390 */    36,   30,  108,  133,  129,   31,   24,   64,   51,  121,
 /*   400 */   144,   58,   92,  111,  105,  143,   19,  116,  152,   25,
 /*   410 */    99,   62,   47,   34,   32,   36,   30,  108,  182,  106,
 /*   420 */   103,   24,   64,   45,  121,   46,   58,  111,   48,  100,
 /*   430 */    39,   19,  152,  183,   25,   54,   62,   41,   34,   49,
 /*   440 */    36,   23,   23,   23,   23,   23,   23,   23,   17,   17,
 /*   450 */    20,   20,   20,  142,   55,   44,  114,  157,  192,  189,
 /*   460 */   191,  178,  165,  163,  161,   40,  167,  155,  171,  155,
 /*   470 */   188,   60,   66,  188,  188,   74,   65,  188,  155,  155,
 /*   480 */   155,  188,   28,  155,  188,  188,   69,  155,  188,   28,
 /*   490 */   155,  155,  188,  151,   67,  188,   68,  151,   67,  155,
 /*   500 */    68,  155,  181,  155,  151,   67,  181,   68,  149,   67,
 /*   510 */   155,   68,  155,  181,   18,  151,   67,  181,   68,  112,
 /*   520 */   155,  155,  188,  155,  181,  188,  112,  155,  155,  100,
 /*   530 */   155,  155,   87,  183,  150,  155,  100,  112,  155,   85,
 /*   540 */   183,  150,  155,  112,  155,  151,   67,  100,   68,  155,
 /*   550 */    96,  183,  150,  100,  181,  112,   88,  183,  150,    6,
 /*   560 */   155,  155,  155,  155,  155,  100,  155,   13,  148,  183,
 /*   570 */   150,    2,  155,  155,  186,  115,   16,   35,  155,  155,
 /*   580 */   155,  155,  186,  115,    1,   35,  186,  115,   15,   35,
 /*   590 */   155,  186,  115,   10,   35,  155,  155,  155,  155,  186,
 /*   600 */   115,    5,   35,  186,  115,    8,   35,  155,  186,  115,
 /*   610 */    11,   35,  155,  155,  155,  155,  186,  115,    7,   35,
 /*   620 */   186,  115,    3,   35,  155,  186,  115,    9,   35,  155,
 /*   630 */   155,  155,  155,  186,  115,    4,   35,  186,  115,  155,
 /*   640 */    35,  155,  186,  115,  155,   35,  155,  155,  155,  155,
 /*   650 */   186,  115,  155,   35,
    );
    static public $yy_lookahead = array(
 /*     0 */     2,    3,    4,    5,    6,    7,    8,    9,   10,   11,
 /*    10 */    12,   13,   14,   15,    2,    3,    4,    5,    6,    7,
 /*    20 */     8,    9,   10,   11,   12,   13,   14,   15,   21,   68,
 /*    30 */    23,   24,   22,   22,   22,   28,   29,   10,   31,   78,
 /*    40 */    33,   30,   81,   82,   83,   38,   39,   40,   41,   59,
 /*    50 */    43,   61,   45,   65,   47,   53,   58,   21,   56,   23,
 /*    60 */    24,   22,   22,   36,   28,   29,   69,   31,   22,   33,
 /*    70 */    59,   35,   61,   37,   38,   78,   79,   41,   22,   43,
 /*    80 */    83,   45,   21,   47,   23,   24,   59,   22,   61,   28,
 /*    90 */    29,   22,   31,   28,   33,   49,   31,   22,   59,   38,
 /*   100 */    61,   40,   41,   42,   43,    1,   45,   21,   47,   23,
 /*   110 */    24,   64,   65,   28,   28,   29,   31,   31,   49,   33,
 /*   120 */    16,   17,   22,   19,   38,   60,   40,   41,   42,   43,
 /*   130 */    22,   45,   21,   47,   23,   24,   48,   49,   22,   28,
 /*   140 */    29,   69,   31,   22,   33,   60,   35,   22,   37,   38,
 /*   150 */    78,   79,   41,   20,   43,   83,   45,   21,   47,   23,
 /*   160 */    24,   55,   56,   27,   28,   29,   22,   31,   21,   33,
 /*   170 */    23,   24,   22,   30,   38,   28,   29,   41,   31,   43,
 /*   180 */    33,   45,   49,   47,   59,   38,   61,   22,   41,   22,
 /*   190 */    43,   44,   45,   21,   47,   23,   24,   69,   50,   49,
 /*   200 */    28,   29,   59,   31,   61,   33,   78,   59,   78,   61,
 /*   210 */    38,   83,   82,   41,   42,   43,    1,   45,   21,   47,
 /*   220 */    23,   24,   22,   25,   26,   28,   29,   68,   31,   22,
 /*   230 */    33,   16,   17,   22,   19,   38,   22,   78,   41,   65,
 /*   240 */    43,   82,   45,   46,   47,   22,   22,   21,   68,   23,
 /*   250 */    24,   22,   60,   22,   28,   29,   22,   31,   78,   33,
 /*   260 */    34,   81,   82,   83,   38,   22,   59,   41,   61,   43,
 /*   270 */    59,   45,   61,   47,   22,    3,    4,    5,    6,    7,
 /*   280 */     8,    9,   10,   11,   12,   13,   14,   15,   59,   21,
 /*   290 */    61,   23,   24,   13,   14,   15,   28,   29,   68,   31,
 /*   300 */    22,   33,   59,   35,   61,   22,   38,   49,   78,   41,
 /*   310 */    62,   43,   82,   45,   21,   47,   23,   24,   68,   30,
 /*   320 */    18,   28,   29,   68,   31,   32,   33,   22,   78,   22,
 /*   330 */    22,   38,   82,   78,   41,   22,   43,   82,   45,   21,
 /*   340 */    47,   23,   24,   69,   10,   78,   28,   29,   59,   31,
 /*   350 */    61,   33,   78,   35,   78,   78,   38,   83,   85,   41,
 /*   360 */    78,   43,   78,   45,   21,   47,   23,   24,   78,   69,
 /*   370 */    78,   28,   29,   69,   31,   78,   33,   78,   78,   78,
 /*   380 */    65,   38,   78,   83,   41,   42,   43,   83,   45,   21,
 /*   390 */    47,   23,   24,   59,   69,   61,   28,   29,   65,   31,
 /*   400 */    56,   33,   78,   78,   84,   66,   38,   39,   83,   41,
 /*   410 */    78,   43,   65,   45,   21,   47,   23,   24,   69,   68,
 /*   420 */    84,   28,   29,   65,   31,   65,   33,   78,   65,   78,
 /*   430 */    65,   38,   83,   82,   41,   65,   43,   65,   45,   65,
 /*   440 */    47,    4,    5,    6,    7,    8,    9,   10,   11,   12,
 /*   450 */    13,   14,   15,   67,   65,   65,   70,   71,   72,   73,
 /*   460 */    74,   75,   76,   77,   22,   65,   80,   85,   22,   85,
 /*   470 */    28,   29,   30,   31,   28,   22,   30,   31,   85,   85,
 /*   480 */    85,   28,   36,   85,   31,   28,   22,   85,   31,   36,
 /*   490 */    85,   85,   28,   51,   52,   31,   54,   51,   52,   85,
 /*   500 */    54,   85,   60,   85,   51,   52,   60,   54,   51,   52,
 /*   510 */    85,   54,   85,   60,   57,   51,   52,   60,   54,   68,
 /*   520 */    85,   85,   28,   85,   60,   31,   68,   85,   85,   78,
 /*   530 */    85,   85,   81,   82,   83,   85,   78,   68,   85,   81,
 /*   540 */    82,   83,   85,   68,   85,   51,   52,   78,   54,   85,
 /*   550 */    81,   82,   83,   78,   60,   68,   81,   82,   83,    1,
 /*   560 */    85,   85,   85,   85,   85,   78,   85,    1,   81,   82,
 /*   570 */    83,    1,   85,   85,   16,   17,    1,   19,   85,   85,
 /*   580 */    85,   85,   16,   17,    1,   19,   16,   17,    1,   19,
 /*   590 */    85,   16,   17,    1,   19,   85,   85,   85,   85,   16,
 /*   600 */    17,    1,   19,   16,   17,    1,   19,   85,   16,   17,
 /*   610 */     1,   19,   85,   85,   85,   85,   16,   17,    1,   19,
 /*   620 */    16,   17,    1,   19,   85,   16,   17,    1,   19,   85,
 /*   630 */    85,   85,   85,   16,   17,    1,   19,   16,   17,   85,
 /*   640 */    19,   85,   16,   17,   85,   19,   85,   85,   85,   85,
 /*   650 */    16,   17,   85,   19,
);
    const YY_SHIFT_USE_DFLT = -11;
    const YY_SHIFT_MAX = 139;
    static public $yy_shift_ofst = array(
 /*     0 */   -11,   61,  111,   86,    7,   36,  368,  343,  268,  136,
 /*    10 */   197,  147,  172,  318,  293,  226,  393,  457,  457,  457,
 /*    20 */   457,  457,  457,  457,  442,  464,  446,  453,  494,  494,
 /*    30 */   494,  494,  494,   85,   85,   85,   85,   85,   85,  570,
 /*    40 */   566,  104,  215,  587,  621,  600,  604,  609,  617,  558,
 /*    50 */    65,  592,  575,  583,  634,  626,   85,   85,   85,   85,
 /*    60 */    85,   85,   85,   85,   85,   85,   85,  344,  344,  -11,
 /*    70 */   -11,  -11,  -11,  -11,  -11,  -11,  -11,  -11,  -11,  -11,
 /*    80 */   -11,  -11,  -11,  -11,   -2,   12,  272,  437,  437,   27,
 /*    90 */    11,  334,  207,  211,  125,  143,  280,  229,  243,   39,
 /*   100 */   148,  289,  -10,  106,   46,    2,   88,  133,  198,  150,
 /*   110 */    69,  -10,  258,  308,  307,  302,  234,  165,  144,  116,
 /*   120 */   167,  224,  223,  214,  108,  200,  121,  231,  305,  248,
 /*   130 */   252,  278,  283,  192,  313,   10,  100,   75,   40,   56,
);
    const YY_REDUCE_USE_DFLT = -40;
    const YY_REDUCE_MAX = 83;
    static public $yy_reduce_ofst = array(
 /*     0 */    47,  386,  386,  386,  386,  386,  386,  386,  386,  386,
 /*    10 */   386,  386,  386,  386,  386,  386,  386,  469,  -39,  458,
 /*    20 */   487,  451,  180,  475,   -3,   72,  128,  128,  304,  349,
 /*    30 */   300,  325,  274,  250,  159,  255,  351,  230,  130,  339,
 /*    40 */   339,  339,  339,  339,  339,  339,  339,  339,  339,  339,
 /*    50 */   332,  339,  339,  339,  339,  339,  292,  297,  290,  284,
 /*    60 */   276,  267,  277,  282,  299,  301,  324,  320,  336,  315,
 /*    70 */   333,  347,  360,  370,  390,  365,  358,  389,  400,  363,
 /*    80 */   372,  374,  174,  -12,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(21, 23, 24, 28, 29, 31, 33, 38, 40, 41, 42, 43, 45, 47, ),
        /* 2 */ array(21, 23, 24, 28, 29, 31, 33, 35, 37, 38, 41, 43, 45, 47, ),
        /* 3 */ array(21, 23, 24, 28, 29, 31, 33, 38, 40, 41, 42, 43, 45, 47, ),
        /* 4 */ array(21, 23, 24, 28, 29, 31, 33, 38, 39, 40, 41, 43, 45, 47, ),
        /* 5 */ array(21, 23, 24, 28, 29, 31, 33, 35, 37, 38, 41, 43, 45, 47, ),
        /* 6 */ array(21, 23, 24, 28, 29, 31, 33, 38, 39, 41, 43, 45, 47, ),
        /* 7 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 42, 43, 45, 47, ),
        /* 8 */ array(21, 23, 24, 28, 29, 31, 33, 35, 38, 41, 43, 45, 47, ),
        /* 9 */ array(21, 23, 24, 27, 28, 29, 31, 33, 38, 41, 43, 45, 47, ),
        /* 10 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 43, 45, 46, 47, ),
        /* 11 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 43, 44, 45, 47, ),
        /* 12 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 42, 43, 45, 47, ),
        /* 13 */ array(21, 23, 24, 28, 29, 31, 33, 35, 38, 41, 43, 45, 47, ),
        /* 14 */ array(21, 23, 24, 28, 29, 31, 32, 33, 38, 41, 43, 45, 47, ),
        /* 15 */ array(21, 23, 24, 28, 29, 31, 33, 34, 38, 41, 43, 45, 47, ),
        /* 16 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 43, 45, 47, ),
        /* 17 */ array(28, 31, 51, 52, 54, 57, 60, ),
        /* 18 */ array(28, 31, 51, 52, 54, 57, 60, ),
        /* 19 */ array(28, 31, 51, 52, 54, 57, 60, ),
        /* 20 */ array(28, 31, 51, 52, 54, 57, 60, ),
        /* 21 */ array(28, 31, 51, 52, 54, 57, 60, ),
        /* 22 */ array(28, 31, 51, 52, 54, 57, 60, ),
        /* 23 */ array(28, 31, 51, 52, 54, 57, 60, ),
        /* 24 */ array(22, 28, 29, 30, 31, 51, 52, 54, 60, ),
        /* 25 */ array(22, 28, 31, 51, 52, 54, 60, ),
        /* 26 */ array(22, 28, 30, 31, 36, 51, 52, 54, 60, ),
        /* 27 */ array(22, 28, 31, 36, 51, 52, 54, 60, ),
        /* 28 */ array(28, 31, 51, 52, 54, 60, ),
        /* 29 */ array(28, 31, 51, 52, 54, 60, ),
        /* 30 */ array(28, 31, 51, 52, 54, 60, ),
        /* 31 */ array(28, 31, 51, 52, 54, 60, ),
        /* 32 */ array(28, 31, 51, 52, 54, 60, ),
        /* 33 */ array(28, 31, 60, ),
        /* 34 */ array(28, 31, 60, ),
        /* 35 */ array(28, 31, 60, ),
        /* 36 */ array(28, 31, 60, ),
        /* 37 */ array(28, 31, 60, ),
        /* 38 */ array(28, 31, 60, ),
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
        /* 50 */ array(22, 28, 31, 60, ),
        /* 51 */ array(1, 16, 17, 19, ),
        /* 52 */ array(1, 16, 17, 19, ),
        /* 53 */ array(1, 16, 17, 19, ),
        /* 54 */ array(1, 16, 17, 19, ),
        /* 55 */ array(1, 16, 17, 19, ),
        /* 56 */ array(28, 31, 60, ),
        /* 57 */ array(28, 31, 60, ),
        /* 58 */ array(28, 31, 60, ),
        /* 59 */ array(28, 31, 60, ),
        /* 60 */ array(28, 31, 60, ),
        /* 61 */ array(28, 31, 60, ),
        /* 62 */ array(28, 31, 60, ),
        /* 63 */ array(28, 31, 60, ),
        /* 64 */ array(28, 31, 60, ),
        /* 65 */ array(28, 31, 60, ),
        /* 66 */ array(28, 31, 60, ),
        /* 67 */ array(56, ),
        /* 68 */ array(56, ),
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
        /* 82 */ array(),
        /* 83 */ array(),
        /* 84 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 58, ),
        /* 85 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 22, ),
        /* 86 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 87 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 88 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 89 */ array(10, 36, 59, 61, ),
        /* 90 */ array(22, 30, 59, 61, ),
        /* 91 */ array(10, 59, 61, ),
        /* 92 */ array(22, 59, 61, ),
        /* 93 */ array(22, 59, 61, ),
        /* 94 */ array(22, 59, 61, ),
        /* 95 */ array(30, 59, 61, ),
        /* 96 */ array(13, 14, 15, ),
        /* 97 */ array(22, 59, 61, ),
        /* 98 */ array(22, 59, 61, ),
        /* 99 */ array(22, 59, 61, ),
        /* 100 */ array(50, 59, 61, ),
        /* 101 */ array(30, 59, 61, ),
        /* 102 */ array(59, 61, ),
        /* 103 */ array(55, 56, ),
        /* 104 */ array(22, 49, ),
        /* 105 */ array(53, 56, ),
        /* 106 */ array(48, 49, ),
        /* 107 */ array(20, 49, ),
        /* 108 */ array(25, 26, ),
        /* 109 */ array(22, 49, ),
        /* 110 */ array(22, 49, ),
        /* 111 */ array(59, 61, ),
        /* 112 */ array(49, ),
        /* 113 */ array(22, ),
        /* 114 */ array(22, ),
        /* 115 */ array(18, ),
        /* 116 */ array(22, ),
        /* 117 */ array(22, ),
        /* 118 */ array(22, ),
        /* 119 */ array(22, ),
        /* 120 */ array(22, ),
        /* 121 */ array(22, ),
        /* 122 */ array(22, ),
        /* 123 */ array(22, ),
        /* 124 */ array(22, ),
        /* 125 */ array(22, ),
        /* 126 */ array(22, ),
        /* 127 */ array(22, ),
        /* 128 */ array(22, ),
        /* 129 */ array(62, ),
        /* 130 */ array(22, ),
        /* 131 */ array(22, ),
        /* 132 */ array(22, ),
        /* 133 */ array(60, ),
        /* 134 */ array(22, ),
        /* 135 */ array(22, ),
        /* 136 */ array(22, ),
        /* 137 */ array(22, ),
        /* 138 */ array(22, ),
        /* 139 */ array(22, ),
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
        /* 193 */ array(),
        /* 194 */ array(),
        /* 195 */ array(),
        /* 196 */ array(),
        /* 197 */ array(),
);
    static public $yy_default = array(
 /*     0 */   200,  266,  266,  266,  266,  266,  266,  266,  266,  266,
 /*    10 */   266,  266,  266,  266,  266,  266,  266,  266,  266,  266,
 /*    20 */   266,  266,  266,  266,  266,  266,  266,  266,  266,  266,
 /*    30 */   266,  266,  266,  266,  266,  266,  266,  266,  266,  266,
 /*    40 */   266,  266,  266,  266,  266,  266,  266,  266,  266,  266,
 /*    50 */   266,  266,  198,  266,  266,  266,  266,  266,  266,  266,
 /*    60 */   266,  266,  266,  266,  266,  266,  266,  266,  266,  200,
 /*    70 */   200,  200,  200,  200,  200,  200,  200,  200,  200,  200,
 /*    80 */   200,  200,  200,  200,  266,  266,  253,  254,  256,  266,
 /*    90 */   266,  266,  266,  266,  266,  266,  255,  266,  266,  266,
 /*   100 */   242,  266,  238,  266,  266,  266,  266,  266,  266,  266,
 /*   110 */   266,  246,  258,  266,  266,  266,  266,  266,  266,  266,
 /*   120 */   266,  266,  266,  266,  266,  266,  266,  266,  266,  266,
 /*   130 */   266,  266,  266,  266,  266,  266,  266,  266,  266,  266,
 /*   140 */   232,  251,  201,  199,  252,  228,  205,  262,  257,  261,
 /*   150 */   260,  247,  248,  226,  234,  259,  249,  207,  227,  215,
 /*   160 */   225,  216,  229,  214,  212,  213,  230,  224,  223,  243,
 /*   170 */   221,  220,  244,  245,  217,  222,  218,  231,  211,  239,
 /*   180 */   263,  264,  241,  240,  250,  203,  202,  237,  265,  209,
 /*   190 */   233,  210,  208,  219,  206,  236,  235,  204,
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
    const YYNSTATE = 198;
    const YYNRULE = 68;
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
  'T_CUSTOM_TAG',  'T_FOR',         'T_AS',          'T_CUSTOM_BLOCK',
  'T_CUSTOM_END',  'T_WITH',        'T_ENDWITH',     'T_CLOSEFOR',  
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
 /*  19 */ "custom_tag ::= T_CUSTOM_TAG T_FOR varname T_CLOSE_TAG",
 /*  20 */ "custom_tag ::= T_CUSTOM_TAG T_FOR varname T_AS varname T_CLOSE_TAG",
 /*  21 */ "custom_tag ::= T_CUSTOM_TAG T_AS varname T_CLOSE_TAG",
 /*  22 */ "custom_tag ::= T_CUSTOM_TAG var_list T_CLOSE_TAG",
 /*  23 */ "custom_tag ::= T_CUSTOM_TAG var_list T_AS varname T_CLOSE_TAG",
 /*  24 */ "custom_tag ::= T_CUSTOM_BLOCK T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  25 */ "alias ::= T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_ENDWITH T_CLOSE_TAG",
 /*  26 */ "stmt ::= regroup",
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
 /*  37 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  38 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  39 */ "filter_stmt ::= T_FILTER filtered_var T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  40 */ "regroup ::= T_REGROUP filtered_var T_BY varname T_AS varname",
 /*  41 */ "filtered_var ::= filtered_var T_PIPE varname_args",
 /*  42 */ "filtered_var ::= varname_args",
 /*  43 */ "varname_args ::= varname T_COLON var_or_string",
 /*  44 */ "varname_args ::= varname",
 /*  45 */ "var_list ::= var_list var_or_string",
 /*  46 */ "var_list ::= var_list T_COMMA var_or_string",
 /*  47 */ "var_list ::= var_or_string",
 /*  48 */ "var_or_string ::= varname",
 /*  49 */ "var_or_string ::= T_NUMERIC",
 /*  50 */ "var_or_string ::= string",
 /*  51 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  52 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  53 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  54 */ "s_content ::= T_STRING_CONTENT",
 /*  55 */ "expr ::= expr T_AND expr",
 /*  56 */ "expr ::= expr T_OR expr",
 /*  57 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  58 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN expr",
 /*  59 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  60 */ "expr ::= filtered_var",
 /*  61 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  62 */ "expr ::= string",
 /*  63 */ "expr ::= T_NUMERIC",
 /*  64 */ "varname ::= varname T_DOT T_ALPHA",
 /*  65 */ "varname ::= varname T_BRACKETS_OPEN var_or_string T_BRACKETS_CLOSE",
 /*  66 */ "varname ::= T_ALPHA",
 /*  67 */ "varname ::= T_CUSTOM_TAG|T_CUSTOM_BLOCK",
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
  array( 'lhs' => 76, 'rhs' => 6 ),
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
        26 => 3,
        44 => 3,
        54 => 3,
        66 => 3,
        67 => 3,
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
        46 => 41,
        42 => 42,
        47 => 42,
        43 => 43,
        45 => 45,
        48 => 48,
        49 => 49,
        63 => 49,
        50 => 50,
        62 => 50,
        51 => 51,
        52 => 51,
        53 => 53,
        55 => 55,
        56 => 55,
        57 => 55,
        59 => 55,
        58 => 58,
        60 => 60,
        61 => 61,
        64 => 64,
        65 => 65,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 65 "parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1384 "parser.php"
#line 67 "parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1387 "parser.php"
#line 68 "parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1390 "parser.php"
#line 71 "parser.y"
    function yy_r3(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1393 "parser.php"
#line 72 "parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1396 "parser.php"
#line 73 "parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1399 "parser.php"
#line 74 "parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1402 "parser.php"
#line 76 "parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1405 "parser.php"
#line 77 "parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1408 "parser.php"
#line 83 "parser.y"
    function yy_r14(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1411 "parser.php"
#line 86 "parser.y"
    function yy_r17(){ $this->_retvalue = array('operation' => 'autoescape', 'value' => strtolower(@$this->yystack[$this->yyidx + -5]->minor), 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1414 "parser.php"
#line 91 "parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1417 "parser.php"
#line 92 "parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'for' => $this->yystack[$this->yyidx + -1]->minor, 'list' => array());     }
#line 1420 "parser.php"
#line 93 "parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'for' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array(),'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1423 "parser.php"
#line 94 "parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1426 "parser.php"
#line 95 "parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1429 "parser.php"
#line 96 "parser.y"
    function yy_r23(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1432 "parser.php"
#line 98 "parser.y"
    function yy_r24(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array());    }
#line 1435 "parser.php"
#line 101 "parser.y"
    function yy_r25(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1438 "parser.php"
#line 107 "parser.y"
    function yy_r27(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL); 
    }
#line 1443 "parser.php"
#line 110 "parser.y"
    function yy_r28(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -9]->minor); 
    }
#line 1448 "parser.php"
#line 113 "parser.y"
    function yy_r29(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL); 
    }
#line 1453 "parser.php"
#line 116 "parser.y"
    function yy_r30(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -13]->minor); 
    }
#line 1458 "parser.php"
#line 120 "parser.y"
    function yy_r31(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1461 "parser.php"
#line 121 "parser.y"
    function yy_r32(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1464 "parser.php"
#line 124 "parser.y"
    function yy_r33(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1469 "parser.php"
#line 128 "parser.y"
    function yy_r34(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1474 "parser.php"
#line 131 "parser.y"
    function yy_r35(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1479 "parser.php"
#line 135 "parser.y"
    function yy_r36(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1484 "parser.php"
#line 141 "parser.y"
    function yy_r37(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1487 "parser.php"
#line 143 "parser.y"
    function yy_r38(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1490 "parser.php"
#line 146 "parser.y"
    function yy_r39(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1493 "parser.php"
#line 149 "parser.y"
    function yy_r40(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1496 "parser.php"
#line 152 "parser.y"
    function yy_r41(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1499 "parser.php"
#line 153 "parser.y"
    function yy_r42(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1502 "parser.php"
#line 155 "parser.y"
    function yy_r43(){ $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, 'args'=>array($this->yystack[$this->yyidx + 0]->minor));     }
#line 1505 "parser.php"
#line 159 "parser.y"
    function yy_r45(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1508 "parser.php"
#line 165 "parser.y"
    function yy_r48(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1511 "parser.php"
#line 166 "parser.y"
    function yy_r49(){ $this->_retvalue = array('number' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1514 "parser.php"
#line 167 "parser.y"
    function yy_r50(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1517 "parser.php"
#line 169 "parser.y"
    function yy_r51(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1520 "parser.php"
#line 171 "parser.y"
    function yy_r53(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1523 "parser.php"
#line 175 "parser.y"
    function yy_r55(){ $this->_retvalue = array('op_expr' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1526 "parser.php"
#line 178 "parser.y"
    function yy_r58(){ $this->_retvalue = array('op_expr' => trim(@$this->yystack[$this->yyidx + -1]->minor), $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1529 "parser.php"
#line 180 "parser.y"
    function yy_r60(){$this->_retvalue = array('var_filter' => $this->yystack[$this->yyidx + 0]->minor);    }
#line 1532 "parser.php"
#line 181 "parser.y"
    function yy_r61(){ $this->_retvalue = array('op_expr' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1535 "parser.php"
#line 187 "parser.y"
    function yy_r64(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1538 "parser.php"
#line 188 "parser.y"
    function yy_r65(){ if (!is_array($this->yystack[$this->yyidx + -3]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -3]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + -1]->minor;    }
#line 1541 "parser.php"

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
#line 1661 "parser.php"
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

#line 1682 "parser.php"
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