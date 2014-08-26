<?php

namespace OpgTest\Common\Exception;


use Opg\Common\Exception\EntityNotFoundException;

class EntityNotFoundExceptionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var EntityNotFoundException
     */
    protected $exception;

    public function setUp()
    {
        $this->exception = new EntityNotFoundException(get_class($this),1, EntityNotFoundException::CODE_DATA_NOT_FOUND, 'id');
    }

    public function testSetUp()
    {
        $expectedMessage = 'Unable to load OpgTest\Common\Exception\EntityNotFoundExceptionTest with identifier: 1';
        $expected = 'notFoundInDataLayer';

        $this->assertTrue($this->exception instanceof EntityNotFoundException);
        $this->assertEquals(EntityNotFoundException::CODE_DATA_NOT_FOUND, $this->exception->getCode());
        $this->assertEquals($expectedMessage, $this->exception->getMessage());
        $this->assertEquals($expected, $this->exception->getMessageDescriptor());
    }
}
