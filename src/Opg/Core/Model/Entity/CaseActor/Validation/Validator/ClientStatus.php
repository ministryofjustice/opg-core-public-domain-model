<?php

namespace Opg\Core\Model\Entity\CaseActor\Validation\Validator;

use Zend\Validator\InArray;

/**
 * Class ClientStatus
 * @package Opg\Core\Model\Entity\CaseActor\Validation\Validator
 */
class ClientStatus extends InArray
{
    static $clientStatus = array(
        "Active",
        "Deceased",
        "Rule 202",
    );

    public function __construct()
    {
        $this->setStrict(InArray::COMPARE_STRICT);

        $this->setHaystack(
            self::$clientStatus
        );
    }
}
