/* Driver template for the LEMON parser generator.
** The author disclaims copyright to this source code.
*/
/* First off, code is included that follows the "include" declaration
** in the input grammar file. */
#include <stdio.h>
#line 2 "parser.y"

/*
  +---------------------------------------------------------------------------------+
  | Copyright (c) 2010 César Rodas and Menéame Comunicacions S.L.                   |
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
#line 45 "parser.c"
/* Next is all token values, in a form suitable for use by makeheaders.
** This section will be null unless lemon is run with the -m switch.
*/
/* 
** These constants (all generated automatically by the parser generator)
** specify the various kinds of tokens (terminals) that the parser
** understands. 
**
** Each symbol here is a terminal symbol in the grammar.
*/
/* Make sure the INTERFACE macro is defined.
*/
#ifndef INTERFACE
# define INTERFACE 1
#endif
/* The next thing included is series of defines which control
** various aspects of the generated parser.
**    YYCODETYPE         is the data type used for storing terminal
**                       and nonterminal numbers.  "unsigned char" is
**                       used if there are fewer than 250 terminals
**                       and nonterminals.  "int" is used otherwise.
**    YYNOCODE           is a number of type YYCODETYPE which corresponds
**                       to no legal terminal or nonterminal number.  This
**                       number is used to fill in empty slots of the hash 
**                       table.
**    YYFALLBACK         If defined, this indicates that one or more tokens
**                       have fall-back values which should be used if the
**                       original value of the token will not parse.
**    YYACTIONTYPE       is the data type used for storing terminal
**                       and nonterminal numbers.  "unsigned char" is
**                       used if there are fewer than 250 rules and
**                       states combined.  "int" is used otherwise.
**    Haanga_TOKENTYPE     is the data type used for minor tokens given 
**                       directly to the parser from the tokenizer.
**    YYMINORTYPE        is the data type used for all minor tokens.
**                       This is typically a union of many types, one of
**                       which is Haanga_TOKENTYPE.  The entry in the union
**                       for base tokens is called "yy0".
**    YYSTACKDEPTH       is the maximum depth of the parser's stack.  If
**                       zero the stack is dynamically sized using realloc()
**    Haanga_ARG_SDECL     A static variable declaration for the %extra_argument
**    Haanga_ARG_PDECL     A parameter declaration for the %extra_argument
**    Haanga_ARG_STORE     Code to store %extra_argument into yypParser
**    Haanga_ARG_FETCH     Code to extract %extra_argument from yypParser
**    YYNSTATE           the combined number of states.
**    YYNRULE            the number of rules in the grammar
**    YYERRORSYMBOL      is the code number of the error symbol.  If not
**                       defined, then do no error processing.
*/
#define YYCODETYPE unsigned char
#define YYNOCODE 83
#define YYACTIONTYPE unsigned short int
#define Haanga_TOKENTYPE void*
typedef union {
  int yyinit;
  Haanga_TOKENTYPE yy0;
} YYMINORTYPE;
#ifndef YYSTACKDEPTH
#define YYSTACKDEPTH 100
#endif
#define Haanga_ARG_SDECL
#define Haanga_ARG_PDECL
#define Haanga_ARG_FETCH
#define Haanga_ARG_STORE
#define YYNSTATE 236
#define YYNRULE 79
#define YY_NO_ACTION      (YYNSTATE+YYNRULE+2)
#define YY_ACCEPT_ACTION  (YYNSTATE+YYNRULE+1)
#define YY_ERROR_ACTION   (YYNSTATE+YYNRULE)

/* The yyzerominor constant is used to initialize instances of
** YYMINORTYPE objects to zero. */
static const YYMINORTYPE yyzerominor = { 0 };

/* Define the yytestcase() macro to be a no-op if is not already defined
** otherwise.
**
** Applications can choose to define yytestcase() in the %include section
** to a macro that can assist in verifying code coverage.  For production
** code the yytestcase() macro should be turned off.  But it is useful
** for testing.
*/
#ifndef yytestcase
# define yytestcase(X)
#endif


/* Next are the tables used to determine what action to take based on the
** current state and lookahead token.  These tables are used to implement
** functions that take a state number and lookahead value and return an
** action integer.  
**
** Suppose the action integer is N.  Then the action is determined as
** follows
**
**   0 <= N < YYNSTATE                  Shift N.  That is, push the lookahead
**                                      token onto the stack and goto state N.
**
**   YYNSTATE <= N < YYNSTATE+YYNRULE   Reduce by rule N-YYNSTATE.
**
**   N == YYNSTATE+YYNRULE              A syntax error has occurred.
**
**   N == YYNSTATE+YYNRULE+1            The parser accepts its input.
**
**   N == YYNSTATE+YYNRULE+2            No such action.  Denotes unused
**                                      slots in the yy_action[] table.
**
** The action table is constructed as a single large table named yy_action[].
** Given state S and lookahead X, the action is computed as
**
**      yy_action[ yy_shift_ofst[S] + X ]
**
** If the index value yy_shift_ofst[S]+X is out of range or if the value
** yy_lookahead[yy_shift_ofst[S]+X] is not equal to X or if yy_shift_ofst[S]
** is equal to YY_SHIFT_USE_DFLT, it means that the action is not in the table
** and that yy_default[S] should be used instead.  
**
** The formula above is for computing the action when the lookahead is
** a terminal symbol.  If the lookahead is a non-terminal (as occurs after
** a reduce action) then the yy_reduce_ofst[] array is used in place of
** the yy_shift_ofst[] array and YY_REDUCE_USE_DFLT is used in place of
** YY_SHIFT_USE_DFLT.
**
** The following are the tables generated in this section:
**
**  yy_action[]        A single table containing all actions.
**  yy_lookahead[]     A table containing the lookahead for each entry in
**                     yy_action.  Used to detect hash collisions.
**  yy_shift_ofst[]    For each state, the offset into yy_action for
**                     shifting terminals.
**  yy_reduce_ofst[]   For each state, the offset into yy_action for
**                     shifting non-terminals after a reduce.
**  yy_default[]       Default action for each state.
*/
static const YYACTIONTYPE yy_action[] = {
 /*     0 */    40,  168,   42,   54,  143,   34,  225,   35,  140,   60,
 /*    10 */    83,   63,  124,  144,   22,  118,   36,   30,   32,   52,
 /*    20 */   119,   47,   48,  116,   40,  162,   42,   54,  146,   34,
 /*    30 */   207,   35,  140,   60,   83,   63,  125,  116,   22,  147,
 /*    40 */    36,   30,   32,   52,  205,   47,   48,  116,   40,  111,
 /*    50 */    42,   54,  149,   34,  207,   35,  140,   60,   83,   63,
 /*    60 */   126,  112,   22,  150,   36,   30,   32,   52,  113,   47,
 /*    70 */    48,  116,   40,  114,   42,   54,  153,   34,  207,   35,
 /*    80 */   140,   60,   83,   63,  316,   51,   22,  154,   36,   30,
 /*    90 */    32,   52,  115,   47,   48,  110,   40,  117,   42,   54,
 /*   100 */   157,   34,  120,   35,  140,   60,   83,   63,  176,  133,
 /*   110 */    22,  158,   36,   30,   32,   52,  122,   47,   48,  170,
 /*   120 */    40,  203,   42,   54,  164,   34,   55,   35,  140,   60,
 /*   130 */    83,   63,   58,  204,   22,  165,   36,   30,   32,   52,
 /*   140 */    59,   47,   48,   62,   40,   65,   42,   54,  138,   34,
 /*   150 */    66,   35,  140,   60,   83,   63,   50,  208,   22,  171,
 /*   160 */    36,   30,   32,   52,   67,   47,   48,   68,   40,   69,
 /*   170 */    42,   54,  139,   34,   70,   35,  140,   60,   83,   63,
 /*   180 */    50,   99,   22,  172,   36,   30,   32,   52,   71,   47,
 /*   190 */    48,   72,   40,   73,   42,   54,  141,   34,   74,   35,
 /*   200 */   140,   60,   83,   63,   50,   75,   22,  134,   36,   30,
 /*   210 */    32,   52,   76,   47,   48,   79,   40,   80,   42,   54,
 /*   220 */   142,   34,   81,   35,  140,   60,   83,   63,   82,  177,
 /*   230 */    22,  178,   36,   30,   32,   52,  181,   47,   48,  187,
 /*   240 */    40,   50,   42,   54,  145,   34,  191,   35,  140,   60,
 /*   250 */    83,   63,  199,   86,   22,  200,   36,   30,   32,   52,
 /*   260 */   201,   47,   48,  209,   40,  317,   42,   54,  148,   34,
 /*   270 */    89,   35,  140,   60,   83,   63,  210,  211,   22,   91,
 /*   280 */    36,   30,   32,   52,  212,   47,   48,  213,   40,  317,
 /*   290 */    42,   54,  151,   34,   93,   35,  140,   60,   83,   63,
 /*   300 */   214,   94,   22,  215,   36,   30,   32,   52,   95,   47,
 /*   310 */    48,  216,   40,  317,   42,   54,  155,   34,   96,   35,
 /*   320 */   140,   60,   83,   63,  217,   97,   22,  218,   36,   30,
 /*   330 */    32,   52,  221,   47,   48,  100,   40,  317,   42,   54,
 /*   340 */   159,   34,  226,   35,  140,   60,   83,   63,  230,  102,
 /*   350 */    22,  231,   36,   30,   32,   52,  235,   47,   48,  317,
 /*   360 */    40,  317,   42,   54,   53,   34,  317,   35,  140,   60,
 /*   370 */    83,   63,  317,  317,   22,  317,   36,   30,   32,   52,
 /*   380 */   317,   47,   48,  317,   40,  317,   42,   54,  160,   34,
 /*   390 */   317,   35,  140,   60,   83,   63,  317,  317,   22,  317,
 /*   400 */    36,   30,   32,   52,  317,   47,   48,  317,   40,  317,
 /*   410 */    42,   54,  129,   34,  317,   35,  140,   60,   83,   63,
 /*   420 */   317,  317,   22,  317,   36,   30,   32,   52,  317,   47,
 /*   430 */    48,  317,   40,  317,   42,   54,  166,   34,  317,   35,
 /*   440 */   140,   60,   83,   63,  317,  317,   22,  317,   36,   30,
 /*   450 */    32,   52,  317,   47,   48,  317,   40,  317,   42,   54,
 /*   460 */   167,   34,  317,   35,  140,   60,   83,   63,  317,  317,
 /*   470 */    22,  196,   36,   30,   32,   52,  317,   47,   48,  317,
 /*   480 */    40,  121,   42,   54,  175,   34,   84,   35,  140,   60,
 /*   490 */    83,   63,  317,  224,   22,   61,   36,   30,   32,   52,
 /*   500 */   317,   47,   48,   23,   25,   27,   27,   27,   27,   27,
 /*   510 */    27,   27,   26,   26,   28,   28,   28,  131,   50,  132,
 /*   520 */    41,  131,   90,  132,   41,   46,   23,   25,   27,   27,
 /*   530 */    27,   27,   27,   27,   27,   26,   26,   28,   28,   28,
 /*   540 */    23,   25,   27,   27,   27,   27,   27,   27,   27,   26,
 /*   550 */    26,   28,   28,   28,   25,   27,   27,   27,   27,   27,
 /*   560 */    27,   27,   26,   26,   28,   28,   28,  131,  317,  132,
 /*   570 */    41,  317,  169,  317,  233,  136,  182,  183,  184,  185,
 /*   580 */   186,  188,  189,  190,    7,  194,  202,  317,   88,  180,
 /*   590 */    57,  180,  131,  317,  132,   41,   43,  236,   21,  317,
 /*   600 */   222,  223,   49,  180,  173,   78,   24,   28,   28,   28,
 /*   610 */   174,  174,  176,  133,  222,  223,   49,  179,   27,   27,
 /*   620 */    27,   27,   27,   27,   27,   26,   26,   28,   28,   28,
 /*   630 */   180,  131,  180,  132,   41,   77,   50,  317,  317,  127,
 /*   640 */   317,   45,  192,  317,  180,  227,  180,   56,  180,  317,
 /*   650 */   116,  228,  228,  176,  133,  128,   29,  207,  179,  317,
 /*   660 */   180,  173,    8,   64,  317,  317,  116,  174,  174,  176,
 /*   670 */   133,  101,  317,  207,  179,  180,  317,  180,  222,  223,
 /*   680 */    49,  193,   43,  131,  317,  132,   41,  317,  317,  180,
 /*   690 */   173,  163,  317,  317,  317,  317,  174,  174,  176,  133,
 /*   700 */   103,  317,  116,  179,  180,  229,  180,  104,  234,  207,
 /*   710 */   317,   43,  131,  317,  132,   41,  317,  317,  180,  173,
 /*   720 */   163,  317,  317,  317,  317,  174,  174,  176,  133,   85,
 /*   730 */   317,  116,  179,  180,  229,  180,  107,  234,  207,  198,
 /*   740 */   317,  317,  317,  317,  317,  317,  317,  180,  173,  121,
 /*   750 */    37,  317,  175,  317,  174,  174,  176,  133,   92,  317,
 /*   760 */   317,  179,  180,  317,  180,  317,  317,  317,  198,  317,
 /*   770 */   317,  317,  317,  317,  317,  317,  180,  173,  121,   39,
 /*   780 */   317,  175,  163,  174,  174,  176,  133,  317,  317,  180,
 /*   790 */   179,  180,  130,  116,  317,  180,  229,  180,  106,  234,
 /*   800 */   207,  317,  121,  180,  227,  175,  317,  317,  317,  180,
 /*   810 */   228,  228,  176,  133,  198,  317,  180,  179,  180,  317,
 /*   820 */   180,  317,  180,  179,  121,   38,  317,  175,  317,    9,
 /*   830 */   180,  173,  317,  317,  180,  161,  317,  174,  174,  176,
 /*   840 */   133,  163,  317,  135,  179,  222,  223,   49,  179,  163,
 /*   850 */   317,  137,  116,  121,  317,  229,  175,  108,  234,  207,
 /*   860 */   116,  121,  163,  229,  175,  123,  234,  207,  317,  317,
 /*   870 */   317,  219,  317,  116,  163,  180,  229,  180,  109,  234,
 /*   880 */   207,  317,  163,  317,  317,  116,  317,  317,  229,  180,
 /*   890 */   232,  234,  207,  116,  163,  317,  229,  317,  105,  234,
 /*   900 */   207,  317,  163,  179,  163,  116,  317,  317,  229,  317,
 /*   910 */    10,   31,  207,  116,    1,  116,  229,  317,  229,  152,
 /*   920 */   207,   33,  207,  163,  317,  317,  222,  223,   49,   11,
 /*   930 */   222,  223,   49,    2,  116,  317,   12,  229,  195,    3,
 /*   940 */   156,  207,   13,  317,  317,  222,  223,   49,    4,  222,
 /*   950 */   223,   49,  222,  223,   49,  222,  223,   49,  222,  223,
 /*   960 */    49,   14,  317,  197,  222,  223,   49,    5,  317,  131,
 /*   970 */   317,  132,   41,  121,  317,   87,  175,  222,  223,   49,
 /*   980 */    15,  206,  317,  222,  223,   49,   16,  317,  317,  317,
 /*   990 */   317,  121,  317,  317,  175,  317,  222,  223,   49,   17,
 /*  1000 */   317,  317,  222,  223,   49,   18,  131,  317,  132,   41,
 /*  1010 */   317,  317,  317,  317,  317,  222,  223,   49,    6,   44,
 /*  1020 */   317,  222,  223,   49,   19,   98,  131,  317,  132,   41,
 /*  1030 */   317,  220,  317,  317,  222,  223,   49,   20,  317,  317,
 /*  1040 */   222,  223,   49,  317,  317,  317,  317,  317,  317,  317,
 /*  1050 */   317,  317,  317,  222,  223,   49,  131,  317,  132,   41,
 /*  1060 */   317,  317,  131,  317,  132,   41,
};
static const YYCODETYPE yy_lookahead[] = {
 /*     0 */    21,   61,   23,   24,   25,   26,   22,   28,   29,   30,
 /*    10 */    31,   32,   63,   34,   35,   74,   37,   38,   39,   40,
 /*    20 */    74,   42,   43,   74,   21,   41,   23,   24,   25,   26,
 /*    30 */    81,   28,   29,   30,   31,   32,   63,   74,   35,   36,
 /*    40 */    37,   38,   39,   40,   81,   42,   43,   74,   21,   74,
 /*    50 */    23,   24,   25,   26,   81,   28,   29,   30,   31,   32,
 /*    60 */    63,   74,   35,   36,   37,   38,   39,   40,   74,   42,
 /*    70 */    43,   74,   21,   74,   23,   24,   25,   26,   81,   28,
 /*    80 */    29,   30,   31,   32,   59,   60,   35,   36,   37,   38,
 /*    90 */    39,   40,   74,   42,   43,   74,   21,   74,   23,   24,
 /*   100 */    25,   26,   74,   28,   29,   30,   31,   32,   49,   50,
 /*   110 */    35,   36,   37,   38,   39,   40,   74,   42,   43,   22,
 /*   120 */    21,   77,   23,   24,   25,   26,   60,   28,   29,   30,
 /*   130 */    31,   32,   60,   22,   35,   36,   37,   38,   39,   40,
 /*   140 */    60,   42,   43,   60,   21,   60,   23,   24,   25,   26,
 /*   150 */    60,   28,   29,   30,   31,   32,   45,   22,   35,   54,
 /*   160 */    37,   38,   39,   40,   60,   42,   43,   60,   21,   60,
 /*   170 */    23,   24,   25,   26,   60,   28,   29,   30,   31,   32,
 /*   180 */    45,   22,   35,   54,   37,   38,   39,   40,   60,   42,
 /*   190 */    43,   60,   21,   60,   23,   24,   25,   26,   60,   28,
 /*   200 */    29,   30,   31,   32,   45,   60,   35,   49,   37,   38,
 /*   210 */    39,   40,   60,   42,   43,   60,   21,   60,   23,   24,
 /*   220 */    25,   26,   60,   28,   29,   30,   31,   32,   60,   51,
 /*   230 */    35,   57,   37,   38,   39,   40,   22,   42,   43,   22,
 /*   240 */    21,   45,   23,   24,   25,   26,   22,   28,   29,   30,
 /*   250 */    31,   32,   22,   22,   35,   22,   37,   38,   39,   40,
 /*   260 */    22,   42,   43,   22,   21,   82,   23,   24,   25,   26,
 /*   270 */    22,   28,   29,   30,   31,   32,   22,   22,   35,   22,
 /*   280 */    37,   38,   39,   40,   22,   42,   43,   22,   21,   82,
 /*   290 */    23,   24,   25,   26,   22,   28,   29,   30,   31,   32,
 /*   300 */    22,   22,   35,   22,   37,   38,   39,   40,   22,   42,
 /*   310 */    43,   22,   21,   82,   23,   24,   25,   26,   22,   28,
 /*   320 */    29,   30,   31,   32,   22,   22,   35,   22,   37,   38,
 /*   330 */    39,   40,   22,   42,   43,   22,   21,   82,   23,   24,
 /*   340 */    25,   26,   22,   28,   29,   30,   31,   32,   22,   22,
 /*   350 */    35,   22,   37,   38,   39,   40,   22,   42,   43,   82,
 /*   360 */    21,   82,   23,   24,   25,   26,   82,   28,   29,   30,
 /*   370 */    31,   32,   82,   82,   35,   82,   37,   38,   39,   40,
 /*   380 */    82,   42,   43,   82,   21,   82,   23,   24,   25,   26,
 /*   390 */    82,   28,   29,   30,   31,   32,   82,   82,   35,   82,
 /*   400 */    37,   38,   39,   40,   82,   42,   43,   82,   21,   82,
 /*   410 */    23,   24,   25,   26,   82,   28,   29,   30,   31,   32,
 /*   420 */    82,   82,   35,   82,   37,   38,   39,   40,   82,   42,
 /*   430 */    43,   82,   21,   82,   23,   24,   25,   26,   82,   28,
 /*   440 */    29,   30,   31,   32,   82,   82,   35,   82,   37,   38,
 /*   450 */    39,   40,   82,   42,   43,   82,   21,   82,   23,   24,
 /*   460 */    25,   26,   82,   28,   29,   30,   31,   32,   82,   82,
 /*   470 */    35,   64,   37,   38,   39,   40,   82,   42,   43,   82,
 /*   480 */    21,   74,   23,   24,   77,   26,   22,   28,   29,   30,
 /*   490 */    31,   32,   82,   20,   35,   27,   37,   38,   39,   40,
 /*   500 */    82,   42,   43,    3,    4,    5,    6,    7,    8,    9,
 /*   510 */    10,   11,   12,   13,   14,   15,   16,   53,   45,   55,
 /*   520 */    56,   53,   22,   55,   56,   11,    3,    4,    5,    6,
 /*   530 */     7,    8,    9,   10,   11,   12,   13,   14,   15,   16,
 /*   540 */     3,    4,    5,    6,    7,    8,    9,   10,   11,   12,
 /*   550 */    13,   14,   15,   16,    4,    5,    6,    7,    8,    9,
 /*   560 */    10,   11,   12,   13,   14,   15,   16,   53,   82,   55,
 /*   570 */    56,   82,   62,   82,   51,   65,   66,   67,   68,   69,
 /*   580 */    70,   71,   72,   73,    1,   22,   76,   82,   78,   26,
 /*   590 */    27,   28,   53,   82,   55,   56,   33,    0,    1,   82,
 /*   600 */    17,   18,   19,   40,   41,   27,    2,   14,   15,   16,
 /*   610 */    47,   48,   49,   50,   17,   18,   19,   54,    5,    6,
 /*   620 */     7,    8,    9,   10,   11,   12,   13,   14,   15,   16,
 /*   630 */    26,   53,   28,   55,   56,   44,   45,   82,   82,   63,
 /*   640 */    82,   11,   22,   82,   40,   41,   26,   27,   28,   82,
 /*   650 */    74,   47,   48,   49,   50,   63,   52,   81,   54,   82,
 /*   660 */    40,   41,    1,   33,   82,   82,   74,   47,   48,   49,
 /*   670 */    50,   22,   82,   81,   54,   26,   82,   28,   17,   18,
 /*   680 */    19,   22,   33,   53,   82,   55,   56,   82,   82,   40,
 /*   690 */    41,   63,   82,   82,   82,   82,   47,   48,   49,   50,
 /*   700 */    22,   82,   74,   54,   26,   77,   28,   79,   80,   81,
 /*   710 */    82,   33,   53,   82,   55,   56,   82,   82,   40,   41,
 /*   720 */    63,   82,   82,   82,   82,   47,   48,   49,   50,   22,
 /*   730 */    82,   74,   54,   26,   77,   28,   79,   80,   81,   64,
 /*   740 */    82,   82,   82,   82,   82,   82,   82,   40,   41,   74,
 /*   750 */    75,   82,   77,   82,   47,   48,   49,   50,   22,   82,
 /*   760 */    82,   54,   26,   82,   28,   82,   82,   82,   64,   82,
 /*   770 */    82,   82,   82,   82,   82,   82,   40,   41,   74,   75,
 /*   780 */    82,   77,   63,   47,   48,   49,   50,   82,   82,   26,
 /*   790 */    54,   28,   64,   74,   82,   26,   77,   28,   79,   80,
 /*   800 */    81,   82,   74,   40,   41,   77,   82,   82,   82,   40,
 /*   810 */    47,   48,   49,   50,   64,   82,   26,   54,   28,   82,
 /*   820 */    26,   82,   28,   54,   74,   75,   82,   77,   82,    1,
 /*   830 */    40,   41,   82,   82,   40,   41,   82,   47,   48,   49,
 /*   840 */    50,   63,   82,   64,   54,   17,   18,   19,   54,   63,
 /*   850 */    82,   64,   74,   74,   82,   77,   77,   79,   80,   81,
 /*   860 */    74,   74,   63,   77,   77,   79,   80,   81,   82,   82,
 /*   870 */    82,   22,   82,   74,   63,   26,   77,   28,   79,   80,
 /*   880 */    81,   82,   63,   82,   82,   74,   82,   82,   77,   40,
 /*   890 */    79,   80,   81,   74,   63,   82,   77,   82,   79,   80,
 /*   900 */    81,   82,   63,   54,   63,   74,   82,   82,   77,   82,
 /*   910 */     1,   80,   81,   74,    1,   74,   77,   82,   77,   80,
 /*   920 */    81,   80,   81,   63,   82,   82,   17,   18,   19,    1,
 /*   930 */    17,   18,   19,    1,   74,   82,    1,   77,   22,    1,
 /*   940 */    80,   81,    1,   82,   82,   17,   18,   19,    1,   17,
 /*   950 */    18,   19,   17,   18,   19,   17,   18,   19,   17,   18,
 /*   960 */    19,    1,   82,   64,   17,   18,   19,    1,   82,   53,
 /*   970 */    82,   55,   56,   74,   82,   22,   77,   17,   18,   19,
 /*   980 */     1,   64,   82,   17,   18,   19,    1,   82,   82,   82,
 /*   990 */    82,   74,   82,   82,   77,   82,   17,   18,   19,    1,
 /*  1000 */    82,   82,   17,   18,   19,    1,   53,   82,   55,   56,
 /*  1010 */    82,   82,   82,   82,   82,   17,   18,   19,    1,   46,
 /*  1020 */    82,   17,   18,   19,    1,   22,   53,   82,   55,   56,
 /*  1030 */    82,   22,   82,   82,   17,   18,   19,    1,   82,   82,
 /*  1040 */    17,   18,   19,   82,   82,   82,   82,   82,   82,   82,
 /*  1050 */    82,   82,   82,   17,   18,   19,   53,   82,   55,   56,
 /*  1060 */    82,   82,   53,   82,   55,   56,
};
#define YY_SHIFT_USE_DFLT (-22)
#define YY_SHIFT_MAX 167
static const short yy_shift_ofst[] = {
 /*     0 */   -22,  -21,    3,   27,   51,   75,   99,  123,  147,  171,
 /*    10 */   195,  219,  243,  267,  291,  315,  339,  363,  387,  411,
 /*    20 */   435,  459,  604,  604,  604,  604,  604,  604,  604,  604,
 /*    30 */   763,  763,  763,  763,  620,  707,  736,  563,  649,  678,
 /*    40 */   790,  790,  790,  790,  790,  769,  769,  769,  769,  769,
 /*    50 */   769,  597,  794,  849,  769,  583,  769,  769,  661,  828,
 /*    60 */   769,  769,  909,  769,  769,  913,  928,  932,  935,  938,
 /*    70 */   941,  947,  960,  966,  979,  985,  998,  769,  769, 1004,
 /*    80 */  1017, 1023, 1036,   59,  -22,  -22,  -22,  -22,  -22,  -22,
 /*    90 */   -22,  -22,  -22,  -22,  -22,  -22,  -22,  -22,  -22,  -22,
 /*   100 */   -22,  -22,  -22,  -22,  500,  523,  537,  550,  613,  613,
 /*   110 */   630,  464,  659,  916,  468,  953,  973,  514, 1003, 1009,
 /*   120 */   578,  539,  539,  593,  111,  135,  159,  591,  473,  -16,
 /*   130 */    97,  105,  129,  158,  178,  174,  214,  217,  224,  230,
 /*   140 */   231,  233,  238,  241,  248,  254,  255,  257,  262,  265,
 /*   150 */   272,  278,  279,  281,  286,  289,  296,  302,  303,  305,
 /*   160 */   310,  313,  320,  196,  326,  327,  329,  334,
};
#define YY_REDUCE_USE_DFLT (-61)
#define YY_REDUCE_MAX 103
static const short yy_reduce_ofst[] = {
 /*     0 */    25,  510,  510,  510,  510,  510,  510,  510,  510,  510,
 /*    10 */   510,  510,  510,  510,  510,  510,  510,  510,  510,  510,
 /*    20 */   510,  510,  628,  657,  719,  778,  786,  799,  811,  819,
 /*    30 */   831,  839,  841,  860,  675,  704,  750,  407,  407,  407,
 /*    40 */   728,  779,  787,  899,  917,  -51,  -27,   -3,  576,  592,
 /*    50 */   -37,  -60,  -59,  -54,  -25,  -60,  -13,   -6,  -60,  -60,
 /*    60 */    -1,   18,  -60,   21,   23,  -60,  -60,  -60,  -60,  -60,
 /*    70 */   -60,  -60,  -60,  -60,  -60,  -60,  -60,   28,   42,  -60,
 /*    80 */   -60,  -60,  -60,   44,   66,   72,   80,   83,   85,   90,
 /*    90 */   104,  107,  109,  114,  128,  131,  133,  138,  145,  152,
 /*   100 */   155,  157,  162,  168,
};
static const YYACTIONTYPE yy_default[] = {
 /*     0 */   238,  315,  315,  315,  315,  315,  315,  315,  315,  315,
 /*    10 */   315,  315,  315,  315,  315,  315,  315,  315,  315,  315,
 /*    20 */   315,  315,  315,  315,  315,  315,  315,  315,  315,  315,
 /*    30 */   315,  315,  315,  315,  315,  315,  315,  315,  315,  315,
 /*    40 */   315,  315,  315,  315,  315,  315,  315,  315,  315,  315,
 /*    50 */   315,  315,  315,  315,  315,  315,  315,  315,  315,  315,
 /*    60 */   315,  315,  315,  315,  315,  315,  315,  315,  315,  315,
 /*    70 */   315,  315,  315,  315,  315,  315,  315,  315,  315,  315,
 /*    80 */   315,  315,  315,  315,  238,  238,  238,  238,  238,  238,
 /*    90 */   238,  238,  238,  238,  238,  238,  238,  238,  238,  238,
 /*   100 */   238,  238,  238,  238,  315,  315,  302,  303,  304,  306,
 /*   110 */   315,  315,  315,  315,  315,  315,  288,  315,  315,  315,
 /*   120 */   315,  292,  284,  305,  315,  315,  315,  315,  315,  315,
 /*   130 */   315,  315,  315,  315,  315,  315,  315,  315,  315,  315,
 /*   140 */   315,  315,  315,  315,  315,  315,  315,  315,  315,  315,
 /*   150 */   315,  315,  315,  315,  315,  315,  315,  315,  315,  315,
 /*   160 */   315,  315,  315,  296,  315,  315,  315,  315,  237,  239,
 /*   170 */   243,  310,  311,  293,  294,  295,  300,  301,  312,  313,
 /*   180 */   314,  244,  245,  246,  247,  248,  249,  250,  251,  252,
 /*   190 */   253,  254,  255,  256,  257,  258,  289,  290,  291,  259,
 /*   200 */   261,  262,  263,  264,  265,  285,  287,  286,  266,  267,
 /*   210 */   268,  269,  270,  271,  273,  275,  276,  277,  278,  279,
 /*   220 */   280,  283,  240,  241,  242,  281,  282,  297,  298,  299,
 /*   230 */   272,  274,  307,  308,  309,  260,
};
#define YY_SZ_ACTTAB (int)(sizeof(yy_action)/sizeof(yy_action[0]))

/* The next table maps tokens into fallback tokens.  If a construct
** like the following:
** 
**      %fallback ID X Y Z.
**
** appears in the grammar, then ID becomes a fallback token for X, Y,
** and Z.  Whenever one of the tokens X, Y, or Z is input to the parser
** but it does not parse, the type of the token is changed to ID and
** the parse is retried before an error is thrown.
*/
#ifdef YYFALLBACK
static const YYCODETYPE yyFallback[] = {
};
#endif /* YYFALLBACK */

/* The following structure represents a single element of the
** parser's stack.  Information stored includes:
**
**   +  The state number for the parser at this level of the stack.
**
**   +  The value of the token stored at this level of the stack.
**      (In other words, the "major" token.)
**
**   +  The semantic value stored at this level of the stack.  This is
**      the information used by the action routines in the grammar.
**      It is sometimes called the "minor" token.
*/
struct yyStackEntry {
  YYACTIONTYPE stateno;  /* The state-number */
  YYCODETYPE major;      /* The major token value.  This is the code
                         ** number for the token at this stack level */
  YYMINORTYPE minor;     /* The user-supplied minor token value.  This
                         ** is the value of the token  */
};
typedef struct yyStackEntry yyStackEntry;

/* The state of the parser is completely contained in an instance of
** the following structure */
struct yyParser {
  int yyidx;                    /* Index of top element in stack */
#ifdef YYTRACKMAXSTACKDEPTH
  int yyidxMax;                 /* Maximum value of yyidx */
#endif
  int yyerrcnt;                 /* Shifts left before out of the error */
  Haanga_ARG_SDECL                /* A place to hold %extra_argument */
#if YYSTACKDEPTH<=0
  int yystksz;                  /* Current side of the stack */
  yyStackEntry *yystack;        /* The parser's stack */
#else
  yyStackEntry yystack[YYSTACKDEPTH];  /* The parser's stack */
#endif
};
typedef struct yyParser yyParser;

#ifndef NDEBUG
#include <stdio.h>
static FILE *yyTraceFILE = 0;
static char *yyTracePrompt = 0;
#endif /* NDEBUG */

#ifndef NDEBUG
/* 
** Turn parser tracing on by giving a stream to which to write the trace
** and a prompt to preface each trace message.  Tracing is turned off
** by making either argument NULL 
**
** Inputs:
** <ul>
** <li> A FILE* to which trace output should be written.
**      If NULL, then tracing is turned off.
** <li> A prefix string written at the beginning of every
**      line of trace output.  If NULL, then tracing is
**      turned off.
** </ul>
**
** Outputs:
** None.
*/
void Haanga_Trace(FILE *TraceFILE, char *zTracePrompt){
  yyTraceFILE = TraceFILE;
  yyTracePrompt = zTracePrompt;
  if( yyTraceFILE==0 ) yyTracePrompt = 0;
  else if( yyTracePrompt==0 ) yyTraceFILE = 0;
}
#endif /* NDEBUG */

#ifndef NDEBUG
/* For tracing shifts, the names of all terminals and nonterminals
** are required.  The following table supplies these names */
static const char *const yyTokenName[] = { 
  "$",             "T_OPEN_TAG",    "T_NOT",         "T_AND",       
  "T_OR",          "T_EQ",          "T_NE",          "T_GT",        
  "T_GE",          "T_LT",          "T_LE",          "T_IN",        
  "T_PLUS",        "T_MINUS",       "T_TIMES",       "T_DIV",       
  "T_MOD",         "T_HTML",        "T_COMMENT",     "T_PRINT_OPEN",
  "T_PRINT_CLOSE",  "T_EXTENDS",     "T_CLOSE_TAG",   "T_INCLUDE",   
  "T_AUTOESCAPE",  "T_CUSTOM_END",  "T_CUSTOM_TAG",  "T_AS",        
  "T_CUSTOM_BLOCK",  "T_SPACEFULL",   "T_WITH",        "T_LOAD",      
  "T_FOR",         "T_COMMA",       "T_EMPTY",       "T_IF",        
  "T_ELSE",        "T_IFCHANGED",   "T_IFEQUAL",     "T_IFNOTEQUAL",
  "T_BLOCK",       "T_NUMERIC",     "T_FILTER",      "T_REGROUP",   
  "T_BY",          "T_PIPE",        "T_COLON",       "T_TRUE",      
  "T_FALSE",       "T_STRING",      "T_INTL",        "T_RPARENT",   
  "T_LPARENT",     "T_OBJ",         "T_ALPHA",       "T_DOT",       
  "T_BRACKETS_OPEN",  "T_BRACKETS_CLOSE",  "error",         "start",       
  "body",          "code",          "stmts",         "filtered_var",
  "var_or_string",  "stmt",          "for_stmt",      "ifchanged_stmt",
  "block_stmt",    "filter_stmt",   "if_stmt",       "custom_tag",  
  "alias",         "ifequal",       "varname",       "params",      
  "regroup",       "string",        "for_def",       "expr",        
  "fvar_or_string",  "varname_args",
};
#endif /* NDEBUG */

#ifndef NDEBUG
/* For tracing reduce actions, the names of all rules are required.
*/
static const char *const yyRuleName[] = {
 /*   0 */ "start ::= body",
 /*   1 */ "body ::= body code",
 /*   2 */ "body ::=",
 /*   3 */ "code ::= T_OPEN_TAG stmts",
 /*   4 */ "code ::= T_HTML",
 /*   5 */ "code ::= T_COMMENT",
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
 /*  18 */ "stmts ::= T_AUTOESCAPE varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  19 */ "custom_tag ::= T_CUSTOM_TAG T_CLOSE_TAG",
 /*  20 */ "custom_tag ::= T_CUSTOM_TAG T_AS varname T_CLOSE_TAG",
 /*  21 */ "custom_tag ::= T_CUSTOM_TAG params T_CLOSE_TAG",
 /*  22 */ "custom_tag ::= T_CUSTOM_TAG params T_AS varname T_CLOSE_TAG",
 /*  23 */ "custom_tag ::= T_CUSTOM_BLOCK T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  24 */ "custom_tag ::= T_CUSTOM_BLOCK params T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  25 */ "custom_tag ::= T_SPACEFULL T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  26 */ "alias ::= T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  27 */ "stmt ::= regroup",
 /*  28 */ "stmt ::= T_LOAD string",
 /*  29 */ "for_def ::= T_FOR varname T_IN filtered_var T_CLOSE_TAG",
 /*  30 */ "for_def ::= T_FOR varname T_COMMA varname T_IN filtered_var T_CLOSE_TAG",
 /*  31 */ "for_stmt ::= for_def body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  32 */ "for_stmt ::= for_def body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  33 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  34 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  35 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  36 */ "ifchanged_stmt ::= T_IFCHANGED params T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  37 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  38 */ "ifchanged_stmt ::= T_IFCHANGED params T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  39 */ "ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  40 */ "ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  41 */ "ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  42 */ "ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  43 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  44 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END varname T_CLOSE_TAG",
 /*  45 */ "block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  46 */ "block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_NUMERIC T_CLOSE_TAG",
 /*  47 */ "filter_stmt ::= T_FILTER filtered_var T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  48 */ "regroup ::= T_REGROUP filtered_var T_BY varname T_AS varname",
 /*  49 */ "filtered_var ::= filtered_var T_PIPE varname_args",
 /*  50 */ "filtered_var ::= varname_args",
 /*  51 */ "varname_args ::= varname T_COLON var_or_string",
 /*  52 */ "varname_args ::= varname",
 /*  53 */ "params ::= params var_or_string",
 /*  54 */ "params ::= params T_COMMA var_or_string",
 /*  55 */ "params ::= var_or_string",
 /*  56 */ "var_or_string ::= varname",
 /*  57 */ "var_or_string ::= T_NUMERIC",
 /*  58 */ "var_or_string ::= T_TRUE|T_FALSE",
 /*  59 */ "var_or_string ::= string",
 /*  60 */ "fvar_or_string ::= filtered_var",
 /*  61 */ "fvar_or_string ::= T_NUMERIC",
 /*  62 */ "fvar_or_string ::= T_TRUE|T_FALSE",
 /*  63 */ "fvar_or_string ::= string",
 /*  64 */ "string ::= T_STRING",
 /*  65 */ "string ::= T_INTL T_STRING T_RPARENT",
 /*  66 */ "expr ::= T_NOT expr",
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
 /*  78 */ "varname ::= T_BLOCK|T_CUSTOM_TAG|T_CUSTOM_BLOCK",
};
#endif /* NDEBUG */


#if YYSTACKDEPTH<=0
/*
** Try to increase the size of the parser stack.
*/
static void yyGrowStack(yyParser *p){
  int newSize;
  yyStackEntry *pNew;

  newSize = p->yystksz*2 + 100;
  pNew = realloc(p->yystack, newSize*sizeof(pNew[0]));
  if( pNew ){
    p->yystack = pNew;
    p->yystksz = newSize;
#ifndef NDEBUG
    if( yyTraceFILE ){
      fprintf(yyTraceFILE,"%sStack grows to %d entries!\n",
              yyTracePrompt, p->yystksz);
    }
#endif
  }
}
#endif

/* 
** This function allocates a new parser.
** The only argument is a pointer to a function which works like
** malloc.
**
** Inputs:
** A pointer to the function used to allocate memory.
**
** Outputs:
** A pointer to a parser.  This pointer is used in subsequent calls
** to Haanga_ and Haanga_Free.
*/
void *Haanga_Alloc(void *(*mallocProc)(size_t)){
  yyParser *pParser;
  pParser = (yyParser*)(*mallocProc)( (size_t)sizeof(yyParser) );
  if( pParser ){
    pParser->yyidx = -1;
#ifdef YYTRACKMAXSTACKDEPTH
    pParser->yyidxMax = 0;
#endif
#if YYSTACKDEPTH<=0
    pParser->yystack = NULL;
    pParser->yystksz = 0;
    yyGrowStack(pParser);
#endif
  }
  return pParser;
}

/* The following function deletes the value associated with a
** symbol.  The symbol can be either a terminal or nonterminal.
** "yymajor" is the symbol code, and "yypminor" is a pointer to
** the value.
*/
static void yy_destructor(
  yyParser *yypParser,    /* The parser */
  YYCODETYPE yymajor,     /* Type code for object to destroy */
  YYMINORTYPE *yypminor   /* The object to be destroyed */
){
  Haanga_ARG_FETCH;
  switch( yymajor ){
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

/*
** Pop the parser's stack once.
**
** If there is a destructor routine associated with the token which
** is popped from the stack, then call it.
**
** Return the major token number for the symbol popped.
*/
static int yy_pop_parser_stack(yyParser *pParser){
  YYCODETYPE yymajor;
  yyStackEntry *yytos = &pParser->yystack[pParser->yyidx];

  if( pParser->yyidx<0 ) return 0;
#ifndef NDEBUG
  if( yyTraceFILE && pParser->yyidx>=0 ){
    fprintf(yyTraceFILE,"%sPopping %s\n",
      yyTracePrompt,
      yyTokenName[yytos->major]);
  }
#endif
  yymajor = yytos->major;
  yy_destructor(pParser, yymajor, &yytos->minor);
  pParser->yyidx--;
  return yymajor;
}

/* 
** Deallocate and destroy a parser.  Destructors are all called for
** all stack elements before shutting the parser down.
**
** Inputs:
** <ul>
** <li>  A pointer to the parser.  This should be a pointer
**       obtained from Haanga_Alloc.
** <li>  A pointer to a function used to reclaim memory obtained
**       from malloc.
** </ul>
*/
void Haanga_Free(
  void *p,                    /* The parser to be deleted */
  void (*freeProc)(void*)     /* Function used to reclaim memory */
){
  yyParser *pParser = (yyParser*)p;
  if( pParser==0 ) return;
  while( pParser->yyidx>=0 ) yy_pop_parser_stack(pParser);
#if YYSTACKDEPTH<=0
  free(pParser->yystack);
#endif
  (*freeProc)((void*)pParser);
}

/*
** Return the peak depth of the stack for a parser.
*/
#ifdef YYTRACKMAXSTACKDEPTH
int Haanga_StackPeak(void *p){
  yyParser *pParser = (yyParser*)p;
  return pParser->yyidxMax;
}
#endif

/*
** Find the appropriate action for a parser given the terminal
** look-ahead token iLookAhead.
**
** If the look-ahead token is YYNOCODE, then check to see if the action is
** independent of the look-ahead.  If it is, return the action, otherwise
** return YY_NO_ACTION.
*/
static int yy_find_shift_action(
  yyParser *pParser,        /* The parser */
  YYCODETYPE iLookAhead     /* The look-ahead token */
){
  int i;
  int stateno = pParser->yystack[pParser->yyidx].stateno;
 
  if( stateno>YY_SHIFT_MAX || (i = yy_shift_ofst[stateno])==YY_SHIFT_USE_DFLT ){
    return yy_default[stateno];
  }
  assert( iLookAhead!=YYNOCODE );
  i += iLookAhead;
  if( i<0 || i>=YY_SZ_ACTTAB || yy_lookahead[i]!=iLookAhead ){
    if( iLookAhead>0 ){
#ifdef YYFALLBACK
      YYCODETYPE iFallback;            /* Fallback token */
      if( iLookAhead<sizeof(yyFallback)/sizeof(yyFallback[0])
             && (iFallback = yyFallback[iLookAhead])!=0 ){
#ifndef NDEBUG
        if( yyTraceFILE ){
          fprintf(yyTraceFILE, "%sFALLBACK %s => %s\n",
             yyTracePrompt, yyTokenName[iLookAhead], yyTokenName[iFallback]);
        }
#endif
        return yy_find_shift_action(pParser, iFallback);
      }
#endif
#ifdef YYWILDCARD
      {
        int j = i - iLookAhead + YYWILDCARD;
        if( j>=0 && j<YY_SZ_ACTTAB && yy_lookahead[j]==YYWILDCARD ){
#ifndef NDEBUG
          if( yyTraceFILE ){
            fprintf(yyTraceFILE, "%sWILDCARD %s => %s\n",
               yyTracePrompt, yyTokenName[iLookAhead], yyTokenName[YYWILDCARD]);
          }
#endif /* NDEBUG */
          return yy_action[j];
        }
      }
#endif /* YYWILDCARD */
    }
    return yy_default[stateno];
  }else{
    return yy_action[i];
  }
}

/*
** Find the appropriate action for a parser given the non-terminal
** look-ahead token iLookAhead.
**
** If the look-ahead token is YYNOCODE, then check to see if the action is
** independent of the look-ahead.  If it is, return the action, otherwise
** return YY_NO_ACTION.
*/
static int yy_find_reduce_action(
  int stateno,              /* Current state number */
  YYCODETYPE iLookAhead     /* The look-ahead token */
){
  int i;
#ifdef YYERRORSYMBOL
  if( stateno>YY_REDUCE_MAX ){
    return yy_default[stateno];
  }
#else
  assert( stateno<=YY_REDUCE_MAX );
#endif
  i = yy_reduce_ofst[stateno];
  assert( i!=YY_REDUCE_USE_DFLT );
  assert( iLookAhead!=YYNOCODE );
  i += iLookAhead;
#ifdef YYERRORSYMBOL
  if( i<0 || i>=YY_SZ_ACTTAB || yy_lookahead[i]!=iLookAhead ){
    return yy_default[stateno];
  }
#else
  assert( i>=0 && i<YY_SZ_ACTTAB );
  assert( yy_lookahead[i]==iLookAhead );
#endif
  return yy_action[i];
}

/*
** The following routine is called if the stack overflows.
*/
static void yyStackOverflow(yyParser *yypParser, YYMINORTYPE *yypMinor){
   Haanga_ARG_FETCH;
   yypParser->yyidx--;
#ifndef NDEBUG
   if( yyTraceFILE ){
     fprintf(yyTraceFILE,"%sStack Overflow!\n",yyTracePrompt);
   }
#endif
   while( yypParser->yyidx>=0 ) yy_pop_parser_stack(yypParser);
   /* Here code is inserted which will execute if the parser
   ** stack every overflows */
   Haanga_ARG_STORE; /* Suppress warning about unused %extra_argument var */
}

/*
** Perform a shift action.
*/
static void yy_shift(
  yyParser *yypParser,          /* The parser to be shifted */
  int yyNewState,               /* The new state to shift in */
  int yyMajor,                  /* The major token to shift in */
  YYMINORTYPE *yypMinor         /* Pointer to the minor token to shift in */
){
  yyStackEntry *yytos;
  yypParser->yyidx++;
#ifdef YYTRACKMAXSTACKDEPTH
  if( yypParser->yyidx>yypParser->yyidxMax ){
    yypParser->yyidxMax = yypParser->yyidx;
  }
#endif
#if YYSTACKDEPTH>0 
  if( yypParser->yyidx>=YYSTACKDEPTH ){
    yyStackOverflow(yypParser, yypMinor);
    return;
  }
#else
  if( yypParser->yyidx>=yypParser->yystksz ){
    yyGrowStack(yypParser);
    if( yypParser->yyidx>=yypParser->yystksz ){
      yyStackOverflow(yypParser, yypMinor);
      return;
    }
  }
#endif
  yytos = &yypParser->yystack[yypParser->yyidx];
  yytos->stateno = (YYACTIONTYPE)yyNewState;
  yytos->major = (YYCODETYPE)yyMajor;
  yytos->minor = *yypMinor;
#ifndef NDEBUG
  if( yyTraceFILE && yypParser->yyidx>0 ){
    int i;
    fprintf(yyTraceFILE,"%sShift %d\n",yyTracePrompt,yyNewState);
    fprintf(yyTraceFILE,"%sStack:",yyTracePrompt);
    for(i=1; i<=yypParser->yyidx; i++)
      fprintf(yyTraceFILE," %s",yyTokenName[yypParser->yystack[i].major]);
    fprintf(yyTraceFILE,"\n");
  }
#endif
}

/* The following table contains information about every rule that
** is used during the reduce.
*/
static const struct {
  YYCODETYPE lhs;         /* Symbol on the left-hand side of the rule */
  unsigned char nrhs;     /* Number of right-hand side symbols in the rule */
} yyRuleInfo[] = {
  { 59, 1 },
  { 60, 2 },
  { 60, 0 },
  { 61, 2 },
  { 61, 1 },
  { 61, 1 },
  { 61, 3 },
  { 62, 3 },
  { 62, 2 },
  { 62, 1 },
  { 62, 1 },
  { 62, 1 },
  { 62, 1 },
  { 62, 1 },
  { 62, 3 },
  { 62, 1 },
  { 62, 1 },
  { 62, 1 },
  { 62, 7 },
  { 71, 2 },
  { 71, 4 },
  { 71, 3 },
  { 71, 5 },
  { 71, 6 },
  { 71, 7 },
  { 71, 6 },
  { 72, 9 },
  { 65, 1 },
  { 65, 2 },
  { 78, 5 },
  { 78, 7 },
  { 66, 5 },
  { 66, 9 },
  { 70, 7 },
  { 70, 11 },
  { 67, 6 },
  { 67, 7 },
  { 67, 10 },
  { 67, 11 },
  { 73, 8 },
  { 73, 12 },
  { 73, 8 },
  { 73, 12 },
  { 68, 7 },
  { 68, 8 },
  { 68, 7 },
  { 68, 8 },
  { 69, 7 },
  { 76, 6 },
  { 63, 3 },
  { 63, 1 },
  { 81, 3 },
  { 81, 1 },
  { 75, 2 },
  { 75, 3 },
  { 75, 1 },
  { 64, 1 },
  { 64, 1 },
  { 64, 1 },
  { 64, 1 },
  { 80, 1 },
  { 80, 1 },
  { 80, 1 },
  { 80, 1 },
  { 77, 1 },
  { 77, 3 },
  { 79, 2 },
  { 79, 3 },
  { 79, 3 },
  { 79, 3 },
  { 79, 3 },
  { 79, 3 },
  { 79, 3 },
  { 79, 1 },
  { 74, 3 },
  { 74, 3 },
  { 74, 4 },
  { 74, 1 },
  { 74, 1 },
};

static void yy_accept(yyParser*);  /* Forward Declaration */

/*
** Perform a reduce action and the shift that must immediately
** follow the reduce.
*/
static void yy_reduce(
  yyParser *yypParser,         /* The parser */
  int yyruleno                 /* Number of the rule by which to reduce */
){
  int yygoto;                     /* The next state */
  int yyact;                      /* The next action */
  YYMINORTYPE yygotominor;        /* The LHS of the rule reduced */
  yyStackEntry *yymsp;            /* The top of the parser's stack */
  int yysize;                     /* Amount to pop the stack */
  Haanga_ARG_FETCH;
  yymsp = &yypParser->yystack[yypParser->yyidx];
#ifndef NDEBUG
  if( yyTraceFILE && yyruleno>=0 
        && yyruleno<(int)(sizeof(yyRuleName)/sizeof(yyRuleName[0])) ){
    fprintf(yyTraceFILE, "%sReduce [%s].\n", yyTracePrompt,
      yyRuleName[yyruleno]);
  }
#endif /* NDEBUG */

  /* Silence complaints from purify about yygotominor being uninitialized
  ** in some cases when it is copied into the stack after the following
  ** switch.  yygotominor is uninitialized when a rule reduces that does
  ** not set the value of its left-hand side nonterminal.  Leaving the
  ** value of the nonterminal uninitialized is utterly harmless as long
  ** as the value is never used.  So really the only thing this code
  ** accomplishes is to quieten purify.  
  **
  ** 2007-01-16:  The wireshark project (www.wireshark.org) reports that
  ** without this code, their parser segfaults.  I'm not sure what there
  ** parser is doing to make this happen.  This is the second bug report
  ** from wireshark this week.  Clearly they are stressing Lemon in ways
  ** that it has not been previously stressed...  (SQLite ticket #2172)
  */
  /*memset(&yygotominor, 0, sizeof(yygotominor));*/
  yygotominor = yyzerominor;


  switch( yyruleno ){
  /* Beginning here are the reduction cases.  A typical example
  ** follows:
  **   case 0:
  **  #line <lineno> <grammarfile>
  **     { ... }           // User supplied code
  **  #line <lineno> <thisfile>
  **     break;
  */
      case 0: /* start ::= body */
#line 63 "parser.y"
{ $this->body = yymsp[0].minor.yy0; }
#line 1099 "parser.c"
        break;
      case 1: /* body ::= body code */
#line 65 "parser.y"
{ yygotominor.yy0=yymsp[-1].minor.yy0; yygotominor.yy0[] = yymsp[0].minor.yy0; }
#line 1104 "parser.c"
        break;
      case 2: /* body ::= */
#line 66 "parser.y"
{ yygotominor.yy0 = array(); }
#line 1109 "parser.c"
        break;
      case 3: /* code ::= T_OPEN_TAG stmts */
#line 69 "parser.y"
{ if (count(yymsp[0].minor.yy0)) yymsp[0].minor.yy0['line'] = $this->lex->getLine();  yygotominor.yy0 = yymsp[0].minor.yy0; }
#line 1114 "parser.c"
        break;
      case 4: /* code ::= T_HTML */
#line 70 "parser.y"
{
    yygotominor.yy0 = array('operation' => 'html', 'html' => yymsp[0].minor.yy0, 'line' => $this->lex->getLine() ); 
}
#line 1121 "parser.c"
        break;
      case 5: /* code ::= T_COMMENT */
#line 73 "parser.y"
{
    yymsp[0].minor.yy0=rtrim(yymsp[0].minor.yy0); yygotominor.yy0 = array('operation' => 'comment', 'comment' => yymsp[0].minor.yy0); 
}
#line 1128 "parser.c"
        break;
      case 6: /* code ::= T_PRINT_OPEN filtered_var T_PRINT_CLOSE */
#line 76 "parser.y"
{
    yygotominor.yy0 = array('operation' => 'print_var', 'variable' => yymsp[-1].minor.yy0, 'line' => $this->lex->getLine() ); 
}
#line 1135 "parser.c"
        break;
      case 7: /* stmts ::= T_EXTENDS var_or_string T_CLOSE_TAG */
#line 80 "parser.y"
{ yygotominor.yy0 = array('operation' => 'base', yymsp[-1].minor.yy0); }
#line 1140 "parser.c"
        break;
      case 8: /* stmts ::= stmt T_CLOSE_TAG */
      case 65: /* string ::= T_INTL T_STRING T_RPARENT */ yytestcase(yyruleno==65);
#line 81 "parser.y"
{ yygotominor.yy0 = yymsp[-1].minor.yy0; }
#line 1146 "parser.c"
        break;
      case 9: /* stmts ::= for_stmt */
      case 10: /* stmts ::= ifchanged_stmt */ yytestcase(yyruleno==10);
      case 11: /* stmts ::= block_stmt */ yytestcase(yyruleno==11);
      case 12: /* stmts ::= filter_stmt */ yytestcase(yyruleno==12);
      case 13: /* stmts ::= if_stmt */ yytestcase(yyruleno==13);
      case 15: /* stmts ::= custom_tag */ yytestcase(yyruleno==15);
      case 16: /* stmts ::= alias */ yytestcase(yyruleno==16);
      case 17: /* stmts ::= ifequal */ yytestcase(yyruleno==17);
      case 27: /* stmt ::= regroup */ yytestcase(yyruleno==27);
      case 52: /* varname_args ::= varname */ yytestcase(yyruleno==52);
      case 64: /* string ::= T_STRING */ yytestcase(yyruleno==64);
      case 73: /* expr ::= fvar_or_string */ yytestcase(yyruleno==73);
      case 77: /* varname ::= T_ALPHA */ yytestcase(yyruleno==77);
      case 78: /* varname ::= T_BLOCK|T_CUSTOM_TAG|T_CUSTOM_BLOCK */ yytestcase(yyruleno==78);
#line 82 "parser.y"
{ yygotominor.yy0 = yymsp[0].minor.yy0; }
#line 1164 "parser.c"
        break;
      case 14: /* stmts ::= T_INCLUDE var_or_string T_CLOSE_TAG */
#line 87 "parser.y"
{ yygotominor.yy0 = array('operation' => 'include', yymsp[-1].minor.yy0); }
#line 1169 "parser.c"
        break;
      case 18: /* stmts ::= T_AUTOESCAPE varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 91 "parser.y"
{ 
    yymsp[-5].minor.yy0 = strtolower(yymsp[-5].minor.yy0);
    if (yymsp[-5].minor.yy0 != 'on' && yymsp[-5].minor.yy0 != 'off') {
        $this->Error("Invalid autoescape param (".yymsp[-5].minor.yy0."), it must be on or off");
    }
    if (yymsp[-1].minor.yy0 != "endautoescape") {
        $this->Error("Invalid close tag ".yymsp[-1].minor.yy0.", it must be endautoescape");
    }
    yygotominor.yy0 = array('operation' => 'autoescape', 'value' => yymsp[-5].minor.yy0, 'body' => yymsp[-3].minor.yy0); 
}
#line 1183 "parser.c"
        break;
      case 19: /* custom_tag ::= T_CUSTOM_TAG T_CLOSE_TAG */
#line 105 "parser.y"
{
    yygotominor.yy0 = array('operation' => 'custom_tag', 'name' => yymsp[-1].minor.yy0, 'list'=>array()); 
}
#line 1190 "parser.c"
        break;
      case 20: /* custom_tag ::= T_CUSTOM_TAG T_AS varname T_CLOSE_TAG */
#line 108 "parser.y"
{
    yygotominor.yy0 = array('operation' => 'custom_tag', 'name' => yymsp[-3].minor.yy0, 'as' => yymsp[-1].minor.yy0, 'list'=>array()); 
}
#line 1197 "parser.c"
        break;
      case 21: /* custom_tag ::= T_CUSTOM_TAG params T_CLOSE_TAG */
#line 111 "parser.y"
{ 
    yygotominor.yy0 = array('operation' => 'custom_tag', 'name' => yymsp[-2].minor.yy0, 'list' => yymsp[-1].minor.yy0); 
}
#line 1204 "parser.c"
        break;
      case 22: /* custom_tag ::= T_CUSTOM_TAG params T_AS varname T_CLOSE_TAG */
#line 114 "parser.y"
{
    yygotominor.yy0 = array('operation' => 'custom_tag', 'name' => yymsp[-4].minor.yy0, 'as' => yymsp[-1].minor.yy0, 'list' => yymsp[-3].minor.yy0);
}
#line 1211 "parser.c"
        break;
      case 23: /* custom_tag ::= T_CUSTOM_BLOCK T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 119 "parser.y"
{
    if ('end'.yymsp[-5].minor.yy0 != yymsp[-1].minor.yy0) { 
        $this->error("Unexpected ".yymsp[-1].minor.yy0); 
    } 
    yygotominor.yy0 = array('operation' => 'custom_tag', 'name' => yymsp[-5].minor.yy0, 'body' => yymsp[-3].minor.yy0, 'list' => array());
}
#line 1221 "parser.c"
        break;
      case 24: /* custom_tag ::= T_CUSTOM_BLOCK params T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 125 "parser.y"
{
    if ('end'.yymsp[-6].minor.yy0 != yymsp[-1].minor.yy0) { 
        $this->error("Unexpected ".yymsp[-1].minor.yy0); 
    } 
    yygotominor.yy0 = array('operation' => 'custom_tag', 'name' => yymsp[-6].minor.yy0, 'body' => yymsp[-3].minor.yy0, 'list' => yymsp[-5].minor.yy0);
}
#line 1231 "parser.c"
        break;
      case 25: /* custom_tag ::= T_SPACEFULL T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 133 "parser.y"
{
    if ('endspacefull' != yymsp[-1].minor.yy0) {
        $this->error("Unexpected ".yymsp[-1].minor.yy0);
    } 
    yygotominor.yy0 = array('operation' => 'spacefull', 'body' => yymsp[-3].minor.yy0);
}
#line 1241 "parser.c"
        break;
      case 26: /* alias ::= T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 141 "parser.y"
{
    if (yymsp[-1].minor.yy0 != "endwith") {
        $this->Error("Unexpected ".yymsp[-1].minor.yy0.", expecting endwith");
    }
    yygotominor.yy0 = array('operation' => 'alias', 'var' => yymsp[-7].minor.yy0, 'as' => yymsp[-5].minor.yy0, 'body' => yymsp[-3].minor.yy0); 
}
#line 1251 "parser.c"
        break;
      case 28: /* stmt ::= T_LOAD string */
#line 150 "parser.y"
{
    if (!is_file(yymsp[0].minor.yy0) || !Haanga_Compiler::getOption('enable_load')) {
        $this->error(yymsp[0].minor.yy0." is not a valid file"); 
    } 
    require_once yymsp[0].minor.yy0;
}
#line 1261 "parser.c"
        break;
      case 29: /* for_def ::= T_FOR varname T_IN filtered_var T_CLOSE_TAG */
#line 158 "parser.y"
{
    /* Try to get the variable */
    $var = $this->compiler->get_context(is_array(yymsp[-1].minor.yy0[0]) ? yymsp[-1].minor.yy0[0] : array(yymsp[-1].minor.yy0[0]));
    if (is_array($var)) {
        /* let's check if it is an object or array */
        $this->compiler->set_context(yymsp[-3].minor.yy0, current($var));
    }

    yygotominor.yy0 = array('operation' => 'loop', 'variable' => yymsp[-3].minor.yy0, 'index' => NULL, 'array' => yymsp[-1].minor.yy0);
}
#line 1275 "parser.c"
        break;
      case 30: /* for_def ::= T_FOR varname T_COMMA varname T_IN filtered_var T_CLOSE_TAG */
#line 169 "parser.y"
{
    /* Try to get the variable */
    $var = $this->compiler->get_context(is_array(yymsp[-1].minor.yy0[0]) ? yymsp[-1].minor.yy0[0] : array(yymsp[-1].minor.yy0[0]));
    if (is_array($var)) {
        /* let's check if it is an object or array */
        $this->compiler->set_context(yymsp[-3].minor.yy0, current($var));
    }
    yygotominor.yy0 = array('operation' => 'loop', 'variable' => yymsp[-3].minor.yy0, 'index' => yymsp[-5].minor.yy0, 'array' => yymsp[-1].minor.yy0);
}
#line 1288 "parser.c"
        break;
      case 31: /* for_stmt ::= for_def body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 180 "parser.y"
{ 
    if (yymsp[-1].minor.yy0 != "endfor") {
        $this->Error("Unexpected ".yymsp[-1].minor.yy0.", expecting endfor");
    }
    yygotominor.yy0 = yymsp[-4].minor.yy0;
    yygotominor.yy0['body'] = yymsp[-3].minor.yy0;
}
#line 1299 "parser.c"
        break;
      case 32: /* for_stmt ::= for_def body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 188 "parser.y"
{ 
    if (yymsp[-1].minor.yy0 != "endfor") {
        $this->Error("Unexpected ".yymsp[-1].minor.yy0.", expecting endfor");
    }
    yygotominor.yy0 = yymsp[-8].minor.yy0;
    yygotominor.yy0['body']  = yymsp[-7].minor.yy0;
    yygotominor.yy0['empty'] = yymsp[-3].minor.yy0;
}
#line 1311 "parser.c"
        break;
      case 33: /* if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 197 "parser.y"
{
    if (yymsp[-1].minor.yy0 != "endif") {
        $this->Error("Unexpected ".yymsp[-1].minor.yy0.", expecting endif");
    }
    yygotominor.yy0 = array('operation' => 'if', 'expr' => yymsp[-5].minor.yy0, 'body' => yymsp[-3].minor.yy0);
}
#line 1321 "parser.c"
        break;
      case 34: /* if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 203 "parser.y"
{
    if (yymsp[-1].minor.yy0 != "endif") {
        $this->Error("Unexpected ".yymsp[-1].minor.yy0.", expecting endif");
    }
    yygotominor.yy0 = array('operation' => 'if', 'expr' => yymsp[-9].minor.yy0, 'body' => yymsp[-7].minor.yy0, 'else' => yymsp[-3].minor.yy0);
}
#line 1331 "parser.c"
        break;
      case 35: /* ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 211 "parser.y"
{ 
    if (yymsp[-1].minor.yy0 != "endifchanged") {
        $this->Error("Unexpected ".yymsp[-1].minor.yy0.", expecting endifchanged");
    }
    yygotominor.yy0 = array('operation' => 'ifchanged', 'body' => yymsp[-3].minor.yy0); 
}
#line 1341 "parser.c"
        break;
      case 36: /* ifchanged_stmt ::= T_IFCHANGED params T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 218 "parser.y"
{ 
    if (yymsp[-1].minor.yy0 != "endifchanged") {
        $this->Error("Unexpected ".yymsp[-1].minor.yy0.", expecting endifchanged");
    }
    yygotominor.yy0 = array('operation' => 'ifchanged', 'body' => yymsp[-3].minor.yy0, 'check' => yymsp[-5].minor.yy0);
}
#line 1351 "parser.c"
        break;
      case 37: /* ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 224 "parser.y"
{ 
    if (yymsp[-1].minor.yy0 != "endifchanged") {
        $this->Error("Unexpected ".yymsp[-1].minor.yy0.", expecting endifchanged");
    }
    yygotominor.yy0 = array('operation' => 'ifchanged', 'body' => yymsp[-7].minor.yy0, 'else' => yymsp[-3].minor.yy0); 
}
#line 1361 "parser.c"
        break;
      case 38: /* ifchanged_stmt ::= T_IFCHANGED params T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 231 "parser.y"
{ 
    if (yymsp[-1].minor.yy0 != "endifchanged") {
        $this->Error("Unexpected ".yymsp[-1].minor.yy0.", expecting endifchanged");
    }
    yygotominor.yy0 = array('operation' => 'ifchanged', 'body' => yymsp[-7].minor.yy0, 'check' => yymsp[-9].minor.yy0, 'else' => yymsp[-3].minor.yy0);
}
#line 1371 "parser.c"
        break;
      case 39: /* ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 239 "parser.y"
{
    if (yymsp[-1].minor.yy0 != "endifequal") {
        $this->Error("Unexpected ".yymsp[-1].minor.yy0.", expecting endifequal");
    }
    yygotominor.yy0 = array('operation' => 'ifequal', 'cmp' => '==', 1 => yymsp[-6].minor.yy0, 2 => yymsp[-5].minor.yy0, 'body' => yymsp[-3].minor.yy0); 
}
#line 1381 "parser.c"
        break;
      case 40: /* ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 245 "parser.y"
{
    if (yymsp[-1].minor.yy0 != "endifequal") {
        $this->Error("Unexpected ".yymsp[-1].minor.yy0.", expecting endifequal");
    }
    yygotominor.yy0 = array('operation' => 'ifequal', 'cmp' => '==', 1 => yymsp[-10].minor.yy0, 2 => yymsp[-9].minor.yy0, 'body' => yymsp[-7].minor.yy0, 'else' => yymsp[-3].minor.yy0); 
}
#line 1391 "parser.c"
        break;
      case 41: /* ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 251 "parser.y"
{
    if (yymsp[-1].minor.yy0 != "endifnotequal") {
        $this->Error("Unexpected ".yymsp[-1].minor.yy0.", expecting endifnotequal");
    }
    yygotominor.yy0 = array('operation' => 'ifequal', 'cmp' => '!=', 1 => yymsp[-6].minor.yy0, 2 => yymsp[-5].minor.yy0, 'body' => yymsp[-3].minor.yy0);
}
#line 1401 "parser.c"
        break;
      case 42: /* ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 257 "parser.y"
{
    if (yymsp[-1].minor.yy0 != "endifnotequal") {
        $this->Error("Unexpected ".yymsp[-1].minor.yy0.", expecting endifnotequal");
    }
    yygotominor.yy0 = array('operation' => 'ifequal', 'cmp' => '!=', 1 => yymsp[-10].minor.yy0, 2 => yymsp[-9].minor.yy0, 'body' => yymsp[-7].minor.yy0, 'else' => yymsp[-3].minor.yy0); 
}
#line 1411 "parser.c"
        break;
      case 43: /* block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 265 "parser.y"
{ 
    if (yymsp[-1].minor.yy0 != "endblock") {
        $this->Error("Unexpected ".yymsp[-1].minor.yy0.", expecting endblock");
    }
    yygotominor.yy0 = array('operation' => 'block', 'name' => yymsp[-5].minor.yy0, 'body' => yymsp[-3].minor.yy0); 
}
#line 1421 "parser.c"
        break;
      case 44: /* block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END varname T_CLOSE_TAG */
      case 46: /* block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_NUMERIC T_CLOSE_TAG */ yytestcase(yyruleno==46);
#line 272 "parser.y"
{
    if (yymsp[-2].minor.yy0 != "endblock") {
        $this->Error("Unexpected ".yymsp[-2].minor.yy0.", expecting endblock");
    }
    yygotominor.yy0 = array('operation' => 'block', 'name' => yymsp[-6].minor.yy0, 'body' => yymsp[-4].minor.yy0); 
}
#line 1432 "parser.c"
        break;
      case 45: /* block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 279 "parser.y"
{
    if (yymsp[-1].minor.yy0 != "endblock") {
        $this->Error("Unexpected ".yymsp[-1].minor.yy0.", expecting endblock");
    }
    yygotominor.yy0 = array('operation' => 'block', 'name' => yymsp[-5].minor.yy0, 'body' => yymsp[-3].minor.yy0); 
}
#line 1442 "parser.c"
        break;
      case 47: /* filter_stmt ::= T_FILTER filtered_var T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG */
#line 294 "parser.y"
{
    if (yymsp[-1].minor.yy0 != "endfilter") {
        $this->Error("Unexpected ".yymsp[-1].minor.yy0.", expecting endfilter");
    }
    yygotominor.yy0 = array('operation' => 'filter', 'functions' => yymsp[-5].minor.yy0, 'body' => yymsp[-3].minor.yy0);
}
#line 1452 "parser.c"
        break;
      case 48: /* regroup ::= T_REGROUP filtered_var T_BY varname T_AS varname */
#line 302 "parser.y"
{ yygotominor.yy0=array('operation' => 'regroup', 'array' => yymsp[-4].minor.yy0, 'row' => yymsp[-2].minor.yy0, 'as' => yymsp[0].minor.yy0); }
#line 1457 "parser.c"
        break;
      case 49: /* filtered_var ::= filtered_var T_PIPE varname_args */
      case 54: /* params ::= params T_COMMA var_or_string */ yytestcase(yyruleno==54);
#line 305 "parser.y"
{ yygotominor.yy0 = yymsp[-2].minor.yy0; yygotominor.yy0[] = yymsp[0].minor.yy0; }
#line 1463 "parser.c"
        break;
      case 50: /* filtered_var ::= varname_args */
      case 55: /* params ::= var_or_string */ yytestcase(yyruleno==55);
#line 306 "parser.y"
{ yygotominor.yy0 = array(yymsp[0].minor.yy0); }
#line 1469 "parser.c"
        break;
      case 51: /* varname_args ::= varname T_COLON var_or_string */
#line 308 "parser.y"
{ yygotominor.yy0 = array(yymsp[-2].minor.yy0, 'args'=>array(yymsp[0].minor.yy0)); }
#line 1474 "parser.c"
        break;
      case 53: /* params ::= params var_or_string */
#line 312 "parser.y"
{ yygotominor.yy0 = yymsp[-1].minor.yy0; yygotominor.yy0[] = yymsp[0].minor.yy0; }
#line 1479 "parser.c"
        break;
      case 56: /* var_or_string ::= varname */
#line 318 "parser.y"
{ yygotominor.yy0 = array('var' => yymsp[0].minor.yy0); }
#line 1484 "parser.c"
        break;
      case 57: /* var_or_string ::= T_NUMERIC */
      case 61: /* fvar_or_string ::= T_NUMERIC */ yytestcase(yyruleno==61);
#line 319 "parser.y"
{ yygotominor.yy0 = array('number' => yymsp[0].minor.yy0); }
#line 1490 "parser.c"
        break;
      case 58: /* var_or_string ::= T_TRUE|T_FALSE */
      case 62: /* fvar_or_string ::= T_TRUE|T_FALSE */ yytestcase(yyruleno==62);
#line 320 "parser.y"
{ yygotominor.yy0 = trim(yymsp[0].major); }
#line 1496 "parser.c"
        break;
      case 59: /* var_or_string ::= string */
      case 63: /* fvar_or_string ::= string */ yytestcase(yyruleno==63);
#line 321 "parser.y"
{ yygotominor.yy0 = array('string' => yymsp[0].minor.yy0); }
#line 1502 "parser.c"
        break;
      case 60: /* fvar_or_string ::= filtered_var */
#line 324 "parser.y"
{ yygotominor.yy0 = array('var_filter' => yymsp[0].minor.yy0); }
#line 1507 "parser.c"
        break;
      case 66: /* expr ::= T_NOT expr */
#line 334 "parser.y"
{ yygotominor.yy0 = array('op_expr' => 'not', yymsp[0].minor.yy0); }
#line 1512 "parser.c"
        break;
      case 67: /* expr ::= expr T_AND expr */
      case 68: /* expr ::= expr T_OR expr */ yytestcase(yyruleno==68);
      case 69: /* expr ::= expr T_PLUS|T_MINUS expr */ yytestcase(yyruleno==69);
      case 71: /* expr ::= expr T_TIMES|T_DIV|T_MOD expr */ yytestcase(yyruleno==71);
#line 335 "parser.y"
{ yygotominor.yy0 = array('op_expr' => yymsp[-1].major, yymsp[-2].minor.yy0, yymsp[0].minor.yy0); }
#line 1520 "parser.c"
        break;
      case 70: /* expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN expr */
#line 338 "parser.y"
{ yygotominor.yy0 = array('op_expr' => trim(yymsp[-1].major), yymsp[-2].minor.yy0, yymsp[0].minor.yy0); }
#line 1525 "parser.c"
        break;
      case 72: /* expr ::= T_LPARENT expr T_RPARENT */
#line 340 "parser.y"
{ yygotominor.yy0 = array('op_expr' => 'expr', yymsp[-1].minor.yy0); }
#line 1530 "parser.c"
        break;
      case 74: /* varname ::= varname T_OBJ T_ALPHA */
#line 344 "parser.y"
{ if (!is_array(yymsp[-2].minor.yy0)) { yygotominor.yy0 = array(yymsp[-2].minor.yy0); } else { yygotominor.yy0 = yymsp[-2].minor.yy0; }  yygotominor.yy0[]=array('object' => yymsp[0].minor.yy0);}
#line 1535 "parser.c"
        break;
      case 75: /* varname ::= varname T_DOT T_ALPHA */
#line 345 "parser.y"
{ if (!is_array(yymsp[-2].minor.yy0)) { yygotominor.yy0 = array(yymsp[-2].minor.yy0); } else { yygotominor.yy0 = yymsp[-2].minor.yy0; } yygotominor.yy0[] = ($this->compiler->var_is_object(yygotominor.yy0)) ? array('object' => yymsp[0].minor.yy0) : yymsp[0].minor.yy0;}
#line 1540 "parser.c"
        break;
      case 76: /* varname ::= varname T_BRACKETS_OPEN var_or_string T_BRACKETS_CLOSE */
#line 346 "parser.y"
{ if (!is_array(yymsp[-3].minor.yy0)) { yygotominor.yy0 = array(yymsp[-3].minor.yy0); } else { yygotominor.yy0 = yymsp[-3].minor.yy0; }  yygotominor.yy0[]=yymsp[-1].minor.yy0;}
#line 1545 "parser.c"
        break;
      default:
        break;
  };
  yygoto = yyRuleInfo[yyruleno].lhs;
  yysize = yyRuleInfo[yyruleno].nrhs;
  yypParser->yyidx -= yysize;
  yyact = yy_find_reduce_action(yymsp[-yysize].stateno,(YYCODETYPE)yygoto);
  if( yyact < YYNSTATE ){
#ifdef NDEBUG
    /* If we are not debugging and the reduce action popped at least
    ** one element off the stack, then we can push the new element back
    ** onto the stack here, and skip the stack overflow test in yy_shift().
    ** That gives a significant speed improvement. */
    if( yysize ){
      yypParser->yyidx++;
      yymsp -= yysize-1;
      yymsp->stateno = (YYACTIONTYPE)yyact;
      yymsp->major = (YYCODETYPE)yygoto;
      yymsp->minor = yygotominor;
    }else
#endif
    {
      yy_shift(yypParser,yyact,yygoto,&yygotominor);
    }
  }else{
    assert( yyact == YYNSTATE + YYNRULE + 1 );
    yy_accept(yypParser);
  }
}

/*
** The following code executes when the parse fails
*/
#ifndef YYNOERRORRECOVERY
static void yy_parse_failed(
  yyParser *yypParser           /* The parser */
){
  Haanga_ARG_FETCH;
#ifndef NDEBUG
  if( yyTraceFILE ){
    fprintf(yyTraceFILE,"%sFail!\n",yyTracePrompt);
  }
#endif
  while( yypParser->yyidx>=0 ) yy_pop_parser_stack(yypParser);
  /* Here code is inserted which will be executed whenever the
  ** parser fails */
  Haanga_ARG_STORE; /* Suppress warning about unused %extra_argument variable */
}
#endif /* YYNOERRORRECOVERY */

/*
** The following code executes when a syntax error first occurs.
*/
static void yy_syntax_error(
  yyParser *yypParser,           /* The parser */
  int yymajor,                   /* The major type of the error token */
  YYMINORTYPE yyminor            /* The minor type of the error token */
){
  Haanga_ARG_FETCH;
#define TOKEN (yyminor.yy0)
#line 54 "parser.y"

    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    $this->Error('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
#line 1614 "parser.c"
  Haanga_ARG_STORE; /* Suppress warning about unused %extra_argument variable */
}

/*
** The following is executed when the parser accepts
*/
static void yy_accept(
  yyParser *yypParser           /* The parser */
){
  Haanga_ARG_FETCH;
#ifndef NDEBUG
  if( yyTraceFILE ){
    fprintf(yyTraceFILE,"%sAccept!\n",yyTracePrompt);
  }
#endif
  while( yypParser->yyidx>=0 ) yy_pop_parser_stack(yypParser);
  /* Here code is inserted which will be executed whenever the
  ** parser accepts */
#line 41 "parser.y"

#line 1635 "parser.c"
  Haanga_ARG_STORE; /* Suppress warning about unused %extra_argument variable */
}

/* The main parser program.
** The first argument is a pointer to a structure obtained from
** "Haanga_Alloc" which describes the current state of the parser.
** The second argument is the major token number.  The third is
** the minor token.  The fourth optional argument is whatever the
** user wants (and specified in the grammar) and is available for
** use by the action routines.
**
** Inputs:
** <ul>
** <li> A pointer to the parser (an opaque structure.)
** <li> The major token number.
** <li> The minor token number.
** <li> An option argument of a grammar-specified type.
** </ul>
**
** Outputs:
** None.
*/
void Haanga_(
  void *yyp,                   /* The parser */
  int yymajor,                 /* The major token code number */
  Haanga_TOKENTYPE yyminor       /* The value for the token */
  Haanga_ARG_PDECL               /* Optional %extra_argument parameter */
){
  YYMINORTYPE yyminorunion;
  int yyact;            /* The parser action. */
  int yyendofinput;     /* True if we are at the end of input */
#ifdef YYERRORSYMBOL
  int yyerrorhit = 0;   /* True if yymajor has invoked an error */
#endif
  yyParser *yypParser;  /* The parser */

  /* (re)initialize the parser, if necessary */
  yypParser = (yyParser*)yyp;
  if( yypParser->yyidx<0 ){
#if YYSTACKDEPTH<=0
    if( yypParser->yystksz <=0 ){
      /*memset(&yyminorunion, 0, sizeof(yyminorunion));*/
      yyminorunion = yyzerominor;
      yyStackOverflow(yypParser, &yyminorunion);
      return;
    }
#endif
    yypParser->yyidx = 0;
    yypParser->yyerrcnt = -1;
    yypParser->yystack[0].stateno = 0;
    yypParser->yystack[0].major = 0;
  }
  yyminorunion.yy0 = yyminor;
  yyendofinput = (yymajor==0);
  Haanga_ARG_STORE;

#ifndef NDEBUG
  if( yyTraceFILE ){
    fprintf(yyTraceFILE,"%sInput %s\n",yyTracePrompt,yyTokenName[yymajor]);
  }
#endif

  do{
    yyact = yy_find_shift_action(yypParser,(YYCODETYPE)yymajor);
    if( yyact<YYNSTATE ){
      assert( !yyendofinput );  /* Impossible to shift the $ token */
      yy_shift(yypParser,yyact,yymajor,&yyminorunion);
      yypParser->yyerrcnt--;
      yymajor = YYNOCODE;
    }else if( yyact < YYNSTATE + YYNRULE ){
      yy_reduce(yypParser,yyact-YYNSTATE);
    }else{
      assert( yyact == YY_ERROR_ACTION );
#ifdef YYERRORSYMBOL
      int yymx;
#endif
#ifndef NDEBUG
      if( yyTraceFILE ){
        fprintf(yyTraceFILE,"%sSyntax Error!\n",yyTracePrompt);
      }
#endif
#ifdef YYERRORSYMBOL
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
      if( yypParser->yyerrcnt<0 ){
        yy_syntax_error(yypParser,yymajor,yyminorunion);
      }
      yymx = yypParser->yystack[yypParser->yyidx].major;
      if( yymx==YYERRORSYMBOL || yyerrorhit ){
#ifndef NDEBUG
        if( yyTraceFILE ){
          fprintf(yyTraceFILE,"%sDiscard input token %s\n",
             yyTracePrompt,yyTokenName[yymajor]);
        }
#endif
        yy_destructor(yypParser, (YYCODETYPE)yymajor,&yyminorunion);
        yymajor = YYNOCODE;
      }else{
         while(
          yypParser->yyidx >= 0 &&
          yymx != YYERRORSYMBOL &&
          (yyact = yy_find_reduce_action(
                        yypParser->yystack[yypParser->yyidx].stateno,
                        YYERRORSYMBOL)) >= YYNSTATE
        ){
          yy_pop_parser_stack(yypParser);
        }
        if( yypParser->yyidx < 0 || yymajor==0 ){
          yy_destructor(yypParser,(YYCODETYPE)yymajor,&yyminorunion);
          yy_parse_failed(yypParser);
          yymajor = YYNOCODE;
        }else if( yymx!=YYERRORSYMBOL ){
          YYMINORTYPE u2;
          u2.YYERRSYMDT = 0;
          yy_shift(yypParser,yyact,YYERRORSYMBOL,&u2);
        }
      }
      yypParser->yyerrcnt = 3;
      yyerrorhit = 1;
#elif defined(YYNOERRORRECOVERY)
      /* If the YYNOERRORRECOVERY macro is defined, then do not attempt to
      ** do any kind of error recovery.  Instead, simply invoke the syntax
      ** error routine and continue going as if nothing had happened.
      **
      ** Applications can set this macro (for example inside %include) if
      ** they intend to abandon the parse upon the first syntax error seen.
      */
      yy_syntax_error(yypParser,yymajor,yyminorunion);
      yy_destructor(yypParser,(YYCODETYPE)yymajor,&yyminorunion);
      yymajor = YYNOCODE;
      
#else  /* YYERRORSYMBOL is not defined */
      /* This is what we do if the grammar does not define ERROR:
      **
      **  * Report an error message, and throw away the input token.
      **
      **  * If the input token is $, then fail the parse.
      **
      ** As before, subsequent error messages are suppressed until
      ** three input tokens have been successfully shifted.
      */
      if( yypParser->yyerrcnt<=0 ){
        yy_syntax_error(yypParser,yymajor,yyminorunion);
      }
      yypParser->yyerrcnt = 3;
      yy_destructor(yypParser,(YYCODETYPE)yymajor,&yyminorunion);
      if( yyendofinput ){
        yy_parse_failed(yypParser);
      }
      yymajor = YYNOCODE;
#endif
    }
  }while( yymajor!=YYNOCODE && yypParser->yyidx>=0 );
  return;
}
