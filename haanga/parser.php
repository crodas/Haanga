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
    const T_FIRST_OF                     = 49;
    const T_PIPE                         = 50;
    const T_COLON                        = 51;
    const T_NUMERIC                      = 52;
    const T_STRING_SINGLE_INIT           = 53;
    const T_STRING_SINGLE_END            = 54;
    const T_STRING_DOUBLE_INIT           = 55;
    const T_STRING_DOUBLE_END            = 56;
    const T_STRING_CONTENT               = 57;
    const T_LPARENT                      = 58;
    const T_RPARENT                      = 59;
    const T_DOT                          = 60;
    const T_ALPHA                        = 61;
    const T_BRACKETS_OPEN                = 62;
    const T_BRACKETS_CLOSE               = 63;
    const YY_NO_ACTION = 273;
    const YY_ACCEPT_ACTION = 272;
    const YY_ERROR_ACTION = 271;

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
    const YY_SZ_ACTTAB = 762;
static public $yy_action = array(
 /*     0 */    32,   98,   33,  113,   56,  199,  149,   24,   57,  145,
 /*    10 */   132,  184,   65,  142,  184,  272,   53,   17,   59,  115,
 /*    20 */    25,  121,   62,  147,   36,  175,   37,  110,   26,   32,
 /*    30 */    63,   33,  113,   73,  109,   29,   24,   57,  181,  132,
 /*    40 */   157,   65,   97,  130,  183,  133,   17,  182,  118,   25,
 /*    50 */    30,   62,   93,   36,  118,   37,   30,   26,   32,  104,
 /*    60 */    33,  113,   20,   20,   20,   24,   57,  155,  132,  184,
 /*    70 */    65,  118,  184,   30,   79,   17,   60,  138,   25,  137,
 /*    80 */    62,   61,   36,  175,   37,  190,   26,   32,  101,   33,
 /*    90 */   113,   77,  109,   28,   24,   57,  191,  132,  157,   65,
 /*   100 */    81,  124,  183,  136,   17,   84,  118,   25,   30,   62,
 /*   110 */    78,   36,  118,   37,   30,   26,   18,   21,   19,   19,
 /*   120 */    19,   19,   19,   19,   19,   23,   23,   20,   20,   20,
 /*   130 */    71,  118,  184,   30,  102,  184,   72,  123,  123,   18,
 /*   140 */    21,   19,   19,   19,   19,   19,   19,   19,   23,   23,
 /*   150 */    20,   20,   20,   64,  180,   38,  156,   69,   38,   70,
 /*   160 */   119,   32,   22,   33,  113,  183,  189,  145,   24,   57,
 /*   170 */    97,  132,  196,   65,   87,  186,  151,   31,   17,  135,
 /*   180 */   141,   25,   85,   62,  176,   36,  118,   37,   30,   26,
 /*   190 */   119,   32,   58,   33,  113,  165,  150,  128,   24,   57,
 /*   200 */    97,  132,  200,   65,   86,  186,  151,  118,   17,   30,
 /*   210 */   118,   25,   30,   62,  174,   36,  177,   37,   32,   26,
 /*   220 */    33,  113,  118,  109,   30,   24,   57,   92,  132,  157,
 /*   230 */    65,  179,   38,  146,   82,   17,  168,  100,   25,  111,
 /*   240 */    62,   47,   36,  117,   37,  148,   26,   32,  105,   33,
 /*   250 */   113,  198,  106,  153,   24,   57,   43,  132,   41,   65,
 /*   260 */   162,  131,   54,  172,   17,  193,  103,   25,   96,   62,
 /*   270 */    99,   36,  175,   37,   94,   26,   32,   91,   33,  113,
 /*   280 */    80,  109,   27,   24,   57,   39,  132,  157,   65,  118,
 /*   290 */    83,   30,  187,   17,   51,  160,   25,   76,   62,   48,
 /*   300 */    36,  118,   37,   30,   26,   32,   42,   33,  113,  178,
 /*   310 */    45,   52,   24,   57,  170,  132,   49,   65,  118,   38,
 /*   320 */    30,  143,   17,   46,  164,   25,  122,   62,  118,   36,
 /*   330 */    30,   37,   40,   26,   32,  159,   33,  113,   55,  152,
 /*   340 */   159,   24,   57,   50,  132,   44,   65,  118,  159,   30,
 /*   350 */   159,   17,  139,  159,   25,  159,   62,  107,   36,  108,
 /*   360 */    37,  159,   26,   32,  159,   33,  113,   97,  159,   97,
 /*   370 */    24,   57,  186,  132,  186,   65,  159,  127,  112,  159,
 /*   380 */    17,  159,  159,   25,  159,   62,  159,   36,   97,   37,
 /*   390 */   159,   26,   32,  186,   33,  113,  140,  159,  159,   24,
 /*   400 */    57,  159,  132,  159,   65,  109,  159,  159,  159,   17,
 /*   410 */   159,  157,   25,  126,   62,  159,   36,  171,   37,  159,
 /*   420 */    26,   32,  159,   33,  113,  159,  109,  114,   24,   57,
 /*   430 */   159,  132,  157,   65,  129,  159,  109,  159,   17,  159,
 /*   440 */   159,   25,  157,   62,  159,   36,  159,   37,  159,   26,
 /*   450 */    32,  159,   33,  113,  185,  159,  125,   24,   57,  159,
 /*   460 */   132,  134,   65,  109,  159,  109,  159,   17,  159,  157,
 /*   470 */    25,  157,   62,  159,   36,  159,   37,  159,   26,   32,
 /*   480 */   159,   33,  113,  159,  159,  159,   24,   57,  159,  132,
 /*   490 */   159,   65,  159,  159,  159,  159,   17,  159,  159,   25,
 /*   500 */   159,   62,  159,   36,  159,   37,  159,   26,  159,   21,
 /*   510 */    19,   19,   19,   19,   19,   19,   19,   23,   23,   20,
 /*   520 */    20,   20,   19,   19,   19,   19,   19,   19,   19,   23,
 /*   530 */    23,   20,   20,   20,  159,  159,  144,  159,  159,  116,
 /*   540 */   197,  159,  195,  192,  194,  166,  167,  161,  159,  169,
 /*   550 */   163,  173,  159,  184,   66,   67,  184,  184,  159,   68,
 /*   560 */   184,  159,   75,  159,  159,   34,   74,  159,  184,  159,
 /*   570 */   159,  184,  184,  159,  159,  184,   34,  154,   69,  159,
 /*   580 */    70,  154,   69,  159,   70,  184,  183,  159,  184,  159,
 /*   590 */   183,  159,  154,   69,  159,   70,  154,   69,  159,   70,
 /*   600 */   184,  183,  159,  184,  159,  183,  119,  159,   34,  154,
 /*   610 */    69,  159,   70,  159,  159,  159,   97,  159,  183,  159,
 /*   620 */    89,  186,  151,  159,  154,   69,  159,   70,  159,  119,
 /*   630 */   159,  159,  119,  183,  159,  159,  159,  159,  159,   97,
 /*   640 */   159,   10,   97,   90,  186,  151,   95,  186,  151,  159,
 /*   650 */   119,  159,  159,  159,  159,  159,  188,  120,  119,   35,
 /*   660 */    97,   14,  159,  159,   88,  186,  151,    4,   97,  159,
 /*   670 */   159,  159,  158,  186,  151,    3,  188,  120,  159,   35,
 /*   680 */   159,    6,  188,  120,  159,   35,  159,   12,  159,  159,
 /*   690 */   188,  120,    2,   35,  159,  159,  188,  120,    9,   35,
 /*   700 */   159,  159,  188,  120,   16,   35,  159,  188,  120,    1,
 /*   710 */    35,  159,  159,  188,  120,   13,   35,  159,  159,  188,
 /*   720 */   120,   15,   35,  159,  188,  120,    5,   35,  159,  159,
 /*   730 */   188,  120,    7,   35,  159,  159,  188,  120,    8,   35,
 /*   740 */   159,  188,  120,   11,   35,  159,  159,  188,  120,  159,
 /*   750 */    35,  159,  159,  188,  120,  159,   35,  159,  188,  120,
 /*   760 */   159,   35,
    );
    static public $yy_lookahead = array(
 /*     0 */    21,   79,   23,   24,   10,   22,   54,   28,   29,   57,
 /*    10 */    31,   28,   33,   22,   31,   65,   66,   38,   30,   40,
 /*    20 */    41,   42,   43,   67,   45,   70,   47,   79,   49,   21,
 /*    30 */    36,   23,   24,   22,   79,   80,   28,   29,   63,   31,
 /*    40 */    85,   33,   79,   35,   61,   37,   38,   84,   60,   41,
 /*    50 */    62,   43,   79,   45,   60,   47,   62,   49,   21,   79,
 /*    60 */    23,   24,   13,   14,   15,   28,   29,   22,   31,   28,
 /*    70 */    33,   60,   31,   62,   22,   38,   30,   40,   41,   42,
 /*    80 */    43,   10,   45,   70,   47,   22,   49,   21,   79,   23,
 /*    90 */    24,   22,   79,   80,   28,   29,   22,   31,   85,   33,
 /*   100 */    22,   35,   61,   37,   38,   22,   60,   41,   62,   43,
 /*   110 */    22,   45,   60,   47,   62,   49,    2,    3,    4,    5,
 /*   120 */     6,    7,    8,    9,   10,   11,   12,   13,   14,   15,
 /*   130 */    22,   60,   28,   62,   79,   31,   22,   25,   26,    2,
 /*   140 */     3,    4,    5,    6,    7,    8,    9,   10,   11,   12,
 /*   150 */    13,   14,   15,   48,   22,   50,   52,   53,   50,   55,
 /*   160 */    69,   21,   58,   23,   24,   61,   56,   57,   28,   29,
 /*   170 */    79,   31,   22,   33,   83,   84,   85,   51,   38,   39,
 /*   180 */    40,   41,   22,   43,   22,   45,   60,   47,   62,   49,
 /*   190 */    69,   21,   30,   23,   24,   22,   59,   27,   28,   29,
 /*   200 */    79,   31,   20,   33,   83,   84,   85,   60,   38,   62,
 /*   210 */    60,   41,   62,   43,   70,   45,   22,   47,   21,   49,
 /*   220 */    23,   24,   60,   79,   62,   28,   29,   79,   31,   85,
 /*   230 */    33,   22,   50,   61,   22,   38,   22,   79,   41,   86,
 /*   240 */    43,   66,   45,   46,   47,   57,   49,   21,   79,   23,
 /*   250 */    24,   22,   86,   22,   28,   29,   66,   31,   66,   33,
 /*   260 */    22,   35,   66,   22,   38,   22,   79,   41,   79,   43,
 /*   270 */    79,   45,   70,   47,   79,   49,   21,   79,   23,   24,
 /*   280 */    22,   79,   80,   28,   29,   66,   31,   85,   33,   60,
 /*   290 */    22,   62,   18,   38,   66,   22,   41,   22,   43,   44,
 /*   300 */    45,   60,   47,   62,   49,   21,   66,   23,   24,   22,
 /*   310 */    66,   66,   28,   29,   22,   31,   66,   33,   60,   50,
 /*   320 */    62,   22,   38,   66,   22,   41,   42,   43,   60,   45,
 /*   330 */    62,   47,   66,   49,   21,   87,   23,   24,   66,   22,
 /*   340 */    87,   28,   29,   66,   31,   66,   33,   60,   87,   62,
 /*   350 */    87,   38,   39,   87,   41,   87,   43,   69,   45,   69,
 /*   360 */    47,   87,   49,   21,   87,   23,   24,   79,   87,   79,
 /*   370 */    28,   29,   84,   31,   84,   33,   87,   35,   69,   87,
 /*   380 */    38,   87,   87,   41,   87,   43,   87,   45,   79,   47,
 /*   390 */    87,   49,   21,   84,   23,   24,   70,   87,   87,   28,
 /*   400 */    29,   87,   31,   87,   33,   79,   87,   87,   87,   38,
 /*   410 */    87,   85,   41,   42,   43,   87,   45,   70,   47,   87,
 /*   420 */    49,   21,   87,   23,   24,   87,   79,   70,   28,   29,
 /*   430 */    87,   31,   85,   33,   34,   87,   79,   87,   38,   87,
 /*   440 */    87,   41,   85,   43,   87,   45,   87,   47,   87,   49,
 /*   450 */    21,   87,   23,   24,   70,   87,   70,   28,   29,   87,
 /*   460 */    31,   32,   33,   79,   87,   79,   87,   38,   87,   85,
 /*   470 */    41,   85,   43,   87,   45,   87,   47,   87,   49,   21,
 /*   480 */    87,   23,   24,   87,   87,   87,   28,   29,   87,   31,
 /*   490 */    87,   33,   87,   87,   87,   87,   38,   87,   87,   41,
 /*   500 */    87,   43,   87,   45,   87,   47,   87,   49,   87,    3,
 /*   510 */     4,    5,    6,    7,    8,    9,   10,   11,   12,   13,
 /*   520 */    14,   15,    4,    5,    6,    7,    8,    9,   10,   11,
 /*   530 */    12,   13,   14,   15,   87,   87,   68,   87,   87,   71,
 /*   540 */    72,   73,   74,   75,   76,   77,   78,   22,   87,   81,
 /*   550 */    82,   22,   87,   28,   29,   30,   31,   28,   87,   30,
 /*   560 */    31,   87,   22,   87,   87,   36,   22,   87,   28,   87,
 /*   570 */    87,   31,   28,   87,   87,   31,   36,   52,   53,   87,
 /*   580 */    55,   52,   53,   87,   55,   28,   61,   87,   31,   87,
 /*   590 */    61,   87,   52,   53,   87,   55,   52,   53,   87,   55,
 /*   600 */    28,   61,   87,   31,   87,   61,   69,   87,   36,   52,
 /*   610 */    53,   87,   55,   87,   87,   87,   79,   87,   61,   87,
 /*   620 */    83,   84,   85,   87,   52,   53,   87,   55,   87,   69,
 /*   630 */    87,   87,   69,   61,   87,   87,   87,   87,   87,   79,
 /*   640 */    87,    1,   79,   83,   84,   85,   83,   84,   85,   87,
 /*   650 */    69,   87,   87,   87,   87,   87,   16,   17,   69,   19,
 /*   660 */    79,    1,   87,   87,   83,   84,   85,    1,   79,   87,
 /*   670 */    87,   87,   83,   84,   85,    1,   16,   17,   87,   19,
 /*   680 */    87,    1,   16,   17,   87,   19,   87,    1,   87,   87,
 /*   690 */    16,   17,    1,   19,   87,   87,   16,   17,    1,   19,
 /*   700 */    87,   87,   16,   17,    1,   19,   87,   16,   17,    1,
 /*   710 */    19,   87,   87,   16,   17,    1,   19,   87,   87,   16,
 /*   720 */    17,    1,   19,   87,   16,   17,    1,   19,   87,   87,
 /*   730 */    16,   17,    1,   19,   87,   87,   16,   17,    1,   19,
 /*   740 */    87,   16,   17,    1,   19,   87,   87,   16,   17,   87,
 /*   750 */    19,   87,   87,   16,   17,   87,   19,   87,   16,   17,
 /*   760 */    87,   19,
);
    const YY_SHIFT_USE_DFLT = -49;
    const YY_SHIFT_MAX = 141;
    static public $yy_shift_ofst = array(
 /*     0 */   -49,  140,   37,   66,  -21,    8,  400,  429,  284,  371,
 /*    10 */   197,  170,  226,  313,  342,  255,  458,  104,  104,  104,
 /*    20 */   104,  104,  104,  104,  525,  544,  557,  529,  540,  572,
 /*    30 */   557,  557,  557,  557,  557,   41,   41,   41,   41,  731,
 /*    40 */   660,  674,  680,  640,  666,  737,  725,  686,  -17,  720,
 /*    50 */   714,  691,  697,  703,  708,  742,   41,   41,   41,   41,
 /*    60 */    41,   41,   41,   41,   41,   41,   41,   41,   41,  188,
 /*    70 */   188,  -49,  -49,  -49,  -49,  -49,  -49,  -49,  -49,  -49,
 /*    80 */   -49,  -49,  -49,  -49,  -49,  -49,  114,  137,  506,  518,
 /*    90 */   518,  162,   -6,  229,  150,   49,   71,  126,  258,   46,
 /*   100 */   287,  268,   11,  -12,   52,  241,  -48,  182,  108,  147,
 /*   110 */   147,  110,  105,  112,  -25,   78,   74,   63,  172,  269,
 /*   120 */   274,  299,  317,  275,  238,  231,  243,  302,  273,  292,
 /*   130 */    45,   -9,   83,  160,  194,  173,   88,  132,  212,  214,
 /*   140 */   209,   69,
);
    const YY_REDUCE_USE_DFLT = -79;
    const YY_REDUCE_MAX = 85;
    static public $yy_reduce_ofst = array(
 /*     0 */   -50,  468,  468,  468,  468,  468,  468,  468,  468,  468,
 /*    10 */   468,  468,  468,  468,  468,  468,  468,  121,  581,  537,
 /*    20 */   589,  560,   91,  563,  202,   13,  -45,  347,  347,  347,
 /*    30 */   357,  384,  386,  326,  144,  288,  290,  309,  -37,  -44,
 /*    40 */   -44,  -44,  -44,  -44,  -44,  -44,  -44,  -44,  -27,  -44,
 /*    50 */   -44,  -44,  -44,  -44,  -44,  -44,   55,  148,  158,  -52,
 /*    60 */   -78,  -20,    9,  189,  187,  191,  198,  195,  169,  166,
 /*    70 */   153,  190,  196,  192,  228,  279,  272,  277,  266,  257,
 /*    80 */   240,  244,  245,  250,  219,  175,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(21, 23, 24, 28, 29, 31, 33, 38, 39, 40, 41, 43, 45, 47, 49, ),
        /* 2 */ array(21, 23, 24, 28, 29, 31, 33, 38, 40, 41, 42, 43, 45, 47, 49, ),
        /* 3 */ array(21, 23, 24, 28, 29, 31, 33, 35, 37, 38, 41, 43, 45, 47, 49, ),
        /* 4 */ array(21, 23, 24, 28, 29, 31, 33, 38, 40, 41, 42, 43, 45, 47, 49, ),
        /* 5 */ array(21, 23, 24, 28, 29, 31, 33, 35, 37, 38, 41, 43, 45, 47, 49, ),
        /* 6 */ array(21, 23, 24, 28, 29, 31, 33, 34, 38, 41, 43, 45, 47, 49, ),
        /* 7 */ array(21, 23, 24, 28, 29, 31, 32, 33, 38, 41, 43, 45, 47, 49, ),
        /* 8 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 42, 43, 45, 47, 49, ),
        /* 9 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 42, 43, 45, 47, 49, ),
        /* 10 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 43, 45, 46, 47, 49, ),
        /* 11 */ array(21, 23, 24, 27, 28, 29, 31, 33, 38, 41, 43, 45, 47, 49, ),
        /* 12 */ array(21, 23, 24, 28, 29, 31, 33, 35, 38, 41, 43, 45, 47, 49, ),
        /* 13 */ array(21, 23, 24, 28, 29, 31, 33, 38, 39, 41, 43, 45, 47, 49, ),
        /* 14 */ array(21, 23, 24, 28, 29, 31, 33, 35, 38, 41, 43, 45, 47, 49, ),
        /* 15 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 43, 44, 45, 47, 49, ),
        /* 16 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 43, 45, 47, 49, ),
        /* 17 */ array(28, 31, 52, 53, 55, 58, 61, ),
        /* 18 */ array(28, 31, 52, 53, 55, 58, 61, ),
        /* 19 */ array(28, 31, 52, 53, 55, 58, 61, ),
        /* 20 */ array(28, 31, 52, 53, 55, 58, 61, ),
        /* 21 */ array(28, 31, 52, 53, 55, 58, 61, ),
        /* 22 */ array(28, 31, 52, 53, 55, 58, 61, ),
        /* 23 */ array(28, 31, 52, 53, 55, 58, 61, ),
        /* 24 */ array(22, 28, 29, 30, 31, 52, 53, 55, 61, ),
        /* 25 */ array(22, 28, 31, 52, 53, 55, 61, ),
        /* 26 */ array(28, 31, 52, 53, 55, 61, ),
        /* 27 */ array(22, 28, 30, 31, 36, 52, 53, 55, 61, ),
        /* 28 */ array(22, 28, 31, 36, 52, 53, 55, 61, ),
        /* 29 */ array(28, 31, 36, 52, 53, 55, 61, ),
        /* 30 */ array(28, 31, 52, 53, 55, 61, ),
        /* 31 */ array(28, 31, 52, 53, 55, 61, ),
        /* 32 */ array(28, 31, 52, 53, 55, 61, ),
        /* 33 */ array(28, 31, 52, 53, 55, 61, ),
        /* 34 */ array(28, 31, 52, 53, 55, 61, ),
        /* 35 */ array(28, 31, 61, ),
        /* 36 */ array(28, 31, 61, ),
        /* 37 */ array(28, 31, 61, ),
        /* 38 */ array(28, 31, 61, ),
        /* 39 */ array(1, 16, 17, 19, ),
        /* 40 */ array(1, 16, 17, 19, ),
        /* 41 */ array(1, 16, 17, 19, ),
        /* 42 */ array(1, 16, 17, 19, ),
        /* 43 */ array(1, 16, 17, 19, ),
        /* 44 */ array(1, 16, 17, 19, ),
        /* 45 */ array(1, 16, 17, 19, ),
        /* 46 */ array(1, 16, 17, 19, ),
        /* 47 */ array(1, 16, 17, 19, ),
        /* 48 */ array(22, 28, 31, 61, ),
        /* 49 */ array(1, 16, 17, 19, ),
        /* 50 */ array(1, 16, 17, 19, ),
        /* 51 */ array(1, 16, 17, 19, ),
        /* 52 */ array(1, 16, 17, 19, ),
        /* 53 */ array(1, 16, 17, 19, ),
        /* 54 */ array(1, 16, 17, 19, ),
        /* 55 */ array(1, 16, 17, 19, ),
        /* 56 */ array(28, 31, 61, ),
        /* 57 */ array(28, 31, 61, ),
        /* 58 */ array(28, 31, 61, ),
        /* 59 */ array(28, 31, 61, ),
        /* 60 */ array(28, 31, 61, ),
        /* 61 */ array(28, 31, 61, ),
        /* 62 */ array(28, 31, 61, ),
        /* 63 */ array(28, 31, 61, ),
        /* 64 */ array(28, 31, 61, ),
        /* 65 */ array(28, 31, 61, ),
        /* 66 */ array(28, 31, 61, ),
        /* 67 */ array(28, 31, 61, ),
        /* 68 */ array(28, 31, 61, ),
        /* 69 */ array(57, ),
        /* 70 */ array(57, ),
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
        /* 84 */ array(),
        /* 85 */ array(),
        /* 86 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 22, ),
        /* 87 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 59, ),
        /* 88 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 89 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 90 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 91 */ array(22, 30, 60, 62, ),
        /* 92 */ array(10, 36, 60, 62, ),
        /* 93 */ array(22, 60, 62, ),
        /* 94 */ array(22, 60, 62, ),
        /* 95 */ array(13, 14, 15, ),
        /* 96 */ array(10, 60, 62, ),
        /* 97 */ array(51, 60, 62, ),
        /* 98 */ array(22, 60, 62, ),
        /* 99 */ array(30, 60, 62, ),
        /* 100 */ array(22, 60, 62, ),
        /* 101 */ array(22, 60, 62, ),
        /* 102 */ array(22, 60, 62, ),
        /* 103 */ array(30, 60, 62, ),
        /* 104 */ array(22, 60, 62, ),
        /* 105 */ array(22, 60, 62, ),
        /* 106 */ array(54, 57, ),
        /* 107 */ array(20, 50, ),
        /* 108 */ array(22, 50, ),
        /* 109 */ array(60, 62, ),
        /* 110 */ array(60, 62, ),
        /* 111 */ array(56, 57, ),
        /* 112 */ array(48, 50, ),
        /* 113 */ array(25, 26, ),
        /* 114 */ array(63, ),
        /* 115 */ array(22, ),
        /* 116 */ array(22, ),
        /* 117 */ array(22, ),
        /* 118 */ array(61, ),
        /* 119 */ array(50, ),
        /* 120 */ array(18, ),
        /* 121 */ array(22, ),
        /* 122 */ array(22, ),
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
        /* 136 */ array(22, ),
        /* 137 */ array(22, ),
        /* 138 */ array(22, ),
        /* 139 */ array(22, ),
        /* 140 */ array(22, ),
        /* 141 */ array(22, ),
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
        /* 198 */ array(),
        /* 199 */ array(),
        /* 200 */ array(),
);
    static public $yy_default = array(
 /*     0 */   203,  271,  271,  271,  271,  271,  271,  271,  271,  271,
 /*    10 */   271,  271,  271,  271,  271,  271,  271,  271,  271,  271,
 /*    20 */   271,  271,  271,  271,  271,  271,  271,  271,  271,  243,
 /*    30 */   271,  271,  271,  271,  271,  271,  271,  271,  271,  271,
 /*    40 */   271,  271,  271,  271,  271,  271,  271,  271,  271,  271,
 /*    50 */   271,  271,  271,  201,  271,  271,  271,  271,  271,  271,
 /*    60 */   271,  271,  271,  271,  271,  271,  271,  271,  271,  271,
 /*    70 */   271,  203,  203,  203,  203,  203,  203,  203,  203,  203,
 /*    80 */   203,  203,  203,  203,  203,  203,  271,  271,  258,  261,
 /*    90 */   259,  271,  271,  271,  271,  260,  271,  247,  271,  271,
 /*   100 */   271,  271,  271,  271,  271,  271,  271,  271,  271,  252,
 /*   110 */   242,  271,  271,  271,  271,  271,  271,  271,  271,  263,
 /*   120 */   271,  271,  271,  271,  271,  271,  271,  271,  271,  271,
 /*   130 */   271,  271,  271,  271,  271,  271,  271,  271,  271,  271,
 /*   140 */   271,  271,  232,  236,  204,  256,  267,  202,  257,  254,
 /*   150 */   264,  265,  238,  208,  251,  230,  266,  253,  262,  211,
 /*   160 */   218,  219,  229,  228,  231,  233,  216,  217,  234,  227,
 /*   170 */   226,  248,  224,  223,  249,  250,  220,  225,  221,  215,
 /*   180 */   235,  268,  244,  269,  270,  246,  245,  206,  205,  255,
 /*   190 */   241,  209,  213,  237,  214,  212,  222,  210,  240,  239,
 /*   200 */   207,
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
    const YYNOCODE = 88;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 201;
    const YYNRULE = 70;
    const YYERRORSYMBOL = 64;
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
  'T_BY',          'T_FIRST_OF',    'T_PIPE',        'T_COLON',     
  'T_NUMERIC',     'T_STRING_SINGLE_INIT',  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',
  'T_STRING_DOUBLE_END',  'T_STRING_CONTENT',  'T_LPARENT',     'T_RPARENT',   
  'T_DOT',         'T_ALPHA',       'T_BRACKETS_OPEN',  'T_BRACKETS_CLOSE',
  'error',         'start',         'body',          'code',        
  'stmts',         'piped_list',    'var_or_string',  'stmt',        
  'for_stmt',      'ifchanged_stmt',  'block_stmt',    'filter_stmt', 
  'if_stmt',       'custom_tag',    'alias',         'varname',     
  'list',          'regroup',       'first_of',      'expr',        
  'varname_args',  'string',        's_content',   
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
 /*  13 */ "stmts ::= if_stmt",
 /*  14 */ "stmts ::= T_INCLUDE var_or_string T_CLOSE_TAG",
 /*  15 */ "stmts ::= custom_tag",
 /*  16 */ "stmts ::= alias",
 /*  17 */ "stmts ::= T_AUTOESCAPE T_OFF|T_ON T_CLOSE_TAG body T_OPEN_TAG T_END_AUTOESCAPE T_CLOSE_TAG",
 /*  18 */ "custom_tag ::= T_CUSTOM_TAG T_CLOSE_TAG",
 /*  19 */ "custom_tag ::= T_CUSTOM_TAG T_FOR varname T_CLOSE_TAG",
 /*  20 */ "custom_tag ::= T_CUSTOM_TAG T_FOR varname T_AS varname T_CLOSE_TAG",
 /*  21 */ "custom_tag ::= T_CUSTOM_TAG T_AS varname T_CLOSE_TAG",
 /*  22 */ "custom_tag ::= T_CUSTOM_TAG list T_CLOSE_TAG",
 /*  23 */ "custom_tag ::= T_CUSTOM_TAG list T_AS varname T_CLOSE_TAG",
 /*  24 */ "custom_tag ::= T_CUSTOM_BLOCK T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  25 */ "alias ::= T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_ENDWITH T_CLOSE_TAG",
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
 /*  38 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  39 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  40 */ "filter_stmt ::= T_FILTER piped_list T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  41 */ "regroup ::= T_REGROUP piped_list T_BY varname T_AS varname",
 /*  42 */ "first_of ::= T_FIRST_OF list",
 /*  43 */ "piped_list ::= piped_list T_PIPE varname_args",
 /*  44 */ "piped_list ::= varname_args",
 /*  45 */ "varname_args ::= varname T_COLON var_or_string",
 /*  46 */ "varname_args ::= varname",
 /*  47 */ "list ::= list var_or_string",
 /*  48 */ "list ::= list T_COMMA var_or_string",
 /*  49 */ "list ::= var_or_string",
 /*  50 */ "var_or_string ::= T_NUMERIC",
 /*  51 */ "var_or_string ::= varname",
 /*  52 */ "var_or_string ::= string",
 /*  53 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  54 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  55 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  56 */ "s_content ::= T_STRING_CONTENT",
 /*  57 */ "expr ::= expr T_AND expr",
 /*  58 */ "expr ::= expr T_OR expr",
 /*  59 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  60 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN expr",
 /*  61 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  62 */ "expr ::= piped_list",
 /*  63 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  64 */ "expr ::= string",
 /*  65 */ "expr ::= T_NUMERIC",
 /*  66 */ "varname ::= varname T_DOT T_ALPHA",
 /*  67 */ "varname ::= varname T_BRACKETS_OPEN var_or_string T_BRACKETS_CLOSE",
 /*  68 */ "varname ::= T_ALPHA",
 /*  69 */ "varname ::= T_CUSTOM_TAG|T_CUSTOM_BLOCK",
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
  array( 'lhs' => 65, 'rhs' => 1 ),
  array( 'lhs' => 66, 'rhs' => 2 ),
  array( 'lhs' => 66, 'rhs' => 0 ),
  array( 'lhs' => 67, 'rhs' => 2 ),
  array( 'lhs' => 67, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 2 ),
  array( 'lhs' => 67, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 2 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 7 ),
  array( 'lhs' => 77, 'rhs' => 2 ),
  array( 'lhs' => 77, 'rhs' => 4 ),
  array( 'lhs' => 77, 'rhs' => 6 ),
  array( 'lhs' => 77, 'rhs' => 4 ),
  array( 'lhs' => 77, 'rhs' => 3 ),
  array( 'lhs' => 77, 'rhs' => 5 ),
  array( 'lhs' => 77, 'rhs' => 6 ),
  array( 'lhs' => 78, 'rhs' => 9 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 9 ),
  array( 'lhs' => 72, 'rhs' => 11 ),
  array( 'lhs' => 72, 'rhs' => 13 ),
  array( 'lhs' => 72, 'rhs' => 15 ),
  array( 'lhs' => 76, 'rhs' => 7 ),
  array( 'lhs' => 76, 'rhs' => 11 ),
  array( 'lhs' => 73, 'rhs' => 6 ),
  array( 'lhs' => 73, 'rhs' => 7 ),
  array( 'lhs' => 73, 'rhs' => 10 ),
  array( 'lhs' => 73, 'rhs' => 11 ),
  array( 'lhs' => 74, 'rhs' => 7 ),
  array( 'lhs' => 74, 'rhs' => 8 ),
  array( 'lhs' => 75, 'rhs' => 7 ),
  array( 'lhs' => 81, 'rhs' => 6 ),
  array( 'lhs' => 82, 'rhs' => 2 ),
  array( 'lhs' => 69, 'rhs' => 3 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 84, 'rhs' => 3 ),
  array( 'lhs' => 84, 'rhs' => 1 ),
  array( 'lhs' => 80, 'rhs' => 2 ),
  array( 'lhs' => 80, 'rhs' => 3 ),
  array( 'lhs' => 80, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 2 ),
  array( 'lhs' => 86, 'rhs' => 1 ),
  array( 'lhs' => 83, 'rhs' => 3 ),
  array( 'lhs' => 83, 'rhs' => 3 ),
  array( 'lhs' => 83, 'rhs' => 3 ),
  array( 'lhs' => 83, 'rhs' => 3 ),
  array( 'lhs' => 83, 'rhs' => 3 ),
  array( 'lhs' => 83, 'rhs' => 1 ),
  array( 'lhs' => 83, 'rhs' => 3 ),
  array( 'lhs' => 83, 'rhs' => 1 ),
  array( 'lhs' => 83, 'rhs' => 1 ),
  array( 'lhs' => 79, 'rhs' => 3 ),
  array( 'lhs' => 79, 'rhs' => 4 ),
  array( 'lhs' => 79, 'rhs' => 1 ),
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
        15 => 3,
        16 => 3,
        26 => 3,
        27 => 3,
        46 => 3,
        56 => 3,
        65 => 3,
        68 => 3,
        69 => 3,
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
        48 => 43,
        44 => 44,
        49 => 44,
        45 => 45,
        47 => 47,
        50 => 50,
        51 => 51,
        52 => 52,
        64 => 52,
        53 => 53,
        54 => 53,
        55 => 55,
        57 => 57,
        58 => 57,
        59 => 57,
        61 => 57,
        60 => 60,
        62 => 62,
        63 => 63,
        66 => 66,
        67 => 67,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 65 "parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1418 "parser.php"
#line 67 "parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1421 "parser.php"
#line 68 "parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1424 "parser.php"
#line 71 "parser.y"
    function yy_r3(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1427 "parser.php"
#line 72 "parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1430 "parser.php"
#line 73 "parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1433 "parser.php"
#line 74 "parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1436 "parser.php"
#line 76 "parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1439 "parser.php"
#line 77 "parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1442 "parser.php"
#line 83 "parser.y"
    function yy_r14(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1445 "parser.php"
#line 86 "parser.y"
    function yy_r17(){ $this->_retvalue = array('operation' => 'autoescape', 'value' => strtolower(@$this->yystack[$this->yyidx + -5]->minor), 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1448 "parser.php"
#line 91 "parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1451 "parser.php"
#line 92 "parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'for' => $this->yystack[$this->yyidx + -1]->minor, 'list' => array());     }
#line 1454 "parser.php"
#line 93 "parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'for' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array(),'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1457 "parser.php"
#line 94 "parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1460 "parser.php"
#line 95 "parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1463 "parser.php"
#line 96 "parser.y"
    function yy_r23(){ $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1466 "parser.php"
#line 98 "parser.y"
    function yy_r24(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array());    }
#line 1469 "parser.php"
#line 101 "parser.y"
    function yy_r25(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1472 "parser.php"
#line 108 "parser.y"
    function yy_r28(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL); 
    }
#line 1477 "parser.php"
#line 111 "parser.y"
    function yy_r29(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -9]->minor); 
    }
#line 1482 "parser.php"
#line 114 "parser.y"
    function yy_r30(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL); 
    }
#line 1487 "parser.php"
#line 117 "parser.y"
    function yy_r31(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -13]->minor); 
    }
#line 1492 "parser.php"
#line 121 "parser.y"
    function yy_r32(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1495 "parser.php"
#line 122 "parser.y"
    function yy_r33(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1498 "parser.php"
#line 125 "parser.y"
    function yy_r34(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1503 "parser.php"
#line 129 "parser.y"
    function yy_r35(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1508 "parser.php"
#line 132 "parser.y"
    function yy_r36(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1513 "parser.php"
#line 136 "parser.y"
    function yy_r37(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1518 "parser.php"
#line 142 "parser.y"
    function yy_r38(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1521 "parser.php"
#line 144 "parser.y"
    function yy_r39(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1524 "parser.php"
#line 147 "parser.y"
    function yy_r40(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1527 "parser.php"
#line 150 "parser.y"
    function yy_r41(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1530 "parser.php"
#line 153 "parser.y"
    function yy_r42(){ $this->_retvalue = array('operation' => 'first_of', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1533 "parser.php"
#line 157 "parser.y"
    function yy_r43(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1536 "parser.php"
#line 158 "parser.y"
    function yy_r44(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1539 "parser.php"
#line 160 "parser.y"
    function yy_r45(){ $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, 'args'=>array($this->yystack[$this->yyidx + 0]->minor));     }
#line 1542 "parser.php"
#line 164 "parser.y"
    function yy_r47(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1545 "parser.php"
#line 168 "parser.y"
    function yy_r50(){ $this->_retvalue = array('number' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1548 "parser.php"
#line 169 "parser.y"
    function yy_r51(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1551 "parser.php"
#line 170 "parser.y"
    function yy_r52(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1554 "parser.php"
#line 172 "parser.y"
    function yy_r53(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1557 "parser.php"
#line 174 "parser.y"
    function yy_r55(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1560 "parser.php"
#line 178 "parser.y"
    function yy_r57(){ $this->_retvalue = array('op_expr' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1563 "parser.php"
#line 181 "parser.y"
    function yy_r60(){ $this->_retvalue = array('op_expr' => trim(@$this->yystack[$this->yyidx + -1]->minor), $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1566 "parser.php"
#line 183 "parser.y"
    function yy_r62(){$this->_retvalue = array('var_filter' => $this->yystack[$this->yyidx + 0]->minor);    }
#line 1569 "parser.php"
#line 184 "parser.y"
    function yy_r63(){ $this->_retvalue = array('op_expr' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1572 "parser.php"
#line 191 "parser.y"
    function yy_r66(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1575 "parser.php"
#line 192 "parser.y"
    function yy_r67(){ if (!is_array($this->yystack[$this->yyidx + -3]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -3]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + -1]->minor;    }
#line 1578 "parser.php"

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
#line 1698 "parser.php"
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

#line 1719 "parser.php"
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