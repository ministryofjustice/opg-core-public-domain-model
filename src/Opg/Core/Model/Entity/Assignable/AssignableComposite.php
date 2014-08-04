<?php

namespace Opg\Core\Model\Entity\Assignable;

use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseItem\CaseItem as CaseEntity;
use Opg\Core\Model\Entity\CaseItem\Task\Task as TaskEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Opg\Core\Model\Entity\Deputyship\Deputyship as DeputyshipEntity;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney as PowerOfAttorneyEntity;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\MaxDepth;

/**
 * @ORM\Entity
 * @ORM\Table(name = "assignees")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "assignee_user" = "Opg\Core\Model\Entity\User\User",
 *     "assignee_team" = "Opg\Core\Model\Entity\Assignable\Team",
 *     "assignee_null" = "Opg\Core\Model\Entity\Assignable\NullEntity"
 * })
 *
 * Class Composite
 * @package Opg\Core\Model\Entity\Composite
 */
abstract class AssignableComposite implements IsAssignee, \IteratorAggregate
{
    use ToArray;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true})
     * @ORM\GeneratedValue(strategy = "AUTO")
     * @ORM\Id
     * @var integer
     * @Groups({"api-poa-list","api-task-list"})
     * @Accessor(getter="getId", setter="setId")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(cascade={"all"}, targetEntity="Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney")
     * @ORM\JoinTable(
     *      name="assigned_powerofattorneys",
     *      joinColumns={@ORM\JoinColumn(name="assignee_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="poa_id", referencedColumnName="id", unique=true)}
     * )
     *
     * @var ArrayCollection
     * @Exclude
     * @ReadOnly
     */
    protected $powerOfAttorneys;

    /**
     * @ORM\ManyToMany(cascade={"all"}, targetEntity="Opg\Core\Model\Entity\Deputyship\Deputyship")
     * @ORM\JoinTable(
     *      name="assigned_deputyships",
     *      joinColumns={@ORM\JoinColumn(name="assignee_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="deputyship_id", referencedColumnName="id", unique=true)}
     * )
     *
     * @var ArrayCollection
     * @Exclude
     * @ReadOnly
     */
    protected $deputyships;

    /**
     * @ORM\ManyToMany(cascade={"all"}, targetEntity="Opg\Core\Model\Entity\CaseItem\Task\Task")
     * @ORM\JoinTable(
     *      name="assigned_tasks",
     *      joinColumns={@ORM\JoinColumn(name="assignee_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="task_id", referencedColumnName="id", unique=true)}
     * )
     *
     * @var ArrayCollection
     * @Exclude
     * @ReadOnly
     */
    protected $tasks;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups({"api-poa-list","api-task-list"})
     * @Accessor(getter="getName", setter="setName")
     */
    protected $name;

    /**
     * @ORM\ManyToMany(cascade={"all"}, targetEntity="Opg\Core\Model\Entity\Assignable\Team", mappedBy="members")
     * @var ArrayCollection
     * @MaxDepth(2)
     */
    protected $teams;

    /**
     * @var string
     * @Type("string")
     * @Accessor(getter="getDisplayName")
     * @ReadOnly
     */
    protected $displayName;

    public function __construct()
    {
        $this->deputyships      = new ArrayCollection();
        $this->powerOfAttorneys = new ArrayCollection();
        $this->tasks            = new ArrayCollection();
        $this->teams            = new ArrayCollection();
    }

    /**
     * @param TaskEntity $task
     *
     * @return AssignableComposite
     */
    public function addTask( TaskEntity $task )
    {
        if (null === $this->tasks) {
            $this->tasks = new ArrayCollection();
        }

        $this->tasks->add( $task );

        return $this;
    }

    /**
     * @param ArrayCollection $tasks
     *
     * @return AssignableComposite
     */
    public function setTasks( ArrayCollection $tasks )
    {
        foreach ($tasks->toArray() as $task) {
            $this->addTask( $task );
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getTasks()
    {
        if (null === $this->tasks) {
            $this->tasks = new ArrayCollection();
        }

        return $this->tasks;
    }

    /**
     * @param CaseEntity $case
     *
     * @return $this
     */
    public function addCase( CaseEntity $case )
    {
        if ($case instanceof PowerOfAttorneyEntity) {
            return $this->addPowerOfAttorney( $case );
        } else {
            return $this->addDeputyship( $case );
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getCases()
    {
        $cases = new ArrayCollection();
        foreach ($this->getPowerOfAttorneys() as $case) {
            $cases->add( $case );
        }
        foreach ($this->getDeputyships() as $case) {
            $cases->add( $case );
        }

        return $cases;
    }

    /**
     * @param PowerOfAttorneyEntity $poa
     *
     * @return AssignableComposite
     */
    public function addPowerOfAttorney( PowerOfAttorneyEntity $poa )
    {
        if (null === $this->powerOfAttorneys) {
            $this->powerOfAttorneys = new ArrayCollection();
        }

        $this->powerOfAttorneys->add( $poa );

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPowerOfAttorneys()
    {
        if (null === $this->powerOfAttorneys) {
            $this->powerOfAttorneys = new ArrayCollection();
        }

        return $this->powerOfAttorneys;
    }

    /**
     * @param DeputyshipEntity $poa
     *
     * @return AssignableComposite
     */
    public function addDeputyship( DeputyshipEntity $poa )
    {
        if (null === $this->deputyships) {
            $this->deputyships = new ArrayCollection();
        }

        $this->deputyships->add( $poa );

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getDeputyships()
    {
        if (null === $this->deputyships) {
            $this->deputyships = new ArrayCollection();
        }

        return $this->deputyships;
    }

    /**
     * @param ArrayCollection $cases
     *
     * @return AssignableComposite
     */
    public function setCases( ArrayCollection $cases )
    {
        foreach ($cases as $case) {
            $this->addCase( $case );
        }

        return $this;
    }

    /**
     * Alias function
     *
     * @param ArrayCollection $cases
     *
     * @return AssignableComposite
     */
    public function setPowerOfAttorneys( ArrayCollection $cases )
    {
        return $this->setCases( $cases );
    }

    /**
     * Alias function
     *
     * @param ArrayCollection $cases
     *
     * @return AssignableComposite
     */
    public function setDeputyships( ArrayCollection $cases )
    {
        return $this->setCases( $cases );
    }

    /**
     * @param int $id
     *
     * @return AssignableComposite
     */
    public function setId( $id )
    {
        $this->id = (int) $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $name
     *
     * @return AssignableComposite
     */
    public function setName( $name )
    {
        $this->name = (string) $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return \RecursiveArrayIterator
     */
    public function getIterator()
    {
        return new \RecursiveArrayIterator( $this->toArray() );
    }

    /**
     * @return string
     */
    abstract public function getDisplayName();

    /**
     * @param Team $team
     * @return $this
     */
    public function addTeam(Team $team)
    {
        if (null === $this->teams) {
            $this->teams = new ArrayCollection();
        }

        if (false === $this->teams->contains($team)) {
            $this->teams->add($team);
        }

        return $this;
    }

    /**
     * @param ArrayCollection $teams
     * @return $this
     */
    public function setTeams(ArrayCollection $teams)
    {
        $this->teams = $teams;

        return $this;
    }

    /**
     * @param ArrayCollection $teams
     * @return $this
     */
    public function addTeams(ArrayCollection $teams)
    {
        foreach ($teams->toArray() as $team) {
            if ($team instanceof Team) {
                $this->addTeam($team);
            }
        }

        return $this;
    }
    /**
     * @return ArrayCollection
     */
    public function getTeams()
    {
        if (null === $this->teams) {
            $this->teams = new ArrayCollection();
        }

        return $this->teams;
    }

    /**
     * @param Team $team
     * @return $this
     */
    public function removeTeam(Team $team)
    {
        if (null == $this->teams) {
            $this->teams = new ArrayCollection();
        }

        $this->teams->removeElement($team);

        return $this;
    }
}
