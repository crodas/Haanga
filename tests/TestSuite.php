<?php

require dirname(__FILE__)."/../lib/Haanga.php";
require dirname(__FILE__)."/../lib/Haanga/Compiler.php";
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
        $config = array(
            'cache_dir' => 'tmp/',
            'template_dir' => '.',
            'debug' => TRUE,
            'use_hash_filename' => FALSE,
            'compiler' => array(
                'allow_exec' => TRUE,
                'global' => array('test_global', 'global1'),
            )
        );

        Haanga::Configure($config);
    }
}
