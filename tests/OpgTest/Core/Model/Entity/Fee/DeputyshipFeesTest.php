<?php

namespace OpgTest\Core\Model\Entity\Fee;


use Opg\Core\Model\Entity\Fee\DeputyshipFees;

class DeputyshipFeesTest extends \PHPUnit_Framework_TestCase
{
    /** @var  DeputyshipFees */
    protected $fees;

    public function setUp()
    {
        $this->fees = new DeputyshipFees();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->fees instanceof DeputyshipFees);
        $this->assertEmpty($this->fees->getId());
        $this->assertEmpty($this->fees->getInvoiceDate());
        $this->assertEmpty($this->fees->getInvoiceNumber());
        $this->assertEmpty($this->fees->getFeeCode());
        $this->assertEmpty($this->fees->getFeePeriod());
        $this->assertEmpty($this->fees->getFeeStatus());
        $this->assertEmpty($this->fees->getFeeValue());
    }

    public function testValidation()
    {
        $expected = 'Invalid';
        $this->assertTrue($this->fees->setFeeStatus($expected) instanceof DeputyshipFees);
        $this->assertFalse($this->fees->isValid(array('feeStatus')));

        $expected = 'Paid';
        $this->assertTrue($this->fees->setFeeStatus($expected) instanceof DeputyshipFees);
        $this->assertTrue($this->fees->isValid(array('feeStatus')));
    }

    public function testGetIterator()
    {
        $this->assertTrue($this->fees->getIterator() instanceof \RecursiveArrayIterator);
    }

    public function testGetSetId()
    {
        $expected = 1;
        $this->assertEmpty($this->fees->getId());
        $this->assertTrue($this->fees->setId('String') instanceof DeputyshipFees);
        $this->assertEmpty($this->fees->getId());
        $this->assertTrue($this->fees->setId($expected) instanceof DeputyshipFees);
        $this->assertNotEmpty($this->fees->getId());
        $this->assertEquals($expected, $this->fees->getId());
    }

    public function testGetSetFeeCode()
    {
        $expected = "11ABC2";
        $this->assertEmpty($this->fees->getFeeCode());
        $this->assertTrue($this->fees->setFeeCode($expected) instanceof DeputyshipFees);
        $this->assertNotEmpty($this->fees->getFeeCode());
        $this->assertEquals($expected, $this->fees->getFeeCode());
    }

    public function testGetSetInvoiceNumber()
    {
        $expected = "11ABC2";
        $this->assertEmpty($this->fees->getInvoiceNumber());
        $this->assertTrue($this->fees->setInvoiceNumber($expected) instanceof DeputyshipFees);
        $this->assertNotEmpty($this->fees->getInvoiceNumber());
        $this->assertEquals($expected, $this->fees->getInvoiceNumber());
    }

    public function testGetSetFeeValue()
    {
        $expected = 1.21;
        $this->assertEmpty($this->fees->getFeeValue());
        $this->assertTrue($this->fees->setFeeValue('String') instanceof DeputyshipFees);
        $this->assertEmpty($this->fees->getFeeValue());
        $this->assertTrue($this->fees->setFeeValue($expected) instanceof DeputyshipFees);
        $this->assertNotEmpty($this->fees->getFeeValue());
        $this->assertEquals($expected, $this->fees->getFeeValue());
    }

    public function testGetSetFeePeriod()
    {
        $expected = new \DateTime();
        $this->assertEmpty($this->fees->getFeePeriod());
        $this->assertTrue($this->fees->setFeePeriod($expected) instanceof DeputyshipFees);
        $this->assertNotEmpty($this->fees->getFeePeriod());
        $this->assertEquals($expected, $this->fees->getFeePeriod());
    }

    public function testGetSetInvoiceDate()
    {
        $expected = new \DateTime();
        $this->assertEmpty($this->fees->getInvoiceDate());
        $this->assertTrue($this->fees->setInvoiceDate($expected) instanceof DeputyshipFees);
        $this->assertNotEmpty($this->fees->getInvoiceDate());
        $this->assertEquals($expected, $this->fees->getInvoiceDate());
    }
}
