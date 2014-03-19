<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa;

use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Attorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\CertificateProvider;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Correspondent;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\Donor;
use Opg\Core\Model\Entity\CaseItem\Lpa\Party\NotifiedPerson;
use Opg\Core\Model\Entity\Person\Person;
use Opg\Core\Model\Entity\PowerOfAttorney\PowerOfAttorney;
use Opg\Core\Model\Entity\CaseItem\Lpa\InputFilter\LpaFilter;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;

/**
 * @ORM\Entity
 *
 * Class Lpa
 *
 * @package Opg Core
 */
class Lpa extends PowerOfAttorney
{

    /**
     * @ORM\Column(type = "integer",options={"default":1}, name="ascertained_by")
     * @var integer
     * @Type("integer")
     */
    protected $lpaAccuracyAscertainedBy = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\Column(type = "datetime")
     * @var \DateTime
     * @Type("datetime")
     */
    protected $lpaDonorSignatureDate;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Type("string")
     */
    protected $lpaDonorSignatoryFullName;

    /**
     * @ORM\Column(type = "boolean",options={"default":0})
     * @var bool
     * @Type("boolean")
     */
    protected $donorHasPreviousLpas = false;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Type("string")
     */
    protected $previousLpaInfo;

    /**
     * @ORM\Column(type = "datetime")
     * @var \DateTime
     * @Type("datetime")
     */
    protected $lpaDonorDeclarationSignatureDate;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Type("string")
     */
    protected $lpaDonorDeclarationSignatoryFullName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("datetime")
     */
    protected $lpaCreatedDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("datetime")
     */
    protected $lpaReceiptDate;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Type("boolean")
     */
    protected $lifeSustainingTreatment = false;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var \DateTime
     * @Type("datetime")
     */
    protected $lifeSustainingTreatmentSignatureDate;

    /**
     * @param int $signedBy
     * @return Lpa
     */
    public function setAccuracyAscertainedBy($signedBy = self::PERMISSION_GIVEN_SINGULAR)
    {
        $this->lpaAccuracyAscertainedBy = $signedBy;
        return $this;
    }

    /**
     * @return int
     */
    public function getAccuracyAscertainedBy()
    {
        return $this->lpaAccuracyAscertainedBy;
    }

    /**
     * @param \DateTime $signatureDate
     * @return $this
     */
    public function setDonorSignatureDate(\DateTime $signatureDate)
    {
        $this->lpaDonorSignatureDate = $signatureDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDonorSignatureDate()
    {
        return $this->lpaDonorSignatureDate;
    }

    /**
     * @param  string $fullName
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
     * @return $this
     */
    public function setDonorDeclarationSignatureDate(\DateTime $signatureDate)
    {
        $this->lpaDonorDeclarationSignatureDate = $signatureDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDonorDeclarationSignatureDate()
    {
        return $this->lpaDonorDeclarationSignatureDate;
    }

    /**
     * @param  string $fullName
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
     * @return CaseItem
     * @throws \LogicException
     */
    public function addPerson(Person $person)
    {
        if ($person instanceof Attorney) {
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
     * @return Lpa
     */
    public function setLpaCreatedDate(\DateTime $lpaCreatedDate = null)
    {
        $this->lpaCreatedDate =
            (null === $lpaCreatedDate) ? new \DateTime() : $lpaCreatedDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLpaCreatedDate()
    {
        return $this->lpaCreatedDate;
    }

    /**
     * @param \DateTime $lpaReceiptDate
     * @return Lpa
     */
    public function setLpaReceiptDate(\DateTime $lpaReceiptDate)
    {
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
     * @param boolean $lifeSustainingTreatment
     * @return Lpa
     */
    public function setLifeSustainingTreatment($lifeSustainingTreatment = false)
    {
        $this->lifeSustainingTreatment = $lifeSustainingTreatment;
        return $this;
    }

    /**
     * @return boolean
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
        return $this->getLifeSustainingTreatment();
    }

    /**
     * @param \DateTime $lifeSustainingTreatmentSignatureDate
     * @return Lpa
     */
    public function setLifeSustainingTreatmentSignatureDate(\DateTime $lifeSustainingTreatmentSignatureDate)
    {
        $this->lifeSustainingTreatmentSignatureDate = $lifeSustainingTreatmentSignatureDate;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getLifeSustainingTreatmentSignatureDate()
    {
        return $this->lifeSustainingTreatmentSignatureDate;
    }



}
