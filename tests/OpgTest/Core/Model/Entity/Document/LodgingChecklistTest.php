<?php

namespace OpgTest\Core\Model\Entity\Document;


use Opg\Core\Model\Entity\Document\Document;
use Opg\Core\Model\Entity\Document\LodgingChecklist;

class LodgingChecklistTest extends \PHPUnit_Framework_TestCase
{

    /** @var  LodgingChecklist */
    protected $checklist;

    public function setUp()
    {
        $this->checklist = new LodgingChecklist();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->checklist instanceof LodgingChecklist);
    }

    public function testGetSetDirection()
    {
        $expected = 'Outgoing';

        $this->assertNotEquals($expected, $this->checklist->getDirection());
        $this->assertEquals($expected, $this->checklist->setDirection($expected)->getDirection());

        $this->assertEquals(Document::DIRECTION_INTERNAL, $this->checklist->setDirection(Document::DIRECTION_INTERNAL)->getDirection());
    }

    public function testGetSetTotalAssets()
    {
        $expected = 1024.00;

        $this->assertEmpty($this->checklist->getTotalAssets());
        $this->assertTrue($this->checklist->setTotalAssets($expected) instanceof LodgingChecklist);

        $this->assertEquals($expected, $this->checklist->getTotalAssets());
    }

    public function testGetSetStartEndDates()
    {
        $expectedStart = new \DateTime('1970-10-01');
        $expectedEnd   = new \DateTime('1970-12-31');

        $this->assertEmpty($this->checklist->getStartDate());
        $this->assertEmpty($this->checklist->getEndDate());

        $this->assertTrue($this->checklist->setStartDate($expectedStart) instanceof LodgingChecklist);
        $this->assertEquals($expectedStart, $this->checklist->getStartDate());

        $this->assertTrue($this->checklist->setEndDate($expectedEnd) instanceof LodgingChecklist);
        $this->assertEquals($expectedEnd, $this->checklist->getEndDate());
    }
}
