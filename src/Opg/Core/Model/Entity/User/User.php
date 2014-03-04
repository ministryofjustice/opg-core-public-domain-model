<?php
namespace Opg\Core\Model\Entity\User;

use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\IteratorAggregate;
use Opg\Common\Model\Entity\Traits\ToArray;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Opg\Core\Model\Entity\CaseItem\CaseItemCollection;

class User implements EntityInterface, \IteratorAggregate
{

    use ToArray {
        toArray as traitToArray;
    }
    use IteratorAggregate;
    use InputFilterTrait;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $firstname;

    /**
     * @var string
     */
    private $surname;

    /**
     * @var string
     */
    private $realname;

    /**
     * @var string
     */
    private $password;

    /**
     * @var string
     */
    private $token;

    /**
     * @var CaseItemCollection
     */
    private $caseItemCollection;

    /**
     * @var bool
     */
    private $locked;

    /**
     * @var bool
     */
    private $suspended;

    /**
     * @var array
     */
    private $roles = [];

    /**
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
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
     * @return User
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string $realname
     */
    public function getRealname()
    {
        return $this->realname;
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
                        'name'       => 'username',
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
                                    'min'      => 3,
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
                                    'min'      => 3,
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
                                    'min'      => 3,
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
            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @return string $username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return CaseItemCollection
     */
    public function getCaseItemCollection()
    {
        return $this->caseItemCollection;
    }

    /**
     * @param CaseItemCollection $caseItemCollection
     * @return User
     */
    public function setCaseItemCollection(CaseItemCollection $caseItemCollection)
    {
        $this->caseItemCollection = $caseItemCollection;

        return $this;
    }

    /**
     * @param string $realname
     * @return User
     */
    public function setRealname($realname)
    {
        $this->realname = $realname;

        return $this;
    }

    /**
     * @param array $data
     * @return EntityInterface
     */
    public function exchangeArray(array $data)
    {
        if (!empty($data['id'])) {
            $this->setId($data['id']);
        }

        if (!empty($data['username'])) {
            $this->setUsername($data['username']);
        }

        if (!empty($data['email'])) {
            $this->setEmail($data['email']);
        }

        if (!empty($data['realname'])) {
            $this->setRealname($data['realname']);
        }

        if (!empty($data['firstname'])) {
            $this->setFirstname($data['firstname']);
        }

        if (!empty($data['surname'])) {
            $this->setSurname($data['surname']);
        }

        if (!empty($data['password'])) {
            $this->setPassword($data['password']);
        }

        if (!empty($data['locked'])) {
            if ('false' === $data['locked']) {
                $this->setLocked(false);
            } else {
                $this->setLocked($data['locked']);
            }
        }

        if (!empty($data['suspended'])) {
            if ('false' === $data['suspended']) {
                $this->setSuspended(false);
            } else {
                $this->setSuspended($data['suspended']);
            }
        }

        // Expects roles to be a list of role names
        if (!empty($data['roles']) && is_array($data['roles'])) {
            $this->clearRoles();

            foreach ($data['roles'] as $role) {
                $this->addRole($role);
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getArrayCopy()
    {
        $data = get_object_vars($this);

        if (!empty($data['caseItemCollection'])) {
            $data['caseItemCollection'] = $data['caseItemCollection']->getArrayCopy();
        }

        if (!empty($data['roles'])) {
            $data['roles'] = array_keys($data['roles']);
        }

        unset($data['inputFilter']);

        return $data;
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
     * @return array
     */
    public function toArray()
    {
        $baseArray = $this->traitToArray();

        if (!empty($baseArray['caseItemCollection'])) {
            $baseArray['caseItemCollection'] = $baseArray['caseItemCollection']->toArray();
        }

        if (!empty($baseArray['roles'])) {
            $baseArray['roles'] = array_keys($baseArray['roles']);
        }

        return $baseArray;
    }

    /**
     * @param string $roleName
     * @return User $this
     */
    public function addRole($roleName)
    {
        $role               = (string)$roleName;
        $this->roles[$role] = null;

        return $this;
    }

    /**
     * @param string $roleName
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
     * @param bool $bool
     * @return User $this
     */
    public function setLocked($bool) {
        $this->locked = (bool) $bool;

        return $this;
    }

    /**
     * @return bool
     */
    public function isLocked() {
        return $this->locked;
    }

    /**
     * @param bool $bool
     * @return User $this
     */
    public function setSuspended($bool) {
        $this->suspended = (bool) $bool;

        return $this;
    }

    /**
     * @return bool
     */
    public function isSuspended() {
        return $this->suspended;
    }
}

