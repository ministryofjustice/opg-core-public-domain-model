<?php
namespace Opg\Core\Model\Entity\PhoneNumber;

use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Opg\Common\Model\Entity\Traits\IteratorAggregate;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\Person\Person;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity
 * @ORM\Table(name = "phonenumbers")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 * @ORM\entity(repositoryClass="Application\Model\Repository\PhoneNumberRepository")
 *
 * Class PhoneNumber
 * @package Opg\Core\Model\Entity\PhoneNumber
 */
class PhoneNumber implements EntityInterface, \IteratorAggregate
{
    use ToArray;
    use IteratorAggregate;
    use InputFilterTrait;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true}) @ORM\GeneratedValue(strategy = "AUTO") @ORM\Id
     * @var integer
     * @Groups({"api-person-get"})
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Opg\Core\Model\Entity\Person\Person", inversedBy="phoneNumbers")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     * @var \Opg\Core\Model\Entity\Person\Person
     * @Groups({"api-person-get"})
     */
    protected $person;

    /**
     * @ORM\Column(type = "string", name="phone_number", nullable=true)
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $phoneNumber;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $type = 'Work';

    /**
     * @ORM\Column(type = "boolean", name="is_default")
     * @var boolean
     * @Groups({"api-person-get"})
     */
    protected $default = false;

    /**
     * @param boolean $default
     *
     * @return PhoneNumber
     */
    public function setDefault($default = true)
    {
        $this->default = (bool)$default;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getDefault()
    {
        return (bool)$this->default;
    }

    /**
     * @param integer $id
     *
     * @return PhoneNumber
     */
    public function setId($id)
    {
        $this->id = (int)$id;

        return $this;
    }

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $person
     *
     * @throws \LogicException
     * @return PhoneNumber
     */
    public function setPerson(Person $person)
    {
        if ($this->person !== null && $this->person->getId() != $person->getId()) {
            throw new \LogicException('This phone number is already linked to a person');
        }
        $this->person = $person;

        return $this;
    }

    /**
     * @return Person
     */
    public function getPerson()
    {
        return $this->person;
    }

    /**
     * @param string $phoneNumber
     *
     * @return PhoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $type
     *
     * @return PhoneNumber
     */
    public function setType($type)
    {
        $this->type = $type;

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
     * @return InputFilterTrait|\Zend\InputFilter\InputFilter|\Zend\InputFilter\InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $this->inputFilter = new \Zend\InputFilter\InputFilter();
        }

        return $this->inputFilter;
    }
}
