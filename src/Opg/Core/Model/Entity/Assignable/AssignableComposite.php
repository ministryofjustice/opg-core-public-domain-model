<?php


namespace Opg\Core\Model\Entity\Assignable;

use Opg\Core\Model\Entity\CaseItem\CaseItem  as CaseEntity;
use Opg\Core\Model\Entity\CaseItem\Task\Task as TaskEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Opg\Core\Model\Entity\Deputyship\Deputyship as DeputyshipEntity;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney as PowerOfAttorneyEntity;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Accessor;

/**
 * @ORM\MappedSuperclass
 *
 * Class Composite
 * @package Opg\Core\Model\Entity\Composite
 */
abstract class AssignableComposite implements IsAssignee
{
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
     * @ORM\ManyToMany(targetEntity="Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney")
     * @ORM\JoinTable(name="assigned_powerofattorneys",
     *     joinColumns={@ORM\JoinColumn(name="assigned_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="poa_id", referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection
     * @Exclude
     * @ReadOnly
     */
    protected $powerOfAttorneys;

    /**
     * @ORM\ManyToMany(targetEntity="Opg\Core\Model\Entity\Deputyship\Deputyship")
     * @ORM\JoinTable(name="assigned_deputyships",
     *     joinColumns={@ORM\JoinColumn(name="assigned_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="deputyship_id", referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection
     * @Exclude
     * @ReadOnly
     */
    protected $deputyships;

    /**
     * @ORM\ManyToMany(targetEntity="Opg\Core\Model\Entity\CaseItem\Task\Task")
     * @ORM\JoinTable(name="assigned_tasks",
     *     joinColumns={@ORM\JoinColumn(name="assigned_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="task_id", referencedColumnName="id")}
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
     * @ORM\ManyToMany(targetEntity="Opg\Core\Model\Entity\Assignable\Team", inversedBy="members")
     * @ORM\JoinTable(name="assignee_teams")
     */
    protected $teams;

    public function __construct()
    {
        $this->deputyships      = new ArrayCollection();
        $this->powerOfAttorneys = new ArrayCollection();
        $this->tasks            = new ArrayCollection();
        $this->teams            = new ArrayCollection();
    }

    /**
     * @param TaskEntity $task
     * @return $this
     */
    public function addTask(TaskEntity $task)
    {
        if (null === $this->tasks) {
            $this->tasks = new ArrayCollection();
        }

        $this->tasks->add($task);

        return $this;
    }

    public function setTasks(ArrayCollection $tasks)
    {
        foreach ($tasks->toArray() as $task) {
            $this->addTask($task);
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
     * @return $this
     */
    public function addCase(CaseEntity $case)
    {
        if ($case instanceof PowerOfAttorneyEntity) {
            return $this->addPowerOfAttorney($case);
        }
        else {
            return $this->addDeputyship($case);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getCases()
    {
        $cases = new ArrayCollection();
        foreach($this->getPowerOfAttorneys() as $case) {
            $cases->add($case);
        }
        foreach($this->getDeputyships() as $case) {
            $cases->add($case);
        }

        return $cases;
    }

    /**
     * @param PowerOfAttorneyEntity $poa
     * @return $this
     */
    public function addPowerOfAttorney(PowerOfAttorneyEntity $poa)
    {
        if (null === $this->powerOfAttorneys) {
            $this->powerOfAttorneys = new ArrayCollection();
        }

        $this->powerOfAttorneys->add($poa);

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
     * @return $this
     */
    public function addDeputyship(DeputyshipEntity $poa)
    {
        if (null === $this->deputyships) {
            $this->deputyships = new ArrayCollection();
        }

        $this->deputyships->add($poa);

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
     * @return $this
     */
    public function setCases(ArrayCollection $cases)
    {
        foreach ($cases as $case) {
            $this->addCase($case);
        }

        return $this;
    }

    /**
     * @param ArrayCollection $cases
     * @return $this
     * Alias function
     */
    public function setPowerOfAttorneys(ArrayCollection $cases)
    {
        return $this->setCases($cases);
    }

    /**
     * @param ArrayCollection $cases
     * @return $this
     * Alias function
     */
    public function setDeputyships(ArrayCollection $cases)
    {
        return $this->setCases($cases);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = (int)$id;

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
     * @return $this|IsAssignee
     */
    public function setName($name)
    {
        $this->name = (string)$name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
