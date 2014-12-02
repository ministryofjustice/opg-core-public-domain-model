<?php

namespace Opg\Core\Model\Entity\CaseActor\Validation\Validator;

use Zend\Validator\InArray;

/**
 * Class DeputyCompliance
 * @package Opg\Core\Model\Entity\CaseActor\Validation\Validator
 */
class DeputyCompliance extends InArray
{
    static $deputyCompliance = array(
        "Compliant",
        "Non-Compliant",
    );

    public function __construct()
    {
        $this->setStrict(InArray::COMPARE_STRICT);

        $this->setHaystack(
            self::$deputyCompliance
        );
    }
}
