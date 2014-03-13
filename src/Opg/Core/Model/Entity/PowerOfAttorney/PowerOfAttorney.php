<?php
namespace Opg\Core\Model\Entity\PowerOfAttorney;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;
use Opg\Core\Model\Entity\Person\Person;
use Opg\Core\Model\Entity\PowerOfAttorney\InputFilter\PowerOfAttorneyFilter;
use Zend\InputFilter\InputFilter;
use JMS\Serializer\Annotation\Type;

/**
 * @ORM\Entity
 * @ORM\Table(name = "case_poas")
 * @ORM\ChangeTrackingPolicy("DEFERRED_EXPLICIT")
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 * "lpa" = "Opg\Core\Model\Entity\CaseItem\Lpa\Lpa",
 * })
 */
abstract class PowerOfAttorney extends CaseItem
{
    /**
     * Constant for the I portion of I/We questions
     */
    const PERMISSION_GIVEN_SINGULAR = 0x01;

    /**
     * Constant for the We portion of I/We questions
     */
    const PERMISSION_GIVEN_PLURAL   = 0x02;

    use ToArray {
        toArray as traitToArray;
    }

    /**
     * @ORM\ManyToOne(cascade={"persist"}, targetEntity = "Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor", fetch = "EAGER")
     * @var Donor
     * @Type("Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor")
     */
    protected $donor;

    /**
     * @ORM\ManyToOne(cascade={"persist"}, targetEntity = "Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent", fetch = "EAGER")
     * @var Correspondent
     * @Type("Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent")
     */
    protected $correspondent;

    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\Person\Person")
     * @ORM\JoinTable(name="pa_applicants",
     *     joinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection
     */
    protected $applicants;

    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney")
     * @ORM\JoinTable(name="pa_attorneys",
     *     joinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="attorney_id", referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection
     */
    protected $attorneys;

    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson")
     * @ORM\JoinTable(name="pa_notified_persons",
     *     joinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="notified_person_id", referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection
     */
    protected $notifiedPersons;

    /**
     * @ORM\Column(type = "boolean",options={"default"=0})
     * @var bool
     * @Type("boolean")
     */
    protected $usesNotifiedPersons = false;

    /**
     * @ORM\Column(type = "integer",options={"default"=1})
     * @var integer
     * @Type("integer")
     */
    protected $notifiedPersonPermissionBy = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider")
     * @ORM\JoinTable(name="pa_certificate_provider",
     * joinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="certificate_provider_id",
     * referencedColumnName="id")}
     * )
     *
     * @var ArrayCollection
     */
    protected $certificateProviders;

    /**
     * @ORM\ManyToMany(targetEntity = "Opg\Core\Model\Entity\CaseItem\Note\Note", cascade={"persist"})
     * @ORM\JoinTable(name="powerofattorney_notes",
     *     joinColumns={@ORM\JoinColumn(name="powerofattorney_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="note_id", referencedColumnName="id")}
     * )
     * @var ArrayCollection
     */
    protected $notes;

    /**
     * use InputFilter;
     * use ToArray {
     * toArray as traitToArray;
     * }
     * @ORM\Column(type = "string", nullable=true)
     *
     * @var string
     */
    protected $paymentMethod;

    /**
     * @ORM\Column(type = "string", nullable=true)
     *
     * @var string
     */
    protected $cardPaymentContact;

    /**
     * @ORM\Column(type = "string", nullable=true)
     *
     * @var string
     */
    protected $bacsPaymentInstructions;

    /**
     * @ORM\Column(type = "string", nullable=true)
     *
     * @var string
     */
    protected $registrationDueDate;

    /**
     * @ORM\Column(type = "string", nullable=true)
     *
     * @var string
     */
    protected $howAttorneysAct;

    /**
     * @ORM\Column(type = "string", nullable=true)
     *
     * @var string
     */
    protected $howReplacementAttorneysAct;

    /**
     * @ORM\Column(type = "string", nullable=true)
     *
     * @var string
     */
    protected $attorneyActDecisions;

    /**
     * @ORM\Column(type = "string", nullable=true)
     *
     * @var string
     */
    protected $replacementAttorneyActDecisions;

    /**
     * @ORM\Column(type = "string", nullable=true)
     *
     * @var string
     */
    protected $replacementOrder;

    /**
     * @ORM\Column(type = "string", nullable=true)
     *
     * @var string
     */
    protected $restrictions;

    /**
     * @ORM\Column(type = "string", nullable=true)
     *
     * @var string
     */
    protected $guidance;

    /**
     * @ORM\Column(type = "string", nullable=true)
     *
     * @var string
     */
    protected $charges;

    /**
     * @ORM\Column(type = "string", nullable=true)
     *
     * @var string
     */
    protected $additionalInfo;

    /**
     * @ORM\Column(type = "string", nullable=true)
     *
     * @var string
     */
    protected $paymentId;

    /**
     * @ORM\Column(type = "string", nullable=true)
     *
     * @var string
     */
    protected $paymentAmount;

    /**
     * @ORM\Column(type = "string", nullable=true)
     *
     * @var string
     */
    protected $paymentDate;

    /**
     * @ORM\Column(type="integer",options={"default":1})
     * @var int
     * @Type("integer")
     */
    protected $attorneyPartyDeclaration = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\Column(type="integer",options={"default":1})
     * @var int
     * @Type("integer")
     */
    protected $attorneyApplicationAssertion = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\Column(type="integer",options={"default":1})
     * @var int
     * @Type("integer")
     */
    protected $attorneyMentalActPermission = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("datetime")
     */
    protected $attorneyDeclarationSignatureDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $attorneyDeclarationSignatoryFullName;

    /**
     * @ORM\Column(type="integer",options={"default":1})
     * @var int
     * @Type("integer")
     */
    protected $correspondentComplianceAssertion  = self::PERMISSION_GIVEN_SINGULAR;

    public function __construct ()
    {
        parent::__construct();

        $this->notifiedPersons = new ArrayCollection();
        $this->attorneys = new ArrayCollection();
        $this->applicants = new ArrayCollection();
        $this->certificateProviders = new ArrayCollection();
    }

    /**
     *
     * @return string $paymentMethod
     */
    public function getPaymentMethod ()
    {
        return $this->paymentMethod;
    }

    /**
     *
     * @param string $paymentMethod
     * @return PowerOfAttorney
     */
    public function setPaymentMethod ($paymentMethod)
    {
        $this->paymentMethod = $paymentMethod;

        return $this;
    }

    /**
     *
     * @return string $cardPaymentContact
     */
    public function getCardPaymentContact ()
    {
        return $this->cardPaymentContact;
    }

    /**
     *
     * @param string $cardPaymentContact
     * @return PowerOfAttorney
     */
    public function setCardPaymentContact ($cardPaymentContact)
    {
        $this->cardPaymentContact = $cardPaymentContact;

        return $this;
    }

    /**
     *
     * @return string $bacsPaymentInstructions
     */
    public function getBacsPaymentInstructions ()
    {
        return $this->bacsPaymentInstructions;
    }

    /**
     *
     * @param string $bacsPaymentInstructions
     * @return PowerOfAttorney
     */
    public function setBacsPaymentInstructions ($bacsPaymentInstructions)
    {
        $this->bacsPaymentInstructions = $bacsPaymentInstructions;

        return $this;
    }

    /**
     *
     * @return string $registrationDueDate
     */
    public function getRegistrationDueDate ()
    {
        return $this->registrationDueDate;
    }

    /**
     *
     * @param string $registrationDueDate
     * @return PowerOfAttorney
     */
    public function setRegistrationDueDate ($registrationDueDate)
    {
        $this->registrationDueDate = $registrationDueDate;

        return $this;
    }

    /**
     *
     * @return string $howAttorneysAct
     */
    public function getHowAttorneysAct ()
    {
        return $this->howAttorneysAct;
    }

    /**
     *
     * @param string $howAttorneysAct
     * @return PowerOfAttorney
     */
    public function setHowAttorneysAct ($howAttorneysAct)
    {
        $this->howAttorneysAct = $howAttorneysAct;

        return $this;
    }

    /**
     *
     * @return string $howReplacementAttorneysAct
     */
    public function getHowReplacementAttorneysAct ()
    {
        return $this->howReplacementAttorneysAct;
    }

    /**
     *
     * @param string $howReplacementAttorneysAct
     * @return PowerOfAttorney
     */
    public function setHowReplacementAttorneysAct ($howReplacementAttorneysAct)
    {
        $this->howReplacementAttorneysAct = $howReplacementAttorneysAct;

        return $this;
    }

    /**
     *
     * @return string $attorneyActDecisions
     */
    public function getAttorneyActDecisions ()
    {
        return $this->attorneyActDecisions;
    }

    /**
     *
     * @param string $attorneyActDecisions
     * @return PowerOfAttorney
     */
    public function setAttorneyActDecisions ($attorneyActDecisions)
    {
        $this->attorneyActDecisions = $attorneyActDecisions;

        return $this;
    }

    /**
     *
     * @return string $replacementAttorneyActDecisions
     */
    public function getReplacementAttorneyActDecisions ()
    {
        return $this->replacementAttorneyActDecisions;
    }

    /**
     *
     * @param string $replacementAttorneyActDecisions
     * @return PowerOfAttorney
     */
    public function setReplacementAttorneyActDecisions (
            $replacementAttorneyActDecisions)
    {
        $this->replacementAttorneyActDecisions = $replacementAttorneyActDecisions;

        return $this;
    }

    /**
     *
     * @return string $replacementOrder
     */
    public function getReplacementOrder ()
    {
        return $this->replacementOrder;
    }

    /**
     *
     * @param string $replacementOrder
     * @return PowerOfAttorney
     */
    public function setReplacementOrder ($replacementOrder)
    {
        $this->replacementOrder = $replacementOrder;

        return $this;
    }

    /**
     *
     * @return string $restrictions
     */
    public function getRestrictions ()
    {
        return $this->restrictions;
    }

    /**
     *
     * @param string $restrictions
     * @return PowerOfAttorney
     */
    public function setRestrictions ($restrictions)
    {
        $this->restrictions = $restrictions;

        return $this;
    }

    /**
     *
     * @return string $guidance
     */
    public function getGuidance ()
    {
        return $this->guidance;
    }

    /**
     * @param string $guidance
     * @return PowerOfAttorney
     */
    public function setGuidance ($guidance)
    {
        $this->guidance = $guidance;
        return $this;
    }

    /**
     *
     * @return string $charges
     */
    public function getCharges ()
    {
        return $this->charges;
    }

    /**
     * @param string $charges
     * @return PowerOfAttorney
     */
    public function setCharges ($charges)
    {
        $this->charges = $charges;
        return $this;
    }

    /**
     * @return string $additionalInfo
     */
    public function getAdditionalInfo ()
    {
        return $this->additionalInfo;
    }

    /**
     *
     * @param string $additionalInfo
     * @return PowerOfAttorney
     */
    public function setAdditionalInfo ($additionalInfo)
    {
        $this->additionalInfo = $additionalInfo;
        return $this;
    }

    /**
     *
     * @return string $paymentId
     */
    public function getPaymentId ()
    {
        return $this->paymentId;
    }

    /**
     *
     * @param string $paymentId
     * @return PowerOfAttorney
     */
    public function setPaymentId ($paymentId)
    {
        $this->paymentId = $paymentId;
        return $this;
    }

    /**
     *
     * @return string $paymentAmount
     */
    public function getPaymentAmount ()
    {
        return $this->paymentAmount;
    }

    /**
     * @param string $paymentAmount
     * @return PowerOfAttorney
     */
    public function setPaymentAmount ($paymentAmount)
    {
        $this->paymentAmount = $paymentAmount;
        return $this;
    }

    /**
     * @return string $paymentDate
     */
    public function getPaymentDate ()
    {
        return $this->paymentDate;
    }

    /**
     * @param string $paymentDate
     * @return PowerOfAttorney
     */
    public function setPaymentDate ($paymentDate)
    {
        $this->paymentDate = $paymentDate;
        return $this;
    }

    /**
     * @return \Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor
     */
    public function getDonor ()
    {
        return $this->donor;
    }

    /**
     * @param Donor $donor
     * @return PowerOfAttorney
     */
    public function setDonor (Donor $donor)
    {
        $this->donor = $donor;
        return $this;
    }

    /**
     * @return Correspondent
     */
    public function getCorrespondent ()
    {
        return $this->correspondent;
    }

    /**
     * @param \Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent $correspondent
     * @return PowerOfAttorney
     */
    public function setCorrespondent (Correspondent $correspondent)
    {
        $this->correspondent = $correspondent;
        return $this;
    }

    /**
     * @return ArrayCollection $applicants
     */
    public function getApplicants ()
    {
        return $this->applicants;
    }

    /**
     * @param Person $applicant
     * @return PowerOfAttorney
     */
    public function addApplicant(Person $applicant)
    {
        if (!$this->applicants->contains($applicant)) {
            $this->applicants->add($applicant);
        }

        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $applicants
     * @internal param \Doctrine\Common\Collections\ArrayCollection $applicantCollection
     * @return PowerOfAttorney
     */
    public function setApplicants (ArrayCollection $applicants)
    {
        foreach($applicants as $applicant) {
            $this->addApplicant($applicant);
        }
        return $this;
    }

    /**
     * @return ArrayCollection $attorneys
     */
    public function getAttorneys ()
    {
        return $this->attorneys;
    }

    /**
     * @param ArrayCollection $attorneys
     * @return PowerOfAttorney
     */
    public function setAttorneys (ArrayCollection $attorneys)
    {
        foreach ($attorneys as $attorney) {
            $this->addAttorney($attorney);
        }
        return $this;
    }

    /**
     * @param Attorney $attorney
     * @return PowerOfAttorney
     */
    public function addAttorney (Attorney $attorney)
    {
        if (!$this->attorneys->contains($attorney)) {
            $this->attorneys->add($attorney);
        }
        return $this;
    }

    /**
     * @return ArrayCollection $notifiedPersons
     */
    public function getNotifiedPersons ()
    {
        return $this->notifiedPersons;
    }

    /**
     * @param ArrayCollection $notifiedPersons
     * @return PowerOfAttorney
     */
    public function setNotifiedPersons (ArrayCollection $notifiedPersons)
    {
        foreach($notifiedPersons as $notifiedPerson) {
            $this->addNotifiedPerson($notifiedPerson);
        }
        return $this;
    }

    /**
     * @param NotifiedPerson $notifiedPerson
     * @return PowerOfAttorney
     */
    public function addNotifiedPerson(NotifiedPerson $notifiedPerson) {
        if (!$this->notifiedPersons->contains($notifiedPerson)) {
            $this->notifiedPersons->add($notifiedPerson);
        }
        return $this;
    }

    /**
     * @return ArrayCollection $certificateProviders
     */
    public function getCertificateProviders ()
    {
        return $this->certificateProviders;
    }

    /**
     * @param ArrayCollection $certificateProviders
     * @return PowerOfAttorney
     */
    public function setCertificateProviders (ArrayCollection $certificateProviders)
    {
        foreach ($certificateProviders as $certificateProvider) {
            $this->addCertificateProvider($certificateProvider);
        }
        return $this;
    }

    /**
     * @param CertificateProvider $certificateProvider
     * @return PowerOfAttorney
     */
    public function addCertificateProvider(CertificateProvider $certificateProvider)
    {
        if (!$this->certificateProviders->contains($certificateProvider)) {
            $this->certificateProviders->add($certificateProvider);
        }
        return $this;
    }

    /**
     * @return InputFilter
     */
    public function getInputFilter ()
    {
        parent::getInputFilter();
        $this->inputFilter->add(new PowerOfAttorneyFilter());
        return $this->inputFilter;
    }

    /**
     * @param bool $exposeClassname
     * @return array
     */
    public function toArray ($exposeClassname = TRUE)
    {
        return $this->traitToArray($exposeClassname);
    }

    /**
     * @param $usesNotifiedPersons
     * @return PowerOfAttorney
     */
    public function setUsesNotifiedPersons($usesNotifiedPersons)
    {
        $this->usesNotifiedPersons = (bool)$usesNotifiedPersons;
        return $this;
    }

    /**
     * @return bool
     */
    public function getUsesNotifiedPersons()
    {
        return $this->usesNotifiedPersons;
    }

    /**
     * Alias for getUsesNotifiedPersons
     * @return bool
     */
    public function hasNotifiedPersons()
    {
        return $this->getUsesNotifiedPersons();
    }

    /**
     * @param int $permissionBy
     * @return PowerOfAttorney
     */
    public function setNotifiedPersonPermissionBy($permissionBy = self::PERMISSION_GIVEN_SINGULAR)
    {
        $this->notifiedPersonPermissionBy = $permissionBy;
        return $this;
    }

    /**
     * @return int
     */
    public function getNotifiedPersonPermissionBy()
    {
        return $this->notifiedPersonPermissionBy;
    }

    /**
     * @param int $attorneyApplicationAssertion
     * @return PowerOfAttorney
     */
    public function setAttorneyApplicationAssertion($attorneyApplicationAssertion = self::PERMISSION_GIVEN_SINGULAR)
    {
        $this->attorneyApplicationAssertion = $attorneyApplicationAssertion;
        return $this;
    }

    /**
     * @return int
     */
    public function getAttorneyApplicationAssertion()
    {
        return $this->attorneyApplicationAssertion;
    }

    /**
     * @param string $attorneyDeclarationSignatoryFullName
     * @return PowerOfAttorney
     */
    public function setAttorneyDeclarationSignatoryFullName($attorneyDeclarationSignatoryFullName)
    {
        $this->attorneyDeclarationSignatoryFullName = $attorneyDeclarationSignatoryFullName;
        return $this;
    }

    /**
     * @return string
     */
    public function getAttorneyDeclarationSignatoryFullName()
    {
        return $this->attorneyDeclarationSignatoryFullName;
    }

    /**
     * @param \DateTime $attorneyDeclarationSignatureDate
     * @return PowerOfAttorney
     */
    public function setAttorneyDeclarationSignatureDate(\DateTime $attorneyDeclarationSignatureDate)
    {
        $this->attorneyDeclarationSignatureDate = $attorneyDeclarationSignatureDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getAttorneyDeclarationSignatureDate()
    {
        return $this->attorneyDeclarationSignatureDate;
    }

    /**
     * @param int $attorneyMentalActPermission
     * @return PowerOfAttorney
     */
    public function setAttorneyMentalActPermission($attorneyMentalActPermission = self::PERMISSION_GIVEN_SINGULAR)
    {
        $this->attorneyMentalActPermission = $attorneyMentalActPermission;
        return $this;
    }

    /**
     * @return int
     */
    public function getAttorneyMentalActPermission()
    {
        return $this->attorneyMentalActPermission;
    }

    /**
     * @param int $attorneyPartyDeclaration
     * @return PowerOfAttorney
     */
    public function setAttorneyPartyDeclaration($attorneyPartyDeclaration = self::PERMISSION_GIVEN_SINGULAR)
    {
        $this->attorneyPartyDeclaration = $attorneyPartyDeclaration;
        return $this;
    }

    /**
     * @return int
     */
    public function getAttorneyPartyDeclaration()
    {
        return $this->attorneyPartyDeclaration;
    }

    /**
     * @param int $correspondentComplianceAssertion
     * @return PowerOfAttorney
     */
    public function setCorrespondentComplianceAssertion($correspondentComplianceAssertion = self::PERMISSION_GIVEN_SINGULAR)
    {
        $this->correspondentComplianceAssertion = $correspondentComplianceAssertion;
        return $this;
    }

    /**
     * @return int
     */
    public function getCorrespondentComplianceAssertion()
    {
        return $this->correspondentComplianceAssertion;
    }


}

