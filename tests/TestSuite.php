<?php

require "../haanga/runtime.php";
require "templateTest.php";

class TestSuite extends PHPUnit_Framework_TestSuite
{
    function __construct()
    {
        /* setup */
        @mkdir("tmp/");
        Haanga::setCacheDir("tmp/");
        Haanga::setTemplateDir(".");
    }

    function __destruct()
    {
        foreach (glob("tmp/*") as $file) {
            unlink($file);
        }
    }

    public static function suite()
    {
        $suite = new TestSuite('Haanga test suite');
        $suite->addTestSuite('templateTest');

        return $suite;
    }
}
