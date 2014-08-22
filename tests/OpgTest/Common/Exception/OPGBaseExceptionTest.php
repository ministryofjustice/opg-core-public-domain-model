<?php

namespace OpgTest\Common\Exception;

use Opg\Common\Exception\OPGBaseException;

class OPGBaseExceptionStub extends OPGBaseException{}

class OPGBaseExceptionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var OPGBaseExceptionStub
     */
    protected $exception;

    public function setUp()
    {
        $this->exception = new OPGBaseExceptionStub(get_class($this), 3, 'bar');
    }

    public function testSetUp()
    {
        $this->assertTrue($this->exception instanceof OPGBaseExceptionStub);
        $this->assertEquals('unexpectedValue', $this->exception->getMessageDescriptor());
        $this->assertEquals(3, $this->exception->getCode());
        $this->assertEquals(
            'OpgTest\Common\Exception\OPGBaseExceptionTest',
            $this->exception->getMessage()
        );
    }

    public function testGetSetAttribute()
    {
        $expected = 'attributeName';
        $this->assertEquals($this->exception->getAttribute(), 'bar');
        $this->exception->setAttribute($expected);
        $this->assertEquals($this->exception->getAttribute(), $expected);

    }

    public function testGetSetDescriptor()
    {
        $expected = 'descriptorName';
        $this->assertEquals($this->exception->getMessageDescriptor(), 'unexpectedValue');
        $this->exception->setMessageDescriptor($expected);
        $this->assertEquals($this->exception->getMessageDescriptor(), $expected);

    }

}
