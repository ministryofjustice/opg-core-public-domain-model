<?php
namespace Opg\Core\Model\Entity\CaseItem;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\HasNotesInterface;
use Opg\Common\Model\Entity\HasCorrespondenceInterface;
use Opg\Common\Model\Entity\HasRagRating;
use Opg\Common\Model\Entity\HasUidInterface;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\HasNotes;
use Opg\Common\Model\Entity\Traits\HasCorrespondence;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Common\Model\Entity\Traits\UniqueIdentifier;
use Opg\Core\Model\Entity\CaseItem\Document\Document;
use Opg\Core\Model\Entity\CaseItem\Note\Note;
use Opg\Core\Model\Entity\CaseItem\Task\Task;
use Opg\Core\Model\Entity\CaseItem\Validation\InputFilter\CaseItemFilter;
use Opg\Core\Model\Entity\Person\Person;
use Opg\Core\Model\Entity\User\User;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Type;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;
use Opg\Core\Validation\InputFilter\IdentifierFilter;
use Opg\Core\Validation\InputFilter\UidFilter;

/**
 * @ORM\MappedSuperclass
 * @package Opg\Core\Model\Entity\CaseItem
 */
abstract class CaseItem implements EntityInterface, \IteratorAggregate, CaseItemInterface, HasUidInterface,
    HasNotesInterface, HasCorrespondenceInterface, HasRagRating
{
    use ToArray;
    use HasNotes;
    use UniqueIdentifier;
    use InputFilter;
    use HasCorrespondence;

    const APPLICATION_TYPE_CLASSIC = 0;
    const APPLICATION_TYPE_ONLINE  = 1;

    /**
     * Constants below are for payment types radio buttons, we use 0
     * as default
     */
    const PAYMENT_OPTION_NOT_SET = 0;
    const PAYMENT_OPTION_FALSE   = 1;
    const PAYMENT_OPTION_TRUE    = 2;


    /**
     * @ORM\Column(type = "integer") @ORM\GeneratedValue(strategy = "AUTO")
     * @ORM\Id
     * @Type("integer")
     * @var int autoincrementID
     * @Serializer\Groups({"api-poa-list","api-task-list"})
     */
    protected $id;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     * @var int
     * @Type("integer")
     * @Serializer\Groups({"api-poa-list","api-task-list"})
     */
    protected $oldCaseId;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     * @var int
     * @Type("integer")
     * @Accessor(getter="getApplicationType",setter="setApplicationType")
     * @Serializer\Groups({"api-poa-list","api-task-list"})
     */
    protected $applicationType = self::APPLICATION_TYPE_CLASSIC;
    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string $title
     * @Type("string")
     * @Serializer\Groups({"api-poa-list","api-task-list"})
     */
    protected $title;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Serializer\Groups({"api-poa-list","api-task-list"})
     * @Accessor(getter="getCaseType", setter="setCaseType")
     */
    protected $caseType;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Serializer\Groups({"api-poa-list","api-task-list"})
     */
    protected $caseSubtype;

    /**
     * @ORM\Column(type = "date", nullable = true)
     * @var \DateTime
     * @Type("string")
     * @Serializer\Groups({"api-poa-list","api-task-list"})
     * @Accessor(getter="getDueDateString", setter="setDueDateString")
     */
    protected $dueDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Serializer\Groups({"api-poa-list","api-task-list"})
     * @Accessor(getter="getRegistrationDateString", setter="setRegistrationDateString")
     */
    protected $registrationDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Serializer\Groups({"api-poa-list","api-task-list"})
     * @Accessor(getter="getClosedDateString", setter="setClosedDateString")
     */
    protected $closedDate;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Serializer\Groups({"api-poa-list","api-task-list"})
     */
    protected $status;

    /**
     * @Serializer\MaxDepth(1)
     * @ORM\ManyToOne(cascade={"persist"}, targetEntity = "Opg\Core\Model\Entity\User\User", fetch = "EAGER")
     * @var User
     * @Type("Opg\Core\Model\Entity\User\User")
     * @ReadOnly
     * @Serializer\Groups("api-poa-list")
     */
    protected $assignedUser;

    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity = "Opg\Core\Model\Entity\CaseItem\Task\Task", fetch="EAGER")
     * @var ArrayCollection
     * @ReadOnly
     * @Serializer\Groups("api-poa-list")
     * @Accessor(getter="filterTasks")
     */
    protected $tasks;

    /**
     * @ORM\ManyToMany(targetEntity = "Opg\Core\Model\Entity\CaseItem\Note\Note", cascade={"persist"})
     * @var ArrayCollection
     * @ReadOnly
     */
    protected $notes;

    /**
     * @ORM\ManyToMany(targetEntity = "Opg\Core\Model\Entity\CaseItem\Document\Document", cascade={"persist"})
     * @var ArrayCollection
     * @ReadOnly
     */
    protected $documents;

    /**
     * @ORM\ManyToMany(targetEntity = "Opg\Core\Model\Entity\Correspondence\Correspondence", cascade={"persist"})
     * @var ArrayCollection
     * @ReadOnly
     */
    protected $correspondence;

    // Fields below are NOT persisted
    /**
     * @var ArrayCollection
     * @todo Move this out of the CaseItem, need to be used in validation, but needs to exist somewhere else
     * @ReadOnly
     */
    protected $caseItems;

    /**
     * @var array
     * This is used to getTaskStatus counts, we do not persist it though
     * @ReadOnly
     */
    protected $taskStatus = [];

    /**
     * Non persistable entity
     * @var int
     * @ReadOnly
     * @Accessor(getter="getRagRating")
     * @Serializer\Groups("api-poa-list")
     */
    protected $ragRating;

    /**
     * Non persistable entity
     * @var int
     * @ReadOnly
     * @Accessor(getter="getRagTotal")
     * @Serializer\Groups("api-poa-list")
     */
    protected $ragTotal;

    /**
     * @ORM\OneToMany(targetEntity="Opg\Core\Model\Entity\CaseItem\BusinessRule", mappedBy="case", cascade={"all"}, fetch="EAGER")
     * @var \Opg\Core\Model\Entity\CaseItem\BusinessRule
     */
    protected $businessRules;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->caseItems = new ArrayCollection();
        $this->businessRules = new ArrayCollection();
    }

    /**
     * @return \DateTime $dueDate
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @return string
     */
    public function getDueDateString()
    {
        if (!empty($this->dueDate)) {
            return $this->dueDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @param \DateTime $dueDate
     *
     * @return CaseItem
     */
    public function setDueDate(\DateTime $dueDate = null)
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * @param $dueDate
     *
     * @return $this
     */
    public function setDueDateString($dueDate)
    {
        if (!empty($dueDate)) {
            $dueDate = OPGDateFormat::createDateTime($dueDate);

            if ($dueDate) {
                $this->setDueDate($dueDate);
            }
        }

        return $this;
    }

    /**
     * @return string $caseType
     */
    public function getCaseType()
    {
        return strtoupper($this->caseType);
    }

    /**
     * @param string $caseType
     * @return CaseItem
     */
    public function setCaseType($caseType)
    {
        $this->caseType = strtoupper($caseType);

        return $this;
    }

    /**
     * @return string $caseSubtype
     */
    public function getCaseSubtype()
    {
        return $this->caseSubtype;
    }

    /**
     * @param string $caseSubtype
     * @return CaseItem
     */
    public function setCaseSubtype($caseSubtype)
    {
        $this->caseSubtype = $caseSubtype;

        return $this;
    }

    /**
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return User $assignedUser
     */
    public function getAssignedUser()
    {
        return $this->assignedUser;
    }

    /**
     * @param string $status
     * @return CaseItem
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @param User $assignedUser
     */
    public function setAssignedUser(User $assignedUser = null)
    {
        $this->assignedUser = $assignedUser;
    }

    /**
     *
     * @return ArrayCollection
     */
    public function getTasks()
    {
        return $this->tasks;
    }

    /**
     *
     * @return ArrayCollection
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param  Task $task
     *
     * @return $this
     */
    public function addTask(Task $task)
    {
        if (is_null($this->tasks)) {
            $this->tasks = new ArrayCollection();
        }
        $this->tasks->add($task);
    }

    /**
     * @param  Document $document
     *
     * @return $this
     */
    public function addDocument(Document $document)
    {
        //Only required when we deserialize
        // @codeCoverageIgnoreStart
        if (is_null($this->documents)) {
            $this->documents = new ArrayCollection();
        }
        // @codeCoverageIgnoreEnd
        $this->documents->add($document);

        return $this;
    }

    /**
     * @param  ArrayCollection $tasks
     *
     * @return CaseItem
     */
    public function setTasks(ArrayCollection $tasks)
    {
        foreach ($tasks as $task) {
            $this->addTask($task);
        }

        return $this;
    }

    /**
     * @param  ArrayCollection $documents
     *
     * @return CaseItem
     */
    public function setDocuments(ArrayCollection $documents)
    {
        foreach ($documents as $document) {
            $this->addDocument($document);
        }

        return $this;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->toArray());
    }

    /**
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param  string $title
     *
     * @return CaseItem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param  int $id
     *
     * @return CaseItem
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
     * @return ArrayCollection
     */
    public function getCaseItems()
    {
        return $this->caseItems;
    }

    /**
     * @param  ArrayCollection $caseItems
     *
     * @return CaseItem
     */
    public function setCaseItems(ArrayCollection $caseItems)
    {
        foreach ($caseItems as $item) {
            $this->addCaseItem($item);
        }

        return $this;
    }

    /**
     * @param  CaseItem $item
     *
     * @return CaseItem
     */
    public function addCaseItem(CaseItem $item)
    {
        $this->caseItems->add($item);

        return $this;
    }

    /**
     * @return InputFilter|CaseItemFilter|\Zend\InputFilter\InputFilterInterface
     */
    public function getInputFilter()
    {
        $this->inputFilter = new \Zend\InputFilter\InputFilter();

        $caseItemFilter =  new CaseItemFilter();
        foreach($caseItemFilter->getInputs() as $name=>$input) {
            $this->inputFilter->add($input, $name);
        }

        $uidFilter =  new UidFilter();
        foreach($uidFilter->getInputs() as $name=>$input) {
            $this->inputFilter->add($input, $name);
        }

        $idFilter = new IdentifierFilter();
        foreach($idFilter->getInputs() as $name=>$input) {
            $this->inputFilter->add($input, $name);
        }
        return $this->inputFilter;
    }

    /**
     * @return array
     */
    public function getTaskStatus()
    {
        return $this->taskStatus;
    }

    /**
     * @param  array $taskStatus
     *
     * @return CaseItem
     */
    public function setTaskStatus(array $taskStatus)
    {
        foreach ($taskStatus as $item) {
            $this->taskStatus[str_replace(' ', '', $item['status'])] = $item['counter'];
        }

        return $this;
    }

    /**
     * @param  Person $person
     *
     * @return CaseItem
     */
    abstract public function addPerson(Person $person);

    /**
     * @return int
     */
    public function getOldCaseId()
    {
        return $this->oldCaseId;
    }

    /**
     * @param $oldCaseId
     *
     * @return CaseItem
     */
    public function setOldCaseId($oldCaseId)
    {
        $this->oldCaseId = $oldCaseId;

        return $this;
    }

    /**
     * @return int
     */
    public function getApplicationType()
    {
        return ($this->applicationType == self::APPLICATION_TYPE_CLASSIC) ? 'Classic' : 'Online';
    }

    /**
     * @param  string $applicationType
     *
     * @return CaseItem
     */
    public function setApplicationType($applicationType)
    {
        $this->applicationType = ($applicationType == 'Classic')
            ? self::APPLICATION_TYPE_CLASSIC
            : self::APPLICATION_TYPE_ONLINE;

        return $this;
    }

    /**
     * @param  \DateTime $closedDate
     *
     * @return CaseItem
     */
    public function setClosedDate(\DateTime $closedDate = null)
    {
        if (is_null($closedDate)) {
            $closedDate = new \DateTime();
        }
        $this->closedDate = $closedDate;
    }

    /**
     * @param string $closedDate
     *
     * @return Lpa
     */
    public function setClosedDateString($closedDate)
    {
        if (!empty($closedDate)) {
            $closedDate = OPGDateFormat::createDateTime($closedDate);

            if ($closedDate) {
                $this->setClosedDate($closedDate);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getClosedDate()
    {
        return $this->closedDate;
    }

    /**
     * @return string
     */
    public function getClosedDateString()
    {
        if (!empty($this->closedDate)) {
            return $this->closedDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @param  \DateTime $registrationDate
     *
     * @return CaseItem
     */
    public function setRegistrationDate(\DateTime $registrationDate = null)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * @param string $registrationDate
     *
     * @return CaseItem
     */
    public function setRegistrationDateString($registrationDate = null)
    {
        if (!empty($registrationDate)) {

            $registrationDate = OPGDateFormat::createDateTime($registrationDate);

            if ($registrationDate) {
                $this->setRegistrationDate($registrationDate);
            }
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * @return string
     */
    public function getRegistrationDateString()
    {
        if (!empty($this->registrationDate)) {
            return $this->registrationDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @return int
     */
    public function getRagRating()
    {
        $rag = array(
            '1' => 0,
            '2' => 0,
            '3' => 0
        );

        if(!empty($this->tasks)) {
            foreach ($this->tasks as $taskItem) {
                if($taskItem->getStatus() !== 'Completed') {
                    $rag[$taskItem->getRagRating()]++;
                }
            }
        }

        //Apply rules
        if (($rag['3'] >= 1) || $rag['2'] > 2) {
            return 3;
        }
        elseif ($rag['2'] >= 1) {
            return 2;
        }
        return 1;
    }

    /**
     * @return int
     */
    public function getRagTotal()
    {
        $total = 0;

        if(!empty($this->tasks)) {
            foreach ($this->filterTasks() as $taskItem) {
                if($taskItem->getStatus() !== 'Completed') {
                    $total += $taskItem->getRagRating();
                }
            }
        }

        return $total;
    }

    /**
     * @return ArrayCollection
     */
    public function filterTasks()
    {
        $activeTasks = new ArrayCollection();

        if(!empty($this->tasks)) {
            foreach ($this->tasks as $taskItem) {
                if($taskItem->getActiveDate() !== null) {
                    $now = time();
                    $taskTime = $taskItem->getActiveDate()->getTimestamp();

                    if ($now >= $taskTime) {
                        $activeTasks->add($taskItem);
                    }
                }
                else {
                    $activeTasks->add($taskItem);
                }
            }
        }
        return $activeTasks;
    }

    /**
     * @return ArrayCollection
     */
    public function getBusinessRules()
    {
        return $this->businessRules;
    }

    /**
     * @param ArrayCollection $businessRules
     *
     * @return CaseItem
     */
    public function setBusinessRules(ArrayCollection $businessRules)
    {
        $this->businessRules = $businessRules;

        return $this;
    }

    /**
     * @param BusinessRule $businessRule
     *
     * @return CaseItem
     */
    public function addBusinessRule(BusinessRule $businessRule)
    {
        $this->businessRules[] = $businessRule;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return BusinessRule|null
     */
    public function getBusinessRule($key)
    {
        foreach ($this->getBusinessRules() as $rule) {
            if ($rule->getKey() == $key) {
                return $rule;
            }
        }

        return null;
    }
}
