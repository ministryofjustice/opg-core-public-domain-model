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
use JMS\Serializer\Annotation\Accessor;

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

    /**
     * @ORM\Column(type = "integer",options={"default":1}, name="ascertained_by")
     * @var integer
     * @Type("string")
     * @Accessor(getter="getLpaAccuracyAscertainedBy",setter="setLPaAccuracyAscertainedBy")
     */
    protected $lpaAccuracyAscertainedBy = self::PERMISSION_GIVEN_SINGULAR;

    /**
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Type("string")
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
     * @ORM\Column(type = "string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $lpaDonorDeclarationSignatureDate;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Type("string")
     */
    protected $lpaDonorDeclarationSignatoryFullName;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $lpaCreatedDate;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $lpaReceiptDate;

    /**
     * @ORM\Column(type="boolean",options={"default"=0})
     * @var bool
     * @Type("boolean")
     */
    protected $lifeSustainingTreatment = false;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Type("string")
     */
    protected $lifeSustainingTreatmentSignatureDate;

    /**
     * @param string $signedBy
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
     * @param string $signatureDate
     * @return $this
     */
    public function setDonorSignatureDate($signatureDate)
    {
        $this->lpaDonorSignatureDate = $signatureDate;
        return $this;
    }

    /**
     * @return string
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
     * @param string $signatureDate
     * @return $this
     */
    public function setDonorDeclarationSignatureDate($signatureDate)
    {
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
     * @param string $lpaCreatedDate
     * @return Lpa
     */
    public function setLpaCreatedDate($lpaCreatedDate = null)
    {
        $this->lpaCreatedDate =
            (null === $lpaCreatedDate) ? date('d/m/Y') : $lpaCreatedDate;
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
     * @param string $lpaReceiptDate
     * @return Lpa
     */
    public function setLpaReceiptDate($lpaReceiptDate)
    {
        $this->lpaReceiptDate = $lpaReceiptDate;
        return $this;
    }

    /**
     * @return string
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
     * @param string $lifeSustainingTreatmentSignatureDate
     * @return Lpa
     */
    public function setLifeSustainingTreatmentSignatureDate($lifeSustainingTreatmentSignatureDate)
    {
        $this->lifeSustainingTreatmentSignatureDate = $lifeSustainingTreatmentSignatureDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getLifeSustainingTreatmentSignatureDate()
    {
        return $this->lifeSustainingTreatmentSignatureDate;
    }



}
