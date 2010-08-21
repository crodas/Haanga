dnl vim:se ts=2 sw=2 et:

PHP_ARG_ENABLE(haanga_parser, whether to enable haanga_parser functions,
[  --enable-haanga_parser         Enable haanga_parser support])

if test "$PHP_HAANGA" != "no"; then

  PHP_SUBST(HAANGA_SHARED_LIBADD)
  AC_DEFINE(HAVE_HAANGA, 1, [ ])

  PHP_NEW_EXTENSION(haanga, tokenizer.c haanga.c, $ext_shared)
fi

