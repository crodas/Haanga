<?php

/**
 *  @runTestsInSeparateProcess
 */
class errorTest extends PHPUnit_Framework_TestCase
{
    /** 
     * @dataProvider tplProvider
     *  
     */
    function testInvalidTemplates($tpl)
    {
        TestSuite::init();
        Haanga_Compiler::setOption('allow_exec', FALSE);
        try {
            Haanga::Load($tpl);
            $this->assertTrue(FALSE);
        } Catch (Haanga_Compiler_Exception $e) {
            $i = preg_match("/in.*:[0-9]+/", $e->getMessage());
            $this->assertEquals(1, $i);
        }
    }

    public function tplProvider()
    {
        $datas = array();
        foreach (glob("err_templates/*.tpl") as $err_file) {
            $datas[] = array($err_file);
        }

        return $datas;
    }

}

