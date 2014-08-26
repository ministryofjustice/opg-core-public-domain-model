<?php


namespace OpgTest\Common\Exception;


use Opg\Common\Exception\InvalidParameterValueException;

class InvalidParameterValueExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var InvalidParameterValueException
     */
    protected $exception;

    public function setUp()
    {
        $this->exception = new InvalidParameterValueException(__CLASS__, 1, 500, 'id');
    }

    public function testSetup()
    {
        $expectedErrorCode = InvalidParameterValueException::CODE_DATA_INVALID;

        $this->assertInstanceOf('Opg\Common\Exception\InvalidParameterValueException', $this->exception);
        $this->assertEquals($expectedErrorCode, $this->exception->getCode());
        $this->assertEquals('invalidFormat', $this->exception->getMessageDescriptor());
    }

    public function testGetAttribute()
    {
        $expected = 'id';
        $this->assertEquals($expected, $this->exception->getAttribute());
    }
}
