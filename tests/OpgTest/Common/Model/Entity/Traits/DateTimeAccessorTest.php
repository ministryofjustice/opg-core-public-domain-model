<?php

namespace OpgTest\Common\Model\Entity\Traits;

use Opg\Common\Model\Entity\DateFormat;
use Opg\Common\Model\Entity\Traits\DateTimeAccessor;
use Opg\Common\Model\Entity\HasDateTimeAccessor;

class testStub implements HasDateTimeAccessor
{
    use DateTimeAccessor;

    /** @var  \DateTime */
    protected $todaysDate;
}

class DateTimeAccessorTest extends \PHPUnit_Framework_TestCase
{
    /** @var  testStub */
    protected $stub;

    public function setUp()
    {
        $this->stub = new testStub();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->stub instanceof HasDateTimeAccessor);
        $this->assertTrue($this->stub instanceof testStub);

        $this->assertEmpty($this->stub->getDateTimeAsString('todaysDate'));
        $this->assertEmpty($this->stub->getDateAsString('todaysDate'));
    }

    public function testGetSetDateTime()
    {
        $today = (new \DateTime())->format(DateFormat::getDateTimeFormat());

        $this->assertTrue($this->stub->setDateFromString($today, 'todaysDate') instanceof HasDateTimeAccessor);
        $this->assertTrue($this->stub->setTodaysDateString($today) instanceof HasDateTimeAccessor);

        $this->assertEquals($today, $this->stub->getDateTimeAsString('todaysDate'));
        $this->assertEquals(date('d/m/Y'), $this->stub->getTodaysDateString('todaysDate'));
        $this->assertEquals($this->stub->getDateAsString('todaysDate'), $this->stub->getTodaysDateString('todaysDate'));
    }

    /**
     * @expectedException \LogicException
     */
    public function testInvalidProperty()
    {
        $this->stub->setNextWeeksDateString(date('d/m/Y'));
    }

    public function testNonMatchingMethodDoesNothing()
    {
        $today = (new \DateTime())->format(DateFormat::getDateTimeFormat());
        $this->assertTrue($this->stub->setTodaysDate($today) instanceof HasDateTimeAccessor);
        $this->assertEmpty($this->stub->getDateTimeAsString('todaysDate'));
        $this->assertEmpty($this->stub->getDateAsString('todaysDate'));
    }
}
