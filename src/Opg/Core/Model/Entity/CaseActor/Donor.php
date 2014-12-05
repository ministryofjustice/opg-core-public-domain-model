<?php
namespace Opg\Core\Model\Entity\CaseActor;

use Opg\Common\Filter\BaseInputFilter;
use Opg\Common\Model\Entity\HasSageId;
use Opg\Common\Model\Entity\Traits\SageId;
use Opg\Core\Model\Entity\CaseActor\Person as BasePerson;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\GenericAccessor;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Type;
use Opg\Common\Model\Entity\Traits\DateTimeAccessor;

/**
 * @ORM\Entity
 *
 * @package Opg Core
 *
 */
class Donor extends BasePerson implements HasSageId
{
    use SageId;

    /**
     * @return BaseInputFilter
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $this->inputFilter = parent::getInputFilter();
        }

        return $this->inputFilter;
    }

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $previousNames;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $cannotSignForm;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $applyingForFeeRemission;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $receivingBenefits;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $receivedDamageAward;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $hasLowIncome;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @GenericAccessor(getter="getDateAsString",setter="setDateFromString", propertyName="signatureDate")
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $signatureDate;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $hasPreviousLpa;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups({"api-task-list","api-person-get"})
     */
    protected $notesForPreviousLpa;

    /**
     * @return string $previousNames
     */
    public function getPreviousNames()
    {
        return $this->previousNames;
    }

    /**
     * @param string $previousNames
     *
     * @return Donor
     */
    public function setPreviousNames($previousNames)
    {
        $this->previousNames = $previousNames;

        return $this;
    }

    /**
     * @return boolean $cannotSignForm
     */
    public function cannotSignForm()
    {
        return $this->cannotSignForm;
    }

    /**
     * @param boolean $cannotSignForm
     *
     * @return Donor
     */
    public function setCannotSignForm($cannotSignForm)
    {
        $this->cannotSignForm = $cannotSignForm;

        return $this;
    }

    /**
     * @return boolean $applyingForFeeRemission
     */
    public function isApplyingForFeeRemission()
    {
        return $this->applyingForFeeRemission;
    }

    /**
     * @param boolean $applyingForFeeRemission
     *
     * @return Donor
     */
    public function setApplyingForFeeRemission($applyingForFeeRemission)
    {
        $this->applyingForFeeRemission = $applyingForFeeRemission;

        return $this;
    }

    /**
     * @return boolean $receivingBenefits
     */
    public function isReceivingBenefits()
    {
        return $this->receivingBenefits;
    }

    /**
     * @param boolean $receivingBenefits
     *
     * @return Donor
     */
    public function setReceivingBenefits($receivingBenefits)
    {
        $this->receivingBenefits = $receivingBenefits;

        return $this;
    }

    /**
     * @return boolean $receivedDamageAward
     */
    public function hasReceivedDamageAward()
    {
        return $this->receivedDamageAward;
    }

    /**
     * @param boolean $receivedDamageAward
     *
     * @return Donor
     */
    public function setReceivedDamageAward($receivedDamageAward)
    {
        $this->receivedDamageAward = $receivedDamageAward;

        return $this;
    }

    /**
     * @return boolean $hasLowIncome
     */
    public function hasLowIncome()
    {
        return $this->hasLowIncome;
    }

    /**
     * @param boolean $hasLowIncome
     *
     * @return Donor
     */
    public function setHasLowIncome($hasLowIncome)
    {
        $this->hasLowIncome = $hasLowIncome;

        return $this;
    }

    /**
     * @param \DateTime $signatureDate
     *
     * @return Donor
     */
    public function setSignatureDate(\DateTime $signatureDate = null)
    {
        if (is_null($signatureDate)) {
            $signatureDate = new \DateTime();
        }
        $this->signatureDate = $signatureDate;

        return $this;
    }

    /**
     * @return \DateTime $signatureDate
     */
    public function getSignatureDate()
    {
        return $this->signatureDate;
    }

    /**
     * @return boolean $hasPreviousLpa
     */
    public function hasPreviousLpa()
    {
        return $this->hasPreviousLpa;
    }

    /**
     * @param boolean $hasPreviousLpa
     *
     * @return Donor
     */
    public function setHasPreviousLpa($hasPreviousLpa)
    {
        $this->hasPreviousLpa = $hasPreviousLpa;

        return $this;
    }

    /**
     * @return string $notesForPreviousLpa
     */
    public function getNotesForPreviousLpa()
    {
        return $this->notesForPreviousLpa;
    }

    /**
     * @param string $notesForPreviousLpa
     *
     * @return Donor
     */
    public function setNotesForPreviousLpa($notesForPreviousLpa)
    {
        $this->notesForPreviousLpa = $notesForPreviousLpa;

        return $this;
    }
}
