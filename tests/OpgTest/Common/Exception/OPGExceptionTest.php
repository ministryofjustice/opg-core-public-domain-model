<?php

namespace OpgTest\Common\Exception;

use Opg\Common\Exception\OPGBaseException;
use Opg\Common\Exception\OPGException;


class OPGExceptionTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var OPGException
     */
    protected $exception;

    public function setUp()
    {
        $this->exception = new OPGException(get_class($this), 3, 'bar');
    }

    public function testSetUp()
    {
        $this->assertTrue($this->exception instanceof OPGException);
        $this->assertEquals('unexpectedValue', $this->exception->getMessageDescriptor());
        $this->assertEquals(3, $this->exception->getCode());
        $this->assertEquals(
            'OpgTest\Common\Exception\OPGExceptionTest',
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
