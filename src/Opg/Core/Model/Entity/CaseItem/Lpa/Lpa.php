<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\AttorneyAbstract;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;
use Opg\Core\Model\Entity\CaseItem\Lpa\Validator\CaseType as CaseTypeValidator;
use Opg\Core\Model\Entity\Person\Person;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\InputFilter\LpaFilter;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\ReadOnly;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Type;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * @ORM\Entity
 * @ORM\EntityListeners({"Opg\Core\Model\Entity\CaseItem\Lpa\LpaListener"})
 *
 * Class Lpa
 *
 * @package Opg Core
 */
class Lpa extends PowerOfAttorney
{
    const PF_FULLTEXTNAME = 'Personal Finance';
    const HW_FULLTEXTNAME = 'Health and Welfare';

    /**
     * @ORM\Column(type = "string", nullable = true)
     * @var string
     * @Groups("api-task-list")
     */
    protected $caseType = CaseTypeValidator::CASE_TYPE_LPA;

    /**
     * @ORM\Column(type = "integer",options={"default":1}, name="ascertained_by")
     * @var integer
     * @Accessor(getter="getLpaAccuracyAscertainedBy",setter="setLPaAccuracyAscertainedBy")
     * @Groups("api-task-list")
     */
    protected $lpaAccuracyAscertainedBy = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Accessor(getter="getLpaDonorSignatureDateString",setter="setLpaDonorSignatureDateString")
     * @Type("string")
     * @Groups("api-task-list")
     */
    protected $lpaDonorSignatureDate;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups("api-task-list")
     */
    protected $lpaDonorSignatoryFullName;

    /**
     * @ORM\Column(type = "boolean",options={"default":0})
     * @var bool
     * @Groups("api-task-list")
     */
    protected $donorHasPreviousLpas = false;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups("api-task-list")
     */
    protected $previousLpaInfo;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getDonorDeclarationSignatureDateString", setter="setDonorDeclarationSignatureDateString")
     * @Groups("api-task-list")
     */
    protected $lpaDonorDeclarationSignatureDate;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups("api-task-list")
     */
    protected $lpaDonorDeclarationSignatoryFullName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getLpaCreatedDateString",setter="setLpaCreatedDateString")
     * @Groups("api-task-list")
     */
    protected $lpaCreatedDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getLpaReceiptDateString",setter="setLpaReceiptDateString")
     * @Groups("api-task-list")
     */
    protected $lpaReceiptDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Groups("api-task-list")
     */
    protected $lifeSustainingTreatment;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getLifeSustainingTreatmentSignatureDateString",setter="setLifeSustainingTreatmentSignatureDateString")
     * @Groups("api-task-list")
     */
    protected $lifeSustainingTreatmentSignatureDate;

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
     * @param string $signatureDate
     *
     * @return Lpa
     */
    public function setLpaDonorSignatureDateString($signatureDate)
    {
        if (!empty($signatureDate)) {
            $signatureDate = OPGDateFormat::createDateTime($signatureDate);

            if ($signatureDate) {
                $this->setLpaDonorSignatureDate($signatureDate);
            }
        }

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
     * @return string
     */
    public function getLpaDonorSignatureDateString()
    {
        if (!empty($this->lpaDonorSignatureDate)) {
            return $this->lpaDonorSignatureDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
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
     * @param string $signatureDate
     *
     * @return Lpa
     */
    public function setDonorDeclarationSignatureDateString($signatureDate)
    {
        if (!empty($signatureDate)) {
            $signatureDate = OPGDateFormat::createDateTime($signatureDate);

            if ($signatureDate) {
                $this->setDonorDeclarationSignatureDate($signatureDate);
            }
        }

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
     * @return string
     */
    public function getDonorDeclarationSignatureDateString()
    {
        if (!empty($this->lpaDonorDeclarationSignatureDate)) {
            return $this->lpaDonorDeclarationSignatureDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
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
            $this->inputFilter = new LpaFilter();
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
     * @param string $lpaCreatedDate
     *
     * @return Lpa
     */
    public function setLpaCreatedDateString($lpaCreatedDate)
    {
        if (!empty($lpaCreatedDate)) {
            $lpaCreatedDate = OPGDateFormat::createDateTime($lpaCreatedDate);

            if ($lpaCreatedDate) {
                return $this->setLpaCreatedDate($lpaCreatedDate);
            }

        }

        return $this->setLpaCreatedDate(new \DateTime());
    }

    /**
     * @return string
     */
    public function getLpaCreatedDate()
    {
        return $this->lpaCreatedDate;
    }

    /**
     * @return string
     */
    public function getLpaCreatedDateString()
    {
        if (!empty($this->lpaCreatedDate)) {
            return $this->lpaCreatedDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
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
     * @param string $lpaReceiptDate
     *
     * @return Lpa
     */
    public function setLpaReceiptDateString($lpaReceiptDate)
    {
        if (!empty($lpaReceiptDate)) {
            $lpaReceiptDate = OPGDateFormat::createDateTime($lpaReceiptDate);

            if ($lpaReceiptDate) {
                return $this->setLpaReceiptDate($lpaReceiptDate);
            }
        }

        return $this->setLpaReceiptDate(new \DateTime($lpaReceiptDate));
    }

    /**
     * @return \DateTime
     */
    public function getLpaReceiptDate()
    {
        return $this->lpaReceiptDate;
    }

    /**
     * @return string
     */
    public function getLpaReceiptDateString()
    {
        if (!empty($this->lpaReceiptDate)) {
            return $this->lpaReceiptDate->format(OPGDateFormat::getDateTimeFormat());
        }

        return '';
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
    public function setLifeSustainingTreatmentSignatureDate(\DateTime $lifeSustainingTreatmentSignatureDate = null)
    {
        if (is_null($lifeSustainingTreatmentSignatureDate)) {
            $lifeSustainingTreatmentSignatureDate = new \DateTime();
        }
        $this->lifeSustainingTreatmentSignatureDate = $lifeSustainingTreatmentSignatureDate;

        return $this;
    }

    /**
     * @param string $lifeSustainingTreatmentSignatureDate
     *
     * @return Lpa
     */
    public function setLifeSustainingTreatmentSignatureDateString($lifeSustainingTreatmentSignatureDate)
    {
        if (!empty($lifeSustainingTreatmentSignatureDate)) {
            $lifeSustainingTreatmentSignatureDate = OPGDateFormat::createDateTime(
                $lifeSustainingTreatmentSignatureDate
            );

            if ($lifeSustainingTreatmentSignatureDate) {
                $this->setLifeSustainingTreatmentSignatureDate($lifeSustainingTreatmentSignatureDate);
            }
        }

        return $this;

    }

    /**
     * @return string
     */
    public function getLifeSustainingTreatmentSignatureDate()
    {
        return $this->lifeSustainingTreatmentSignatureDate;
    }

    /**
     * @return string
     */
    public function getLifeSustainingTreatmentSignatureDateString()
    {
        if (!empty($this->lifeSustainingTreatmentSignatureDate)) {
            return $this->lifeSustainingTreatmentSignatureDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
    }
}
