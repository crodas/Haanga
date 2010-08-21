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
#ifndef PHP_HAANGA_H
#define PHP_HAANGA_H

#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include <php.h>
#include <ext/standard/info.h>
#include <Zend/zend_exceptions.h>

extern zend_module_entry haanga_module_entry;
#define phpext_haanga_ptr &haanga_module_entry

#ifdef PHP_WIN32
    #define PHP_HAANGA_API __declspec(dllexport)
#else
    #define PHP_HAANGA_API
#endif

#ifdef ZTS
#include "TSRM.h"
#endif

#define PHP_HAANGA_VERSION "0.1"

PHP_MINIT_FUNCTION(haanga);
PHP_MINFO_FUNCTION(haanga);


#define CALL_METHOD(Class, Method, retval, thisptr)  PHP_FN(Class##_##Method)(0, retval, NULL, thisptr, 0 TSRMLS_CC);

typedef struct iTokenize iTokenize;
struct iTokenize {
    /* string */
    unsigned char * str; 

    /* string length */
    int length;
    int line;

    /* should be free the str? */
    int free;

    /* init/end */
    unsigned char open_tag[20];
    unsigned char open_echo[20];
    unsigned char open_comment[20];
    unsigned char close_tag[20];
    unsigned char close_echo[20];
    unsigned char close_comment[20];

    /* current offset */
    int offset;

    /* where is the tokenizer? */
    int state;

    /* Last token information */
    int tType;
    int tErr;
    unsigned char * tValue;
    int tLength;
};


typedef struct {
    zval * ptr;
    zval * language;
    TSRMLS_D;
} haanga_callback_param;


#endif /* PHP_HAANGA_H */

/*
 * Local variables:
 * tab-width: 4
 * c-basic-offset: 4
 * End:
 * vim600: sw=4 ts=4 fdm=marker
 * vim<600: sw=4 ts=4
 */
