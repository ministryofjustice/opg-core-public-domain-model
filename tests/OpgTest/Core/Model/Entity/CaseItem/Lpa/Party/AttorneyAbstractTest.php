<?php

namespace OpgTest\Common\Model\Entity\CaseItem\Lpa\Party;


class AttorneyAbstractTest extends \PHPUnit_Framework_TestCase
{
    protected $attorney;

    public function setUp()
    {
        $this->attorney = $this->getMockForAbstractClass('Opg\Core\Model\Entity\CaseItem\Lpa\Party\AttorneyAbstract');
    }

    public function testGetSetDXNumber()
    {
        $expected = '123456/ABCD0';

        $this->assertEmpty($this->attorney->getDxNumber());
        $this->attorney->setDxNumber($expected);
        $this->assertEquals($expected, $this->attorney->getDxNumber());
    }

    public function testGetSetDXExchange()
    {
        $expected = '123456/ABCD0';

        $this->assertEmpty($this->attorney->getDxExchange());
        $this->attorney->setDxExchange($expected);
        $this->assertEquals($expected, $this->attorney->getDxExchange());
    }
}
