<?php

namespace OpgTest\Core\Model\Entity\Assignable;


use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Assignable\Group;

class GroupStub extends Group
{
    public function __unset($key)
    {
        switch($key)
        {
            case 'children' :
                $this->children = null;
                break;
        }
    }
}


class GroupTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Group
     */
    protected $group;

    public function setUp()
    {
        $this->group = new GroupStub();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->group instanceof Group);
    }

    /**
     * @expectedException \LogicException
     */
    public function testGetSetParent()
    {
        $expected = $this->getMockForAbstractClass('Opg\Core\Model\Entity\Assignable\Group')->setId(1);

        $this->group->setId(3);

        $this->assertNull($this->group->getParent());

        $this->assertTrue($this->group->setParent($expected) instanceof Group);
        $this->assertEquals($expected, $this->group->getParent());
        $this->group->setParent($expected);
    }

    public function testGetSetChildren()
    {
        $child1 = $this->getMockForAbstractClass('Opg\Core\Model\Entity\Assignable\Group')->setId(2);

        $child2 = $this->getMockForAbstractClass('Opg\Core\Model\Entity\Assignable\Group')->setId(2);

        $collection = new ArrayCollection();
        $collection->add($child1);
        $collection->add($child2);

        $this->group->setId(1);

        $this->assertEmpty($this->group->getChildren()->toArray());
        unset($this->group->{'children'});
        $this->assertTrue($this->group->setChildren($collection) instanceof Group);
        $this->assertEquals($collection, $this->group->getChildren());

        $collection2 = clone $collection;

        $collection2->add($child1);
        $collection2->add($child2);

        $this->assertNotEquals($collection, $collection2);

        $this->assertTrue($this->group->setChildren($collection2) instanceof Group);
        $this->assertEquals($collection, $this->group->getChildren());

        $this->assertTrue($this->group->addChildren($collection2) instanceof Group);
        $this->assertEquals($collection, $this->group->getChildren());

    }
}
