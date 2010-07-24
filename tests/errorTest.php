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
    function testInvalidForloop($tpl)
    {
        TestSuite::init();
        $this->setExpectedException('Haanga_Compiler_Exception');
        Haanga::Load($tpl);
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

