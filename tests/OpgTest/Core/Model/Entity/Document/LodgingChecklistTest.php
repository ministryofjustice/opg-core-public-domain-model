<?php

namespace OpgTest\Core\Model\Entity\Document;


use Opg\Core\Model\Entity\Document\Document;
use Opg\Core\Model\Entity\Document\LodgingChecklist;

class LodgingChecklistTest extends \PHPUnit_Framework_TestCase {

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

    public function testGetSetClosingBalances()
    {
        $expected1 = 1.50;
        $expected2 = 'Rubbish';

        $this->assertEmpty($this->checklist->getClosingBalance1());
        $this->assertEmpty($this->checklist->getClosingBalance2());

        $this->assertTrue($this->checklist->setClosingBalance1($expected1) instanceof LodgingChecklist);
        $this->assertEquals($expected1, $this->checklist->getClosingBalance1());
        $this->assertTrue($this->checklist->setClosingBalance2($expected2) instanceof LodgingChecklist);
        $this->assertEmpty($this->checklist->getClosingBalance2());
    }
}
