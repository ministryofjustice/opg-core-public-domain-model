<?php

namespace Opg\Core\Model\Entity\CaseActor;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Util\ClassUtils;
use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Filter\BaseInputFilter;
use Opg\Common\Model\Entity\HasCasesInterface;
use Opg\Common\Model\Entity\Traits\HasCases;
use Opg\Common\Model\Entity\Traits\HasDocuments;
use Opg\Common\Model\Entity\Traits\HasNotes as HasNotesTrait;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Opg\Common\Model\Entity\Traits\UniqueIdentifier;
use Opg\Core\Model\Entity\Address\Address;
use Opg\Core\Model\Entity\PhoneNumber\PhoneNumber;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use Opg\Core\Model\Entity\Warning\Warning;
use Opg\Core\Model\Entity\LegalEntity\LegalEntity;
use Opg\Core\Validation\InputFilter\IdentifierFilter;
use Opg\Core\Validation\InputFilter\UidFilter;
use Zend\InputFilter\InputFilterInterface;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * @ORM\Entity
 * @ORM\Table(name = "persons")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "lpa_attorney" = "Opg\Core\Model\Entity\CaseActor\Attorney",
 *     "lpa_replacement_attorney" = "Opg\Core\Model\Entity\CaseActor\ReplacementAttorney",
 *     "lpa_trust_corporation" = "Opg\Core\Model\Entity\CaseActor\TrustCorporation",
 *     "lpa_correspondent" = "Opg\Core\Model\Entity\CaseActor\Correspondent",
 *     "lpa_donor" = "Opg\Core\Model\Entity\CaseActor\Donor",
 *     "lpa_notified_person" = "Opg\Core\Model\Entity\CaseActor\NotifiedPerson",
 *     "lpa_certificate_provider" = "Opg\Core\Model\Entity\CaseActor\CertificateProvider",
 *     "actor_non_case_contact" = "Opg\Core\Model\Entity\CaseActor\NonCaseContact",
 *     "actor_notified_relative" = "Opg\Core\Model\Entity\CaseActor\NotifiedRelative",
 *     "actor_notified_attorney" = "Opg\Core\Model\Entity\CaseActor\NotifiedAttorney",
 *     "actor_notified_donor" = "Opg\Core\Model\Entity\CaseActor\PersonNotifyDonor"
 *     "actor_client" = "Opg\Core\Model\Entity\CaseActor\Client"
 *     "actor_deputy" = "Opg\Core\Model\Entity\CaseActor\Deputy"
 *     "actor_fee_payer" = "Opg\Core\Model\Entity\CaseActor\FeePayer"
 * })
 * @ORM\entity(repositoryClass="Application\Model\Repository\PersonRepository")
 */
abstract class Person extends LegalEntity implements HasCasesInterface
{
    use HasCases;

    /**
     * Constants below are for yes/no radio buttons, we use 0
     * as default
     */
    const OPTION_NOT_SET = 0;
    const OPTION_FALSE   = 1;
    const OPTION_TRUE    = 2;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups({"api-poa-list","api-task-list","api-person-get","api-warning-list"})
     */
    protected $email;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Accessor(getter="getDobString",setter="setDobString")
     * @Type("string")
     * @Groups({"api-poa-list","api-task-list","api-person-get","api-warning-list"})
     */
    protected $dob;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Accessor(getter="getDateOfDeathString",setter="setDateOfDeathString")
     * @Type("string")
     * @Groups({"api-poa-list","api-task-list","api-person-get","api-warning-list"})
     */
    protected $dateOfDeath;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups({"api-poa-list","api-task-list","api-person-get","api-warning-list"})
     * @Accessor(getter="getTitle",setter="setTitle")
     */
    protected $salutation;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups({"api-poa-list","api-task-list","api-person-get","api-warning-list"})
     */
    protected $firstname;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups({"api-poa-list","api-task-list","api-person-get","api-warning-list"})
     */
    protected $middlenames;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups({"api-poa-list","api-task-list","api-person-get","api-warning-list"})
     */
    protected $surname;

    /**
     * @ORM\OneToMany(targetEntity="Opg\Core\Model\Entity\Address\Address", mappedBy="person", cascade={"persist", "remove"}, fetch="EAGER")
     * @ORM\OrderBy({"id"="ASC"})
     * @var \Opg\Core\Model\Entity\Address\Address
     * @Groups({"api-person-get"})
     */
    protected $addresses;

    /**
     * @ORM\OneToMany(targetEntity="Opg\Core\Model\Entity\PhoneNumber\PhoneNumber", mappedBy="person",cascade={"persist", "remove"}, fetch="EAGER")
     * @ORM\OrderBy({"id"="ASC"})
     * @var ArrayCollection
     * @Groups({"api-person-get"})
     */
    protected $phoneNumbers;

    /**
     * @ORM\ManyToOne(targetEntity = "Person", inversedBy = "children", cascade={"persist", "remove"})
     * @Groups({"api-person-get"})
     * @Type("Opg\Core\Model\Entity\CaseActor\Person")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity = "Person", mappedBy = "parent", cascade={"persist", "remove"})
     * @ORM\OrderBy({"id"="ASC"})
     * @Type("ArrayCollection<Opg\Core\Model\Entity\CaseActor\Person>")
     * @ReadOnly
     * @Groups({"api-person-get"})
     */
    protected $children;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups({"api-person-get","api-warning-list"})
     */
    protected $occupation;

    public function __construct()
    {
        $this->addresses        = new ArrayCollection();
        $this->phoneNumbers     = new ArrayCollection();
        $this->notes            = new ArrayCollection();
        $this->tasks            = new ArrayCollection();
        $this->documents        = new ArrayCollection();
        $this->children         = new ArrayCollection();
        $this->warnings         = new ArrayCollection();
        $this->cases            = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param Person $person
     * @throws \LogicException
     */
    public function addChild(Person $person)
    {
        if (get_class($person) !== ClassUtils::getRealClass(get_class($this))) {
            throw new \LogicException('Parent child relationships can only be defined on the same type of person');
        }

        if ($person === $this) {
            throw new \LogicException('Person cannot be a parent of itself.');
        }

        $person->setParent($this);
        $this->children->add($person);
    }

    /**
     * @param Person $child
     * @return Person
     */
    public function removeChild(Person $child)
    {
        $this->children->removeElement($child);

        return $this;
    }

    /**
     * @return Person
     */
    public function removeParent()
    {
        $this->parent = null;

        return $this;
    }

    /**
     * @param Person $person
     * @throws \LogicException
     * @internal
     */
    protected function setParent(Person $person)
    {
        if ($this->parent !== null && $this->parent !== $person) {
            throw new \LogicException('This person is already associated with another parent.');
        }

        $this->parent = $person;
    }

    /**
     * @param  \Opg\Core\Model\Entity\Address\Address $address
     *
     * @return Person
     */
    public function addAddress(Address $address = null)
    {
        $address->setPerson($this);
        $this->addresses->add($address);

        return $this;
    }

    /**
     * @param  ArrayCollection $addresses
     *
     * @return Person
     */
    public function setAddresses(ArrayCollection $addresses)
    {
        $this->addresses = $addresses;

        return $this;
    }

    /**
     * @return Person
     */
    public function clearAddresses()
    {
        $this->addresses = new ArrayCollection();

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     *
     * @return string $email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     *
     * @param  string $email
     *
     * @return Person
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @param \DateTime $dob
     *
     * @return Person
     */
    public function setDob(\DateTime $dob = null)
    {
        $this->dob = $dob;

        return $this;
    }

    /**
     * @param string $dob
     *
     * @return Person
     */
    public function setDobString($dob)
    {
        if (!empty($dob)) {
            $result = OPGDateFormat::createDateTime($dob);
            return $this->setDob($result);
        }

        return $this;
    }

    /**
     * @return string $dob
     */
    public function getDob()
    {
        return $this->dob;
    }

    /**
     * @return string
     */
    public function getDobString()
    {
        if (!empty($this->dob)) {
            return $this->dob->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @param \DateTime $dateOfDeath
     *
     * @return Person
     */
    public function setDateOfDeath(\DateTime $dateOfDeath = null)
    {
        $this->dateOfDeath = $dateOfDeath;

        return $this;
    }

    /**
     * @param string $dateOfDeath
     *
     * @return Person
     */
    public function setDateOfDeathString($dateOfDeath)
    {
        if (!empty($dateOfDeath)) {
            $result = OPGDateFormat::createDateTime($dateOfDeath);
            return $this->setDateOfDeath($result);
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateOfDeath()
    {
        return $this->dateOfDeath;
    }

    /**
     * @return string
     */
    public function getDateOfDeathString()
    {
        if (!empty($this->dateOfDeath)) {
            return $this->dateOfDeath->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @return bool
     */
    public function isDeceased()
    {
        return $this->dateOfDeath !== null;
    }

    /**
     * @return string $title
     */
    public function getTitle()
    {
        return $this->salutation;
    }

    /**
     * @param  string $salutation
     * @return Person
     */
    public function setTitle($salutation)
    {
        $this->salutation = (string)$salutation;

        return $this;
    }

    /**
     * @return string $salutation
     */
    public function getSalutation()
    {
        return $this->salutation;
    }

    /**
     * @param  string $salutation
     * @return Person
     */
    public function setSalutation($salutation)
    {
        $this->salutation = $salutation;

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
     * @param  string $firstname
     * @return Person
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string $middlenames
     */
    public function getMiddlename()
    {
        return $this->middlenames;
    }

    /**
     * @param  string $middlenames
     * @return Person
     */
    public function setMiddlename($middlenames)
    {
        $this->middlenames = $middlenames;

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
     * @param string
     * @return Person
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @param  PhoneNumber $phoneNumber
     * @return Person
     */
    public function addPhoneNumber(PhoneNumber $phoneNumber)
    {
        $phoneNumber->setPerson($this);
        $this->phoneNumbers->add($phoneNumber);

        return $this;
    }

    /**
     * @param  ArrayCollection $phoneNumbers
     * @return Person
     */
    public function setPhoneNumbers(ArrayCollection $phoneNumbers)
    {
        $this->phoneNumbers = $phoneNumbers;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPhoneNumbers()
    {
        return $this->phoneNumbers;
    }

    /**
     * @return Person
     */
    public function clearPhoneNumbers()
    {
        $this->phoneNumbers = new ArrayCollection();

        return $this;
    }

    /**
     * @param  InputFilterInterface $inputFilter
     * @return Person
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;

        return $this;
    }

    /**
     * @return BaseInputFilter
     */
    public function getInputFilter()
    {
        $this->inputFilter = new BaseInputFilter();

        $this->inputFilter->merge(new UidFilter());
        $this->inputFilter->merge(new IdentifierFilter());

        return $this->inputFilter;
    }

    /**
     * @return string $occupation
     */
    public function getOccupation()
    {
        return $this->occupation;
    }

    /**
     * @param string $occupation
     * @return Attorney
     */
    public function setOccupation($occupation)
    {
        $this->occupation = $occupation;

        return $this;
    }
}
