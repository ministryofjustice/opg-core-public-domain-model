<?php

namespace OpgTest\Core\Model\Entity\DDC;


use Opg\Core\Model\Entity\DDC\IngestedDocument;

class IngestedDocumentTest extends \PHPUnit_Framework_TestCase
{
    /** @var  IngestedDocument */
    protected $stub;

    public function setUp()
    {
        $this->stub = new IngestedDocument();
    }

    public function testSetUp()
    {
        $expectedDate = date('d-m-Y');

        $this->assertTrue($this->stub instanceof IngestedDocument);
        $this->assertEquals($expectedDate, $this->stub->getIngestedDateTime()->format('d-m-Y'));
        $this->assertFalse($this->stub->getProcessed());
    }

    public function testGetSetId()
    {
        $expected = 1;

        $this->assertNull($this->stub->getId());
        $this->assertTrue($this->stub->setId($expected) instanceof IngestedDocument);
        $this->assertEquals($expected, $this->stub->getId());
    }

    public function testGetSetUid()
    {
        $expected = 123456789012;

        $this->assertNull($this->stub->getId());
        $this->assertTrue($this->stub->setUid($expected) instanceof IngestedDocument);
        $this->assertEquals($expected, $this->stub->getUid());
    }

    public function testGetSetIngestedDateTime()
    {
        $expected = new \DateTime();

        $this->assertNull($this->stub->getId());
        $this->assertTrue($this->stub->setIngestedDateTime($expected) instanceof IngestedDocument);
        $this->assertEquals($expected, $this->stub->getIngestedDateTime());
    }

    public function testGetSetProcessed()
    {
        $expected = true;

        $this->assertFalse($this->stub->getProcessed());
        $this->assertTrue($this->stub->setProcessed($expected) instanceof IngestedDocument);
        $this->assertEquals($expected, $this->stub->getProcessed());
    }

    public function testGetSetFilename()
    {
        $expected  = "file_" . uniqid();

        $this->assertNull($this->stub->getFilename());
        $this->assertTrue($this->stub->setFilename($expected) instanceof IngestedDocument);
        $this->assertEquals($expected, $this->stub->getFilename());
    }
}
