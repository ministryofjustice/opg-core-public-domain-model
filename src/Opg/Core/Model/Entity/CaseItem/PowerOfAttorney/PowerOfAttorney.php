<?php

namespace Opg\Core\Model\Entity\CaseItem\PowerOfAttorney;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

use Opg\Common\Model\Entity\Traits\ToArray;
use Opg\Core\Model\Entity\CaseActor\Decorators\NoticeGivenDate;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasNoticeGivenDate;
use Opg\Core\Model\Entity\CaseItem\CaseItem;
use Opg\Core\Model\Entity\CaseActor\AttorneyAbstract;
use Opg\Core\Model\Entity\CaseActor\CertificateProvider;
use Opg\Core\Model\Entity\CaseActor\Correspondent;
use Opg\Core\Model\Entity\CaseActor\NotifiedPerson;
use Opg\Core\Model\Entity\CaseActor\Donor;
use Opg\Core\Model\Entity\CaseActor\Person;
use Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Decorator\Attorneys;
use Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Decorator\DonorCannotSignForm;
use Opg\Core\Model\Entity\CaseItem\PowerOfAttorney\Interfaces\HasAttorneys;
use Opg\Core\Model\Entity\CaseItem\Validation\InputFilter\PowerOfAttorneyFilter;
use Zend\InputFilter\InputFilter;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\GenericAccessor;

/**
 * Class PowerOfAttorney
 * @package Opg\Core\Model\Entity\CaseItem\PowerOfAttorney
 *
 * @ORM\Entity(repositoryClass="Application\Model\Repository\CaseItemRepository")
 *
 */
abstract class PowerOfAttorney extends CaseItem implements HasNoticeGivenDate, HasAttorneys
{
    use DonorCannotSignForm;
    use NoticeGivenDate;
    use Attorneys;

    /**
     * Constant for the I portion of I/We questions
     */
    const PERMISSION_GIVEN_SINGULAR = 0x01;

    /**
     * Constant for the We portion of I/We questions
     */
    const PERMISSION_GIVEN_PLURAL = 0x02;

    use ToArray {
        toArray as traitToArray;
    }

    /**
     * @ORM\ManyToOne(cascade={"persist"}, targetEntity = "Opg\Core\Model\Entity\CaseActor\Donor", fetch = "EAGER")
     * @ORM\OrderBy({"id"="ASC"})
     * @var Donor
     * @Groups({"api-case-list","api-task-list","api-person-get"})
     * @ReadOnly
     */
    protected $donor;

    /**
     * @ORM\ManyToOne(cascade={"persist"}, targetEntity = "Opg\Core\Model\Entity\CaseActor\Correspondent", fetch = "EAGER")
     * @ORM\OrderBy({"id"="ASC"})
     * @var Correspondent
     * @Groups({"api-person-get"})
     * @ReadOnly
     */
    protected $correspondent;

    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\CaseActor\Person")
     * @ORM\JoinTable(name="pa_applicants",
     *     joinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="person_id", referencedColumnName="id")}
     * )
     * @ORM\OrderBy({"id"="ASC"})
     * @ReadOnly
     * @Groups({"api-person-get"})
     * @var ArrayCollection
     */
    protected $applicants;

    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\CaseActor\NotifiedPerson")
     * @ORM\JoinTable(name="pa_notified_persons",
     *     joinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="notified_person_id", referencedColumnName="id")}
     * )
     * @ORM\OrderBy({"id"="ASC"})
     * @ReadOnly
     * @Groups({"api-person-get"})
     * @var ArrayCollection
     */
    protected $notifiedPersons;

    /**
     * @ORM\Column(type = "boolean",options={"default"=0})
     * @var bool
     * @Groups({"api-person-get"})
     */
    protected $usesNotifiedPersons = false;

    /**
     * @ORM\Column(type = "boolean",options={"default"=0})
     * @var bool
     * @Groups({"api-person-get"})
     */
    protected $noNoticeGiven = false;

    /**
     * @ORM\Column(type = "integer",options={"default"=1})
     * @var int
     * @Accessor(getter="getNotifiedPersonPermissionBy",setter="setNotifiedPersonPermissionBy")
     * @Groups({"api-person-get"})
     * These accessors are required to convert between the integer type we store the field as and the
     * human readable text passed around the front end
     */
    protected $notifiedPersonPermissionBy = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\ManyToMany(cascade={"persist"}, targetEntity="Opg\Core\Model\Entity\CaseActor\CertificateProvider")
     * @ORM\JoinTable(name="pa_certificate_provider",
     * joinColumns={@ORM\JoinColumn(name="pa_id", referencedColumnName="id")},
     * inverseJoinColumns={@ORM\JoinColumn(name="certificate_provider_id",
     * referencedColumnName="id")}
     * )
     * @var ArrayCollection
     * @ReadOnly
     * @Groups({"api-person-get"})
     */
    protected $certificateProviders;

    /**
     * @ORM\Column(type="integer",options={"default"=0})
     * @var int
     * @Type("boolean")
     * @Accessor(getter="getPaymentByDebitCreditCardNormalized",setter="setPaymentByDebitCreditCardNormalized")
     * @Groups({"api-person-get"})
     */
    protected $paymentByDebitCreditCard = self::PAYMENT_OPTION_NOT_SET;

    /**
     * @ORM\Column(type="integer",options={"default"=0})
     * @var int
     * @Type("boolean")
     * @Accessor(getter="getPaymentByChequeNormalized",setter="setPaymentByChequeNormalized")
     * @Groups({"api-person-get"})
     */
    protected $paymentByCheque = self::PAYMENT_OPTION_NOT_SET;

    /**
     * @ORM\Column(type="integer", options={"default"=0})
     * @var int
     * @Type("boolean")
     * The discrepancy here is the serializer casts this to a bool and needs the type annotation to enforce this
     * @Accessor(getter="getNormalFeeApplyForRemission", setter="setNormalFeeApplyForRemission")
     * @Groups({"api-person-get"})
     */
    protected $wouldLikeToApplyForFeeRemission = self::PAYMENT_OPTION_NOT_SET;

    /**
     * @ORM\Column(type="integer",options={"default"=0})
     * @var int
     * @Type("boolean")
     * The discrepancy here is the serializer casts this to a bool and needs the type annotation to enforce this
     * @Accessor(getter="getNormalHaveAppliedForRemission", setter="setNormalHaveAppliedForRemission")
     * @Groups({"api-person-get"})
     */
    protected $haveAppliedForFeeRemission= self::PAYMENT_OPTION_NOT_SET;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $cardPaymentContact;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $howAttorneysAct;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $howReplacementAttorneysAct;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $attorneyActDecisions;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $replacementAttorneyActDecisions;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $replacementOrder;

    /**
     * @ORM\Column(type = "text", nullable=true)
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $additionalInfo;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Groups({"api-person-get"})
     */
    protected $anyOtherInfo = false;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Groups({"api-person-get"})
     */
    protected $additionalInfoDonorSignature = false;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString",setter="setDateFromString",propertyName="additionalInfoDonorSignatureDate")
     * @Groups({"api-person-get"})
     */
    protected $additionalInfoDonorSignatureDate;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $paymentId;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $paymentAmount;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString",setter="setDateFromString",propertyName="paymentDate")
     * @Groups({"api-person-get"})
     */
    protected $paymentDate;

    /**
     * @ORM\Column(type="integer",options={"default"=0})
     * @var int
     * @Type("boolean")
     * The discrepancy here is the serializer casts this to a bool and needs the type annotation to enforce this
     * @Accessor(getter="getNormalPaymentRemission", setter="setNormalPaymentRemission")
     * @Groups({"api-person-get"})
     */
    protected $paymentRemission = self::PAYMENT_OPTION_NOT_SET;

    /**
     * @ORM\Column(type="integer",options={"default"=0})
     * @var int
     * @Type("boolean")
     * The discrepancy here is the serializer casts this to a bool and needs the type annotation to enforce this
     * @Accessor(getter="getNormalPaymentExemption", setter="setNormalPaymentExemption")
     * @Groups({"api-person-get"})
     */
    protected $paymentExemption = self::PAYMENT_OPTION_NOT_SET;

    /**
     * @ORM\Column(type="integer",options={"default":1})
     * @var int
     * @Type("string")
     * @Accessor(getter="getAttorneyPartyDeclaration",setter="setAttorneyPartyDeclaration")
     * @Groups({"api-person-get"})
     */
    protected $attorneyPartyDeclaration = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\Column(type="integer",options={"default":1})
     * @var int
     * @Type("string")
     * @Accessor(getter="getAttorneyApplicationAssertion",setter="setAttorneyApplicationAssertion")
     * @Groups({"api-person-get"})
     */
    protected $attorneyApplicationAssertion = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\Column(type="integer",options={"default":1})
     * @var int
     * @Type("string")
     * @Accessor(getter="getAttorneyMentalActPermission",setter="setAttorneyMentalActPermission")
     * @Groups({"api-person-get"})
     */
    protected $attorneyMentalActPermission = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString",setter="setDateFromString", propertyName="attorneyDeclarationSignatureDate")
     * @Groups({"api-person-get"})
     */
    protected $attorneyDeclarationSignatureDate;

    /**
     * @ORM\Column(type="boolean"), options={"default":0})
     * @var bool
     * @Groups({"api-person-get"})
     */
    protected $attorneyDeclarationSignature = false;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Groups({"api-person-get"})
     */
    protected $attorneyDeclarationSignatureWitness = false;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $attorneyDeclarationSignatoryFullName;

    /**
     * @ORM\Column(type="integer",options={"default":1})
     * @var int
     * @Type("string")
     * @Accessor(getter="getCorrespondentComplianceAssertion",setter="setCorrespondentComplianceAssertion")
     * @Groups({"api-person-get"})
     */
    protected $correspondentComplianceAssertion = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString",setter="setDateFromString", propertyName="notificationDate")
     * @Groups({"api-person-get"})
     */
    protected $notificationDate;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString",setter="setDateFromString", propertyName="dispatchDate")
     * @Groups({"api-person-get"})
     */
    protected $dispatchDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Groups({"api-person-get"})
     */
    protected $applicantType;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Groups({"api-person-get"})
     * @GenericAccessor(getter="getDateAsString",setter="getDateAsString", propertyName="cancellationDate")
     */
    protected $cancellationDate;

    /**
     * Non persisted overload for the serializer to correctly convert this into a string. It seems not to work when declared
     * on a base class with this type of conversion
     * @ORM\Column(type = "integer", nullable=true)
     * @Type("string")
     * @Accessor(getter="getApplicationType",setter="setApplicationType")
     * @Groups({"api-case-list","api-task-list","api-person-get"})
     */
    protected $applicationType = self::APPLICATION_TYPE_CLASSIC;

    /**
     * @ORM\Column(type = "integer",options={"default"=1})
     * @var int
     * @Type("string")
     * @Accessor(getter="getApplicantsDeclaration",setter="setApplicantsDeclaration")
     * @Groups({"api-person-get"})
     */
    protected $applicantsDeclaration = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Groups({"api-person-get"})
     * @GenericAccessor(getter="getDateAsString",setter="getDateAsString", propertyName="applicantsDeclarationSignatureDate")
     */
    protected $applicantsDeclarationSignatureDate;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Groups({"api-person-get"})
     *
     * In new applications we map the Instructions checkbox to this field
     */
    protected $applicationHasRestrictions = false;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Groups({"api-person-get"})
     *
     * In newer applications we map the Preferences checkbox to this field
     */
    protected $applicationHasGuidance = false;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Groups({"api-person-get"})
     */
    protected $applicationHasCharges = false;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Groups({"api-person-get"})
     * @GenericAccessor(getter="getDateAsString",setter="getDateAsString", propertyName="certificateProviderSignatureDate")
     */
    protected $certificateProviderSignatureDate;

    /**
     * @ORM\Column(type="boolean"), options={"default":0})
     * @var bool
     * @Groups({"api-person-get"})
     */
    protected $certificateProviderSignature = false;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Groups({"api-person-get"})
     * @GenericAccessor(getter="getDateAsString",setter="getDateAsString", propertyName="attorneyStatementDate")
     */
    protected $attorneyStatementDate;

    public function __construct()
    {
        parent::__construct();

        $this->notifiedPersons      = new ArrayCollection();
        $this->attorneys            = new ArrayCollection();
        $this->applicants           = new ArrayCollection();
        $this->certificateProviders = new ArrayCollection();
    }

    /**
     *
     * @return string $cardPaymentContact
     */
    public function getCardPaymentContact()
    {
        return $this->cardPaymentContact;
    }

    /**
     *
     * @param string $cardPaymentContact
     *
     * @return PowerOfAttorney
     */
    public function setCardPaymentContact($cardPaymentContact)
    {
        $this->cardPaymentContact = $cardPaymentContact;

        return $this;
    }

    /**
    /**
     *
     * @return string $howAttorneysAct
     */
    public function getHowAttorneysAct()
    {
        return $this->howAttorneysAct;
    }

    /**
     *
     * @param string $howAttorneysAct
     *
     * @return PowerOfAttorney
     */
    public function setHowAttorneysAct($howAttorneysAct)
    {
        $this->howAttorneysAct = $howAttorneysAct;

        return $this;
    }

    /**
     *
     * @return string $howReplacementAttorneysAct
     */
    public function getHowReplacementAttorneysAct()
    {
        return $this->howReplacementAttorneysAct;
    }

    /**
     *
     * @param string $howReplacementAttorneysAct
     *
     * @return PowerOfAttorney
     */
    public function setHowReplacementAttorneysAct($howReplacementAttorneysAct)
    {
        $this->howReplacementAttorneysAct = $howReplacementAttorneysAct;

        return $this;
    }

    /**
     *
     * @return string $attorneyActDecisions
     */
    public function getAttorneyActDecisions()
    {
        return $this->attorneyActDecisions;
    }

    /**
     *
     * @param string $attorneyActDecisions
     *
     * @return PowerOfAttorney
     */
    public function setAttorneyActDecisions($attorneyActDecisions)
    {
        $this->attorneyActDecisions = $attorneyActDecisions;

        return $this;
    }

    /**
     *
     * @return string $replacementAttorneyActDecisions
     */
    public function getReplacementAttorneyActDecisions()
    {
        return $this->replacementAttorneyActDecisions;
    }

    /**
     *
     * @param string $replacementAttorneyActDecisions
     *
     * @return PowerOfAttorney
     */
    public function setReplacementAttorneyActDecisions(
        $replacementAttorneyActDecisions
    ) {
        $this->replacementAttorneyActDecisions = $replacementAttorneyActDecisions;

        return $this;
    }

    /**
     *
     * @return string $replacementOrder
     */
    public function getReplacementOrder()
    {
        return $this->replacementOrder;
    }

    /**
     *
     * @param string $replacementOrder
     *
     * @return PowerOfAttorney
     */
    public function setReplacementOrder($replacementOrder)
    {
        $this->replacementOrder = $replacementOrder;

        return $this;
    }

    /**
     * @return string $additionalInfo
     */
    public function getAdditionalInfo()
    {
        return $this->additionalInfo;
    }

    /**
     *
     * @param string $additionalInfo
     *
     * @return PowerOfAttorney
     */
    public function setAdditionalInfo($additionalInfo)
    {
        $this->additionalInfo = $additionalInfo;

        return $this;
    }

    /**
     * @param bool $info
     * @return $this
     */
    public function setAnyOtherInfo($info = false)
    {
        $this->anyOtherInfo = $info;

        return $this;
    }

    /**
     * @return bool
     */
    public function getAnyOtherInfo()
    {
        return $this->anyOtherInfo;
    }

    /**
     * @return bool
     */
    public function getAdditionalInfoDonorSignature()
    {
        return $this->additionalInfoDonorSignature;
    }

    /**
     * @param bool $signature
     * @return PowerOfAttorney
     */
    public function setAdditionalInfoDonorSignature($signature = false)
    {
        $this->additionalInfoDonorSignature = (bool)$signature;

        return $this;
    }

    /**
     * @param \DateTime $signatureDate
     * @return PowerOfAttorney
     */
    public function setAdditionalInfoDonorSignatureDate(\DateTime $signatureDate)
    {
        $this->additionalInfoDonorSignatureDate = $signatureDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getAdditionalInfoDonorSignatureDate()
    {
        return $this->additionalInfoDonorSignatureDate;
    }

    /**
     *
     * @return string $paymentId
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     *
     * @param string $paymentId
     *
     * @return PowerOfAttorney
     */
    public function setPaymentId($paymentId)
    {
        $this->paymentId = $paymentId;

        return $this;
    }

    /**
     *
     * @return string $paymentAmount
     */
    public function getPaymentAmount()
    {
        return $this->paymentAmount;
    }

    /**
     * @param string $paymentAmount
     *
     * @return PowerOfAttorney
     */
    public function setPaymentAmount($paymentAmount)
    {
        $this->paymentAmount = $paymentAmount;

        return $this;
    }

    /**
     * @param \DateTime $paymentDate
     *
     * @return PowerOfAttorney
     */
    public function setPaymentDate(\DateTime $paymentDate = null)
    {
        if (is_null($paymentDate)) {
            $paymentDate = new \DateTime();
        }
        $this->paymentDate = $paymentDate;

        return $this;
    }

    /**
     * @return \DateTime $paymentDate
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * @return Donor
     */
    public function getDonor()
    {
        return $this->donor;
    }

    /**
     * @param Donor $donor
     *
     * @return PowerOfAttorney
     */
    public function setDonor(Donor $donor)
    {
        $this->donor = $donor;

        return $this;
    }

    /**
     * @return Correspondent
     */
    public function getCorrespondent()
    {
        return $this->correspondent;
    }

    /**
     * @param Correspondent $correspondent
     *
     * @return PowerOfAttorney
     */
    public function setCorrespondent(Correspondent $correspondent)
    {
        $this->correspondent = $correspondent;

        return $this;
    }

    /**
     * @return ArrayCollection $applicants
     */
    public function getApplicants()
    {
        if (null ===  $this->applicants) {
            $this->applicants = new ArrayCollection();
        }

        return $this->applicants;
    }

    /**
     * @param Person $applicant
     *
     * @return PowerOfAttorney
     */
    public function addApplicant(Person $applicant)
    {
        if (null === $this->applicants) {
            $this->applicants = new ArrayCollection();
        }

        if (!$this->applicants->contains($applicant)) {
            $this->applicants->add($applicant);
        }

        return $this;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $applicants
     *
     * @internal param \Doctrine\Common\Collections\ArrayCollection $applicantCollection
     * @return PowerOfAttorney
     */
    public function setApplicants(ArrayCollection $applicants)
    {
        foreach ($applicants as $applicant) {
            $this->addApplicant($applicant);
        }

        return $this;
    }

    /**
     * @return ArrayCollection $notifiedPersons
     */
    public function getNotifiedPersons()
    {
        if (null === $this->notifiedPersons) {
            $this->notifiedPersons = new ArrayCollection();
        }

        return $this->notifiedPersons;
    }

    /**
     * @param ArrayCollection $notifiedPersons
     *
     * @return PowerOfAttorney
     */
    public function setNotifiedPersons(ArrayCollection $notifiedPersons)
    {
        foreach ($notifiedPersons as $notifiedPerson) {
            $this->addNotifiedPerson($notifiedPerson);
        }

        return $this;
    }

    /**
     * @param NotifiedPerson $notifiedPerson
     *
     * @return PowerOfAttorney
     */
    public function addNotifiedPerson(NotifiedPerson $notifiedPerson)
    {
        if (is_null($this->notifiedPersons)) {
            $this->notifiedPersons = new ArrayCollection();
        }

        if (!$this->notifiedPersons->contains($notifiedPerson)) {
            $this->notifiedPersons->add($notifiedPerson);
        }

        return $this;
    }

    /**
     * @return ArrayCollection $certificateProviders
     */
    public function getCertificateProviders()
    {
        if (null === $this->certificateProviders) {
            $this->certificateProviders = new ArrayCollection();
        }

        return $this->certificateProviders;
    }

    /**
     * @param ArrayCollection $certificateProviders
     *
     * @return PowerOfAttorney
     */
    public function setCertificateProviders(ArrayCollection $certificateProviders)
    {
        foreach ($certificateProviders as $certificateProvider) {
            $this->addCertificateProvider($certificateProvider);
        }

        return $this;
    }

    /**
     * @param CertificateProvider $certificateProvider
     *
     * @return PowerOfAttorney
     */
    public function addCertificateProvider(CertificateProvider $certificateProvider)
    {
        if (is_null($this->certificateProviders)) {
            $this->certificateProviders = new ArrayCollection();
        }

        if (!$this->certificateProviders->contains($certificateProvider)) {
            $this->certificateProviders->add($certificateProvider);
        }

        return $this;
    }

    /**
     * @return InputFilter
     */
    public function getInputFilter()
    {
        parent::getInputFilter();

        $powerOfAttorneyFilter =  new PowerOfAttorneyFilter();
        foreach($powerOfAttorneyFilter->getInputs() as $name=>$input) {
            $this->inputFilter->add($input, $name);
        }

        return $this->inputFilter;
    }

    /**
     * @param bool $exposeClassname
     *
     * @return array
     */
    public function toArray($exposeClassname = true)
    {
        return $this->traitToArray($exposeClassname);
    }

    /**
     * @param $usesNotifiedPersons
     *
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
     * @param $noNoticeGiven
     *
     * @return PowerOfAttorney
     */
    public function setNoNoticeGiven($noNoticeGiven)
    {
        $this->noNoticeGiven = (bool)$noNoticeGiven;

        return $this;
    }

    /**
     * @return bool
     */
    public function getNoNoticeGiven()
    {
        return $this->noNoticeGiven;
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
     *
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
     *
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
     *
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
     *
     * @return PowerOfAttorney
     */
    public function setAttorneyDeclarationSignatureDate(\DateTime $attorneyDeclarationSignatureDate = null)
    {
        if (is_null($attorneyDeclarationSignatureDate)) {
            $attorneyDeclarationSignatureDate = new \DateTime();
        }
        $this->attorneyDeclarationSignatureDate = $attorneyDeclarationSignatureDate;

        return $this;
    }

    /**
     * @return \DateTime $attorneyDeclarationSignatureDate
     */
    public function getAttorneyDeclarationSignatureDate()
    {
        return $this->attorneyDeclarationSignatureDate;
    }

    /**
     * @return bool
     */
    public function isAttorneyDeclarationSignatureWitnessed()
    {
        return ($this->getAttorneyDeclarationSignatureWitnessed() === true);
    }

    /**
     * @return bool
     */
    public function getAttorneyDeclarationSignatureWitnessed()
    {
        return $this->attorneyDeclarationSignatureWitness;
    }

    /**
     * @param bool $witness
     * @return PowerOfAttorney
     */
    public function setAttorneyDeclarationSignatureWitnessed($witness = false)
    {
        $this->attorneyDeclarationSignatureWitness = $witness;

        return $this;
    }

    /**
     * @return bool
     */
    public function getAttorneyDeclarationSignature()
    {
        return $this->attorneyDeclarationSignature;
    }

    /**
     * @param bool $signed
     * @return PowerOfAttorney
     */
    public function setAttorneyDeclarationSignature($signed = false)
    {
        $this->attorneyDeclarationSignature = $signed;

        return $this;
    }

    /**
     * @param string $attorneyMentalActPermission
     *
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
     *
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
     *
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
     * @param int $wouldLikeToApplyForFeeRemission
     *
     * @return PowerOfAttorney
     */
    public function setWouldLikeToApplyForFeeRemission($wouldLikeToApplyForFeeRemission = self::PAYMENT_OPTION_NOT_SET)
    {
        $this->wouldLikeToApplyForFeeRemission = $wouldLikeToApplyForFeeRemission;

        return $this;
    }

    /**
     * @return int
     */
    public function getWouldLikeToApplyForFeeRemission()
    {
        return $this->wouldLikeToApplyForFeeRemission;
    }

    /**
     * @param int $haveAppliedForFeeRemission
     *
     * @return PowerOfAttorney
     */
    public function setHaveAppliedForFeeRemission($haveAppliedForFeeRemission = self::PAYMENT_OPTION_NOT_SET)
    {
        $this->haveAppliedForFeeRemission = $haveAppliedForFeeRemission;

        return $this;
    }

    /**
     * @return int
     */
    public function getHaveAppliedForFeeRemission()
    {
        return $this->haveAppliedForFeeRemission;
    }

    /**
     * @param int $paymentByCheque
     *
     * @return PowerOfAttorney
     */
    public function setPaymentByCheque($paymentByCheque = self::PAYMENT_OPTION_NOT_SET)
    {
        $this->paymentByCheque = $paymentByCheque;

        return $this;
    }

    /**
     * @param $value
     *
     * @return PowerOfAttorney
     */
    public function setPaymentByChequeNormalized($value) {
        if (is_null($value)) {
            $this->paymentByCheque = self::PAYMENT_OPTION_NOT_SET;
        } elseif ($value === true ) {
            $this->paymentByCheque = self::PAYMENT_OPTION_TRUE;
        } else {
            $this->paymentByCheque = self::PAYMENT_OPTION_FALSE;
        }

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
     * @return bool|null
     */
    public function getPaymentByChequeNormalized()
    {
        switch($this->paymentByCheque) {
            case self::PAYMENT_OPTION_FALSE:
                return false;
            case self::PAYMENT_OPTION_TRUE:
                return true;
            default :
                return null;
        }
    }

    /**
     * @param int $paymentByDebitCreditCard
     *
     * @return PowerOfAttorney
     */
    public function setPaymentByDebitCreditCard($paymentByDebitCreditCard = self::PAYMENT_OPTION_NOT_SET)
    {
        $this->paymentByDebitCreditCard = $paymentByDebitCreditCard;

        return $this;
    }

    /**
     * @param $value
     *
     * @return PowerOfAttorney
     */
    public function setPaymentByDebitCreditCardNormalized($value) {
        if (is_null($value)) {
            $this->paymentByDebitCreditCard = self::PAYMENT_OPTION_NOT_SET;
        } elseif ($value === true ) {
            $this->paymentByDebitCreditCard = self::PAYMENT_OPTION_TRUE;
        } else {
            $this->paymentByDebitCreditCard = self::PAYMENT_OPTION_FALSE;
        }

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
     * @return bool|null
     */
    public function getPaymentByDebitCreditCardNormalized()
    {
        switch($this->paymentByDebitCreditCard) {
            case self::PAYMENT_OPTION_FALSE:
                return false;
            case self::PAYMENT_OPTION_TRUE:
                return true;
            default:
                return null;
        }
    }

    /**
     * @param \DateTime $dispatchDate
     *
     * @return PowerOfAttorney
     */
    public function setDispatchDate(\DateTime $dispatchDate = null)
    {
        if (is_null($dispatchDate)) {
            $dispatchDate = new \DateTime();
        }
        $this->dispatchDate = $dispatchDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDispatchDate()
    {
        return $this->dispatchDate;
    }

    /**
     * @param \DateTime $notificationDate
     *
     * @return PowerOfAttorney
     */
    public function setNotificationDate(\DateTime $notificationDate = null)
    {
        if (is_null($notificationDate)) {
            $notificationDate = new \DateTime();
        }
        $this->notificationDate = $notificationDate;

        return $this;
    }

    /**
     * @return \DateTime $notificationDate
     */
    public function getNotificationDate()
    {
        return $this->notificationDate;
    }

    /**
     * @param int $paymentExemption
     * @return PowerOfAttorney
     */
    public function setPaymentExemption($paymentExemption = self::PAYMENT_OPTION_NOT_SET)
    {
        $this->paymentExemption =$paymentExemption;
        return $this;
    }

    /**
     * @return int
     */
    public function getPaymentExemption()
    {
        return $this->paymentExemption;
    }

    /**
     * @param int $paymentRemission
     * @return PowerOfAttorney
     */
    public function setPaymentRemission($paymentRemission = self::PAYMENT_OPTION_NOT_SET)
    {
        $this->paymentRemission = $paymentRemission;
        return $this;
    }

    /**
     * @return int
     */
    public function getPaymentRemission()
    {
        return (bool)$this->paymentRemission;
    }

    /**
     * @param string $applicantType
     * @return PowerOfAttorney
     */
    public function setApplicantType($applicantType)
    {
        $this->applicantType = $applicantType;

        return $this;
    }

    /**
     * @return string
     */
    public function getApplicantType()
    {
        return $this->applicantType;
    }

    /**
     * @param \DateTime $cancellationDate
     * @return PowerOfAttorney
     */
    public function setCancellationDate(\DateTime $cancellationDate = null)
    {
        $this->cancellationDate = $cancellationDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCancellationDate()
    {
        return $this->cancellationDate;
    }

    /**
     * @param string $permissionBy
     *
     * @return PowerOfAttorney
     */
    public function setApplicantsDeclaration($permissionBy)
    {
        $this->applicantsDeclaration =
            ($permissionBy === 'I') ?
                self::PERMISSION_GIVEN_SINGULAR :
                self::PERMISSION_GIVEN_PLURAL;

        return $this;
    }

    /**
     * @return string
     */
    public function getApplicantsDeclaration()
    {
        return ($this->applicantsDeclaration === self::PERMISSION_GIVEN_SINGULAR)
            ? 'I'
            : 'We';
    }

    /**
     * @param \DateTime $signatureDate
     * @return PowerOfAttorney
     */
    public function setApplicantsDeclarationSignatureDate(\DateTime $signatureDate = null)
    {
        $this->applicantsDeclarationSignatureDate = $signatureDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getApplicantsDeclarationSignatureDate()
    {
        return $this->applicantsDeclarationSignatureDate;
    }


    /**
     * @param bool $restrictions
     * @return PowerOfAttorney
     */
    public function setApplicationHasRestrictions($restrictions = false)
    {
        $this->applicationHasRestrictions = $restrictions;

        return $this;
    }

    /**
     * @return bool
     */
    public function getApplicationHasRestrictions()
    {
        return $this->applicationHasRestrictions;
    }

    /**
     * @param bool $guidance
     * @return PowerOfAttorney
     */
    public function setApplicationHasGuidance($guidance = false)
    {
        $this->applicationHasGuidance = $guidance;

        return $this;
    }

    /**
     * @return bool
     */
    public function getApplicationHasGuidance()
    {
        return $this->applicationHasGuidance;
    }

    /**
     * @param bool $charges
     * @return PowerOfAttorney
     */
    public function setApplicationHasCharges($charges = false)
    {
        $this->applicationHasCharges = $charges;
        return $this;
    }

    /**
     * @return bool
     */
    public function getApplicationHasCharges()
    {
        return $this->applicationHasCharges;
    }

    /**
     * @param \DateTime $signatureDate
     * @return PowerOfAttorney
     */
    public function setCertificateProviderSignatureDate(\DateTime $signatureDate = null)
    {
        $this->certificateProviderSignatureDate = $signatureDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCertificateProviderSignatureDate()
    {
        return $this->certificateProviderSignatureDate;
    }

    /**
     * @param bool $signed
     * @return PowerOfAttorney
     */
    public function setCertificateProviderSignature($signed = false)
    {
        $this->certificateProviderSignature = $signed;

        return $this;
    }

    /**
     * @return bool
     */
    public function getCertificateProviderSignature()
    {
        return $this->certificateProviderSignature;
    }

    /**
     * @param \DateTime $signatureDate
     * @return PowerOfAttorney
     */
    public function setAttorneyStatementDate(\DateTime $signatureDate = null)
    {
        $this->attorneyStatementDate = $signatureDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getAttorneyStatementDate()
    {
        return $this->attorneyStatementDate;
    }

    /**
     * @return bool|null
     */
    public function getNormalFeeApplyForRemission()
    {
        switch($this->wouldLikeToApplyForFeeRemission) {
            case self::PAYMENT_OPTION_FALSE:
                return false;
            case self::PAYMENT_OPTION_TRUE:
                return true;
            default :
                return null;
        }
    }

    /**
     * @param $value
     * @return PowerOfAttorney
     */
    public function setNormalFeeApplyForRemission($value)
    {
        if (is_null($value)) {
            $this->wouldLikeToApplyForFeeRemission = self::PAYMENT_OPTION_NOT_SET;
        } elseif ($value === true) {
            $this->wouldLikeToApplyForFeeRemission = self::PAYMENT_OPTION_TRUE;
        } else {
            $this->wouldLikeToApplyForFeeRemission = self::PAYMENT_OPTION_FALSE;
        }

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getNormalHaveAppliedForRemission()
    {
        switch($this->haveAppliedForFeeRemission) {
            case self::PAYMENT_OPTION_FALSE:
                return false;
            case self::PAYMENT_OPTION_TRUE:
                return true;
            default :
                return null;
        }
    }

    /**
     * @param $value
     * @return PowerOfAttorney
     */
    public function setNormalHaveAppliedForRemission($value)
    {
        if (is_null($value)) {
            $this->haveAppliedForFeeRemission = self::PAYMENT_OPTION_NOT_SET;
        } elseif ($value === true) {
            $this->haveAppliedForFeeRemission = self::PAYMENT_OPTION_TRUE;
        } else {
            $this->haveAppliedForFeeRemission = self::PAYMENT_OPTION_FALSE;
        }

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getNormalPaymentRemission()
    {
        switch($this->paymentRemission) {
            case self::PAYMENT_OPTION_FALSE:
                return false;
            case self::PAYMENT_OPTION_TRUE:
                return true;
            default :
                return null;
        }
    }

    /**
     * @param $value
     * @return PowerOfAttorney
     */
    public function setNormalPaymentRemission($value)
    {
        if (is_null($value)) {
            $this->paymentRemission = self::PAYMENT_OPTION_NOT_SET;
        } elseif ($value === true) {
            $this->paymentRemission = self::PAYMENT_OPTION_TRUE;
        } else {
            $this->paymentRemission = self::PAYMENT_OPTION_FALSE;
        }

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getNormalPaymentExemption()
    {
        switch($this->paymentExemption) {
            case self::PAYMENT_OPTION_FALSE:
                return false;
            case self::PAYMENT_OPTION_TRUE:
                return true;
            default :
                return null;
        }
    }

    /**
     * @param $value
     * @return PowerOfAttorney
     */
    public function setNormalPaymentExemption($value)
    {
        if (is_null($value)) {
            $this->paymentExemption = self::PAYMENT_OPTION_NOT_SET;
        } elseif ($value === true) {
            $this->paymentExemption = self::PAYMENT_OPTION_TRUE;
        } else {
            $this->paymentExemption = self::PAYMENT_OPTION_FALSE;
        }

        return $this;
    }
}
