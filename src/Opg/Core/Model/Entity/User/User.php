<?php
namespace Opg\Core\Model\Entity\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Opg\Common\Model\Entity\Traits\IteratorAggregate;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\ReadOnly;

/**
 * @ORM\Entity
 * @ORM\Table(name = "users")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 */
class User implements EntityInterface, \IteratorAggregate
{
    use ToArray {
        toArray as traitToArray;
    }
    use ExchangeArray {
        exchangeArray as traitExchangeArray;
    }
    use IteratorAggregate;
    use InputFilterTrait;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true}) @ORM\GeneratedValue(strategy = "AUTO") @ORM\Id
     * @var integer
     * @Type("integer")
     * @Groups("api-poa-list")
     */
    protected $id;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Type("string")
     * @Groups("api-poa-list")
     */
    protected $email;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Type("string");
     * @Groups("api-poa-list")
     */
    protected $firstname;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Type("string")
     * @Groups("api-poa-list")
     */
    protected $surname;

    /**
     * @ORM\ManyToMany(targetEntity="Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney")
     * @ORM\JoinTable(name="user_pas",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection
     * @Type("Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney")
     * @Exclude
     * @ReadOnly
     */
    protected $powerOfAttorneys;

    /**
     * @ORM\ManyToMany(targetEntity="Opg\Core\Model\Entity\Deputyship\Deputyship")
     * @ORM\JoinTable(name="user_deputyships",
     *     joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="deputyship_id", referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection
     * @Type("Opg\Core\Model\Entity\Deputyship\Deputyship")
     * @Exclude
     * @ReadOnly
     */
    protected $deputyships;

    /**
     * @ORM\Column(type = "json_array")
     * @var array
     * @Accessor(getter="getNormalisedRoles",setter="setFromNormalisedRoles")
     * @Type("array")
     * @todo change the way this is persisted to a 0 index array
     */
    protected $roles = [];


    // The fields below are NOT persisted.

    /**
     * @var string
     * @Exclude
     * @Type("string")
     */
    protected $password;

    /**
     * @var string
     * @Exclude
     * @Type("string")
     */
    protected $token;

    /**
     * @var boolean
     * @Type("boolean")
     */
    protected $locked;

    /**
     * @param boolean $locked
     *
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
        return $this->locked;
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
        $this->deputyships      = new ArrayCollection();
        $this->powerOfAttorneys = new ArrayCollection();
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
        return $this->firstname;
    }

    /**
     * @param string $firstname
     *
     * @return User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
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
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     *
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * @param bool $exposeClassname
     *
     * @return array
     */
    public function toArray($exposeClassname = false)
    {
        $baseArray = $this->traitToArray($exposeClassname);

        if (!empty($baseArray['roles'])) {
            $baseArray['roles'] = array_keys($baseArray['roles']);
        }

        return $baseArray;
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
     * @param \Opg\Core\Model\Entity\CaseItem\CaseItem
     *
     * @return $this
     */
    public function addCase(CaseItem $case)
    {
        if ($case instanceof PowerOfAttorney) {
            $this->powerOfAttorneys->add($case);
        } else {
            $this->deputyships->add($case);
        }

        return $this;
    }

    /**
     * @param ArrayCollection $cases
     *
     * @return $this
     */
    public function setPowerOfAttorneys(ArrayCollection $cases)
    {
        foreach ($cases as $case) {
            $this->addCase($case);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPowerOfAttorneys()
    {
        return $this->powerOfAttorneys;
    }

    /**
     * @param ArrayCollection $cases
     *
     * @return $this
     */
    public function setDeputyships(ArrayCollection $cases)
    {
        foreach ($cases as $case) {
            $this->addCase($case);
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getDeputyships()
    {
        return $this->deputyships;
    }

    /**
     * @param array $data
     *
     * @return User $this
     */
    public function exchangeArray(array $data)
    {
        $this->traitExchangeArray($data);

        if (isset($data['roles'])) {
            $this->setRoles($data['roles']);
        }

        return $this;
    }
}
