<?php

require "../haanga/runtime.php";
require "templateTest.php";
require "errorTest.php";

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
        $suite->addTestSuite('errorTest');

        return $suite;
    }
}
