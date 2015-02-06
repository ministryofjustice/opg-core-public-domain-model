<?php

namespace OpgTest\Core\Model\Entity\Document;

use Opg\Core\Model\Entity\Document\Crec;

class CrecTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Crec */
    protected $crec;

    public function setUp()
    {
        $this->crec = new Crec();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->crec instanceof Crec);
    }

    public function testGetSetTotalAssets()
    {
        $expected = 42;

        $this->assertEmpty($this->crec->getRiskScore());
        $this->assertTrue($this->crec->setRiskScore($expected) instanceof Crec);

        $this->assertEquals($expected, $this->crec->getRiskScore());
    }
}
