<?php


namespace OpgTest\Common\Exception;


use Opg\Common\Exception\InvalidParameterValueException;

class InvalidParameterValueExceptionTest extends \PHPUnit_Framework_TestCase
{
    protected $exception;

    public function setUp()
    {
        $this->exception = new InvalidParameterValueException(__CLASS__, 1, 500, 'id');
    }

    public function testSetup()
    {
        $expectedErrorCode = 500;

        $this->assertInstanceOf('Opg\Common\Exception\InvalidParameterValueException', $this->exception);
        $this->assertEquals($expectedErrorCode, $this->exception->getCode());
    }

    public function testGetAttribute()
    {
        $expected = 'id';
        $this->assertEquals($expected, $this->exception->getAttribute());
    }
}
