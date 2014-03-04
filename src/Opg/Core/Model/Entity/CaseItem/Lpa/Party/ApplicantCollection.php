<?php

namespace Opg\Core\Model\Entity\CaseItem\Lpa\Party;

use Opg\Common\Model\Entity\Traits\ToArray as ToArrayTrait;

use Opg\Common\Model\Entity\Traits\InputFilter as InputFilterTrait;

use IteratorAggregate;
use ArrayIterator;
use Opg\Common\Model\Entity\CollectionInterface;
use Opg\Common\Exception\UnusedException;
use Opg\Core\Model\Entity\CaseItem\Lpa\InputFilter\ApplicantFilter;

/**
 * Class ApplicantCollection
 *
 * @package Opg Core
 */
class ApplicantCollection implements CollectionInterface, IteratorAggregate
{
    use ToArrayTrait;
    use InputFilterTrait;
    
    /**
     * @var array
     */
    private $applicantCollection = array();

    /**
     * @return ArrayIterator|\Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->getData());
    }

    /**
     * Alias for getApplicantCollection()
     *
     * @return array
     */
    public function getData()
    {
        return $this->getApplicantCollection();
    }

    /**
     * @return array
     */
    public function getApplicantCollection()
    {
        return $this->applicantCollection;
    }

    /**
     * @param Attorney|Donor $applicant
     * @return ApplicantCollection
     */
    public function addApplicant(PartyInterface $applicant)
    {
        $this->applicantCollection[] = $applicant;

        return $this;
    }
    
    public function exchangeArray(array $data)
    {
        $this->applicantCollection = [];

        foreach ($data['applicantCollection'] as $applicant) {
            $this->addApplicant($applicant); 
        }
    }
    
    /**
     * @return InputFilter|InputFilterInterface
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $this->inputFilter = new ApplicantFilter();
        }
        return $this->inputFilter;
    }
}
