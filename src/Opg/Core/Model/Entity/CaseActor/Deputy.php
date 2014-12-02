<?php


namespace Opg\Core\Model\Entity\CaseActor;

use Doctrine\ORM\Mapping as ORM;
use Opg\Core\Model\Entity\CaseActor\Validation\InputFilter\DeputyFilter;

/**
 * Class Deputy
 * @package Opg\Core\Model\Entity\CaseActor
 *
 * @ORM\Entity
 */
class Deputy extends Attorney
{
    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Type("String")
     * @Groups({"api-person-get"})
     */
    protected $deputyReferenceNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Type("String")
     * @Groups({"api-person-get"})
     */
    protected $deputyCompliance;

    /**
     * @return \Zend\InputFilter\InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $this->inputFilter = parent::getInputFilter();
            $this->inputFilter->merge(new DeputyFilter());
        }

        return $this->inputFilter;
    }

    /**
     * @return string
     */
    public function getDeputyReferenceNumber()
    {
        return $this->deputyReferenceNumber;
    }

    /**
     * @param string $referenceNumber
     * @return Deputy
     */
    public function setDeputyReferenceNumber($referenceNumber)
    {
        $this->deputyReferenceNumber = $referenceNumber;

        return $this;
    }

    /**
     * @return string
     */
    public function getDeputyCompliance()
    {
        return $this->deputyCompliance;
    }

    /**
     * @param string $compliance
     * @return Deputy
     */
    public function setDeputyCompliance($compliance)
    {
        $this->deputyCompliance = $compliance;

        return $this;
    }
}
