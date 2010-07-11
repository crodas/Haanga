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
    const CUSTOM_TAG                     = 28;
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
    const T_CYCLE                        = 49;
    const T_FIRST_OF                     = 50;
    const T_PIPE                         = 51;
    const T_COLON                        = 52;
    const T_STRING_SINGLE_INIT           = 53;
    const T_STRING_SINGLE_END            = 54;
    const T_STRING_DOUBLE_INIT           = 55;
    const T_STRING_DOUBLE_END            = 56;
    const T_STRING_CONTENT               = 57;
    const T_LPARENT                      = 58;
    const T_RPARENT                      = 59;
    const T_NUMERIC                      = 60;
    const T_DOT                          = 61;
    const T_ALPHA                        = 62;
    const T_BRACKETS_OPEN                = 63;
    const T_BRACKETS_CLOSE               = 64;
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
    const YY_SZ_ACTTAB = 755;
static public $yy_action = array(
 /*     0 */    36,  175,   33,  117,  132,  106,   35,   24,   61,  198,
 /*    10 */   125,  203,   58,  195,  128,  162,  129,   23,  115,   30,
 /*    20 */    25,   71,   69,  155,   38,  173,   73,   32,   26,   27,
 /*    30 */    36,   49,   33,  117,   59,  185,   57,   24,   61,   21,
 /*    40 */   125,  154,   58,  168,   59,   85,   57,   23,   60,  144,
 /*    50 */    25,  137,   69,  168,   38,  198,   73,  193,   26,   27,
 /*    60 */    36,   48,   33,  117,  115,   31,  115,   24,   61,  167,
 /*    70 */   125,  173,   58,  173,   68,  168,  196,   23,  140,  139,
 /*    80 */    25,   66,   69,   83,   38,   86,   73,   32,   26,   27,
 /*    90 */    36,   52,   33,  117,   19,   19,   19,   24,   61,  132,
 /*   100 */   125,   35,   58,   65,   59,  170,   57,   23,   62,  138,
 /*   110 */    25,  136,   69,  168,   38,  132,   73,   35,   26,   27,
 /*   120 */    36,   39,   33,  117,  132,  179,   35,   24,   61,   53,
 /*   130 */   125,   41,   58,   64,  141,   44,  145,   23,   51,  132,
 /*   140 */    25,   35,   69,   50,   38,  186,   73,   47,   26,   27,
 /*   150 */    36,   42,   33,  117,  132,  113,   35,   24,   61,  198,
 /*   160 */   125,  156,   58,   84,  132,  106,   35,   23,  115,   29,
 /*   170 */    25,  147,   69,   56,   38,  173,   73,   32,   26,   27,
 /*   180 */    36,  169,   33,  117,  132,  187,   35,   24,   61,  190,
 /*   190 */   125,  201,   58,  183,   59,   87,   57,   23,   63,   82,
 /*   200 */    25,  123,   69,  168,   38,  198,   73,  151,   26,   27,
 /*   210 */    36,  188,   33,  117,  115,   28,   39,   24,   61,  182,
 /*   220 */   125,  173,   58,  168,  143,   81,   59,   23,   57,  132,
 /*   230 */    25,   35,   69,  191,   38,  168,   73,   32,   26,   27,
 /*   240 */    36,  174,   33,  117,  178,   77,  121,   24,   61,   59,
 /*   250 */   125,   57,   58,  184,   59,   80,   57,   23,  168,   75,
 /*   260 */    25,  164,   69,  168,   38,   34,   73,  202,   26,   27,
 /*   270 */    36,   98,   33,  117,  132,  180,   35,   24,   61,  150,
 /*   280 */   125,  148,   58,  134,  132,  181,   35,   23,  176,  178,
 /*   290 */    25,   70,   69,  110,   38,   88,   73,   94,   26,   27,
 /*   300 */    36,  177,   33,  117,  132,  116,   35,   24,   61,  197,
 /*   310 */   125,  133,   58,  111,  132,  106,   35,   23,  115,   76,
 /*   320 */    25,  147,   69,  172,   38,  173,   73,  105,   26,   27,
 /*   330 */    36,  114,   33,  117,  132,  127,   35,   24,   61,   54,
 /*   340 */   125,  112,   58,   40,  115,  103,  104,   23,  146,   97,
 /*   350 */    25,  173,   69,  162,   38,  118,   73,  115,   26,   27,
 /*   360 */    36,  107,   33,  117,  173,  194,   95,   24,   61,   99,
 /*   370 */   125,   96,   58,   46,   74,  101,  100,   23,  135,   45,
 /*   380 */    25,  109,   69,  102,   38,   43,   73,  126,   26,   27,
 /*   390 */    36,  162,   33,  117,  162,  162,  115,   24,   61,  162,
 /*   400 */   125,  162,   58,  173,  132,  162,   35,   23,  122,  122,
 /*   410 */    25,  120,   69,  132,   38,   35,   73,  162,   26,   27,
 /*   420 */    78,   22,   20,   18,   18,   18,   18,   18,   18,   18,
 /*   430 */    17,   17,   19,   19,   19,  162,   36,  162,   33,  117,
 /*   440 */   162,   79,  162,   24,   61,  162,  125,  162,   58,   39,
 /*   450 */   142,  276,   55,   23,  162,  162,   25,  162,   69,  162,
 /*   460 */    38,  162,   73,  162,   26,   27,  162,   22,   20,   18,
 /*   470 */    18,   18,   18,   18,   18,   18,   17,   17,   19,   19,
 /*   480 */    19,  124,   36,  162,   33,  117,  162,  162,  162,   24,
 /*   490 */    61,  106,  125,  162,   58,  162,   90,  147,  153,   23,
 /*   500 */   130,  162,   25,  124,   69,  162,   38,  162,   73,  115,
 /*   510 */    26,   27,  162,  106,  162,  162,  173,  162,   91,  147,
 /*   520 */   153,  162,  162,  162,  152,  162,  162,  162,   20,   18,
 /*   530 */    18,   18,   18,   18,   18,   18,   17,   17,   19,   19,
 /*   540 */    19,  171,  162,  162,  131,  160,  159,  158,  157,  161,
 /*   550 */   166,  165,  162,  162,  200,  199,  192,  162,  162,   18,
 /*   560 */    18,   18,   18,   18,   18,   18,   17,   17,   19,   19,
 /*   570 */    19,  163,  162,  124,  162,  162,  162,  124,   67,   72,
 /*   580 */   162,  124,  162,  106,  162,  162,  162,  106,  108,  147,
 /*   590 */   153,  106,  149,  147,  153,  162,   92,  147,  153,  124,
 /*   600 */   162,  162,   59,  124,   57,  162,    2,  162,  162,  106,
 /*   610 */   162,  168,  162,  106,   89,  147,  153,    8,   93,  147,
 /*   620 */   153,  189,  119,   12,   37,  162,  162,  162,  162,  162,
 /*   630 */   162,  162,  189,  119,   10,   37,  162,  162,  189,  119,
 /*   640 */    11,   37,  162,  162,  162,  162,  162,  162,  162,  189,
 /*   650 */   119,    7,   37,  162,  162,  189,  119,    1,   37,  162,
 /*   660 */   162,  162,  162,  162,  162,  162,  189,  119,    3,   37,
 /*   670 */   162,  162,  189,  119,    9,   37,  162,  162,  162,  162,
 /*   680 */   162,  162,  162,  189,  119,    6,   37,  162,  162,  189,
 /*   690 */   119,    5,   37,  162,  162,  162,  162,  162,  162,  162,
 /*   700 */   189,  119,   15,   37,  162,  162,  189,  119,   13,   37,
 /*   710 */   162,  162,  162,  162,  162,  162,  162,  189,  119,   16,
 /*   720 */    37,  162,  162,  189,  119,    4,   37,  162,  162,  162,
 /*   730 */   162,  162,  162,  162,  189,  119,   14,   37,  162,  162,
 /*   740 */   189,  119,  162,   37,  162,  162,  162,  162,  162,  162,
 /*   750 */   162,  189,  119,  162,   37,
    );
    static public $yy_lookahead = array(
 /*     0 */    21,   64,   23,   24,   61,   80,   63,   28,   29,   71,
 /*    10 */    31,   86,   33,   22,   35,   22,   37,   38,   80,   81,
 /*    20 */    41,   30,   43,   22,   45,   87,   47,   36,   49,   50,
 /*    30 */    21,   67,   23,   24,   53,   22,   55,   28,   29,   58,
 /*    40 */    31,   60,   33,   62,   53,   22,   55,   38,   10,   40,
 /*    50 */    41,   42,   43,   62,   45,   71,   47,   71,   49,   50,
 /*    60 */    21,   67,   23,   24,   80,   81,   80,   28,   29,   22,
 /*    70 */    31,   87,   33,   87,   36,   62,   22,   38,   39,   40,
 /*    80 */    41,   30,   43,   22,   45,   22,   47,   36,   49,   50,
 /*    90 */    21,   67,   23,   24,   13,   14,   15,   28,   29,   61,
 /*   100 */    31,   63,   33,   10,   53,   22,   55,   38,   30,   40,
 /*   110 */    41,   42,   43,   62,   45,   61,   47,   63,   49,   50,
 /*   120 */    21,   51,   23,   24,   61,   22,   63,   28,   29,   67,
 /*   130 */    31,   67,   33,   30,   35,   67,   37,   38,   67,   61,
 /*   140 */    41,   63,   43,   67,   45,   22,   47,   67,   49,   50,
 /*   150 */    21,   67,   23,   24,   61,   70,   63,   28,   29,   71,
 /*   160 */    31,   22,   33,   22,   61,   80,   63,   38,   80,   81,
 /*   170 */    41,   86,   43,   44,   45,   87,   47,   36,   49,   50,
 /*   180 */    21,   62,   23,   24,   61,   20,   63,   28,   29,   22,
 /*   190 */    31,   22,   33,   22,   53,   22,   55,   38,   30,   22,
 /*   200 */    41,   42,   43,   62,   45,   71,   47,   22,   49,   50,
 /*   210 */    21,   18,   23,   24,   80,   81,   51,   28,   29,   22,
 /*   220 */    31,   87,   33,   62,   35,   22,   53,   38,   55,   61,
 /*   230 */    41,   63,   43,   22,   45,   62,   47,   36,   49,   50,
 /*   240 */    21,   54,   23,   24,   57,   22,   27,   28,   29,   53,
 /*   250 */    31,   55,   33,   22,   53,   22,   55,   38,   62,   22,
 /*   260 */    41,   22,   43,   62,   45,   52,   47,   22,   49,   50,
 /*   270 */    21,   80,   23,   24,   61,   22,   63,   28,   29,   22,
 /*   280 */    31,   22,   33,   34,   61,   22,   63,   38,   56,   57,
 /*   290 */    41,   48,   43,   88,   45,   22,   47,   80,   49,   50,
 /*   300 */    21,   57,   23,   24,   61,   70,   63,   28,   29,   71,
 /*   310 */    31,   32,   33,   88,   61,   80,   63,   38,   80,   22,
 /*   320 */    41,   86,   43,   68,   45,   87,   47,   80,   49,   50,
 /*   330 */    21,   80,   23,   24,   61,   71,   63,   28,   29,   67,
 /*   340 */    31,   80,   33,   67,   80,   80,   80,   38,   71,   80,
 /*   350 */    41,   87,   43,   89,   45,   46,   47,   80,   49,   50,
 /*   360 */    21,   80,   23,   24,   87,   22,   80,   28,   29,   80,
 /*   370 */    31,   80,   33,   67,   22,   80,   80,   38,   39,   67,
 /*   380 */    41,   80,   43,   80,   45,   67,   47,   71,   49,   50,
 /*   390 */    21,   89,   23,   24,   89,   89,   80,   28,   29,   89,
 /*   400 */    31,   89,   33,   87,   61,   89,   63,   38,   25,   26,
 /*   410 */    41,   42,   43,   61,   45,   63,   47,   89,   49,   50,
 /*   420 */    22,    2,    3,    4,    5,    6,    7,    8,    9,   10,
 /*   430 */    11,   12,   13,   14,   15,   89,   21,   89,   23,   24,
 /*   440 */    89,   22,   89,   28,   29,   89,   31,   89,   33,   51,
 /*   450 */    35,   66,   67,   38,   89,   89,   41,   89,   43,   89,
 /*   460 */    45,   89,   47,   89,   49,   50,   89,    2,    3,    4,
 /*   470 */     5,    6,    7,    8,    9,   10,   11,   12,   13,   14,
 /*   480 */    15,   70,   21,   89,   23,   24,   89,   89,   89,   28,
 /*   490 */    29,   80,   31,   89,   33,   89,   85,   86,   87,   38,
 /*   500 */    71,   89,   41,   70,   43,   89,   45,   89,   47,   80,
 /*   510 */    49,   50,   89,   80,   89,   89,   87,   89,   85,   86,
 /*   520 */    87,   89,   89,   89,   59,   89,   89,   89,    3,    4,
 /*   530 */     5,    6,    7,    8,    9,   10,   11,   12,   13,   14,
 /*   540 */    15,   69,   89,   89,   72,   73,   74,   75,   76,   77,
 /*   550 */    78,   79,   89,   89,   82,   83,   84,   89,   89,    4,
 /*   560 */     5,    6,    7,    8,    9,   10,   11,   12,   13,   14,
 /*   570 */    15,   22,   89,   70,   89,   89,   89,   70,   29,   30,
 /*   580 */    89,   70,   89,   80,   89,   89,   89,   80,   85,   86,
 /*   590 */    87,   80,   85,   86,   87,   89,   85,   86,   87,   70,
 /*   600 */    89,   89,   53,   70,   55,   89,    1,   89,   89,   80,
 /*   610 */    89,   62,   89,   80,   85,   86,   87,    1,   85,   86,
 /*   620 */    87,   16,   17,    1,   19,   89,   89,   89,   89,   89,
 /*   630 */    89,   89,   16,   17,    1,   19,   89,   89,   16,   17,
 /*   640 */     1,   19,   89,   89,   89,   89,   89,   89,   89,   16,
 /*   650 */    17,    1,   19,   89,   89,   16,   17,    1,   19,   89,
 /*   660 */    89,   89,   89,   89,   89,   89,   16,   17,    1,   19,
 /*   670 */    89,   89,   16,   17,    1,   19,   89,   89,   89,   89,
 /*   680 */    89,   89,   89,   16,   17,    1,   19,   89,   89,   16,
 /*   690 */    17,    1,   19,   89,   89,   89,   89,   89,   89,   89,
 /*   700 */    16,   17,    1,   19,   89,   89,   16,   17,    1,   19,
 /*   710 */    89,   89,   89,   89,   89,   89,   89,   16,   17,    1,
 /*   720 */    19,   89,   89,   16,   17,    1,   19,   89,   89,   89,
 /*   730 */    89,   89,   89,   89,   16,   17,    1,   19,   89,   89,
 /*   740 */    16,   17,   89,   19,   89,   89,   89,   89,   89,   89,
 /*   750 */    89,   16,   17,   89,   19,
);
    const YY_SHIFT_USE_DFLT = -64;
    const YY_SHIFT_MAX = 145;
    static public $yy_shift_ofst = array(
 /*     0 */   -64,   99,   39,   69,  -21,    9,  369,  279,  189,  219,
 /*    10 */   309,  249,  129,  415,  339,  159,  461,  -19,  -19,  -19,
 /*    20 */   -19,  -19,  -19,  -19,  549,  173,  196,  196,   -9,  141,
 /*    30 */    51,  201,  196,  196,  196,  196,  196,  161,  161,  161,
 /*    40 */   684,  673,  656,  633,  650,  724,  639,  616,  622,  605,
 /*    50 */   667,  690,  735,  701,  707,  718,   13,  244,  161,  244,
 /*    60 */   161,  161,  161,  161,  161,  161,  161,  161,  161,  161,
 /*    70 */   161,  161,  161,  161,  -64,  -64,  -64,  -64,  -64,  -64,
 /*    80 */   -64,  -64,  -64,  -64,  -64,  -64,  -64,  -64,  -64,  465,
 /*    90 */   419,  525,  555,  555,   38,  103,  343,  352,  273,   54,
 /*   100 */    78,  243,   93,  223,  253,  168,  213,  123,   81,   63,
 /*   110 */   187,  232,  -57,  165,  -57,  -57,  398,  383,  167,  193,
 /*   120 */   257,  239,  233,  263,   70,   61,   83,   -7,    1,  297,
 /*   130 */   -63,   47,  119,  245,  169,  171,  197,  185,  203,  177,
 /*   140 */   139,  211,  259,  231,  237,   23,
);
    const YY_REDUCE_USE_DFLT = -76;
    const YY_REDUCE_MAX = 88;
    static public $yy_reduce_ofst = array(
 /*     0 */   385,  472,  472,  472,  472,  472,  472,  472,  472,  472,
 /*    10 */   472,  472,  472,  472,  472,  472,  472,  503,  511,  507,
 /*    20 */   533,  529,  433,  411,  134,   88,  -62,  -16,  -14,  -14,
 /*    30 */   -14,  -14,  238,  264,  277,  429,  316,   85,  235,  -75,
 /*    40 */   255,  255,  255,  255,  255,  255,  255,  255,  255,  255,
 /*    50 */   255,  255,  255,  255,  255,  255,  281,  225,  247,  205,
 /*    60 */   191,  217,  251,  269,  266,  265,  261,  286,  303,  301,
 /*    70 */   296,  291,  289,  295,  306,  276,  272,  312,  318,  -36,
 /*    80 */    64,   62,   24,   68,   71,   80,   -6,   76,   84,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(21, 23, 24, 28, 29, 31, 33, 35, 37, 38, 41, 43, 45, 47, 49, 50, ),
        /* 2 */ array(21, 23, 24, 28, 29, 31, 33, 38, 39, 40, 41, 43, 45, 47, 49, 50, ),
        /* 3 */ array(21, 23, 24, 28, 29, 31, 33, 38, 40, 41, 42, 43, 45, 47, 49, 50, ),
        /* 4 */ array(21, 23, 24, 28, 29, 31, 33, 35, 37, 38, 41, 43, 45, 47, 49, 50, ),
        /* 5 */ array(21, 23, 24, 28, 29, 31, 33, 38, 40, 41, 42, 43, 45, 47, 49, 50, ),
        /* 6 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 42, 43, 45, 47, 49, 50, ),
        /* 7 */ array(21, 23, 24, 28, 29, 31, 32, 33, 38, 41, 43, 45, 47, 49, 50, ),
        /* 8 */ array(21, 23, 24, 28, 29, 31, 33, 35, 38, 41, 43, 45, 47, 49, 50, ),
        /* 9 */ array(21, 23, 24, 27, 28, 29, 31, 33, 38, 41, 43, 45, 47, 49, 50, ),
        /* 10 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 43, 45, 46, 47, 49, 50, ),
        /* 11 */ array(21, 23, 24, 28, 29, 31, 33, 34, 38, 41, 43, 45, 47, 49, 50, ),
        /* 12 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 43, 44, 45, 47, 49, 50, ),
        /* 13 */ array(21, 23, 24, 28, 29, 31, 33, 35, 38, 41, 43, 45, 47, 49, 50, ),
        /* 14 */ array(21, 23, 24, 28, 29, 31, 33, 38, 39, 41, 43, 45, 47, 49, 50, ),
        /* 15 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 42, 43, 45, 47, 49, 50, ),
        /* 16 */ array(21, 23, 24, 28, 29, 31, 33, 38, 41, 43, 45, 47, 49, 50, ),
        /* 17 */ array(53, 55, 58, 60, 62, ),
        /* 18 */ array(53, 55, 58, 60, 62, ),
        /* 19 */ array(53, 55, 58, 60, 62, ),
        /* 20 */ array(53, 55, 58, 60, 62, ),
        /* 21 */ array(53, 55, 58, 60, 62, ),
        /* 22 */ array(53, 55, 58, 60, 62, ),
        /* 23 */ array(53, 55, 58, 60, 62, ),
        /* 24 */ array(22, 29, 30, 53, 55, 62, ),
        /* 25 */ array(22, 53, 55, 62, ),
        /* 26 */ array(53, 55, 62, ),
        /* 27 */ array(53, 55, 62, ),
        /* 28 */ array(22, 30, 36, 53, 55, 62, ),
        /* 29 */ array(22, 36, 53, 55, 62, ),
        /* 30 */ array(30, 36, 53, 55, 62, ),
        /* 31 */ array(36, 53, 55, 62, ),
        /* 32 */ array(53, 55, 62, ),
        /* 33 */ array(53, 55, 62, ),
        /* 34 */ array(53, 55, 62, ),
        /* 35 */ array(53, 55, 62, ),
        /* 36 */ array(53, 55, 62, ),
        /* 37 */ array(62, ),
        /* 38 */ array(62, ),
        /* 39 */ array(62, ),
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
        /* 56 */ array(22, 62, ),
        /* 57 */ array(57, ),
        /* 58 */ array(62, ),
        /* 59 */ array(57, ),
        /* 60 */ array(62, ),
        /* 61 */ array(62, ),
        /* 62 */ array(62, ),
        /* 63 */ array(62, ),
        /* 64 */ array(62, ),
        /* 65 */ array(62, ),
        /* 66 */ array(62, ),
        /* 67 */ array(62, ),
        /* 68 */ array(62, ),
        /* 69 */ array(62, ),
        /* 70 */ array(62, ),
        /* 71 */ array(62, ),
        /* 72 */ array(62, ),
        /* 73 */ array(62, ),
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
        /* 86 */ array(),
        /* 87 */ array(),
        /* 88 */ array(),
        /* 89 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 59, ),
        /* 90 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 22, ),
        /* 91 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 92 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 93 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 94 */ array(10, 36, 61, 63, ),
        /* 95 */ array(22, 30, 61, 63, ),
        /* 96 */ array(22, 61, 63, ),
        /* 97 */ array(22, 61, 63, ),
        /* 98 */ array(22, 61, 63, ),
        /* 99 */ array(22, 61, 63, ),
        /* 100 */ array(30, 61, 63, ),
        /* 101 */ array(48, 61, 63, ),
        /* 102 */ array(10, 61, 63, ),
        /* 103 */ array(22, 61, 63, ),
        /* 104 */ array(22, 61, 63, ),
        /* 105 */ array(30, 61, 63, ),
        /* 106 */ array(52, 61, 63, ),
        /* 107 */ array(22, 61, 63, ),
        /* 108 */ array(13, 14, 15, ),
        /* 109 */ array(22, 61, 63, ),
        /* 110 */ array(54, 57, ),
        /* 111 */ array(56, 57, ),
        /* 112 */ array(61, 63, ),
        /* 113 */ array(20, 51, ),
        /* 114 */ array(61, 63, ),
        /* 115 */ array(61, 63, ),
        /* 116 */ array(22, 51, ),
        /* 117 */ array(25, 26, ),
        /* 118 */ array(22, ),
        /* 119 */ array(18, ),
        /* 120 */ array(22, ),
        /* 121 */ array(22, ),
        /* 122 */ array(22, ),
        /* 123 */ array(22, ),
        /* 124 */ array(51, ),
        /* 125 */ array(22, ),
        /* 126 */ array(22, ),
        /* 127 */ array(22, ),
        /* 128 */ array(22, ),
        /* 129 */ array(22, ),
        /* 130 */ array(64, ),
        /* 131 */ array(22, ),
        /* 132 */ array(62, ),
        /* 133 */ array(22, ),
        /* 134 */ array(22, ),
        /* 135 */ array(22, ),
        /* 136 */ array(22, ),
        /* 137 */ array(22, ),
        /* 138 */ array(22, ),
        /* 139 */ array(22, ),
        /* 140 */ array(22, ),
        /* 141 */ array(22, ),
        /* 142 */ array(22, ),
        /* 143 */ array(22, ),
        /* 144 */ array(22, ),
        /* 145 */ array(22, ),
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
        /* 203 */ array(),
);
    static public $yy_default = array(
 /*     0 */   206,  275,  275,  275,  275,  275,  275,  275,  275,  275,
 /*    10 */   275,  275,  275,  275,  275,  275,  275,  275,  275,  275,
 /*    20 */   275,  275,  275,  275,  275,  275,  275,  275,  275,  275,
 /*    30 */   247,  249,  275,  275,  275,  275,  275,  275,  275,  275,
 /*    40 */   275,  275,  275,  275,  275,  275,  275,  275,  275,  275,
 /*    50 */   275,  275,  275,  275,  275,  204,  275,  275,  275,  275,
 /*    60 */   275,  275,  275,  275,  275,  275,  275,  275,  275,  275,
 /*    70 */   275,  275,  275,  275,  206,  206,  206,  206,  206,  206,
 /*    80 */   206,  206,  206,  206,  206,  206,  206,  206,  206,  275,
 /*    90 */   275,  263,  266,  264,  275,  275,  275,  275,  275,  275,
 /*   100 */   275,  275,  275,  275,  275,  275,  253,  275,  265,  275,
 /*   110 */   275,  275,  248,  275,  246,  257,  275,  275,  275,  275,
 /*   120 */   275,  275,  275,  275,  268,  275,  275,  275,  275,  275,
 /*   130 */   275,  275,  275,  275,  275,  275,  275,  275,  275,  275,
 /*   140 */   275,  275,  275,  275,  275,  275,  252,  251,  236,  267,
 /*   150 */   242,  240,  269,  270,  271,  234,  237,  216,  215,  214,
 /*   160 */   213,  217,  218,  222,  221,  220,  219,  212,  274,  272,
 /*   170 */   211,  207,  205,  258,  259,  273,  260,  262,  261,  223,
 /*   180 */   224,  241,  239,  238,  235,  243,  244,  210,  209,  208,
 /*   190 */   245,  233,  232,  254,  227,  226,  225,  255,  256,  231,
 /*   200 */   230,  229,  228,  250,
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
    const YYNOCODE = 90;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 204;
    const YYNRULE = 71;
    const YYERRORSYMBOL = 65;
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
  'CUSTOM_TAG',    'T_FOR',         'T_AS',          'T_CUSTOM_BLOCK',
  'T_CUSTOM_END',  'T_WITH',        'T_ENDWITH',     'T_CLOSEFOR',  
  'T_COMMA',       'T_EMPTY',       'T_IF',          'T_ENDIF',     
  'T_ELSE',        'T_IFCHANGED',   'T_ENDIFCHANGED',  'T_BLOCK',     
  'T_END_BLOCK',   'T_FILTER',      'T_END_FILTER',  'T_REGROUP',   
  'T_BY',          'T_CYCLE',       'T_FIRST_OF',    'T_PIPE',      
  'T_COLON',       'T_STRING_SINGLE_INIT',  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',
  'T_STRING_DOUBLE_END',  'T_STRING_CONTENT',  'T_LPARENT',     'T_RPARENT',   
  'T_NUMERIC',     'T_DOT',         'T_ALPHA',       'T_BRACKETS_OPEN',
  'T_BRACKETS_CLOSE',  'error',         'start',         'body',        
  'code',          'stmts',         'piped_list',    'var_or_string',
  'stmt',          'for_stmt',      'ifchanged_stmt',  'block_stmt',  
  'filter_stmt',   'if_stmt',       'custom_tag',    'alias',       
  'varname',       'list',          'cycle',         'regroup',     
  'first_of',      'expr',          'varname_args',  'string',      
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
 /*  18 */ "custom_tag ::= CUSTOM_TAG T_CLOSE_TAG",
 /*  19 */ "custom_tag ::= CUSTOM_TAG T_FOR varname T_CLOSE_TAG",
 /*  20 */ "custom_tag ::= CUSTOM_TAG T_FOR varname T_AS varname T_CLOSE_TAG",
 /*  21 */ "custom_tag ::= CUSTOM_TAG T_AS varname T_CLOSE_TAG",
 /*  22 */ "custom_tag ::= CUSTOM_TAG list T_CLOSE_TAG",
 /*  23 */ "custom_tag ::= CUSTOM_TAG list T_AS varname T_CLOSE_TAG",
 /*  24 */ "custom_tag ::= T_CUSTOM_BLOCK T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
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
 /*  62 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN expr",
 /*  63 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  64 */ "expr ::= piped_list",
 /*  65 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  66 */ "expr ::= string",
 /*  67 */ "expr ::= T_NUMERIC",
 /*  68 */ "varname ::= varname T_DOT T_ALPHA",
 /*  69 */ "varname ::= varname T_BRACKETS_OPEN var_or_string T_BRACKETS_CLOSE",
 /*  70 */ "varname ::= T_ALPHA",
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
  array( 'lhs' => 66, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 2 ),
  array( 'lhs' => 67, 'rhs' => 0 ),
  array( 'lhs' => 68, 'rhs' => 2 ),
  array( 'lhs' => 68, 'rhs' => 1 ),
  array( 'lhs' => 68, 'rhs' => 2 ),
  array( 'lhs' => 68, 'rhs' => 3 ),
  array( 'lhs' => 69, 'rhs' => 3 ),
  array( 'lhs' => 69, 'rhs' => 2 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 3 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 1 ),
  array( 'lhs' => 69, 'rhs' => 7 ),
  array( 'lhs' => 78, 'rhs' => 2 ),
  array( 'lhs' => 78, 'rhs' => 4 ),
  array( 'lhs' => 78, 'rhs' => 6 ),
  array( 'lhs' => 78, 'rhs' => 4 ),
  array( 'lhs' => 78, 'rhs' => 3 ),
  array( 'lhs' => 78, 'rhs' => 5 ),
  array( 'lhs' => 78, 'rhs' => 6 ),
  array( 'lhs' => 79, 'rhs' => 9 ),
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 72, 'rhs' => 1 ),
  array( 'lhs' => 73, 'rhs' => 9 ),
  array( 'lhs' => 73, 'rhs' => 11 ),
  array( 'lhs' => 73, 'rhs' => 13 ),
  array( 'lhs' => 73, 'rhs' => 15 ),
  array( 'lhs' => 77, 'rhs' => 7 ),
  array( 'lhs' => 77, 'rhs' => 11 ),
  array( 'lhs' => 74, 'rhs' => 6 ),
  array( 'lhs' => 74, 'rhs' => 7 ),
  array( 'lhs' => 74, 'rhs' => 10 ),
  array( 'lhs' => 74, 'rhs' => 11 ),
  array( 'lhs' => 75, 'rhs' => 7 ),
  array( 'lhs' => 75, 'rhs' => 8 ),
  array( 'lhs' => 76, 'rhs' => 7 ),
  array( 'lhs' => 83, 'rhs' => 6 ),
  array( 'lhs' => 82, 'rhs' => 2 ),
  array( 'lhs' => 82, 'rhs' => 4 ),
  array( 'lhs' => 84, 'rhs' => 2 ),
  array( 'lhs' => 70, 'rhs' => 3 ),
  array( 'lhs' => 70, 'rhs' => 1 ),
  array( 'lhs' => 86, 'rhs' => 3 ),
  array( 'lhs' => 86, 'rhs' => 1 ),
  array( 'lhs' => 81, 'rhs' => 2 ),
  array( 'lhs' => 81, 'rhs' => 3 ),
  array( 'lhs' => 81, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 71, 'rhs' => 1 ),
  array( 'lhs' => 87, 'rhs' => 3 ),
  array( 'lhs' => 87, 'rhs' => 3 ),
  array( 'lhs' => 88, 'rhs' => 2 ),
  array( 'lhs' => 88, 'rhs' => 1 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 1 ),
  array( 'lhs' => 85, 'rhs' => 3 ),
  array( 'lhs' => 85, 'rhs' => 1 ),
  array( 'lhs' => 85, 'rhs' => 1 ),
  array( 'lhs' => 80, 'rhs' => 3 ),
  array( 'lhs' => 80, 'rhs' => 4 ),
  array( 'lhs' => 80, 'rhs' => 1 ),
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
        28 => 3,
        49 => 3,
        58 => 3,
        67 => 3,
        70 => 3,
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
        63 => 59,
        62 => 62,
        64 => 64,
        65 => 65,
        68 => 68,
        69 => 69,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 65 "parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1424 "parser.php"
#line 67 "parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1427 "parser.php"
#line 68 "parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1430 "parser.php"
#line 71 "parser.y"
    function yy_r3(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1433 "parser.php"
#line 72 "parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1436 "parser.php"
#line 73 "parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1439 "parser.php"
#line 74 "parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1442 "parser.php"
#line 76 "parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1445 "parser.php"
#line 77 "parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1448 "parser.php"
#line 83 "parser.y"
    function yy_r14(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1451 "parser.php"
#line 86 "parser.y"
    function yy_r17(){ $this->_retvalue = array('operation' => 'autoescape', 'value' => @$this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1454 "parser.php"
#line 91 "parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1457 "parser.php"
#line 92 "parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'for' => $this->yystack[$this->yyidx + -1]->minor, 'list' => array());     }
#line 1460 "parser.php"
#line 93 "parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'for' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array(),'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1463 "parser.php"
#line 94 "parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1466 "parser.php"
#line 95 "parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1469 "parser.php"
#line 96 "parser.y"
    function yy_r23(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1472 "parser.php"
#line 98 "parser.y"
    function yy_r24(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'filter', 'functions' =>array($this->yystack[$this->yyidx + -5]->minor), 'body' => $this->yystack[$this->yyidx + -3]->minor);    }
#line 1475 "parser.php"
#line 101 "parser.y"
    function yy_r25(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1478 "parser.php"
#line 109 "parser.y"
    function yy_r29(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1483 "parser.php"
#line 112 "parser.y"
    function yy_r30(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -9]->minor); 
    }
#line 1488 "parser.php"
#line 115 "parser.y"
    function yy_r31(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1493 "parser.php"
#line 118 "parser.y"
    function yy_r32(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -13]->minor); 
    }
#line 1498 "parser.php"
#line 122 "parser.y"
    function yy_r33(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1501 "parser.php"
#line 123 "parser.y"
    function yy_r34(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1504 "parser.php"
#line 126 "parser.y"
    function yy_r35(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1509 "parser.php"
#line 130 "parser.y"
    function yy_r36(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1514 "parser.php"
#line 133 "parser.y"
    function yy_r37(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1519 "parser.php"
#line 137 "parser.y"
    function yy_r38(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1524 "parser.php"
#line 143 "parser.y"
    function yy_r39(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1527 "parser.php"
#line 145 "parser.y"
    function yy_r40(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1530 "parser.php"
#line 148 "parser.y"
    function yy_r41(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1533 "parser.php"
#line 151 "parser.y"
    function yy_r42(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1536 "parser.php"
#line 154 "parser.y"
    function yy_r43(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1539 "parser.php"
#line 155 "parser.y"
    function yy_r44(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1542 "parser.php"
#line 158 "parser.y"
    function yy_r45(){ $this->_retvalue = array('operation' => 'first_of', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1545 "parser.php"
#line 162 "parser.y"
    function yy_r46(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1548 "parser.php"
#line 163 "parser.y"
    function yy_r47(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1551 "parser.php"
#line 165 "parser.y"
    function yy_r48(){ $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, 'args'=>array($this->yystack[$this->yyidx + 0]->minor));     }
#line 1554 "parser.php"
#line 169 "parser.y"
    function yy_r50(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1557 "parser.php"
#line 173 "parser.y"
    function yy_r53(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1560 "parser.php"
#line 174 "parser.y"
    function yy_r54(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1563 "parser.php"
#line 176 "parser.y"
    function yy_r55(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1566 "parser.php"
#line 178 "parser.y"
    function yy_r57(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1569 "parser.php"
#line 182 "parser.y"
    function yy_r59(){ $this->_retvalue = array('op' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1572 "parser.php"
#line 185 "parser.y"
    function yy_r62(){ $this->_retvalue = array('op' => trim(@$this->yystack[$this->yyidx + -1]->minor), $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1575 "parser.php"
#line 187 "parser.y"
    function yy_r64(){$this->_retvalue = array('var_filter' => $this->yystack[$this->yyidx + 0]->minor);    }
#line 1578 "parser.php"
#line 188 "parser.y"
    function yy_r65(){ $this->_retvalue = array('op' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1581 "parser.php"
#line 195 "parser.y"
    function yy_r68(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1584 "parser.php"
#line 196 "parser.y"
    function yy_r69(){ if (!is_array($this->yystack[$this->yyidx + -3]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -3]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + -1]->minor;    }
#line 1587 "parser.php"

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
#line 1707 "parser.php"
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

#line 1728 "parser.php"
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