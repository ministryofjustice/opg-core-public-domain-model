<?php
namespace Opg\Core\Model\Entity\CaseItem\PowerOfAttorney;

use Opg\Core\Model\Entity\CaseActor\AttorneyAbstract;
use Opg\Core\Model\Entity\CaseActor\CertificateProvider;
use Opg\Core\Model\Entity\CaseActor\Correspondent;
use Opg\Core\Model\Entity\CaseActor\NotifiedPerson;
use Opg\Core\Model\Entity\CaseActor\Donor;
use Opg\Core\Model\Entity\CaseItem\Validation\Validator\CaseType as CaseTypeValidator;
use Opg\Core\Model\Entity\CaseActor\Person;
use Opg\Core\Model\Entity\CaseItem\Validation\InputFilter\LpaFilter;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\GenericAccessor;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * @ORM\Entity
 * @ORM\EntityListeners({"BusinessRule\Specification\Lpa\Listener"})
 *
 * Class Lpa
 *
 * @package Opg Core
 */
class Lpa extends PowerOfAttorney
{
    const PF_FULLTEXTNAME = 'Property and Financial Affairs';
    const HW_FULLTEXTNAME = 'Health and Welfare';

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $caseType = CaseTypeValidator::CASE_TYPE_LPA;

    /**
     * @ORM\Column(type = "integer",options={"default":1}, name="ascertained_by")
     * @var integer
     * @Accessor(getter="getLpaAccuracyAscertainedBy",setter="setLPaAccuracyAscertainedBy")
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $lpaAccuracyAscertainedBy = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="lpaDonorSignatureDate")
     * @Type("string")
     * @Groups({"api-task-list","api-person-get","api-case-list"})
     */
    protected $lpaDonorSignatureDate;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $lpaDonorSignature = false;

    /**
     * @ORM\Column(type = "boolean", options={"default":0})
     * @var bool
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $donorSignatureWitnessed = false;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $lpaDonorSignatoryFullName;

    /**
     * @ORM\Column(type = "boolean",options={"default":0})
     * @var bool
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $donorHasPreviousLpas = false;

    /**
     * @ORM\Column(type = "text")
     * @var string
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $previousLpaInfo;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="lpaDonorDeclarationSignatureDate")
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $lpaDonorDeclarationSignatureDate;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $lpaDonorDeclarationSignatoryFullName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="lpaCreatedDate")
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $lpaCreatedDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="lpaReceiptDate")
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $lpaReceiptDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $lifeSustainingTreatment;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="lifeSustainingTreatmentSignatureDateA")
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $lifeSustainingTreatmentSignatureDateA;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString", setter="setDateFromString", propertyName="lifeSustainingTreatmentSignatureDateB")
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $lifeSustainingTreatmentSignatureDateB;

    /**
     * @ORM\Column(type = "integer",options={"default":1})
     * @var string
     * @Accessor(getter="getTrustCorporationSignedAs",setter="setTrustCorporationSignedAs")
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $trustCorporationSignedAs;

    /**
     * @param string $signedBy
     *
     * @return Lpa
     */
    public function setLpaAccuracyAscertainedBy($signedBy)
    {
        $this->lpaAccuracyAscertainedBy =
            ($signedBy === 'I') ?
                self::PERMISSION_GIVEN_SINGULAR :
                self::PERMISSION_GIVEN_PLURAL;

        return $this;
    }

    /**
     * @return string
     */
    public function getLpaAccuracyAscertainedBy()
    {
        return ($this->lpaAccuracyAscertainedBy === self::PERMISSION_GIVEN_SINGULAR)
            ? 'I'
            : 'We';
    }

    /**
     * @param \DateTime $signatureDate
     *
     * @return $this
     */
    public function setLpaDonorSignatureDate(\DateTime $signatureDate = null)
    {
        if (is_null($signatureDate)) {
            $signatureDate = new \DateTime();
        }
        $this->lpaDonorSignatureDate = $signatureDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getLpaDonorSignatureDate()
    {
        return $this->lpaDonorSignatureDate;
    }


    /**
     * @return bool
     */
    public function isDonorSignatureWitnessed()
    {
        return ($this->getDonorSignatureWitnessed() === true);
    }

    /**
     * @return bool
     */
    public function getDonorSignatureWitnessed()
    {
        return $this->donorSignatureWitnessed;
    }

    /**
     * @param $witnessed
     * @return Lpa
     */
    public function setDonorSignatureWitnessed($witnessed = false)
    {
        $this->donorSignatureWitnessed = (bool) $witnessed;

        return $this;
    }

    /**
     * @param  string $fullName
     *
     * @return Lpa
     */
    public function setDonorLpaSignatoryFullName($fullName)
    {
        $this->lpaDonorSignatoryFullName = $fullName;

        return $this;
    }

    /**
     * @return string
     */
    public function getDonorLpaSignatoryFullName()
    {
        return $this->lpaDonorSignatoryFullName;
    }

    /**
     * @param \DateTime $signatureDate
     *
     * @return $this
     */
    public function setDonorDeclarationSignatureDate(\DateTime $signatureDate = null)
    {
        if (is_null($signatureDate)) {
            $signatureDate = new \DateTime();
        }
        $this->lpaDonorDeclarationSignatureDate = $signatureDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getDonorDeclarationSignatureDate()
    {
        return $this->lpaDonorDeclarationSignatureDate;
    }

    /**
     * @param  string $fullName
     *
     * @return Lpa
     */
    public function setDonorDeclarationLpaSignatoryFullName($fullName)
    {
        $this->lpaDonorDeclarationSignatoryFullName = $fullName;

        return $this;
    }

    /**
     * @return string
     */
    public function getDonorDeclarationLpaSignatoryFullName()
    {
        return $this->lpaDonorDeclarationSignatoryFullName;
    }

    /**
     * @param   bool $previousLpas
     *
     * @return  Lpa
     */
    public function setDonorHasPreviousLpas($previousLpas)
    {
        $this->donorHasPreviousLpas = (bool)$previousLpas;

        return $this;
    }

    /**
     * @return bool
     */
    public function getDonorHasPreviousLpas()
    {
        return $this->donorHasPreviousLpas;
    }

    /**
     * Alias for Lpa::getDonorHasPreviousLpas
     * @return bool
     */
    public function hasPreviousLpas()
    {
        return $this->getDonorHasPreviousLpas();
    }

    /**
     * @param   string $lpaInfo
     *
     * @return  Lpa
     */
    public function setPreviousLpaInfo($lpaInfo)
    {
        $this->previousLpaInfo = $lpaInfo;

        return $this;
    }

    public function getPreviousLpaInfo()
    {
        return $this->previousLpaInfo;
    }

    /**
     * @return InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            parent::getInputFilter();

            $lpaFilter =  new LpaFilter();
            foreach($lpaFilter->getInputs() as $name=>$input) {
                $this->inputFilter->add($input, $name);
            }
        }

        return $this->inputFilter;
    }

    /**
     * @param Person $person
     *
     * @return CaseItem
     * @throws \LogicException
     */
    public function addPerson(Person $person)
    {
        if ($person instanceof AttorneyAbstract) {
            $this->addAttorney($person);
        } elseif ($person instanceof CertificateProvider) {
            $this->addCertificateProvider($person);
        } elseif ($person instanceof NotifiedPerson) {
            $this->addNotifiedPerson($person);
        } elseif ($person instanceof Correspondent) {
            $this->setCorrespondent($person);
        } elseif ($person instanceof Donor) {
            $this->setDonor($person);
        } else {
            throw new \LogicException(__CLASS__ . ' does not support a person of type ' . get_class($person));
        }

        return $this;
    }

    /**
     * @param \DateTime $lpaCreatedDate
     *
     * @return Lpa
     */
    public function setLpaCreatedDate(\DateTime $lpaCreatedDate = null)
    {
        if (is_null($lpaCreatedDate)) {
            $lpaCreatedDate = new \DateTime();
        }
        $this->lpaCreatedDate = $lpaCreatedDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getLpaCreatedDate()
    {
        return $this->lpaCreatedDate;
    }

    /**
     * @param \DateTime $lpaReceiptDate
     *
     * @return Lpa
     */
    public function setLpaReceiptDate(\DateTime $lpaReceiptDate = null)
    {
        if (is_null($lpaReceiptDate)) {
            $lpaReceiptDate = new \DateTime();
        }
        $this->lpaReceiptDate = $lpaReceiptDate;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLpaReceiptDate()
    {
        return $this->lpaReceiptDate;
    }

    /**
     * @param string $lifeSustainingTreatment
     *
     * @return Lpa
     */
    public function setLifeSustainingTreatment($lifeSustainingTreatment = '')
    {
        $this->lifeSustainingTreatment = $lifeSustainingTreatment;

        return $this;
    }

    /**
     * @return string
     */
    public function getLifeSustainingTreatment()
    {
        return $this->lifeSustainingTreatment;
    }

    /**
     * Alias for getLifeSustainingTreatment
     * @return boolean
     */
    public function hasLifeSustainingTreatment()
    {
        return !empty($this->getLifeSustainingTreatment());
    }

    /**
     * @param \DateTime $lifeSustainingTreatmentSignatureDate
     *
     * @return Lpa
     */
    public function setLifeSustainingTreatmentSignatureDateA(\DateTime $lifeSustainingTreatmentSignatureDate = null)
    {
        if (is_null($lifeSustainingTreatmentSignatureDate)) {
            $lifeSustainingTreatmentSignatureDate = new \DateTime();
        }
        $this->lifeSustainingTreatmentSignatureDateA = $lifeSustainingTreatmentSignatureDate;

        return $this;
    }

    /**
     * @param \DateTime $lifeSustainingTreatmentSignatureDate
     *
     * @return Lpa
     */
    public function setLifeSustainingTreatmentSignatureDateB(\DateTime $lifeSustainingTreatmentSignatureDate = null)
    {
        if (is_null($lifeSustainingTreatmentSignatureDate)) {
            $lifeSustainingTreatmentSignatureDate = new \DateTime();
        }
        $this->lifeSustainingTreatmentSignatureDateB = $lifeSustainingTreatmentSignatureDate;

        return $this;
    }

    /**
     * @param string $lifeSustainingTreatmentSignatureDate
     *
     * @return Lpa
     */
    public function setLifeSustainingTreatmentSignatureDateAString($lifeSustainingTreatmentSignatureDate)
    {
        if (!empty($lifeSustainingTreatmentSignatureDate)) {
            $lifeSustainingTreatmentSignatureDate = OPGDateFormat::createDateTime(
                $lifeSustainingTreatmentSignatureDate
            );
            return $this->setLifeSustainingTreatmentSignatureDateA($lifeSustainingTreatmentSignatureDate);
        }

        return $this;

    }

    /**
     * @param string $lifeSustainingTreatmentSignatureDate
     *
     * @return Lpa
     */
    public function setLifeSustainingTreatmentSignatureDateBString($lifeSustainingTreatmentSignatureDate)
    {
        if (!empty($lifeSustainingTreatmentSignatureDate)) {
            $lifeSustainingTreatmentSignatureDate = OPGDateFormat::createDateTime(
                $lifeSustainingTreatmentSignatureDate
            );
            return $this->setLifeSustainingTreatmentSignatureDateB($lifeSustainingTreatmentSignatureDate);
        }

        return $this;

    }

    /**
     * @return string
     */
    public function getLifeSustainingTreatmentSignatureDateA()
    {
        return $this->lifeSustainingTreatmentSignatureDateA;
    }

    /**
     * @return string
     */
    public function getLifeSustainingTreatmentSignatureDateB()
    {
        return $this->lifeSustainingTreatmentSignatureDateB;
    }

    /**
     * @return string
     */
    public function getLifeSustainingTreatmentSignatureDateAString()
    {
        if (!empty($this->lifeSustainingTreatmentSignatureDateA)) {
            return $this->lifeSustainingTreatmentSignatureDateA->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @return string
     */
    public function getLifeSustainingTreatmentSignatureDateBString()
    {
        if (!empty($this->lifeSustainingTreatmentSignatureDateB)) {
            return $this->lifeSustainingTreatmentSignatureDateB->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }

    /**
     * @param string $trustCorporationSignedAs
     * @return Lpa
     */
    public function setTrustCorporationSignedAs($trustCorporationSignedAs)
    {
        $this->trustCorporationSignedAs =
            ($trustCorporationSignedAs === 'I') ?
                self::PERMISSION_GIVEN_SINGULAR :
                self::PERMISSION_GIVEN_PLURAL;

        return $this;
    }

    /**
     * @return string
     */
    public function getTrustCorporationSignedAs()
    {
        return ($this->trustCorporationSignedAs === self::PERMISSION_GIVEN_SINGULAR) ? 'I' : 'We';
    }

    /**
     * @return bool
     */
    public function getLpaDonorSignature()
    {
        return $this->lpaDonorSignature;
    }

    /**
     * @param bool $signed
     * @return Lpa
     */
    public function setLpaDonorSignature($signed = false)
    {
        $this->lpaDonorSignature = $signed;

        return $this;
    }
}
