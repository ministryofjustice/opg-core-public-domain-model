<?php

namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Party;


use Opg\Core\Model\Entity\CaseItem\Lpa\Party\TrustCorporation;

class TrustCorporationTest extends \PHPUnit_Framework_TestCase
{
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
}
