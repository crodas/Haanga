#!/bin/bash -x

gcc -o lemon.c lemon

./lemon parser-source.y

mv parser-source.c parser.c
mv parser-source.h parser.h
