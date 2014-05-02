<?php

/**
 * @package Opg Core Domain Model
 */
namespace Opg\Core\Model\Entity\CaseItem;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\HasNotesInterface;
use Opg\Common\Model\Entity\HasCorrespondenceInterface;
use Opg\Common\Model\Entity\HasUidInterface;
use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\HasNotes;
use Opg\Common\Model\Entity\Traits\HasCorrespondence;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Common\Model\Entity\Traits\UniqueIdentifier;
use Opg\Core\Model\Entity\CaseItem\Document\Document;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Note\Note;
use Opg\Core\Model\Entity\CaseItem\Task\Task;
use Opg\Core\Model\Entity\CaseItem\Validation\InputFilter\CaseItemFilter;
use Opg\Core\Model\Entity\Person\Person;
use Opg\Core\Model\Entity\User\User;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Groups;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * @ORM\MappedSuperclass
 */
abstract class CaseItem implements EntityInterface, \IteratorAggregate, CaseItemInterface, HasUidInterface, HasNotesInterface, HasCorrespondenceInterface
{
    use ToArray;
    use HasNotes;
    use UniqueIdentifier;
    use InputFilter;
    use ExchangeArray {
        exchangeArray as exchangeArrayTrait;
    }
    use HasCorrespondence;

    const APPLICATION_TYPE_CLASSIC = 0;
    const APPLICATION_TYPE_ONLINE  = 1;

    /**
     * Constants below are for payment types radio buttons, we use 0
     * as default
     */
    const PAYMENT_OPTION_NOT_SET   = 0;
    const PAYMENT_OPTION_FALSE     = 1;
    const PAYMENT_OPTION_TRUE      = 2;


    /**
     * @ORM\Column(type = "integer") @ORM\GeneratedValue(strategy = "AUTO") @ORM\Id
     * @var int autoincrementID
     * @Type("integer")
     * @Serializer\Groups("api-poa-list")
     */
    protected $id;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     * @var int
     * @Type("integer")
     * @Serializer\Groups("api-poa-list")
     */
    protected $oldCaseId;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     * @var int
     * @Type("string")
     * @Accessor(getter="getApplicationType",setter="setApplicationType")
     * @Serializer\Groups("api-poa-list")
     */
    protected $applicationType = self::APPLICATION_TYPE_CLASSIC;
    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string $title
     * @Type("string")
     * @Serializer\Groups("api-poa-list")
     */
    protected $title;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Serializer\Groups("api-poa-list")
     */
    protected $caseType;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Serializer\Groups("api-poa-list")
     */
    protected $caseSubtype;

    /**
     * @ORM\Column(type = "datetime", nullable = true)
     * @var \DateTime
     * @Type("string")
     * @Serializer\Groups("api-poa-list")
     * @Accessor(getter="getDueDateString", setter="setDueDateString")
     */
    protected $dueDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Serializer\Groups("api-poa-list")
     * @Accessor(getter="getRegistrationDateString", setter="setRegistrationDateString")
     */
    protected $registrationDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Serializer\Groups("api-poa-list")
     * @Accessor(getter="getClosedDateString", setter="setClosedDateString")
     */
    protected $closedDate;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Serializer\Groups("api-poa-list")
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
     * @Type("ArrayCollection<Opg\Core\Model\Entity\CaseItem\Task\Task>")
     * @ReadOnly
     * @Serializer\Groups("api-poa-list")
     */
    protected $tasks;

    /**
     * @ORM\ManyToMany(targetEntity = "Opg\Core\Model\Entity\CaseItem\Note\Note", cascade={"persist"})
     * @var ArrayCollection
     * @Type("ArrayCollection<Opg\Core\Model\Entity\CaseItem\Note\Note>")
     * @ReadOnly
     */
    protected $notes;

    /**
     * @ORM\ManyToMany(targetEntity = "Opg\Core\Model\Entity\CaseItem\Document\Document", cascade={"persist"})
     * @var ArrayCollection
     * @Type("ArrayCollection<Opg\Core\Model\Entity\CaseItem\Document\Document>")
     * @ReadOnly
     */
    protected $documents;

    /**
     * @ORM\ManyToMany(targetEntity = "Opg\Core\Model\Entity\Correspondence\Correspondence", cascade={"persist"})
     * @var ArrayCollection
     * @Type("ArrayCollection<Opg\Core\Model\Entity\Correspondence\Correspondence>")
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

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->caseItems = new ArrayCollection();
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
     * @return CaseItem
     */
    public function setDueDate(\DateTime $dueDate)
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     * @param $dueDate
     * @return $this
     */
    public function setDueDateString($dueDate)
    {
        if (!empty($dueDate)) {
            $this->setDueDate(new \DateTime($dueDate));
        }
        return $this;
    }

    /**
     * @return string $caseType
     */
    public function getCaseType()
    {
        return $this->caseType;
    }

    /**
     * @param string $caseType
     */
    public function setCaseType($caseType)
    {
        $this->caseType = $caseType;
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
     */
    public function setCaseSubtype($caseSubtype)
    {
        $this->caseSubtype = $caseSubtype;
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
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
     * @param  Task  $task
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
     * @TODO is this still required?
     *
     * @param  array    $data
     * @return CaseItem
     */
    public function exchangeArray(array $data)
    {
        $this->exchangeArrayTrait($data);

        if (!empty($data['assignedUser'])) {
            $assignedUser = new User();
            $assignedUser->exchangeArray($data['assignedUser']);
            $this->setAssignedUser($assignedUser);
        }

        if (!empty($data['tasks'])) {
            $this->tasks = null;
            foreach ($data['tasks'] as $taskData) {
                $newTask = new Task();
                $this->addTask(is_object($taskData) ? $taskData : $newTask->exchangeArray($taskData));
            }
        }

        if (!empty($data['notes'])) {
            $this->notes = null;
            foreach ($data['notes'] as $noteData) {
                $newNote = new Note();
                $this->addNote(is_object($noteData) ? $noteData : $newNote->exchangeArray($noteData));
            }
        }

        if (!empty($data['documents'])) {
            $this->documents = null;
            foreach ($data['documents'] as $documentData) {
                $newDocument = new Document();
                $this->addDocument(is_object($documentData) ? $documentData : $newDocument->exchangeArray($documentData));
            }
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
     * @param  string   $title
     * @return CaseItem
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @param  int   $id
     * @return CaseItem
     */
    public function setId($id)
    {
        $this->id = $id;

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
        if (!$this->inputFilter) {
            $this->inputFilter = new CaseItemFilter();
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
     * @param  array    $taskStatus
     * @return CaseItem
     */
    public function setTaskStatus(array $taskStatus)
    {
        foreach ($taskStatus as $item) {
            $this->taskStatus[str_replace(' ' ,'',$item['status'])] = $item['counter'];
        }

        return $this;
    }

    /**
     * @param  Person   $person
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
     * @param  string   $applicationType
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
     * @return Lpa
     */
    public function setClosedDateString($closedDate)
    {
        if (empty($closedDate)) {
            $closedDate = null;
        }
        return $this->setClosedDate(new \DateTime($closedDate));
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
     * @param  \DateTime  $registrationDate
     * @return CaseItem
     */
    public function setRegistrationDate(\DateTime $registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * @param string $registrationDate
     * @return CaseItem
     */
    public function setRegistrationDateString($registrationDate)
    {
        if (!empty($registrationDate)) {
            $this->setRegistrationDate(new \DateTime($registrationDate));
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

}
