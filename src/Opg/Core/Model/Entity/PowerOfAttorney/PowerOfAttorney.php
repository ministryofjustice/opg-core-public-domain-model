<?php
namespace Opg\Core\Model\Entity\PowerOfAttorney;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\AttorneyAbstract;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;
use Opg\Core\Model\Entity\Person\Person;
use Opg\Core\Model\Entity\PowerOfAttorney\InputFilter\PowerOfAttorneyFilter;
use Zend\InputFilter\InputFilter;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\ReadOnly;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

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
 * @ORM\entity(repositoryClass="Application\Model\Repository\PowerOfAttorneyRepository")
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
     * @Groups("api-poa-list")
     * @ReadOnly
     */
    protected $donor;

    /**
     * @ORM\ManyToOne(cascade={"persist"}, targetEntity = "Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent", fetch = "EAGER")
     * @var Correspondent
     * @Type("Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent")
     * @ReadOnly
     */
    protected $correspondent;

    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\Person\Person")
     * @ORM\JoinTable(name="pa_applicants",
     *     joinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")}
     * )
     * @ReadOnly
     * @var ArrayCollection
     */
    protected $applicants;

    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\Person\Person")
     * @ORM\JoinTable(name="pa_attorneys",
     *     joinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="attorney_id", referencedColumnName="id")}
     * )
     * @ReadOnly
     * @var ArrayCollection
     */
    protected $attorneys;

    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson")
     * @ORM\JoinTable(name="pa_notified_persons",
     *     joinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="notified_person_id", referencedColumnName="id")}
     * )
     * @ReadOnly
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
     * @var int
     * @Type("string")
     * @Accessor(getter="getNotifiedPersonPermissionBy",setter="setNotifiedPersonPermissionBy")
     *
     * These accessors are required to convert between the integer type we store the field as and the
     * human readable text passed around the front end
     */
    protected $notifiedPersonPermissionBy = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider")
     * @ORM\JoinTable(name="pa_certificate_provider",
     * joinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="certificate_provider_id",
     * referencedColumnName="id")}
     * )
     * @Type("ArrayCollection<Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider>")
     * @var ArrayCollection
     * @ReadOnly
     */
    protected $certificateProviders;

    /**
     * @ORM\Column(type="integer",options={"default"=0})
     * @var integer
     * @Type("integer")
     */
    protected $paymentByDebitCreditCard = self::PAYMENT_OPTION_NOT_SET;

    /**
     * @ORM\Column(type="integer",options={"default"=0})
     * @var integer
     * @Type("integer")
     */
    protected $paymentByCheque = self::PAYMENT_OPTION_NOT_SET;

    /**
     * @ORM\Column(type="integer", options={"default"=0})
     * @var integer
     * @Type("integer")
     */
    protected $feeExemptionAppliedFor = self::PAYMENT_OPTION_NOT_SET;

    /**
     * @ORM\Column(type="integer",options={"default"=0})
     * @var integer
     * @Type("integer")
     */
    protected $feeRemissionAppliedFor = self::PAYMENT_OPTION_NOT_SET;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Type("boolean")
     */
    protected $caseAttorneySingular = false;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Type("boolean")
     */
    protected $caseAttorneyJointlyAndSeverally = false;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Type("boolean")
     */
    protected $caseAttorneyJointly = false;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Type("boolean")
     */
    protected $caseAttorneyJointlyAndJointlyAndSeverally = false;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $cardPaymentContact;

    /**
     * @ORM\Column(type = "datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getRegistrationDueDateString", setter="setRegistrationDueDateString")
     */
    protected $registrationDueDate;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $howAttorneysAct;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $howReplacementAttorneysAct;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $attorneyActDecisions;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $replacementAttorneyActDecisions;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $replacementOrder;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $restrictions;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $guidance;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $charges;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $additionalInfo;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $paymentId;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $paymentAmount;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $paymentDate;

    /**
     * @ORM\Column(type="integer",options={"default":1})
     * @var int
     * @Type("string")
     * @Accessor(getter="getAttorneyPartyDeclaration",setter="setAttorneyPartyDeclaration")
     */
    protected $attorneyPartyDeclaration = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\Column(type="integer",options={"default":1})
     * @var int
     * @Type("string")
     * @Accessor(getter="getAttorneyApplicationAssertion",setter="setAttorneyApplicationAssertion")
     */
    protected $attorneyApplicationAssertion = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\Column(type="integer",options={"default":1})
     * @var int
     * @Type("string")
     * @Accessor(getter="getAttorneyMentalActPermission",setter="setAttorneyMentalActPermission")
     */
    protected $attorneyMentalActPermission = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Type("string")
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
     * @Type("string")
     * @Accessor(getter="getCorrespondentComplianceAssertion",setter="setCorrespondentComplianceAssertion")
     */
    protected $correspondentComplianceAssertion  = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $notificationDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $dispatchDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $noticeGivenDate;

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
     * @return \DateTime $registrationDueDate
     */
    public function getRegistrationDueDate ()
    {
        return $this->registrationDueDate;
    }

    /**
     * @return string
     */
    public function getRegistrationDueDateString()
    {
        if (!empty($this->registrationDueDate)) {
            return $this->registrationDueDate->format(OPGDateFormat::getDateFormat());
        }
        return '';
    }

    /**
     *
     * @param \DateTime $registrationDueDate
     * @return PowerOfAttorney
     */
    public function setRegistrationDueDate (\DateTime $registrationDueDate)
    {
        $this->registrationDueDate = $registrationDueDate;

        return $this;
    }

    /**
     *
     * @param string $registrationDueDate
     * @return PowerOfAttorney
     */
    public function setRegistrationDueDateString ($registrationDueDate)
    {
        if (!empty($this->registrationDueDate)) {
            $this->setRegistrationDueDate(new \DateTime($registrationDueDate));
        }

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
     * @param AttorneyAbstract $attorney
     * @return PowerOfAttorney
     */
    public function addAttorney (AttorneyAbstract $attorney)
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
     * @param string $permissionBy
     * @return PowerOfAttorney
     */
    public function setNotifiedPersonPermissionBy($permissionBy)
    {
        $this->notifiedPersonPermissionBy =
            ($permissionBy === 'I') ?
                self::PERMISSION_GIVEN_SINGULAR :
                self::PERMISSION_GIVEN_PLURAL;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotifiedPersonPermissionBy()
    {
        return ($this->notifiedPersonPermissionBy === self::PERMISSION_GIVEN_SINGULAR)
            ? 'I'
            : 'We';
    }

    /**
     * @param string $attorneyApplicationAssertion
     * @return PowerOfAttorney
     */
    public function setAttorneyApplicationAssertion($attorneyApplicationAssertion)
    {
        $this->attorneyApplicationAssertion =
            ($attorneyApplicationAssertion === 'I') ?
                self::PERMISSION_GIVEN_SINGULAR :
                self::PERMISSION_GIVEN_PLURAL;
        return $this;
    }

    /**
     * @return string
     */
    public function getAttorneyApplicationAssertion()
    {
        return ($this->attorneyApplicationAssertion === self::PERMISSION_GIVEN_SINGULAR)
            ? 'I'
            : 'We';
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
     * @param string $attorneyDeclarationSignatureDate
     * @return PowerOfAttorney
     */
    public function setAttorneyDeclarationSignatureDate($attorneyDeclarationSignatureDate)
    {
        $this->attorneyDeclarationSignatureDate = $attorneyDeclarationSignatureDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getAttorneyDeclarationSignatureDate()
    {
        return $this->attorneyDeclarationSignatureDate;
    }

    /**
     * @param string $attorneyMentalActPermission
     * @return PowerOfAttorney
     */
    public function setAttorneyMentalActPermission($attorneyMentalActPermission)
    {
        $this->attorneyMentalActPermission =
            ($attorneyMentalActPermission === 'I') ?
                self::PERMISSION_GIVEN_SINGULAR :
                self::PERMISSION_GIVEN_PLURAL;
        return $this;
    }

    /**
     * @return string
     */
    public function getAttorneyMentalActPermission()
    {
        return ($this->attorneyMentalActPermission === self::PERMISSION_GIVEN_SINGULAR)
            ? 'I'
            : 'We';
    }

    /**
     * @param string $attorneyPartyDeclaration
     * @return PowerOfAttorney
     */
    public function setAttorneyPartyDeclaration($attorneyPartyDeclaration)
    {
        $this->attorneyPartyDeclaration =
            ($attorneyPartyDeclaration === 'I') ?
                self::PERMISSION_GIVEN_SINGULAR :
                self::PERMISSION_GIVEN_PLURAL;
        return $this;
    }

    /**
     * @return string
     */
    public function getAttorneyPartyDeclaration()
    {
        return ($this->attorneyPartyDeclaration === self::PERMISSION_GIVEN_SINGULAR)
            ? 'I'
            : 'We';
    }

    /**
     * @param string $correspondentComplianceAssertion
     * @return PowerOfAttorney
     */
    public function setCorrespondentComplianceAssertion($correspondentComplianceAssertion)
    {
        $this->correspondentComplianceAssertion =
            ($correspondentComplianceAssertion === 'I') ?
                self::PERMISSION_GIVEN_SINGULAR :
                self::PERMISSION_GIVEN_PLURAL;
        return $this;
    }

    /**
     * @return string
     */
    public function getCorrespondentComplianceAssertion()
    {
        return ($this->correspondentComplianceAssertion === self::PERMISSION_GIVEN_SINGULAR)
            ? 'I'
            : 'We';
    }

    /**
     * @param int $feeExemptionAppliedFor
     * @return PowerOfAttorney
     */
    public function setFeeExemptionAppliedFor($feeExemptionAppliedFor = self::PAYMENT_OPTION_NOT_SET)
    {
        $this->feeExemptionAppliedFor = $feeExemptionAppliedFor;
        return $this;
    }

    /**
     * @return int
     */
    public function getFeeExemptionAppliedFor()
    {
        return $this->feeExemptionAppliedFor;
    }

    /**
     * @param int $feeRemissionAppliedFor
     * @return PowerOfAttorney
     */
    public function setFeeRemissionAppliedFor($feeRemissionAppliedFor = self::PAYMENT_OPTION_NOT_SET)
    {
        $this->feeRemissionAppliedFor = $feeRemissionAppliedFor;
        return $this;
    }

    /**
     * @return int
     */
    public function getFeeRemissionAppliedFor()
    {
        return $this->feeRemissionAppliedFor;
    }

    /**
     * @param int $paymentByCheque
     * @return PowerOfAttorney
     */
    public function setPaymentByCheque($paymentByCheque = self::PAYMENT_OPTION_NOT_SET)
    {
        $this->paymentByCheque = $paymentByCheque;
        return $this;
    }

    /**
     * @return int
     */
    public function getPaymentByCheque()
    {
        return $this->paymentByCheque;
    }

    /**
     * @param int $paymentByDebitCreditCard
     * @return PowerOfAttorney
     */
    public function setPaymentByDebitCreditCard($paymentByDebitCreditCard =  self::PAYMENT_OPTION_NOT_SET)
    {
        $this->paymentByDebitCreditCard = $paymentByDebitCreditCard;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getPaymentByDebitCreditCard()
    {
        return $this->paymentByDebitCreditCard;
    }

    /**
     * @param boolean $caseAttorney
     * @return PowerOfAttorney
     */
    public function setCaseAttorneyJointly($caseAttorney = false)
    {
        $this->caseAttorneyJointly = $caseAttorney;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getCaseAttorneyJointly()
    {
        return $this->caseAttorneyJointly;
    }

    /**
     * @param boolean $caseAttorney
     * @return PowerOfAttorney
     */
    public function setCaseAttorneyJointlyAndJointlyAndSeverally($caseAttorney = false)
    {
        $this->caseAttorneyJointlyAndJointlyAndSeverally = $caseAttorney;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getCaseAttorneyJointlyAndJointlyAndSeverally()
    {
        return $this->caseAttorneyJointlyAndJointlyAndSeverally;
    }

    /**
     * @param boolean $caseAttorney
     * @return PowerOfAttorney
     */
    public function setCaseAttorneyJointlyAndSeverally($caseAttorney = false)
    {
        $this->caseAttorneyJointlyAndSeverally = $caseAttorney;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getCaseAttorneyJointlyAndSeverally()
    {
        return $this->caseAttorneyJointlyAndSeverally;
    }

    /**
     * @param boolean $caseAttorney
     * @return PowerOfAttorney
     */
    public function setCaseAttorneySingular($caseAttorney = false)
    {
        $this->caseAttorneySingular = $caseAttorney;
        return $this;
    }

    /**
     * @return boolean
     */
    public function getCaseAttorneySingular()
    {
        return $this->caseAttorneySingular;
    }

    /**
     * @param string $dispatchDate
     * @return PowerOfAttorney
     */
    public function setDispatchDate($dispatchDate)
    {
        $this->dispatchDate = $dispatchDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getDispatchDate()
    {
        return $this->dispatchDate;
    }

    /**
     * @param string $noticeGivenDate
     * @return PowerOfAttorney
     */
    public function setNoticeGivenDate( $noticeGivenDate)
    {
        $this->noticeGivenDate = $noticeGivenDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getNoticeGivenDate()
    {
        return $this->noticeGivenDate;
    }

    /**
     * @param string $notificationDate
     * @return PowerOfAttorney
     */
    public function setNotificationDate($notificationDate)
    {
        $this->notificationDate = $notificationDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getNotificationDate()
    {
        return $this->notificationDate;
    }
}

