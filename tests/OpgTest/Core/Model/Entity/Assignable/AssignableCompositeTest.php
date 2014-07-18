<?php

namespace OpgTest\Core\Model\Entity\Assignable;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Assignable\AssignableComposite;
use Opg\Core\Model\Entity\CaseItem\LayDeputy\LayDeputy;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Core\Model\Entity\CaseItem\Task\Task;

/**
 * Class AssignableCompositeTest
 * @package OpgTest\Core\Model\Entity\Assignable
 */
class AssignableCompositeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AssignableComposite
     */
    protected $assignable;

    public function setUp()
    {
        $this->assignable = $this->getMockForAbstractClass('Opg\Core\Model\Entity\Assignable\AssignableComposite');
    }

    public function testGetSetId()
    {
        $expected = PHP_INT_MAX;

        $this->assertNull($this->assignable->getId());

        $this->assertTrue($this->assignable->setId($expected) instanceof AssignableComposite);

        $this->assertEquals($expected, $this->assignable->getId());
    }

    public function testSetIdCastsToInt()
    {
        $expected = 0;

        $actual = 'This is an id';

        $this->assertNull($this->assignable->getId());

        $this->assertTrue($this->assignable->setId($actual) instanceof AssignableComposite);

        $this->assertEquals($expected, $this->assignable->getId());
    }


    public function testGetSetCases()
    {
        $lpa = new Lpa();

        $deputyship = new LayDeputy();

        $cases = new ArrayCollection();

        $cases->add($lpa);

        $cases->add($deputyship);

        $this->assignable->setCases($cases);

        $this->assertEquals($cases, $this->assignable->getCases());

    }

    public function testSetGetTasks()
    {
        $task = new Task();

        $task2 = clone $task;

        $tasks = new ArrayCollection();

        $tasks->add($task);
        $tasks->add($task2);

        $this->assignable->setTasks($tasks);

        $this->assertEquals($tasks, $this->assignable->getTasks());

    }
}
