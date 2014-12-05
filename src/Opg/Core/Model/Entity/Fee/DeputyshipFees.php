<?php

namespace Opg\Core\Model\Entity\Fee;

use Doctrine\ORM\Mapping as ORM;
use Opg\Core\Model\Entity\Fee\Validation\InputFilter\FeeStatusFilter;

/**
 * Class DeputyshipFees
 * @package Opg\Core\Model\Entity\Payment
 *
 * @ORM\Entity
 */
class DeputyshipFees extends Fees
{
    /**
     * @return \Opg\Common\Filter\BaseInputFilter
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $this->inputFilter = parent::getInputFilter();
            $this->inputFilter->merge(new FeeStatusFilter());
        }
        return $this->inputFilter;
    }
}
