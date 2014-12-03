<?php

namespace Opg\Core\Model\Entity\Fee\Validation\Validator;

use Zend\Validator\InArray;

/**
 * Class FeeStatusValidator
 * @package Opg\Core\Model\Entity\Fee\Validation\Validator
 */
class FeeStatusValidator extends InArray
{
    static $feeStatus = array(
        'Paid',
        'Outstanding',
        'Exempt',
        'Waived'
    );

    public function __construct()
    {
        $this->setStrict(InArray::COMPARE_STRICT);

        $this->setHaystack(
            self::$feeStatus
        );
    }
}
