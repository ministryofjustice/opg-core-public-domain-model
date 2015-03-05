<?php


namespace Opg\Core\Model\Entity\CaseActor;

use Doctrine\ORM\Mapping as ORM;
use Opg\Common\Model\Entity\HasStatusDate;
use Opg\Common\Model\Entity\Traits\StatusDate;
use Opg\Core\Model\Entity\Assignable\Assignee;
use Opg\Core\Model\Entity\Assignable\IsAssignable;
use Opg\Core\Model\Entity\CaseActor\Decorators\CaseRecNumber;
use Opg\Core\Model\Entity\CaseActor\Interfaces\HasCaseRecNumber;
use Opg\Core\Model\Entity\CaseActor\Validation\InputFilter\DeputyFilter;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\Groups;

/**
 * Class Deputy
 * @package Opg\Core\Model\Entity\CaseActor
 *
 * @ORM\Entity
 */
class Deputy extends Attorney implements HasStatusDate, HasCaseRecNumber, IsAssignable
{
    use CaseRecNumber;
    use StatusDate;
    use Assignee;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Type("string")
     * @Groups({"api-person-get"})
     */
    protected $deputyReferenceNumber;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     * @Type("string")
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
