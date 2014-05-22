<?php

namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Party;


use Opg\Core\Model\Entity\CaseItem\Lpa\Party\TrustCorporation;

class TrustCorporationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var TrustCorporation
     */
    protected $attorney;

    public function setUp()
    {
        $this->attorney = new TrustCorporation();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->attorney instanceof TrustCorporation);
    }

    public function testGetSetTrustCorporationAppointedAs()
    {
        $this->assertEmpty($this->attorney->getTrustCorporationAppointedAs());
        $this->attorney->setTrustCorporationAppointedAs(TrustCorporation::AS_ATTORNEY);
        $this->assertEquals(TrustCorporation::AS_ATTORNEY, $this->attorney->getTrustCorporationAppointedAs());
    }

    public function testGetSetSignatoryOne()
    {
        $expected = "Signatory One";

        $this->assertEmpty($this->attorney->getSignatoryOne());
        $this->attorney->setSignatoryOne($expected);
        $this->assertEquals($expected, $this->attorney->getSignatoryOne());
    }

    public function testGetSetSignatoryTwo()
    {
        $expected = "Signatory Two";

        $this->assertEmpty($this->attorney->getSignatoryTwo());
        $this->attorney->setSignatoryTwo($expected);
        $this->assertEquals($expected, $this->attorney->getSignatoryTwo());
    }

    public function testGetSetCompanySeal()
    {
        $expected = "Company Seal Details";

        $this->assertEmpty($this->attorney->getCompanySeal());
        $this->attorney->setCompanySeal($expected);
        $this->assertEquals($expected, $this->attorney->getCompanySeal());
    }
}
