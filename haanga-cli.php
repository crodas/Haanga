#!/usr/bin/php
<?php

require dirname(__FILE__)."/lib/Haanga.php";

Haanga::registerAutoload();

Haanga_Compiler_Base::main_cli();
