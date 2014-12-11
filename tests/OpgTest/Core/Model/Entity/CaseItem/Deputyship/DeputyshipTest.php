<?php

namespace OpgTest\Core\Model\CaseItem\Deputyship;

use Opg\Core\Model\Entity\CaseActor\Client;
use Opg\Core\Model\Entity\CaseItem\Deputyship\Deputyship;

class DeputyshipTest extends \PHPUnit_Framework_TestCase {

    /** @var  Deputyship */
    protected $deputyShip;

    public function setUp()
    {
        $this->deputyShip = $this->getMockForAbstractClass("Opg\Core\Model\Entity\CaseItem\Deputyship\Deputyship");
    }

    public function testSetUp()
    {
        $this->assertTrue($this->deputyShip instanceof Deputyship);
    }

    public function testGetSetBondReferenceNumber()
    {
        $expected = '123ABC';

        $this->assertEmpty($this->deputyShip->getBondReferenceNumber());
        $this->assertTrue($this->deputyShip->setBondReferenceNumber($expected) instanceof Deputyship);
        $this->assertEquals($expected, $this->deputyShip->getBondReferenceNumber());
    }

    public function testGetSetBondValue()
    {
        $expected = 123.12;

        $this->assertEmpty($this->deputyShip->getBondValue());
        $this->assertTrue($this->deputyShip->setBondValue('a value') instanceof Deputyship);
        $this->assertEmpty($this->deputyShip->getBondValue());
        $this->assertTrue($this->deputyShip->setBondValue($expected) instanceof Deputyship);

        $this->assertEquals($expected, $this->deputyShip->getBondValue());
    }

    public function testGetSetOrderDate()
    {
        $expected = new \DateTime();

        $this->assertEmpty($this->deputyShip->getOrderDate());
        $this->assertTrue($this->deputyShip->setOrderDate($expected) instanceof Deputyship);
        $this->assertEquals($expected, $this->deputyShip->getOrderDate());
    }

    public function testGetSetOrderIssueDate()
    {
        $expected = new \DateTime();

        $this->assertEmpty($this->deputyShip->getOrderIssueDate());
        $this->assertTrue($this->deputyShip->setOrderIssueDate($expected) instanceof Deputyship);
        $this->assertEquals($expected, $this->deputyShip->getOrderIssueDate());
    }

    public function testGetSetSecurityBond()
    {
        $this->assertFalse($this->deputyShip->hasSecurityBond());
        $this->assertTrue($this->deputyShip->setSecurityBond(true) instanceof Deputyship);
        $this->assertTrue($this->deputyShip->hasSecurityBond());
    }
}
