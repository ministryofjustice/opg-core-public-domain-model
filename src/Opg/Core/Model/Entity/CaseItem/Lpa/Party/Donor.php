<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Common\Model\Entity\Traits\ExchangeArray;
use Zend\InputFilter\InputFilter;
use Opg\Common\Model\Entity\Traits\ToArray;
use Zend\InputFilter\Factory as InputFactory;
use Opg\Core\Model\Entity\Person\Person as BasePerson;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Exclude;

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

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'firstname',
                        'required'   => true,
                        'filters'    => array(
                            array('name' => 'StripTags'),
                            array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                            array(
                                'name'    => 'StringLength',
                                'options' => array(
                                    'encoding' => 'UTF-8',
                                    'min'      => 3,
                                    'max'      => 24,
                                ),
                            )
                        )
                    )
                )
            );

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

    /**
     * @ORM\Column(type = "string")
     * @var string
     * @Type("string")
     */
    protected $previousNames;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     */
    protected $cannotSignForm;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     */
    protected $applyingForFeeRemission;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     */
    protected $receivingBenefits;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     */
    protected $receivedDamageAward;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     */
    protected $hasLowIncome;

    /**
     * @ORM\Column(type = "string")
     * @var string
     */
    protected $signatureDate;

    /**
     * @ORM\Column(type = "boolean")
     * @var boolean
     */
    protected $hasPreviousLpa;

    /**
     * @ORM\Column(type = "string")
     * @var string
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
     * @return Donor
     */
    public function setHasLowIncome($hasLowIncome)
    {
        $this->hasLowIncome = $hasLowIncome;
        return $this;
    }

    /**
     * @return string $signatureDate
     */
    public function getSignatureDate()
    {
        return $this->signatureDate;
    }

    /**
     * @param string $signatureDate
     * @return Donor
     */
    public function setSignatureDate($signatureDate)
    {
        $this->signatureDate = $signatureDate;
        return $this;
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
    public function toArray($exposeClassname = TRUE) {
        return $this->traitToArray($exposeClassname);
    }
}
