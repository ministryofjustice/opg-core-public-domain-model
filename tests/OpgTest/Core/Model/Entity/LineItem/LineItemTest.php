<?php

namespace OpgTest\Core\Model\Entity\LineItem;

use Opg\Core\Model\Entity\LineItem\LineItem;

class LineItemTest extends \PHPUnit_Framework_TestCase
{
    /** @var  LineItem */
    protected $lineItem;

    public function setUp()
    {
        $this->lineItem = new LineItem();
    }

    public function testGetSetId()
    {
        $expected = 1;
        $this->assertEmpty($this->lineItem->getId());
        $this->assertTrue($this->lineItem->setId($expected) instanceof LineItem);
        $this->assertEquals($expected, $this->lineItem->getId());
    }

    public function testGetSetLineItemName()
    {
        $expected = 'line item name';
        $this->assertEmpty($this->lineItem->getName());
        $this->assertTrue($this->lineItem->setName($expected) instanceof LineItem);
        $this->assertEquals($expected, $this->lineItem->getName());
    }

    public function testGetSetLineItemValue()
    {
        $expected = 2500.34;
        $this->assertEmpty($this->lineItem->getValue());
        $this->assertTrue($this->lineItem->setValue($expected) instanceof LineItem);
        $this->assertEquals($expected, $this->lineItem->getValue());
    }
}
