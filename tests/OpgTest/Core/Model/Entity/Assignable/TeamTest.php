<?php

namespace OpgTest\Core\Model\Entity\Assignable;


use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Assignable\Team;
use Opg\Core\Model\Entity\User\User;
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
    }

    public function testGetIterator()
    {
        $expected = array(
            'members'           => array(),
            'groupName'         => null,
            'parent'            => null,
            'children'          => array(),
            'id'                => null,
            'powerOfAttorneys'  => array(),
            'deputyships'       => array(),
            'tasks'             => array(),
            'name'              => null,
            'errorMessages'     => array(),
            'assignee'          => null,
            'teams'             => array()
        );

        $this->assertEquals($expected, (array)$this->team->getIterator());
    }
}
