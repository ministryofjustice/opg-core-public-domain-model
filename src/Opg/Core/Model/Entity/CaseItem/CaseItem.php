<?php
namespace Opg\Core\Model\Entity\CaseItem;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

use Opg\Common\Filter\BaseInputFilter;
use Opg\Common\Model\Entity\HasRagRating;
use Opg\Common\Model\Entity\Traits\DateTimeAccessor;
use Opg\Common\Model\Entity\Traits\HasDocuments;
use Opg\Common\Model\Entity\Traits\HasTasks;
use Opg\Common\Model\Entity\Traits\InputFilter;
use Opg\Common\Model\Entity\Traits\HasNotes;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Common\Model\Entity\Traits\UniqueIdentifier;
use Opg\Core\Model\Entity\Assignable\AssignableComposite;
use Opg\Core\Model\Entity\Assignable\Assignee;
use Opg\Core\Model\Entity\Assignable\IsAssignable;
use Opg\Core\Model\Entity\CaseItem\Validation\InputFilter\CaseItemFilter;
use Opg\Core\Model\Entity\LegalEntity\LegalEntity;
use Opg\Core\Model\Entity\Payment\PaymentType;
use Opg\Core\Model\Entity\CaseActor\Person;
use Opg\Core\Model\Entity\Queue as ScheduledJob;

use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\GenericAccessor;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Type;

use Opg\Core\Validation\InputFilter\IdentifierFilter;
use Opg\Core\Validation\InputFilter\UidFilter;

/**
 * @ORM\Entity
 * @ORM\Table(name = "cases")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 * "lpa" = "Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Lpa",
 * "epa" = "Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Epa",
 * "poa" = "Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\PowerOfAttorney",
 * "dep" = "Opg\Core\Model\Entity\CaseItem\Deputyship\Deputyship",
 * "order" = "Opg\Core\Model\Entity\CaseItem\Deputyship\Order",
 * })
 * @ORM\entity(repositoryClass="Application\Model\Repository\CaseItemRepository")
 */
abstract class CaseItem extends LegalEntity implements CaseItemInterface, HasRagRating, IsAssignable
{
    use Assignee;

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
     * @ORM\Column(type = "integer", nullable=true)
     * @var int
     * @Type("integer")
     * @Serializer\Groups({"api-case-list","api-task-list","api-person-get"})
     */
    protected $oldCaseId;

    /**
     * @ORM\Column(type = "integer", nullable=true)
     * @var int
     * @Type("integer")
     * @Accessor(getter="getApplicationType",setter="setApplicationType")
     * @Serializer\Groups({"api-case-list","api-task-list","api-person-get"})
     */
    protected $applicationType = self::APPLICATION_TYPE_CLASSIC;
    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string $title
     * @Type("string")
     * @Serializer\Groups({"api-case-list","api-task-list","api-person-get"})
     */
    protected $title;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Serializer\Groups({"api-case-list","api-task-list","api-person-get"})
     * @Accessor(getter="getCaseType", setter="setCaseType")
     */
    protected $caseType;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Serializer\Groups({"api-case-list","api-task-list","api-person-get"})
     */
    protected $caseSubtype;

    /**
     * @ORM\Column(type = "date", nullable = true)
     * @var \DateTime
     * @Type("string")
     * @Serializer\Groups({"api-case-list","api-task-list","api-person-get"})
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="dueDate")
     */
    protected $dueDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Serializer\Groups({"api-case-list","api-task-list","api-person-get"})
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="registrationDate")
     */
    protected $registrationDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Serializer\Groups({"api-case-list","api-task-list","api-person-get"})
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="closedDate")
     */
    protected $closedDate;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Serializer\Groups({"api-case-list","api-task-list","api-person-get"})
     */
    protected $status;

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
     * @Serializer\Groups({"api-case-list","api-person-get"})
     */
    protected $ragRating;

    /**
     * Non persistable entity
     * @var int
     * @ReadOnly
     * @Accessor(getter="getRagTotal")
     * @Serializer\Groups({"api-case-list","api-person-get"})
     */
    protected $ragTotal;

    /**
     * @ORM\Column(type = "datetime", nullable = true)
     * @var \DateTime
     * @Type("string")
     * @Serializer\Groups({"api-case-list","api-task-list","api-person-get"})
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

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Groups({"api-person-get"})
     */
    protected $caseAttorneySingular = false;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Groups({"api-person-get"})
     */
    protected $caseAttorneyJointlyAndSeverally = false;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Groups({"api-person-get"})
     */
    protected $caseAttorneyJointly = false;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Groups({"api-person-get"})
     */
    protected $caseAttorneyJointlyAndJointlyAndSeverally = false;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Groups({"api-person-get"})
     */
    protected $caseAttorneyActionAdditionalInfo = false;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Groups({"api-person-get","api-case-list"})
     */
    protected $repeatApplication = false;

    /**
     * @ORM\Column(type="string",nullable=true)
     * @var string
     * @Groups({"api-person-get","api-case-list"})
     */
    protected $repeatApplicationReference;

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
     * @return BaseInputFilter
     */
    public function getInputFilter()
    {
        $this->inputFilter = new BaseInputFilter();

        $this->inputFilter->merge(new CaseItemFilter());
        $this->inputFilter->merge(new UidFilter());
        $this->inputFilter->merge(new IdentifierFilter());

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

    /**
     * @param boolean $caseAttorney
     *
     * @return PowerOfAttorney
     */
    public function setCaseAttorneyJointly($caseAttorney = false)
    {
        $this->caseAttorneyJointly = $caseAttorney;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getCaseAttorneyJointly()
    {
        return $this->caseAttorneyJointly;
    }

    /**
     * @param boolean $caseAttorney
     *
     * @return CaseItem
     */
    public function setCaseAttorneyJointlyAndJointlyAndSeverally($caseAttorney = false)
    {
        $this->caseAttorneyJointlyAndJointlyAndSeverally = $caseAttorney;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getCaseAttorneyJointlyAndJointlyAndSeverally()
    {
        return $this->caseAttorneyJointlyAndJointlyAndSeverally;
    }

    /**
     * @param boolean $caseAttorney
     *
     * @return CaseItem
     */
    public function setCaseAttorneyJointlyAndSeverally($caseAttorney = false)
    {
        $this->caseAttorneyJointlyAndSeverally = $caseAttorney;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getCaseAttorneyJointlyAndSeverally()
    {
        return $this->caseAttorneyJointlyAndSeverally;
    }

    /**
     * @param boolean $caseAttorney
     *
     * @return CaseItem
     */
    public function setCaseAttorneySingular($caseAttorney = false)
    {
        $this->caseAttorneySingular = $caseAttorney;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getCaseAttorneySingular()
    {
        return $this->caseAttorneySingular;
    }

    /**
     * @param bool $caseAttorney
     * @return CaseItem
     */
    public function setCaseAttorneyActionAdditionalInfo($caseAttorney = false)
    {
        $this->caseAttorneyActionAdditionalInfo = $caseAttorney;

        return $this;
    }

    /**
     * @return bool
     */
    public function getCaseAttorneyActionAdditionalInfo()
    {
        return $this->caseAttorneyActionAdditionalInfo;
    }

    /**
     * @param bool $repeatApplication
     * @return CaseItem
     */
    public function setRepeatApplication($repeatApplication = false)
    {
        $this->repeatApplication = $repeatApplication;

        return $this;
    }

    /**
     * @return bool
     */
    public function getRepeatApplication()
    {
        return $this->repeatApplication;
    }

    /**
     * @return bool
     */
    public function isRepeatApplication()
    {
        return (true === $this->getRepeatApplication());
    }

    /**
     * @param $reference
     * @return CaseItem
     */
    public function setRepeatApplicationReference($reference)
    {
        $this->repeatApplicationReference = $reference;

        return $this;
    }

    /**
     * @return string
     */
    public function getRepeatApplicationReference()
    {
        return $this->repeatApplicationReference;
    }

    /**
     * @return Person
     */
    abstract public function getPrimaryActor();
}
