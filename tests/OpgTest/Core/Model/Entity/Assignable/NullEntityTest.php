<?php

namespace OpgTest\Core\Model\Entity\Assignable;


use Opg\Core\Model\Entity\Assignable\NullEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\CaseItem\Deputyship\LayDeputy;
use Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Lpa;
use Opg\Core\Model\Entity\Task\Task;
use Zend\InputFilter\InputFilter;

class NullEntityTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var NullEntity
     */
    protected $nullEntity;

    public function setUp()
    {
        $this->nullEntity = new NullEntity();
    }

    public function testGetSetId()
    {
        $expected = NullEntity::NULL_USER_ID;

        $this->assertEquals($expected, $this->nullEntity->getId());
        $this->assertTrue($this->nullEntity->setId(1) instanceof NullEntity);

        $this->assertEquals($expected, $this->nullEntity->getId());
    }

    public function testGetSetName()
    {
        $expected = NullEntity::NULL_USER_NAME;

        $this->assertEquals($expected, $this->nullEntity->getName());
        $this->assertTrue($this->nullEntity->setName('test') instanceof NullEntity);

        $this->assertEquals($expected, $this->nullEntity->getName());
    }

    public function testGetSetCases()
    {
        $lpa = new Lpa();

        $deputyship = new LayDeputy();

        $cases = new ArrayCollection();

        $cases->add($lpa);

        $cases->add($deputyship);

        $this->nullEntity->setCases($cases);

        $this->assertEquals($cases, $this->nullEntity->getCases());

    }

    public function testSetGetTasks()
    {
        $task = new Task();

        $task2 = clone $task;

        $tasks = new ArrayCollection();

        $tasks->add($task);
        $tasks->add($task2);

        $this->nullEntity->setTasks($tasks);

        $this->assertEquals($tasks, $this->nullEntity->getTasks());

    }

    public function testToArray()
    {
        $this->assertEmpty($this->nullEntity->toArray());
    }

    /**
     * @expectedException \LogicException
     */
    public function testSetInputFilter()
    {
        $this->nullEntity->setInputFilter(new InputFilter());
    }

    /**
     * @expectedException \LogicException
     */
    public function testGetInputFilter()
    {
        $this->nullEntity->getInputFilter();
    }

    public function testGetDisplayName()
    {
        $this->assertEquals(NullEntity::NULL_USER_NAME, $this->nullEntity->getDisplayName());
    }
}
