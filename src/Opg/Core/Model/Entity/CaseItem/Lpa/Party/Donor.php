<?php
namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Common\Model\Entity\EntityInterface;
use Opg\Common\Model\Entity\Traits\InputFilter as InputfilterTrait;
use Zend\InputFilter\InputFilter;
use Opg\Core\Model\Entity\CaseItem\Traits\Party;
use Opg\Core\Model\Entity\CaseItem\Lpa\Traits\Person;
use Opg\Common\Model\Entity\Traits\ToArray;
use Zend\InputFilter\Factory as InputFactory;

/**
 *
 * @package Opg Core
 * @author Chris Moreton <chris@netsensia.com>
 *
 */
class Donor implements PartyInterface, EntityInterface, \IteratorAggregate
{
    use InputfilterTrait;
    use Party;
    use Person;
    use ToArray;

    public function toArray()
    {
        $data = get_object_vars($this);
        unset($data['inputFilter']);

        if (!empty($data['caseCollection'])) {
            $data['caseCollection'] = $data['caseCollection']->toArray();
        }

        return $data;
    }
    
    // Fulfil IteratorAggregate interface requirements
    public function getIterator()
    {
        return new \RecursiveArrayIterator($this->toArray());
    }

    /**
     * @param array $data
     *
     * @return EntityInterface|void
     */
    public function exchangeArray(array $data)
    {
        $donor = new Donor;

        return $donor;
    }

    /**
     * @return InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();

            $inputFilter->add(
                $factory->createInput(
                    array(
                        'name'       => 'id',
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
                                    'min'      => 5,
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
     * @var string
     */
    private $previousNames;
    
    /**
     * @var boolean
     */
    private $cannotSignForm;
    
    /**
     * @var boolean
     */
    private $applyingForFeeRemission;
    
    /**
     * @var boolean
     */
    private $receivingBenefits;
    
    /**
     * @var boolean
     */
    private $receivedDamageAward;
    
    /**
     * @var boolean
     */
    private $hasLowIncome;
    
    /**
     * @var string
     */
    private $signatureDate;
    
    /**
     * @var boolean
     */
    private $hasPreviousLpa;
    
    /**
     * @var string
     */
    private $notesForPreviousLpa;
    
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
}
