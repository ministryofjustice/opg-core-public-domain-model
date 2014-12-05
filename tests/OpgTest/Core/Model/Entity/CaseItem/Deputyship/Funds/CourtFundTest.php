<?php

namespace OpgTest\Core\Model\CaseItem\Deputyship\Funds;


use Opg\Core\Model\Entity\CaseItem\Deputyship\Funds\CourtFund;

class CourtFundTest extends \PHPUnit_Framework_TestCase {

    /** @var  CourtFund */
    protected $fund;

    public function setUp()
    {
        $this->fund = new CourtFund();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->fund instanceof CourtFund);
        $this->assertEmpty($this->fund->getId());
        $this->assertEmpty($this->fund->getAccountBalance());
        $this->assertEmpty($this->fund->getPreviousBalance());
        $this->assertEmpty($this->fund->getLastUpdatedDate());
    }

    public function testGetSetId()
    {
        $expected = 1;
        $this->assertEmpty($this->fund->getId());
        $this->assertTrue($this->fund->setId($expected) instanceof CourtFund);
        $this->assertNotEmpty($this->fund->getId());
        $this->assertEquals($expected, $this->fund->getId());
    }

    public function testGetSetAccountBalance()
    {
        $expected = 0.01;
        $this->assertEmpty($this->fund->getAccountBalance());
        $this->assertTrue($this->fund->setAccountBalance($expected) instanceof CourtFund);
        $this->assertNotEmpty($this->fund->getAccountBalance());
        $this->assertEquals($expected, $this->fund->getAccountBalance());
    }

    public function testGetSetPreviousBalance()
    {
        $expected = 0.01;
        $this->assertEmpty($this->fund->getPreviousBalance());
        $this->assertTrue($this->fund->setPreviousBalance($expected) instanceof CourtFund);
        $this->assertNotEmpty($this->fund->getPreviousBalance());
        $this->assertEquals($expected, $this->fund->getPreviousBalance());
    }

    public function testGetSetLastUpdateDate()
    {
        $expected = new \DateTime();
        $this->assertEmpty($this->fund->getLastUpdatedDate());
        $this->assertTrue($this->fund->setLastUpdatedDate($expected) instanceof CourtFund);
        $this->assertNotEmpty($this->fund->getLastUpdatedDate());
        $this->assertEquals($expected, $this->fund->getLastUpdatedDate());
    }
}
