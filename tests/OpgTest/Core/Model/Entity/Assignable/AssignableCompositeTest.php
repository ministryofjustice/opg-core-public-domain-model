<?php

namespace OpgTest\Core\Model\Entity\Assignable;

use Doctrine\Common\Collections\ArrayCollection;
use Opg\Core\Model\Entity\Assignable\AssignableComposite;
use Opg\Core\Model\Entity\Assignable\Team;
use Opg\Core\Model\Entity\CaseItem\LayDeputy\LayDeputy;
use Opg\Core\Model\Entity\CaseItem\Lpa\Lpa;
use Opg\Core\Model\Entity\CaseItem\Task\Task;


class AssignableCompositeStub extends AssignableComposite
{
    public function __unset($key)
    {
        switch($key)
        {
            case 'tasks' :
                $this->tasks = null;
                break;
            case 'teams' :
                $this->teams = null;
                break;
            case 'deputyships':
                $this->deputyships = null;
                break;
            case 'poas':
                $this->powerOfAttorneys = null;
                break;
        }
    }

    public function getDisplayName()
    {
        return $this->getName();
    }
}
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
        $this->assignable = new AssignableCompositeStub();
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

        unset($this->assignable->{'deputyships'});
        unset($this->assignable->{'poas'});

        $lpa = new Lpa();

        $deputyship = new LayDeputy();

        $cases = new ArrayCollection();

        $cases->add($lpa);

        $cases->add($deputyship);

        $this->assignable->setCases($cases);

        $this->assertEquals($cases, $this->assignable->getCases());

        unset($this->assignable->{'deputyships'});
        unset($this->assignable->{'poas'});

        $this->assertEmpty($this->assignable->getCases()->toArray());
    }

    public function testSetGetTasks()
    {
        unset($this->assignable->{'tasks'});
        $task = new Task();

        $task2 = clone $task;

        $tasks = new ArrayCollection();

        $tasks->add($task);
        $tasks->add($task2);

        $this->assignable->setTasks($tasks);

        $this->assertEquals($tasks, $this->assignable->getTasks());

        unset($this->assignable->{'tasks'});
        $this->assertEmpty($this->assignable->getTasks()->toArray());
    }

    public function testGetSetDisplayName()
    {
        $expected = "Test Name";

        $this->assertTrue($this->assignable->setName($expected) instanceof AssignableComposite);

        $this->assertEquals($expected, $this->assignable->getDisplayName());
    }

    public function testTeams()
    {
        unset($this->assignable->{'teams'});

        $this->assertEmpty($this->assignable->getTeams()->toArray());

        unset($this->assignable->{'teams'});

        $teamCollection = new ArrayCollection();

        $teamCollection->add(new Team());
        $teamCollection->add(new Team());
        $teamCollection->add(new Team());

        $this->assignable->setTeams($teamCollection);

        $this->assertEquals($teamCollection, $this->assignable->getTeams());

        unset($this->assignable->{'teams'});
        $this->assignable->addTeams($teamCollection);

        $this->assertEquals($teamCollection, $this->assignable->getTeams());
    }
}
