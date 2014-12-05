<?php

namespace Opg\Core\Model\Entity\CaseActor\Validation\Validator;

use Zend\Validator\InArray;

/**
 * Class MaritalStatus
 * @package Opg\Core\Model\Entity\CaseActor\Validation\Validator
 */
class MaritalStatus extends InArray
{
    static $maritalStatuses = array(
        "Civil Partnership",
        "Divorced",
        "Co-habiting",
        "Married",
        "Not Stated",
        "Separated",
        "Single",
        "Widowed",
        "Other"
    );

    public function __construct()
    {
        $this->setStrict(InArray::COMPARE_STRICT);

        $this->setHaystack(
            self::$maritalStatuses
        );
    }
}
