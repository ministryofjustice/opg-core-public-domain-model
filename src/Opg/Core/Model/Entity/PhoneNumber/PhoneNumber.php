<?php
namespace Opg\Core\Model\Entity\PhoneNumber;

use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\HasIdInterface;
use Opg\Common\Model\Entity\Traits\HasId;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Opg\Common\Model\Entity\Traits\IteratorAggregate;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseActor\Person;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Type;

/**
 * @ORM\Entity
 * @ORM\Table(name = "phonenumbers")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 * @ORM\entity(repositoryClass="Application\Model\Repository\PhoneNumberRepository")
 *
 * Class PhoneNumber
 * @package Opg\Core\Model\Entity\PhoneNumber
 */
class PhoneNumber implements EntityInterface, \IteratorAggregate, HasIdInterface
{
    use ToArray;
    use IteratorAggregate;
    use InputFilterTrait;
    use HasId;

    /**
     * @ORM\ManyToOne(targetEntity="Opg\Core\Model\Entity\CaseActor\Person", inversedBy="phoneNumbers")
     * @ORM\JoinColumn(name="person_id", referencedColumnName="id")
     * @var \Opg\Core\Model\Entity\CaseActor\Person
     * @Groups({"api-person-get"})
     * @Type("Opg\Core\Model\Entity\CaseActor\Person")
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
        $this->phoneNumber = preg_replace('/[^\d]/', '', $phoneNumber);

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
