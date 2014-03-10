<?php
namespace Opg\Core\Model\Entity\CaseItem\Task;

use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Core\Model\Entity\User\User;
use \Zend\InputFilter\InputFilter;
use \Zend\InputFilter\Factory as InputFactory;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Type;
use Opg\Core\Model\Entity\CaseItem\CaseItem;

/**
 * @ORM\Entity
 * @ORM\Table(name = "tasks")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @package Opg Core
 * @author Chris Moreton
 *
 */
class Task implements EntityInterface, \IteratorAggregate
{
    use \Opg\Common\Model\Entity\Traits\Time;
    use \Opg\Common\Model\Entity\Traits\InputFilter;
    use ToArray;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true}) @ORM\GeneratedValue(strategy = "AUTO") @ORM\Id
     * @var int $id
     * @Type("integer")
     */
    protected $id;

    /**
     * @Serializer\MaxDepth(2)
     * @ORM\ManyToOne(targetEntity = "Opg\Core\Model\Entity\User\User", fetch="EAGER")
     * @var User
     * @Type("Opg\Core\Model\Entity\User\User")
     */
    protected $assignedUser;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     */
    protected $status;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     */
    protected $priority;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     */
    protected $dueDate;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string name
     * @Type("string")
     */
    protected $name;

    /**
     * Non persistable entity, used for validation of create;
     * @var CaseItem case
     */
    protected $case;

    public function __construct()
    {
        $now = new \DateTime();
        $this->setCreatedTime($now->format('Y-m-d\Th:i:s'));
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
     * @return string $dueDate
     */
    public function getDueDate()
    {
        return $this->dueDate;
    }

    /**
     * @param string $dueDate
     * @return Task
     */
    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
        return $this;
    }

    /**
     * @param string $priority
     * @return Task
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }

    /**
     * @param string $name
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
    public function getAssignedUser()
    {
        return $this->assignedUser;
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
     * @return Task
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param User $assignedUser
     * @return Task
     */
    public function setAssignedUser(User $assignedUser = null)
    {
        $this->assignedUser = $assignedUser;
        return $this;
    }

    /**
     * @param string $status
     * @return Task
     */
    public function setStatus($status)
    {
        $this->status = $status;
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
                                'name'    => 'Digits',
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
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name'    => 'Date'
                            ),
                            array(
                                'name'   => 'Callback',
                                'options' => array(
                                    'messages' => array(
                                     \Zend\Validator\Callback::INVALID_VALUE => 'The due date cannot be in the past',
                                    ),
                                    'callback' => function($value, $context = array()) {

                                        $dueDate = \DateTime::createFromFormat('Y-m-d', $value);
                                        $now = new \DateTime();

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
                                'name'    => 'NotEmpty',
                            )
                        )
                    )
                )
            );

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    public function exchangeArray(array $data) {
        if (!empty($data['id'])) {
            $this->setId($data['id']);
        }

        if (!empty($data['name'])) {
            $this->setName($data['name']);
        }

        if (!empty($data['dueDate'])) {
            $this->setDueDate($data['dueDate']);
        }

        if (!empty($data['priority'])) {
            $this->setPriority($data['priority']);
        }

        if (!empty($data['status'])) {
            $this->setStatus($data['status']);
        }

        if (!empty($data['createdTime'])) {
            $this->setCreatedTime($data['createdTime']);
        }

        if (!empty($data['assignedUser'])) {
            $user = new User();
            $user = $user->exchangeArray($data['assignedUser']);
            $this->setAssignedUser($user);
        }

        return $this;
    }

    /**
     * @param CaseItem $case
     * @return Task
     */
    public function setCase(CaseItem $case)
    {
        $this->case = $case;
        return $this;
    }
}
