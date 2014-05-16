<?php
namespace OpgTest\Common\Model\Entity\Traits;

use Opg\Common\Model\Entity\DateFormat;
use Opg\Common\Model\Entity\Traits\Time;

/**
 * Time test case.
 */
class TimeTest extends \PHPUnit_Framework_TestCase
{

    use Time;

    public function testSetCreatedTimeWithNoParams()
    {
        $this->assertInstanceOf(
            'OpgTest\Common\Model\Entity\Traits\TimeTest',
            $this->setCreatedTime()
        );

        $this->assertInstanceOf(
            'DateTime',
            $this->getCreatedTime()
        );
    }

    public function testSetCreatedTimeWithParams()
    {
        $now = new \DateTime();

        $this->assertInstanceOf(
            'OpgTest\Common\Model\Entity\Traits\TimeTest',
            $this->setCreatedTime(
                $now
            )
        );

        $this->assertEquals(
            $now,
            $this->getCreatedTime()
        );
    }

    public function testSetCreatedTimeString()
    {
        $datetime = '2010-01-01T01:02:03';

        $this->assertInstanceOf(
            'OpgTest\Common\Model\Entity\Traits\TimeTest',
            $this->setCreatedTimeString($datetime)
        );

        $this->assertEquals(
            $datetime,
            $this->getCreatedTime()->format('Y-m-d\Th:i:s')
        );
    }

    public function testGetCreatedTimeString()
    {
        $datetime = '2010-01-01T01:02:03';

        $this->assertInstanceOf(
            'OpgTest\Common\Model\Entity\Traits\TimeTest',
            $this->setCreatedTimeString($datetime)
        );

        $this->assertEquals(
            $this->getCreatedTime()->format(DateFormat::getDateTimeFormat()),
            $this->getCreatedTimeString()
        );
    }

    public function testSetCreatedTimeStringWithEmpty()
    {
        $expected = new \DateTime();

        $this->assertEmpty($this->getCreatedTimeString());
        
        $this->setCreatedTimeString(null);

        $this->assertEquals(
            $this->getCreatedTimeString(),
            $expected->format(DateFormat::getDateTimeFormat())
        );
    }
}
