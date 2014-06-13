<?php

namespace OpgTest\Common\Model;


use Opg\Common\Model\Entity\LuhnCheckDigit;

class LuhnCheckDigitTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateEvenNumbers()
    {
        $expected = 4;
        $this->assertEquals($expected, LuhnCheckDigit::createCheckSum(1234));
    }

    public function testCreateOddNumbers()
    {
        $expected = 6;
        $this->assertEquals($expected, LuhnCheckDigit::createCheckSum(12345));
    }

    public function testValidateGood()
    {
        $expected = 4;
        $this->assertTrue(LuhnCheckDigit::validateNumber('1234'.$expected));
    }

    public function testValidateBad()
    {
        $expected = 8;
        $this->assertFalse(LuhnCheckDigit::validateNumber('1234'.$expected));
    }
}
