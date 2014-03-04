<?php
namespace Opg\Core\Model\Entity\CaseItem\Task;

use Opg\Common\Model\Entity\EntityInterface;
use Opg\Core\Model\Entity\User\User;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;

/**
 *
 * @package Opg Core
 * @author Chris Moreton
 *
 */
class Task implements EntityInterface, \IteratorAggregate
{
    use \Opg\Common\Model\Entity\Traits\Time;
    use \Opg\Common\Model\Entity\Traits\InputFilter;

    /**
     * @var string $id
     */
    private $id;

    /**
     * @var User
     */
    private $assignedUser;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $priority;
    
    /**
     * @var string
     */
    private $dueDate;

    /**
     * @var string name
     */
    private $name;
    
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
     * @return string $id
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
     * @param string $id
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
    public function setAssignedUser(User $assignedUser)
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
                                    'max'      => 36,
                                )
                            )
                        )
                    )
                )
            );

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'assignedUser',
                        'required'   => false,
                        'validators' => array(
                            array(
                                'name'    => 'Callback',
                                'options' => array(
                                    'callback' => function($value) {
                                            if (!empty($value['username'])) {
                                                return true;
                                            }
                                            return false;
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
                                        'Completed'
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

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    public function toArray() {
        $data = get_object_vars($this);

        if (!empty($data['assignedUser'])) {
            $data['assignedUser'] = $data['assignedUser']->toArray();
        }

        return $data;
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

        if (!empty($data['username'])) {
            $user = new User();
            $user->setUsername($data['username']);
            $this->setAssignedUser($user);
        }
    }
}
