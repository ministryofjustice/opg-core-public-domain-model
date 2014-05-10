<?php
namespace Opg\Core\Model\Entity\Person;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\HasNotesInterface;
use Opg\Common\Model\Entity\HasCorrespondenceInterface;
use Opg\Common\Model\Entity\HasUidInterface;
use Opg\Common\Model\Entity\Traits\HasNotes as HasNotesTrait;
use Opg\Common\Model\Entity\Traits\HasCorrespondence as HasCorrespondenceTrait;
use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;
use Opg\Common\Model\Entity\Traits\UniqueIdentifier;
use Opg\Core\Model\Entity\Address\Address;
use Opg\Core\Model\Entity\CaseItem\CaseItemInterface;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\PartyInterface;
use Opg\Core\Model\Entity\Deputyship\Deputyship;
use Opg\Core\Model\Entity\PhoneNumber\PhoneNumber;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\MaxDepth;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Accessor;
use Zend\InputFilter\InputFilterInterface;
use Zend\InputFilter\Factory as InputFactory;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * @ORM\Entity
 * @ORM\Table(name = "persons")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "lpa_attorney" = "Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney",
 *     "lpa_replacement_attorney" = "Opg\Core\Model\Entity\CaseItem\Lpa\Party\ReplacementAttorney",
 *     "lpa_trust_corporation" = "Opg\Core\Model\Entity\CaseItem\Lpa\Party\TrustCorporation",
 *     "lpa_correspondent" = "Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent",
 *     "lpa_donor" = "Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor",
 *     "lpa_notified_person" = "Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson",
 *     "lpa_certificate_provider" = "Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider",
 * })
 * @ORM\entity(repositoryClass="Application\Model\Repository\PersonRepository")
 */
abstract class Person implements HasUidInterface, HasNotesInterface, EntityInterface, \IteratorAggregate, HasCorrespondenceInterface
{
    use HasNotesTrait;
    use UniqueIdentifier;
    use InputFilterTrait;
    use HasCorrespondenceTrait;

    /**
     * Constants below are for yes/no radio buttons, we use 0
     * as default
     */
    const OPTION_NOT_SET = 0;
    const OPTION_FALSE   = 1;
    const OPTION_TRUE    = 2;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true}) @ORM\GeneratedValue(strategy = "AUTO") @ORM\Id
     * @var integer
     * @Type("integer")
     * @Groups("api-poa-list")
     */
    protected $id;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Groups("api-poa-list")
     */
    protected $email;

    /**
     * @ORM\ManyToMany(targetEntity="Opg\Core\Model\Entity\CaseItem\Lpa\Lpa", cascade={"persist"})
     * @ORM\JoinTable(name="person_pas",
     *     joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection
     * @MaxDepth(5)
     * @Type("ArrayCollection<Opg\Core\Model\Entity\CaseItem\Lpa\Lpa>")
     * @ReadOnly
     */
    protected $powerOfAttorneys;

    /**
     * @ORM\ManyToMany(targetEntity="Opg\Core\Model\Entity\Deputyship\Deputyship", cascade={"persist"})
     * @ORM\JoinTable(name="person_deputyships",
     *     joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="deputyship_id", referencedColumnName="id")}
     * )
     * @MaxDepth(5)
     * @var ArrayCollection
     * @Type("ArrayCollection<Opg\Core\Model\Entity\Deputyship\Deputyship>")
     * @ReadOnly
     */
    protected $deputyships;

    /**
     * @ORM\ManyToMany(targetEntity = "Opg\Core\Model\Entity\CaseItem\Note\Note", cascade={"persist"})
     * @ORM\JoinTable(name="person_notes",
     *     joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="note_id", referencedColumnName="id")}
     * )
     * @var ArrayCollection
     * @Type("ArrayCollection<Opg\Core\Model\Entity\CaseItem\Note\Note>")
     * @ReadOnly
     */
    protected $notes;

    /**
     * @ORM\ManyToMany(targetEntity = "Opg\Core\Model\Entity\Correspondence\Correspondence", cascade={"persist"})
     * @ORM\JoinTable(name="person_correspondence",
     *     joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="correspondence_id", referencedColumnName="id")}
     * )
     * @var ArrayCollection
     * @Type("ArrayCollection<Opg\Core\Model\Entity\Correspondence\Correspondence>")
     * @ReadOnly
     */
    protected $correspondence;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getDobString",setter="setDobString")
     * @Groups("api-poa-list")
     */
    protected $dob;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getDateOfDeathString",setter="setDateOfDeathString")
     * @Groups("api-poa-list")
     */
    protected $dateOfDeath;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Groups("api-poa-list")
     * @Accessor(getter="getTitle",setter="setTitle")
     */
    protected $salutation;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Groups("api-poa-list")
     */
    protected $firstname;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Groups("api-poa-list")
     */
    protected $middlenames;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Type("string")
     * @Groups("api-poa-list")
     */
    protected $surname;

    /**
     * @ORM\OneToMany(targetEntity="Opg\Core\Model\Entity\Address\Address", mappedBy="person", cascade={"all"}, fetch="EAGER")
     * @var \Opg\Core\Model\Entity\Address\Address
     * @Type("ArrayCollection<Opg\Core\Model\Entity\Address\Address>")
     */
    protected $addresses;

    /**
     * @ORM\OneToMany(targetEntity="Opg\Core\Model\Entity\PhoneNumber\PhoneNumber", mappedBy="person", cascade={"all"}, fetch="EAGER")
     * @var ArrayCollection
     * @Type("ArrayCollection<Opg\Core\Model\Entity\PhoneNumber\PhoneNumber>")
     */
    protected $phoneNumbers;

    public function __construct()
    {
        $this->deputyships      = new ArrayCollection();
        $this->powerOfAttorneys = new ArrayCollection();
        $this->addresses        = new ArrayCollection();
        $this->phoneNumbers     = new ArrayCollection();
        $this->notes            = new ArrayCollection();
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
     * @return PartyInterface
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     *
     * @return string $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     *
     * @param  string $id
     *
     * @return PartyInterface
     */
    public function setId($id)
    {
        $this->id = $id;

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
            if ($result) {
                return $this->setDob($result);
            }
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

            if ($result) {
                return $this->setDateOfDeath($result);
            }

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
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->salutation;
    }

    /**
     *
     * @param  string $salutation
     *
     * @return PartyInterface
     */
    public function setTitle($salutation)
    {
        $this->salutation = (string)$salutation;

        return $this;
    }

    /**
     *
     * @return string $salutation
     */
    public function getSalutation()
    {
        return $this->salutation;
    }

    /**
     *
     * @param  string $salutation
     *
     * @return PartyInterface
     */
    public function setSalutation($salutation)
    {
        $this->salutation = $salutation;

        return $this;
    }

    /**
     *
     * @return string $firstname
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     *
     * @param  string $firstname
     *
     * @return PartyInterface
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     *
     * @return string $middlenames
     */
    public function getMiddlename()
    {
        return $this->middlenames;
    }

    /**
     *
     * @param  string $middlenames
     *
     * @return PartyInterface
     */
    public function setMiddlename($middlenames)
    {
        $this->middlenames = $middlenames;

        return $this;
    }

    /**
     *
     * @return string $surname
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * @param string
     *
     * @return PartyInterface
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     *
     * @param  \Opg\Core\Model\Entity\CaseItem\CaseItemInterface $case
     *
     * @throws Exception
     * @return Person
     */
    public function addCase(CaseItemInterface $case)
    {
        if ($case instanceof PowerOfAttorney) {
            // @codeCoverageIgnoreStart
            // requires PersonFactory to test
            if (is_null($this->powerOfAttorneys)) {
                $this->powerOfAttorneys = new ArrayCollection();
            }
            // @codeCoverageIgnoreEnd
            if (!$this->powerOfAttorneys->contains($case)) {
                $this->powerOfAttorneys->add($case);
            }
        } elseif ($case instanceof Deputyship) {
            // @codeCoverageIgnoreStart
            // requires PersonFactory to test
            if (is_null($this->powerOfAttorneys)) {
                $this->deputyships = new ArrayCollection();
            }
            // @codeCoverageIgnoreEnd
            if (!$this->deputyships->contains($case)) {
                $this->deputyships->add($case);
            }
        } else {
            throw new Exception('A case can only be of type PowerOfAttorney or DeputyShip');
        }

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getPowerOfAttorneys()
    {
        // @codeCoverageIgnoreStart
        // requires PersonFactory to test
        if (is_null($this->powerOfAttorneys)) {
            $this->powerOfAttorneys = new ArrayCollection();
        }

        // @codeCoverageIgnoreEnd
        return $this->powerOfAttorneys;
    }

    public function getCases()
    {
        return array($this->getPowerOfAttorneys(), $this->getDeputyships());
    }

    /**
     * @param  ArrayCollection $cases
     *
     * @return PartyInterface
     */
    public function setCases(ArrayCollection $cases)
    {
        foreach ($cases as $case) {
            $this->addCase($case);
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getDeputyships()
    {
        // @codeCoverageIgnoreStart
        // requires PersonFactory to test
        if (is_null($this->deputyships)) {
            $this->deputyships = new ArrayCollection();
        }

        // @codeCoverageIgnoreEnd
        return $this->deputyships;
    }

    /**
     * @param  PhoneNumber $phoneNumber
     *
     * @return $this
     */
    public function addPhoneNumber(PhoneNumber $phoneNumber)
    {
        $phoneNumber->setPerson($this);
        $this->phoneNumbers->add($phoneNumber);

        return $this;
    }

    /**
     * @param  ArrayCollection $phoneNumbers
     *
     * @return $this
     */
    public function setPhoneNumbers(ArrayCollection $phoneNumbers)
    {
        $this->phoneNumbers = $phoneNumbers;

        return $this;
    }

    /**
     * @return ArrayCollection|\Opg\Core\Model\Entity\Address\PhoneNumber
     */
    public function getPhoneNumbers()
    {
        return $this->phoneNumbers;
    }

    /**
     * @return $this
     */
    public function clearPhoneNumbers()
    {
        $this->phoneNumbers = new ArrayCollection();

        return $this;
    }

    /**
     * @param  InputFilterInterface $inputFilter
     *
     * @return return               Person
     */
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        $this->inputFilter = $inputFilter;

        return $this;
    }

    /**
     * @return \Zend\InputFilter\InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new \Zend\InputFilter\InputFilter();
            $factory     = new InputFactory();

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    // Fulfil IteratorAggregate interface requirements
    public function getIterator()
    {
        return new \RecursiveArrayIterator($this->toArray());
    }

    /**
     * Method to validate a person in the input filter, where required
     * This is a bitwise or comparison, if either condition is true, it returns true
     * @return bool
     *
     */
    public function hasAttachedCase()
    {
        return
            (bool)(
                ($this->getPowerOfAttorneys()->count() > 0)
                |
                ($this->getDeputyships()->count() > 0)
            );
    }
}
