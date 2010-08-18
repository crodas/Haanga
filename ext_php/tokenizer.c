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
  |                                             OR"                                    |
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

#include <stdio.h>
#include <stdlib.h>
#include "Parser.h"

typedef struct Keyword Keyword;
typedef struct iTokenize iTokenize;

struct Keyword {
    char * zName;
    int tokenType;
    int len;
    int iNext;
};

static Keyword aKeywordTable[] = {
    {"block",       T_BLOCK        },
    {"load",        T_LOAD         },
    {"for",         T_FOR          },
    {"empty",       T_EMPTY        },
    {"TRUE",        T_TRUE         },
    {"FALSE",       T_FALSE        },
    {"AND",         T_AND          },
    {"OR",          T_OR           },
    {"NOT",         T_NOT          },
    {"not",         T_NOT          },
    {"if",          T_IF           },
    {"else",        T_ELSE         },
    {"ifequal",     T_IFEQUAL      },
    {"ifnotequal",  T_IFNOTEQUAL   },
    {"ifchanged",   T_IFCHANGED    },
    {"spacefull",   T_SPACEFULL    },
    {"autoescape",  T_AUTOESCAPE   },
    {"filter",      T_FILTER       },
    {"include",     T_INCLUDE      },
    {"in",          T_IN           },
    {"as",          T_AS           },
    {"by",          T_BY           },
    {"extends",     T_EXTENDS      },
    {"regroup",     T_REGROUP      },
    {"with",        T_WITH         },
    {"_(",          T_INTL         },
};

static Keyword aOperationTable[] = {
    {"&&",      T_AND  },
    {"===",     T_EQ   },
    {"==",      T_EQ   },
    {"->",      T_OBJ  },
    {"||",      T_OR   },
    {"[",       T_BRACKETS_OPEN    },
    {"]",       T_BRACKETS_CLOSE   },
    {"-",       T_MINUS },
    {"+",       T_PLUS  },
    {"*",       T_TIMES },
    {"/",       T_DIV   },
    {":",       T_DIV   },
    {".",       T_DOT   },
};


struct iTokenize {
    /* string */
    unsigned char * str; 

    /* string length */
    int length;

    /* should be free the str? */
    int free;

    /* init/end */
    unsigned char * open_tag;
    unsigned char * open_echo;
    unsigned char * open_comment;
    unsigned char * close_tag;
    unsigned char * close_echo;
    unsigned char * close_comment;

    /* current offset */
    int offset;

    /* where is the tokenizer? */
    int state;

    /* Last token information */
    unsigned char * tValue;
    int tLength;
};

#define HAANGA_TOKENIZER_NONE       0x00
#define HAANGA_TOKENIZER_HTML       0x01
#define HAANGA_TOKENIZER_ECHO       0x02
#define HAANGA_TOKENIZER_TAG        0x03
#define HAANGA_TOKENIZER_COMMENT    0x04

#define KEY_HASH_SIZE   101
static int aiHashTable[KEY_HASH_SIZE];

static int haanga_gettoken_html(iTokenize * ztok);

iTokenize *  haanga_tokenizer_init(const char *z, int length, int alloc)
{
    iTokenize * ztok;
    ztok = (iTokenize *) malloc(sizeof(struct iTokenize));

    if (ztok == NULL) {
        return NULL;
    }

    if (alloc) {
        ztok->str = (unsigned char *) malloc((length+2) * sizeof(char));
        if (ztok->str == NULL) {
            free(ztok);
            return NULL;
        }
        strncpy(ztok->str, z, length); 
        ztok->free = 1;
    } else {
        ztok->str  = z;
        ztok->free = 0;
    }

    ztok->length = length;
    ztok->offset = 0;
    ztok->state  = HAANGA_TOKENIZER_NONE;

    return ztok;
}

void haanga_tokenizer_destroy(iTokenize ** ztok)
{
    if ((*ztok)->free) {
        free((*ztok)->str);
    }
    free(*ztok);
    *ztok = NULL;
}

int haanga_gettoken(iTokenize * ztok, int * tokenType)
{
    int i;
    unsigned char * start;

    if (ztok->state == HAANGA_TOKENIZER_NONE) {
        /* get information about the next state */
        start = ztok->str + ztok->offset; 
        if (strncmp(start, ztok->open_tag, strlen(ztok->open_tag)) == 0) {
        } else if (strncmp(start, ztok->open_comment, strlen(ztok->open_comment)) == 0) {
        } else if (strncmp(start, ztok->open_echo, strlen(ztok->open_echo)) == 0) {
        } else {
            ztok->state = HAANGA_TOKENIZER_HTML;
        }
    }

    switch (ztok->state) {
    case HAANGA_TOKENIZER_HTML:
        haanga_gettoken_html(ztok);
        break;
    case HAANGA_TOKENIZER_ECHO:
    case HAANGA_TOKENIZER_TAG:
        break;
    }

}

static int haanga_gettoken_html(iTokenize * ztok)
{
    unsigned char * tag, comment, echo;
    unsigned char * zLowest =-1;
    int zLength;

    /* Search in the HTML open tag,echo and comment */
    tag     = strstr(ztok->str + ztok->offset, ztok->open_tag);
    echo    = strstr(ztok->str + ztok->offset, ztok->open_echo);
    comment = strstr(ztok->str + ztok->offset, ztok->open_comment);

    /* select the first comment */
    if (tag != NULL) {
        zLowest = tag;
    }
    if (echo != NULL && (zLowest == -1 || zLowest > echo)) {
        zLowest = echo;
    }
    if (comment != NULL && (zLowest == -1 || zLowest > comment)) {
        zLowest = comment;
    }

    /* pointer to the token start */
    ztok->tValue  = ztok->str + ztok->offset; 

    if (zLowest == -1) {
        /* no tags were found, everything is HTML */
        ztok->tLength = ztok->length - ztok->offset; /* token end */
    } else {
        /* Length = pointer to tag - pointer to the string */
        ztok->tLength = zLowest - ztok->str;
    }

    /* reset tokenizer state */
    ztok->state  = HAANGA_TOKENIZER_NONE;

    return 1;

}
