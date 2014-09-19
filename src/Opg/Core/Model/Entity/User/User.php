<?php
namespace Opg\Core\Model\Entity\User;

use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Opg\Common\Model\Entity\Traits\IteratorAggregate;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Type;
use Opg\Core\Model\Entity\Assignable\AssignableComposite;
use Opg\Core\Model\Entity\Assignable\IsAssignee;

/**
 * @ORM\Entity
 * @ORM\EntityListeners({"Application\Listener\UserListener"})
 */
class User extends AssignableComposite implements EntityInterface, IsAssignee
{
    use IteratorAggregate;
    use InputFilterTrait;


    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups({"api-poa-list","api-task-list","api-get-person"})
     */
    protected $email;

    /**
     * Non persisted entity, is an alias of $name
     * @var string
     * @Type("string")
     * @Groups({"api-poa-list","api-task-list","api-get-person"})
     * @Accessor(getter="getFirstName", setter="setFirstname")
     */
    protected $firstname;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups({"api-poa-list","api-task-list","api-get-person"})
     */
    protected $surname;

    /**
     * @ORM\Column(type = "json_array")
     * @var array
     * @Accessor(getter="getNormalisedRoles",setter="setFromNormalisedRoles")
     * @todo change the way this is persisted to a 0 index array
     */
    protected $roles = [];


    // The fields below are NOT persisted.

    /**
     * @var string
     * @Exclude
     */
    protected $password;

    /**
     * @var string
     * @Exclude
     * @Groups({"api-poa-list","api-task-list","api-get-person"})
     */
    protected $token;

    /**
     * @Type("boolean")
     * @var boolean
     * @Groups({"api-poa-list","api-task-list","api-get-person"})
     * @Accessor(getter="getLocked", setter="setLocked")
     */
    protected $locked;

    /**
     * @param boolean $locked
     * @return User
     */
    public function setLocked($locked)
    {
        $this->locked = (bool)$locked;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getLocked()
    {
        return (bool)$this->locked;
    }

    /**
     * Alias for getLocked
     * @return bool
     */
    public function isLocked()
    {
        return $this->getLocked();
    }

    /**
     * @param mixed $suspended
     *
     * @return User
     */
    public function setSuspended($suspended)
    {
        $this->suspended = (bool)$suspended;

        return $this;
    }

    /**
     * @return bool
     */
    public function getSuspended()
    {
        return $this->suspended;
    }

    /**
     * @return bool
     */
    public function isSuspended()
    {
        return $this->getSuspended();
    }

    /**
     * @ORM\Column(type = "boolean", options={"default":0})
     * @var boolean
     * @Type("boolean")
     */
    protected $suspended;

    public function __construct()
    {
        $this->setLocked(false);
        $this->setSuspended(false);
    }

    /**
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string $firstname
     */
    public function getFirstname()
    {
        return $this->getName();
    }

    /**
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
        return $this->setName($firstname);
    }

    /**
     * @return string $surname
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     *
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return \Zend\InputFilter\InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();


            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'firstname',
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
                                    'min'      => 1,
                                    'max'      => 128,
                                ),
                            )
                        )
                    )
                )
            );
            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'surname',
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
                                    'min'      => 1,
                                    'max'      => 128,
                                ),
                            )
                        )
                    )
                )
            );
            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'email',
                        'required'   => true,
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name' => 'EmailAddress'
                            )
                        )
                    )
                )
            );
            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'password',
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
                                    'min'      => 8,
                                    'max'      => 24,
                                ),
                            )
                        )
                    )
                )
            );
            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'passwordConfirmation',
                        'required'   => true,
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name'    => 'Identical',
                                'options' => array(
                                    'messages' => array(
                                        \Zend\Validator\Identical::NOT_SAME => 'Passwords do not match'
                                    ),
                                    'token' => 'password',
                                ),
                            ),
                        )
                    )
                )
            );
            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'roles',
                        'required'   => true,
                        'validators' => array(
                            array(
                                'name'    => 'Callback',
                                'options' => array(
                                    'messages' => array(
                                        \Zend\Validator\Callback::INVALID_VALUE => 'The user must either be an OPG user or a COP user.',
                                    ),
                                    'callback' => function ($roles) {
                                            $keyedRoles = array_flip($roles);

                                            return (array_key_exists('OPG User', $keyedRoles) xor
                                                array_key_exists('COP User', $keyedRoles));
                                        }
                                ),
                            ),
                        )
                    )
                )
            );
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = (string)$password;

        return $this;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     *
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = (string)$token;

        return $this;
    }

    /**
     * @param string $roleName
     *
     * @return User $this
     */
    public function addRole($roleName)
    {
        $role               = (string)$roleName;
        $this->roles[$role] = $roleName;

        return $this;
    }

    /**
     * @param array $roles
     *
     * @return User $this
     */
    public function setRoles(array $roles)
    {
        $this->clearRoles();

        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }

    /**
     * @param string $roleName
     *
     * @return User $this
     */
    public function removeRole($roleName)
    {
        $role = (string)$roleName;

        if ($this->hasRole($role)) {
            unset($this->roles[$role]);
        }

        return $this;
    }

    /**
     * @param string $roleName
     *
     * @return bool
     */
    public function hasRole($roleName)
    {
        $role = (string)$roleName;

        return array_key_exists($role, $this->roles);
    }

    /**
     * @return User $this
     */
    public function clearRoles()
    {
        $this->roles = [];

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @return array
     */
    public function getNormalisedRoles()
    {
        return array_values($this->roles);
    }

    /**
     * @param array $roles
     *
     * @return User
     */
    public function setFromNormalisedRoles(array $roles)
    {
        $this->clearRoles();

        foreach ($roles as $role) {
            $this->addRole($role);
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return sprintf('%s %s', $this->getFirstname(), $this->getSurname());
    }
}
