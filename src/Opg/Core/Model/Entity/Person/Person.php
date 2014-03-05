<?php
namespace Opg\Core\Model\Entity\Person;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Exception;
use Opg\Common\Model\Entity\HasUidInterface;
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

/**
 * @ORM\Entity
 * @ORM\Table(name = "persons")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "lpa_attorney" = "Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney",
 *     "lpa_correspondent" = "Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent",
 *     "lpa_donor" = "Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor",
 *     "lpa_notified_person" = "Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson",
 *     "lpa_certificate_provider" = "Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider",
 * })
 */
abstract class Person implements HasUidInterface
{
    use UniqueIdentifier;

    /**
     * @ORM\Column(type = "integer", options = {"unsigned": true}) @ORM\GeneratedValue(strategy = "AUTO") @ORM\Id
     * @var string
     */
    protected $id;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $email;

    /**
     * @ORM\ManyToMany(targetEntity="Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney", cascade={"persist"})
     * @ORM\JoinTable(name="person_pas",
     *     joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection
     * @MaxDepth(2)
     */
    protected $powerOfAttorneys;

    /**
     * @ORM\ManyToMany(targetEntity="Opg\Core\Model\Entity\Deputyship\Deputyship", cascade={"persist"})
     * @ORM\JoinTable(name="person_deputyships",
     *     joinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="deputyship_id", referencedColumnName="id")}
     * )
     * @MaxDepth(2)
     * @var ArrayCollection
     */
    protected $deputyships;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $dob;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $title;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $firstname;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $middlenames;

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     */
    protected $surname;

    /**
     * @ORM\OneToMany(targetEntity="Opg\Core\Model\Entity\Address\Address", mappedBy="person", cascade={"all"}, fetch="EAGER")
     * @var \Opg\Core\Model\Entity\Address\Address
     */
    protected $addresses;

    /**
     * @ORM\OneToMany(targetEntity="Opg\Core\Model\Entity\PhoneNumber\PhoneNumber", mappedBy="person", cascade={"all"}, fetch="EAGER")
     * @var \Opg\Core\Model\Entity\PhoneNumber\PhoneNumber
     */
    protected $phoneNumbers;

    /**
     * @param \Opg\Core\Model\Entity\Address\Address $address
     * @return Person
     */
    public function addAddress(Address $address = null)
    {
        $address->setPerson($this);
        $this->addresses->add($address);
        return $this;
    }

    /**
     * @param ArrayCollection $addresses
     * @return Person
     */
    public function setAddresses(ArrayCollection $addresses)
    {
        $this->addresses =  $addresses;
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

    public function __construct()
    {
        $this->deputyships      = new ArrayCollection();
        $this->powerOfAttorneys = new ArrayCollection();
        $this->addresses        = new ArrayCollection();
        $this->phoneNumbers     = new ArrayCollection();
    }

    /**
     *
     * @return string $email
     */
    public function getEmail ()
    {
        return $this->email;
    }

    /**
     *
     * @param string $email
     * @return PartyInterface
     */
    public function setEmail ($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     *
     * @return string $id
     */
    public function getId ()
    {
        return $this->id;
    }

    /**
     *
     * @param string $id
     * @return PartyInterface
     */
    public function setId ($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     *
     * @return string $dob
     */
    public function getDob ()
    {
        return $this->dob;
    }

    /**
     *
     * @param number $dob
     * @return PartyInterface
     */
    public function setDob ($dob)
    {
        $this->dob = $dob;
        return $this;
    }

    /**
     *
     * @return string $title
     */
    public function getTitle ()
    {
        return $this->title;
    }

    /**
     *
     * @param string $title
     * @return PartyInterface
     */
    public function setTitle ($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     *
     * @return string $firstname
     */
    public function getFirstname ()
    {
        return $this->firstname;
    }

    /**
     *
     * @param string $firstname
     * @return PartyInterface
     */
    public function setFirstname ($firstname)
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     *
     * @return string $middlenames
     */
    public function getMiddlename ()
    {
        return $this->middlenames;
    }

    /**
     *
     * @param string $middlenames
     * @return PartyInterface
     */
    public function setMiddlename ($middlenames)
    {
        $this->middlenames = $middlenames;
        return $this;
    }

    /**
     *
     * @return string $surname
     */
    public function getSurname ()
    {
        return $this->surname;
    }

    /**
     *
     * @param string $surname
     * @return PartyInterface
     */
    public function setSurname ($surname)
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     *
     * @param \Opg\Core\Model\Entity\CaseItem\CaseItemInterface $case
     * @throws Exception
     * @internal param $CaseItemInterface
     * @return Person
     */
    public function addCase (CaseItemInterface $case)
    {
        if ($case instanceof PowerOfAttorney) {
            if(!$this->powerOfAttorneys->contains($case)) {
               $this->powerOfAttorneys->add($case);
            }
        } elseif ($case instanceof Deputyship) {
            if(!$this->deputyships->contains($case)) {
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
    public function getPowerOfAttorneys ()
    {
        return $this->powerOfAttorneys;
    }

    public function getCases() {
        return array ($this->getPowerOfAttorneys(), $this->getDeputyships());
    }
    /**
     * @param ArrayCollection $cases
     * @return PartyInterface
     */
    public function setCases (ArrayCollection $cases)
    {
       foreach ($cases as $case) {
           $this->addCase($case);
       }
    }

    /**
     * @return ArrayCollection
     */
    public function getDeputyships ()
    {
        return $this->deputyships;
    }

    /**
     * @param PhoneNumber $phoneNumber
     * @return $this
     */
    public function addPhoneNumber(PhoneNumber $phoneNumber)
    {
        $phoneNumber->setPerson($this);
        $this->phoneNumbers->add($phoneNumber);
        return $this;
    }

    /**
     * @param ArrayCollection $phoneNumbers
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
}

