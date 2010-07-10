<?php

require "../haanga/runtime.php";
require "templateTest.php";

class TestSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new TestSuite('Haanga test suite');
        $suite->addTestSuite('templateTest');

        return $suite;
    }
}
