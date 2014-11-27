<?php
namespace Opg\Core\Model\Entity\CaseItem;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\HasDocumentsInterface;
use Opg\Common\Model\Entity\HasNotesInterface;
use Opg\Common\Model\Entity\HasRagRating;
use Opg\Common\Model\Entity\HasUidInterface;
use Opg\Common\Model\Entity\Traits\DateTimeAccessor;
use Opg\Common\Model\Entity\Traits\HasDocuments;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\HasNotes;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Common\Model\Entity\Traits\UniqueIdentifier;
use Opg\Common\Model\Entity\HasDateTimeAccessor;
use Opg\Core\Model\Entity\Assignable\AssignableComposite;
use Opg\Core\Model\Entity\Assignable\Assignee;
use Opg\Core\Model\Entity\Assignable\IsAssignable;
use Opg\Core\Model\Entity\CaseItem\Task\Task;
use Opg\Core\Model\Entity\CaseItem\Validation\InputFilter\CaseItemFilter;
use Opg\Core\Model\Entity\Payment\PaymentType;
use Opg\Core\Model\Entity\CaseActor\Person;
use Opg\Core\Model\Entity\Queue as ScheduledJob;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\GenericAccessor;
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
    HasNotesInterface, HasDocumentsInterface, HasRagRating, IsAssignable, HasDateTimeAccessor
{
    use ToArray;
    use HasNotes;
    use UniqueIdentifier;
    use InputFilter;
    use Assignee;
    use HasDocuments;
    use DateTimeAccessor;

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
     * @ORM\Column(type = "integer")
     * @ORM\GeneratedValue(strategy = "AUTO")
     * @ORM\Id
     * @Type("integer")
     * @var int autoincrementID
     * @Serializer\Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $id;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     * @var int
     * @Type("integer")
     * @Serializer\Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $oldCaseId;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     * @var int
     * @Type("integer")
     * @Accessor(getter="getApplicationType",setter="setApplicationType")
     * @Serializer\Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $applicationType = self::APPLICATION_TYPE_CLASSIC;
    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string $title
     * @Type("string")
     * @Serializer\Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $title;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Serializer\Groups({"api-poa-list","api-task-list","api-person-get"})
     * @Accessor(getter="getCaseType", setter="setCaseType")
     */
    protected $caseType;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Serializer\Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $caseSubtype;

    /**
     * @ORM\Column(type = "date", nullable = true)
     * @var \DateTime
     * @Type("string")
     * @Serializer\Groups({"api-poa-list","api-task-list","api-person-get"})
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="dueDate")
     */
    protected $dueDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Serializer\Groups({"api-poa-list","api-task-list","api-person-get"})
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="registrationDate")
     */
    protected $registrationDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Serializer\Groups({"api-poa-list","api-task-list","api-person-get"})
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="closedDate")
     */
    protected $closedDate;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Serializer\Groups({"api-poa-list","api-task-list","api-person-get"})
     */
    protected $status;

    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity = "Opg\Core\Model\Entity\CaseItem\Task\Task", fetch="EAGER")
     * @ORM\OrderBy({"id"="ASC"})
     * @var ArrayCollection
     * @ReadOnly
     * @Serializer\Groups({"api-poa-list","api-task-list","api-person-get"})
     * @Accessor(getter="filterTasks")
     */
    protected $tasks;

    /**
     * @ORM\ManyToMany(targetEntity = "Opg\Core\Model\Entity\CaseItem\Note\Note", cascade={"persist"})
     * @ORM\OrderBy({"id"="ASC"})
     * @var ArrayCollection
     * @Serializer\Groups({"api-person-get"})
     * @ReadOnly
     */
    protected $notes;


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
     * @Serializer\Groups({"api-poa-list","api-person-get"})
     */
    protected $ragRating;

    /**
     * Non persistable entity
     * @var int
     * @ReadOnly
     * @Accessor(getter="getRagTotal")
     * @Serializer\Groups({"api-poa-list","api-person-get"})
     */
    protected $ragTotal;

    /**
     * @ORM\Column(type = "datetime", nullable = true)
     * @var \DateTime
     * @Type("string")
     * @Serializer\Groups({"api-poa-list","api-task-list","api-person-get"})
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="rejectedDate")
     */
    protected $rejectedDate;

    /**
     * @ORM\ManyToMany(targetEntity="Opg\Core\Model\Entity\Queue", cascade={"all"})
     * @ORM\JoinTable(
     *      joinColumns={@ORM\JoinColumn(name="case_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="scheduled_job_id", referencedColumnName="id", unique=true)}
     * )
     * @var ArrayCollection
     */
    protected $scheduledJobs;

    /**
     * @ORM\ManyToMany(targetEntity="Opg\Core\Model\Entity\Payment\PaymentType", cascade={"all"}, fetch="EAGER")
     * @ORM\OrderBy({"id"="ASC"})
     * @var ArrayCollection
     */
    protected $payments;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->caseItems = new ArrayCollection();
        $this->scheduledJobs = new ArrayCollection();
        $this->payments = new ArrayCollection();
    }

    /**
     * @return \DateTime $dueDate
     */
    public function getDueDate()
    {
        return $this->dueDate;
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
     * @param string $status
     * @return CaseItem
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
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
     * @return string
     */
    public function getClosedDate()
    {
        return $this->closedDate;
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
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
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
    public function getScheduledJobs()
    {
        if (null === $this->scheduledJobs) {
            $this->scheduledJobs = new ArrayCollection();
        }

        return  $this->scheduledJobs;
    }

    /**
     * @param ArrayCollection $scheduledJobs
     *
     * @return CaseItem
     */
    public function setScheduledJobs(ArrayCollection $scheduledJobs)
    {
        $this->scheduledJobs = $scheduledJobs;

        return $this;
    }

    /**
     * @param ScheduledJob $ScheduledJob
     *
     * @return CaseItem
     */
    public function addScheduledJob(ScheduledJob $scheduledJob)
    {
        if (null === $this->scheduledJobs) {
            $this->scheduledJobs = new ArrayCollection();
        }

        $this->scheduledJobs->add($scheduledJob);

        return $this;

    }

    /**
     * @param ScheduledJob $scheduledJob
     */
    public function removeScheduledJob(ScheduledJob $scheduledJob) {
        $this->scheduledJobs->removeElement($scheduledJob);
    }

    /**
     * Alias
     * @param AssignableComposite $user
     * @return $this|IsAssignable
     * @deprecated
     */
    public function setAssignedUser(AssignableComposite $user = null)
    {
        return $this->assign($user);
    }

    /**
     * Alias
     * @return AssignableComposite
     * @deprecated
     */
    public function getAssignedUser()
    {
        return $this->getAssignee();
    }

    /**
     * @return \DateTime
     */
    public function getRejectedDate()
    {
        return $this->rejectedDate;
    }

    /**
     * @param \DateTime $rejectedDate
     * @return CaseItem
     */
    public function setRejectedDate(\DateTime $rejectedDate = null)
    {
        $this->rejectedDate = $rejectedDate;

        return $this;
    }

    /**
     * @param PaymentType $payment
     * @return CaseItem
     */
    public function addPayment(PaymentType $payment)
    {
        if (null === $this->payments) {
            $this->payments = new ArrayCollection();
        }

        $this->payments->add($payment);

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPayments()
    {
        if (null === $this->payments) {
            $this->payments = new ArrayCollection();
        }

        return $this->payments;
    }
}
