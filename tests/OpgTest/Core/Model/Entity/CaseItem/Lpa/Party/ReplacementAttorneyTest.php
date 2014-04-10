<?php

namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Party;


use Opg\Core\Model\Entity\CaseItem\Lpa\Party\ReplacementAttorney;

class ReplacementAttorneyTest extends \PHPUnit_Framework_TestCase
{
    protected $attorney;

    public function setUp()
    {
        $this->attorney = new ReplacementAttorney();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->attorney instanceof ReplacementAttorney);
    }

    public function testSetGetIsReplacementAttorney()
    {
        $this->attorney->setIsReplacementAttorney(true);
        $this->assertTrue($this->attorney->isReplacementAttorney());

        $this->attorney->setIsReplacementAttorney(false);
        $this->assertFalse($this->attorney->isReplacementAttorney());
    }

    public function testGetSetLpaPartCSignatureDate()
    {
        $expected = date('Y-m-d h:i:s');

        $this->assertEmpty($this->attorney->getLpaPartCSignatureDate());

        $this->attorney->setLpaPartCSignatureDate($expected);
        $this->assertEquals($expected, $this->attorney->getLpaPartCSignatureDate());
    }

}
