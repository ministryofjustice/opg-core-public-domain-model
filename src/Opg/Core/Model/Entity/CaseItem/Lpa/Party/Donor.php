<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Zend\InputFilter\InputFilter;
use Opg\Common\Model\Entity\Traits\ToArray;
use Zend\InputFilter\Factory as InputFactory;
use Opg\Core\Model\Entity\Person\Person as BasePerson;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Accessor;
use JMS\Serializer\Annotation\Groups;
use JMS\Serializer\Annotation\Type;
use Opg\Common\Model\Entity\DateFormat as OPGDateFormat;

/**
 * @ORM\Entity
 *
 * @package Opg Core
 *
 */
class Donor extends BasePerson implements PartyInterface
{
    use ToArray {
        toArray as traitToArray;
    }
    use ExchangeArray;

    /**
     * @return InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = parent::getInputFilter();
            $factory     = new InputFactory();

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups("api-task-list")
     */
    protected $previousNames;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     * @Groups("api-task-list")
     */
    protected $cannotSignForm;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     * @Groups("api-task-list")
     */
    protected $applyingForFeeRemission;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     * @Groups("api-task-list")
     */
    protected $receivingBenefits;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     * @Groups("api-task-list")
     */
    protected $receivedDamageAward;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     * @Groups("api-task-list")
     */
    protected $hasLowIncome;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @var \DateTime
     * @Type("string")
     * @Accessor(getter="getSignatureDateString",setter="setSignatureDateString")
     * @Groups("api-task-list")
     */
    protected $signatureDate;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     * @Groups("api-task-list")
     */
    protected $hasPreviousLpa;

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Groups("api-task-list")
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
     * @param string $signatureDate
     *
     * @return Lpa
     */
    public function setSignatureDateString($signatureDate)
    {
        if (!empty($signatureDate)) {
            $signatureDate = OPGDateFormat::createDateTime($signatureDate);

            if ($signatureDate) {
                $this->setSignatureDate($signatureDate);
            }
        }

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
     * @return string
     */
    public function getSignatureDateString()
    {
        if (!empty($this->signatureDate)) {
            return $this->signatureDate->format(OPGDateFormat::getDateFormat());
        }

        return '';
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

    /**
     * @param bool $exposeClassname
     *
     * @return array
     */
    public function toArray($exposeClassname = true)
    {
        return $this->traitToArray($exposeClassname);
    }
}
