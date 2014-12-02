<?php

namespace OpgTest\Core\Model\Entity\Assignable;


use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Assignable\Team;
use Opg\Core\Model\Entity\Assignable\User;
use Zend\InputFilter\InputFilter;

class TeamStub extends Team
{
        public function __unset($key)
        {
            switch($key)
            {
                case 'members' :
                    $this->members = null;
                    break;
                case 'teams' :
                    $this->teams = null;
                    break;
                case 'children' :
                    $this->children = null;
                    break;
            }
        }
}

class TeamTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Team
     */
    protected $team;

    public function setUp()
    {
        $this->team = new TeamStub();
    }

    public function testSetUp()
    {
        $this->assertTrue($this->team->getInputFilter() instanceof InputFilter);
    }

    public function testGetSetMembers()
    {
        unset($this->team->{'members'});
        $this->assertEmpty($this->team->getMembers()->toArray());

        $member1 = new User();

        $member2 = new Team();

        $members = new ArrayCollection();
        $members->add($member1);
        $members->add($member1);
        $members->add($member2);

        $this->assertEquals(3, $members->count());

        $this->assertTrue($this->team->setMembers($members) instanceof Team);

        $returnedMembers = $this->team->getMembers();
        $this->assertEquals(array($member1, $member2), $returnedMembers->toArray());

        unset($this->team->{'members'});

        $this->assertEquals($returnedMembers,$this->team->addMembers($members)->getMembers());
        $this->assertEquals($returnedMembers[0]->getTeams()->toArray()[0], $this->team);

        unset($this->team->{'teams'});
        $this->assertEquals(0, $this->team->getTeams()->count());

        unset($this->team->{'members'});
        $this->assertTrue($this->team->removeMember($member1) instanceof TeamStub);
    }

    public function testGetIterator()
    {
        $expected = array(
            'members'           => array(),
            'groupName'         => null,
            'parent'            => null,
            'children'          => array(),
            'id'                => null,
            'cases'             => array(),
            'tasks'             => array(),
            'name'              => null,
            'errorMessages'     => array(),
            'teams'             => array(),
            'displayName'       => null
        );

        $this->assertEquals($expected, (array)$this->team->getIterator());
    }

    public function testSetGetDisplayName()
    {
        $name  = 'Test';
        $group = 'Group';

        $expected = sprintf('%s (%s)', $name, $group);

        $this->assertTrue($this->team->setName($name) instanceof Team);
        $this->assertTrue($this->team->setGroupName($group) instanceof Team);

        $this->assertEquals($expected, $this->team->getDisplayName());

        $this->team->setGroupName(null);

        $this->assertEquals($name, $this->team->getDisplayName());
    }

    /**
     * @expectedException \LogicException
     */
    public function testSetGetParent()
    {
        $parent = (new Team())->setName('AwesomeTeam');

        $this->assertTrue($this->team->setParent($parent) instanceof Team);

        $this->assertEquals($parent, $this->team->getParent());

        $this->assertTrue($this->team->setParent($parent) instanceof Team);

    }

    public function testSetGetChildren()
    {
        $child1 = (new Team)->setName('Child 1');
        $child2 = (new Team)->setName('Child 2');

        $this->assertTrue($this->team->addChild($child1) instanceof Team);
        $this->assertTrue($this->team->addChild($child2) instanceof Team);

        $childCollection = new ArrayCollection();

        $childCollection->add($child1);
        $childCollection->add($child2);

        $this->assertEquals($childCollection, $this->team->getChildren());

        unset($this->team->{'children'});

        $childCollection2 = clone $childCollection;

        $childCollection2->add($child1);
        $childCollection2->add($child2);

        $this->assertTrue($this->team->addChildren($childCollection) instanceof Team);

        $this->assertEquals($childCollection, $this->team->getChildren());

        $this->assertTrue($this->team->setChildren($childCollection2) instanceof Team);

        $this->assertEquals($childCollection, $this->team->getChildren());
    }

    public function testValidation()
    {

        $this->assertFalse($this->team->isValid());


        $nameTooLong = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
        . 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
        . 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
        . 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789'
        . 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        $this->team->setName($nameTooLong);

        $this->assertFalse($this->team->isValid());

        $this->team->setName('Something Sensible');

        $this->assertTrue($this->team->isValid());

    }
}
