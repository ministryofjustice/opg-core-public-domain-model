<?php
namespace Opg\Core\Model\Entity\CaseItem\Task;

use Opg\Common\Model\Entity\HasRagRating;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Core\Model\Entity\Assignable\AssignableComposite;
use Opg\Core\Model\Entity\Assignable\IsAssignable;
use Opg\Core\Model\Entity\Assignable\NullEntity;
use Opg\Core\Model\Entity\User\User;
use \Zend\InputFilter\InputFilter;
use \Zend\InputFilter\Factory as InputFactory;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Type;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

use Opg\Core\Model\Entity\CaseItem\CaseItem;

/**
 * @ORM\Entity
 * @ORM\EntityListeners({"BusinessRule\Specification\Task\Listener"})
 * @ORM\Table(name = "tasks")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 * @ORM\entity(repositoryClass="Application\Model\Repository\TaskRepository")
 *
 * @package Opg Core
 * @author  Chris Moreton
 *
 */
class Task implements EntityInterface, \IteratorAggregate, HasRagRating, IsAssignable
{

    const STATUS_COMPLETED = 'completed';

    use \Opg\Common\Model\Entity\Traits\Time;
    use \Opg\Common\Model\Entity\Traits\InputFilter;
    use ToArray;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true}) @ORM\GeneratedValue(strategy = "AUTO") @ORM\Id
     * @var int $id
     * @Groups({"api-poa-list","api-task-list"})
     */
    protected $id;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups({"api-poa-list","api-task-list"})
     */
    protected $type;

    /**
     * @ORM\Column(type = "integer", nullable = true)
     * @var int
     */
    protected $systemType;

    /**
     * @ORM\ManyToOne(
     *      cascade={"persist"},
     *      targetEntity = "Opg\Core\Model\Entity\Assignable\AssignableComposite",
     *      fetch = "EAGER"
     * )
     * @Serializer\MaxDepth(2)
     * @Type("Opg\Core\Model\Entity\Assignable\AssignableComposite")
     * @var User
     * @Groups({"api-poa-list","api-task-list"})
     */
    protected $assignee;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups({"api-poa-list","api-task-list"})
     * @Accessor(getter="getStatus",setter="setStatus")
     */
    protected $status;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups({"api-poa-list","api-task-list"})
     */
    protected $priority;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Accessor(getter="getDueDateString",setter="setDueDateString")
     * @Type("string")
     * @Groups({"api-poa-list","api-task-list"})
     */
    protected $dueDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Accessor(getter="getActiveDateString",setter="setActiveDateString")
     * @Type("string")
     * @Groups({"api-poa-list","api-task-list"})
     */
    protected $activeDate;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string name
     * @Groups({"api-poa-list","api-task-list"})
     */
    protected $name;

    /**
     * @ORM\Column(type = "text", nullable = true)
     * @var string description
     * @Groups({"api-poa-list","api-task-list"})
     */
    protected $description;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getCompletedDateString",setter="setCompletedDateString")
     */
    protected $completedDate;

    /**
     * Non persistable entity, used for validation of create
     *
     * @var CaseItem case
     * @Groups({"api-poa-list","api-task-list"})
     */
    protected $case;

    /**
     * Non persistable entity
     *
     * @var int
     * @Groups({"api-poa-list","api-task-list"})
     * @ReadOnly
     * @Accessor(getter="getRagRating")
     */
    protected $ragRating;

    public function __construct()
    {
        $this->setCreatedTime();
    }

    public function getIterator()
    {
        return new \RecursiveArrayIterator($this->toArray());
    }

    /**
     * @return string $priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param \DateTime $dueDate
     *
     * @return Task
     */
    public function setDueDate(\DateTime $dueDate = null)
    {
        if (is_null($dueDate)) {
            $dueDate = new \DateTime();
        }
        $this->dueDate = $dueDate;

        return $this;
    }

    /**
     * @param string $dueDate
     *
     * @return Task
     */
    public function setDueDateString($dueDate)
    {
        if (!empty($dueDate)) {
            $dueDate = OPGDateFormat::createDateTime($dueDate . ' 23:59:59');

            if ($dueDate) {
                $this->setDueDate($dueDate);
            }
        }

        return $this;
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
            return $this->getDueDate()->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @param \DateTime $activeDate
     *
     * @return Task
     */
    public function setActiveDate(\DateTime $activeDate = null)
    {
        if (is_null($activeDate)) {
            $activeDate = OPGDateFormat::createDateTime(date(OPGDateFormat::getDateFormat().' 00:00:00'));
        }
        $this->activeDate = $activeDate;

        return $this;
    }

    /**
     * @param string $activeDate
     *
     * @return Task
     */
    public function setActiveDateString($activeDate)
    {
        if (!empty($activeDate)) {
            $activeDate = OPGDateFormat::createDateTime($activeDate . ' 00:00:00');
            return $this->setActiveDate($activeDate);
        }

        return $this->setActiveDate();
    }

    /**
     * @return \DateTime $activeDate
     */
    public function getActiveDate()
    {
        return $this->activeDate;
    }

    /**
     * @return string
     */
    public function getActiveDateString()
    {
        if (!empty($this->activeDate)) {
            return $this->getActiveDate()->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @param string $priority
     *
     * @return Task
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @param string $name
     *
     * @return Task
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return User $assignedUser
     */
    public function getAssignee()
    {
        return $this->assignee;
    }

    /**
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $id
     *
     * @return Task
     */
    public function setId($id)
    {
        $this->id = (int)$id;

        return $this;
    }

    /**
     * @param AssignableComposite $assignee
     * @return IsAssignable
     */
    public function assign(AssignableComposite $assignee)
    {
        $this->assignee = $assignee;
//        $this->assignee->addTask($this);

        return $this;
    }

    /**
     * @return bool
     */
    public function isAssigned()
    {
        return (null !== $this->assignee);
    }

    /**
     * @param string $status
     *
     * @return Task
     */
    public function setStatus($status)
    {
        $this->status = $status;
        if((strtolower($this->status)) == self::STATUS_COMPLETED) {
            $this->setCompletedDate(new \DateTime());
        }

        return $this;
    }

    /**
     * @return InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'id',
                        'required'   => false,
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'Digits',
                            )
                        )
                    )
                )
            );

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'name',
                        'required'   => true,
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name'    => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min'      => 5,
                                    'max'      => 24,
                                )
                            )
                        )
                    )
                )
            );

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'status',
                        'required'   => true,
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name'    => 'InArray',
                                'options' => array(
                                    'haystack' => array(
                                        'Incomplete',
                                        'Not Started',
                                        'In Progress',
                                        'Completed',
                                        'Pending Input',
                                        'Deferred'
                                    )
                                )
                            )
                        )
                    )
                )
            );

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'dueDate',
                        'required'   => true,
                        'validators' => array(
                            array(
                                'name' => 'Date'
                            ),
                            array(
                                'name'    => 'Callback',
                                'options' => array(
                                    'messages' => array(
                                        \Zend\Validator\Callback::INVALID_VALUE => 'The due date cannot be in the past',
                                    ),
                                    'callback' => function ($value, $context = array()) {
                                            $dueDate = $value;
                                            $now     = new \DateTime();

                                            return $now <= $dueDate;
                                        }
                                )
                            )
                        )
                    )
                )
            );

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'case',
                        'required'   => true,
                        'validators' => array(
                            array(
                                'name' => 'NotEmpty',
                            )
                        )
                    )
                )
            );

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @param CaseItem $case
     *
     * @return Task
     */
    public function setCase(CaseItem $case)
    {
        $this->case = $case;

        return $this;
    }

    /**
     * @return CaseItem | null
     */
    public function getCase()
    {
        return $this->case;
    }

    /**
     * @return int
     */
    public function getRagRating()
    {
        if(isset($this->dueDate)) {
            $dateDiff = $this->getDueDate()->diff(new \DateTime);

            $daysOffset = $dateDiff->days;
            if ($dateDiff->invert == 1) {
                $daysOffset *= -1;
            }

            if ($daysOffset > 0) {
                return 3;
            } elseif ($daysOffset < 0) {
                return 1;
            }

            return 2;
        }
        else {
            //Something has gone wrong here, we have no due date, flag it
            return 3;
        }
    }

    /**
     * @param string $description
     *
     * @return Task
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $type
     *
     * @return Task
     */
    public function setType($type)
    {
        $this->type = (string) $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param int $systemType
     *
     * @return Task
     */
    public function setSystemType($systemType)
    {
        $this->systemType = (int) $systemType;

        return $this;
    }

    /**
     * @return int
     */
    public function getSystemType()
    {
        return $this->systemType;
    }

    /**
     * @param \DateTime $completedDate
     *
     * @return $this
     */
    public function setCompletedDate(\DateTime $completedDate = null)
    {
        if (is_null($completedDate)) {
            $completedDate = new \DateTime();
        }
        $this->completedDate = $completedDate;

        return $this;
    }

    /**
     * @param string $completedDate
     *
     * @return $this
     */
    public function setCompletedDateString($completedDate)
    {
        if (!empty($completedDate)) {
            $completedDate = OPGDateFormat::createDateTime($completedDate);
            return $this->setCompletedDate($completedDate);
        }
        return $this->setCompletedDate(new \DateTime());
    }

    /**
     * @return string
     */
    public function getCompletedDate()
    {
        return $this->completedDate;
    }

    /**
     * @return string
     */
    public function getCompletedDateString()
    {
        if (!empty($this->completedDate)) {
            return $this->completedDate->format(OPGDateFormat::getDateTimeFormat());
        }

        return '';
    }

    /**
     * Alias
     * @param AssignableComposite $user
     * @return $this|IsAssignable
     * @deprecated
     */
    public function setAssignedUser(AssignableComposite $user = null)
    {
        if (null === $user) {
            $user = new NullEntity();
        }

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
}
