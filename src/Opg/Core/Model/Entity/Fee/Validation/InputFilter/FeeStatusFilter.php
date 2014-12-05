<?php

namespace Opg\Core\Model\Entity\Fee\Validation\InputFilter;

use Opg\Common\Filter\BaseInputFilter;

/**
 * Class FeeStatusFilter
 * @package Opg\Core\Model\Entity\Fee\Validation\InputFilter
 */
class FeeStatusFilter extends BaseInputFilter
{

    protected function setValidators()
    {
        $this->addValidator('feeStatus', 'Opg\Core\Model\Entity\Fee\Validation\Validator\FeeStatusValidator');
    }
}
