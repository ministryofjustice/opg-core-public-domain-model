<?php

namespace OpgTest\Core\Model\CaseItem\Deputyship\Report;


use Opg\Core\Model\Entity\CaseItem\Deputyship\Report\AnnualReport;
use Opg\Core\Model\Entity\Document\IncomingDocument;
use Opg\Core\Model\Entity\Document\OutgoingDocument;

class AnnualReportTest extends \PHPUnit_Framework_TestCase {

    /** @var  AnnualReport */
    protected $report;

    public function setUp()
    {
        $this->report = new AnnualReport();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->report instanceof AnnualReport);
        $this->assertTrue($this->report->getIterator() instanceof \RecursiveArrayIterator);
    }

    public function testGetSetDocuments()
    {
        $incDoc = new IncomingDocument();
        $outGoingDoc = new OutgoingDocument();
        $expectedCount = 1;

        $this->assertEmpty($this->report->getDocuments()->toArray());
        $this->assertTrue($this->report->addDocument($incDoc) instanceof AnnualReport);
        $this->assertTrue($this->report->addDocument($outGoingDoc) instanceof AnnualReport);

        $this->assertCount(2, $this->report->getDocuments()->toArray());
        $this->assertEquals($expectedCount, $this->report->getCorrespondenceCount());
    }

    public function testGetSetDueDate()
    {
        $expected = new \DateTime();

        $this->assertEmpty($this->report->getDueDate());
        $this->assertTrue($this->report->setDueDate($expected) instanceof AnnualReport);
        $this->assertEquals($expected, $this->report->getDueDate());
    }

    public function testGetSetLodgedDate()
    {
        $expected = new \DateTime();

        $this->assertEmpty($this->report->getLodgedDate());
        $this->assertTrue($this->report->setLodgedDate($expected) instanceof AnnualReport);
        $this->assertEquals($expected, $this->report->getLodgedDate());
    }

    public function testGetSetReceiptDate()
    {
        $expected = new \DateTime();

        $this->assertEmpty($this->report->getReceiptDate());
        $this->assertTrue($this->report->setReceiptDate($expected) instanceof AnnualReport);
        $this->assertEquals($expected, $this->report->getReceiptDate());
    }

    public function testGetSetReportingPeriod()
    {
        $expected = '2014-2015';

        $this->assertEmpty($this->report->getReportingPeriod());
        $this->assertTrue($this->report->setReportingPeriod($expected) instanceof AnnualReport);
        $this->assertEquals($expected, $this->report->getReportingPeriod());
    }

    public function testGetSetRevisedDueDate()
    {
        $expected = new \DateTime();

        $this->assertEmpty($this->report->getRevisedDueDate());
        $this->assertTrue($this->report->setRevisedDueDate($expected) instanceof AnnualReport);
        $this->assertEquals($expected, $this->report->getRevisedDueDate());
    }

    public function testGetSetStatus()
    {
        $expected = 'Yes';

        $this->assertEmpty($this->report->getStatus());
        $this->assertTrue($this->report->setStatus($expected) instanceof AnnualReport);
        $this->assertEquals($expected, $this->report->getStatus());
        $this->assertFalse($this->report->isValid(array('status')));

        $expected = 'Neither';

        $this->assertTrue($this->report->setStatus($expected) instanceof AnnualReport);
        $this->assertEquals($expected, $this->report->getStatus());
        $this->assertTrue($this->report->isValid(array('status')));
    }
}
