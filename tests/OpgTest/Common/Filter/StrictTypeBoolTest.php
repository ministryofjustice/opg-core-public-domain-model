<?php

use Opg\Common\Filter\StrictTypeBool;

class StrictTypeBoolTest extends \PHPUnit_Framework_TestCase
{

    public function testApplyString()
    {
        $value = "false";
        $applyResult = StrictTypeBool::apply($value);
        $this->assertFalse($applyResult);
    }

    public function testApplyBooleanFalse()
    {
        $value = false;
        $applyResult = StrictTypeBool::apply($value);
        $this->assertFalse($applyResult);
    }

    public function testApplyDigitZero()
    {
        $value = 0;
        $applyResult = StrictTypeBool::apply($value);
        $this->assertFalse($applyResult);
    }

    public function testApplyDefaultTrue()
    {
        $value = 'anythingelse';
        $applyResult = StrictTypeBool::apply($value);
        //var_dump($applyResult);
        $this->assertEquals(true,$applyResult);
    }

}