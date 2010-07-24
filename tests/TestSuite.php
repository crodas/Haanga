<?php

require dirname(__FILE__)."/../lib/Haanga.php";
require dirname(__FILE__)."/templateTest.php";
require dirname(__FILE__)."/errorTest.php";


class TestSuite extends PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new TestSuite('Haanga test suite');
        $suite->addTestSuite('templateTest');
        $suite->addTestSuite('errorTest');

        return $suite;
    }

    public static function Init()
    {
        Haanga::RegisterAutoLoad();
        Haanga::setCacheDir("tmp/");
        Haanga::setTemplateDir(".");
        Haanga::enableDebug(TRUE);
    }
}
