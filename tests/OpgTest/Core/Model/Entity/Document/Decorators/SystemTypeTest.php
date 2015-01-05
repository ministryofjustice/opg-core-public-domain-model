<?php

namespace OpgTest\Core\Model\Entity\Document\Decorators;

use Opg\Core\Model\Entity\Document\Decorators\SystemType;
use Opg\Core\Model\Entity\Document\Decorators\HasSystemType;

class SystemTypeStub implements HasSystemType
{
    use SystemType;
}
class SystemTypeTest extends \PHPUnit_Framework_TestCase
{
    /** @var  SystemTypeStub */
    protected $SystemType;

    public function setUp()
    {
        $this->SystemType = new SystemTypeStub();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->SystemType instanceof HasSystemType);
    }

    public function testSetGetSystemType()
    {
        // Check that new object has blank type
        $this->assertNull($this->SystemType->getSystemType());

        // Add a system type
        $expectedType = 'Random';
        $this->SystemType->setSystemType($expectedType);

        // Check the get() returns the value passed to set.
        $this->assertEquals($expectedType, $this->SystemType->getSystemType());
    }
}
